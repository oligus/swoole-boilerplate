<?php declare(strict_types=1);

namespace SwooleTest\Schema\Fields;

use SwooleTest\Database\Entities\Comment;
use SwooleTest\Schema\TypeManager;
use SwooleTest\Schema\AppContext;
use SwooleTest\Database\Manager;
use SwooleTest\Helpers\ClassHelper;
use GraphQL\Type\Definition\ResolveInfo;

/**
 * Class Comments
 * @package SwooleTest\Schema\Fields
 */
class Comments implements Field
{
    /**
     * @return array
     * @throws \Exception
     */
    public static function getField(): array
    {
        return [
            'type' => TypeManager::get('comments'),
            'args' => [
                'first' => [
                    'type' => TypeManager::int()
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
        if(!empty($value) && array_key_exists('comments', $value)) {
            $filter = new FilterDoctrineCollection($value['comments'], $args);
            $comments = $filter->getResult();

        } else {
            $comments = self::getData($args);
        }

        $nodes = [];

        foreach ($comments as $comment) {
            $nodes[] = [
                'id' => ClassHelper::getPropertyValue($comment, 'id'),
                'title' => ClassHelper::getPropertyValue($comment, 'title'),
                'content' => ClassHelper::getPropertyValue($comment, 'content'),
                'date' => ClassHelper::getPropertyValue($comment, 'date')->format('Y-m-d'),
                'author' => ClassHelper::getPropertyValue($comment, 'author')
            ];
        }

        return [
            'total' => self::getCount(),
            'count' => count($comments),
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
        $repo = $em->getRepository(Comment::class);

        return $repo->getCount();
    }

    /**
     * @param array $args
     * @return mixed
     */
    public static function getData(array $args)
    {
        /** @var \SwooleTest\Database\Repositories\CommonRepository $repo */
        $repo = Manager::getInstance()->getEm()->getRepository(Comment::class);
        return $repo->findAll();
    }
}
