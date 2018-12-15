<?php declare(strict_types=1);

namespace SwooleTest\Schema\Fields;

use SwooleTest\Database\Entities\Post;
use SwooleTest\Schema\TypeManager;
use SwooleTest\Schema\AppContext;
use SwooleTest\Database\Manager;
use SwooleTest\Helpers\ClassHelper;
use GraphQL\Type\Definition\ResolveInfo;
use Doctrine\Common\Collections\Collection;

/**
 * Class Authors
 * @package SwooleTest\Schema\Fields
 */
class Posts implements Field
{
    /**
     * @return array
     * @throws \Exception
     */
    public static function getField(): array
    {
        return [
            'type' => TypeManager::get('posts'),
            'args' => [
                'first' => [
                    'type' => TypeManager::int()
                ],
                'offset' => [
                    'type' => TypeManager::int(),
                    'defaultValue' => 0
                ],
                'after' => [
                    'type' => TypeManager::int(),
                    'defaultValue' => 0
                ],
            ],
            'resolve' => function ($value, $args, AppContext $appContext, ResolveInfo $resolveInfo) {
                return self::resolve($value, $args, $appContext,  $resolveInfo);
            }
        ];
    }

    /**
     * @param $value
     * @param array $args
     * @param AppContext $appContext
     * @param ResolveInfo $resolveInfo
     * @return array|mixed|null
     * @throws \Doctrine\ORM\NonUniqueResultException
     * @throws \ReflectionException
     */
    public static function resolve($value, $args, AppContext $appContext, ResolveInfo $resolveInfo)
    {
        if(!empty($value) && array_key_exists('posts', $value)) {
            $filter = new FilterDoctrineCollection($value['posts'], $args);
            $posts = $filter->getResult();
        } elseif ($value instanceof Post) {
            $posts = [$value];
        } else {
            $posts = self::getData($args);
        }

        $nodes = [];

        /** @var Post $post */
        foreach ($posts as $post) {
            $nodes[] = [
                'id' => ClassHelper::getPropertyValue($post, 'id'),
                'title' => ClassHelper::getPropertyValue($post, 'title'),
                'content' => ClassHelper::getPropertyValue($post, 'content'),
                'date' => ClassHelper::getPropertyValue($post, 'date')->format('Y-m-d'),
                'comments' => ClassHelper::getPropertyValue($post, 'comments')
            ];
        }

        return [
            'total' => self::getCount(),
            'count' => count($posts),
            'nodes' => $nodes
        ];
    }

    /**
     * @return int
     * @throws \Doctrine\ORM\NonUniqueResultException
     */
    public static function getCount()
    {
        /** @var \Doctrine\ORM\EntityManager $em */
        $em = Manager::getInstance()->getEm();

        /** @var \SwooleTest\Database\Repositories\CommonRepository $repo*/
        $repo = $em->getRepository(Post::class);

        return $repo->getCount();
    }

    /**
     * @param array $args
     * @return mixed
     */
    public static function getData(array $args)
    {
        /** @var \SwooleTest\Database\Repositories\CommonRepository $repo */
        $repo = Manager::getInstance()->getEm()->getRepository(Post::class);
        return $repo->findAll();
    }
}
