<?php declare(strict_types=1);

namespace SwooleTest\Schema\Fields;

use SwooleTest\Database\Entities\Author;
use SwooleTest\Schema\TypeManager;
use SwooleTest\Schema\AppContext;
use SwooleTest\Database\Manager;
use SwooleTest\Helpers\ClassHelper;
use GraphQL\Type\Definition\ResolveInfo;

/**
 * Class Authors
 * @package SwooleTest\Schema\Fields
 */
class Authors implements Field
{
    /**
     * @return array
     * @throws \Exception
     */
    public static function getField(): array
    {
        return [
            'type' => TypeManager::get('authors'),
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
        if ($value instanceof Author) {
            $authors = [$value];
        } else {
            $authors = self::getData($args);
        }

        $nodes = [];

        /** @var Author $author */
        foreach ($authors as $author) {
            $nodes[] = [
                'id' => ClassHelper::getPropertyValue($author, 'id'),
                'name' => ClassHelper::getPropertyValue($author, 'name'),
            ];
        }

        return [
            'total' => self::getCount(),
            'count' => count($authors),
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
        $repo = $em->getRepository(Author::class);

        return $repo->getCount();
    }

    /**
     * @param array $args
     * @return mixed
     */
    public static function getData(array $args)
    {
        /** @var \SwooleTest\Database\Repositories\CommonRepository $repo */
        $repo = Manager::getInstance()->getEm()->getRepository(Author::class);
        return $repo->findAll();
    }
}
