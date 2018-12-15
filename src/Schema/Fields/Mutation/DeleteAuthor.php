<?php declare(strict_types=1);

namespace SwooleTest\Schema\Fields\Mutation;

use SwooleTest\Schema\Fields\Field;
use SwooleTest\Database\Entities\Author;
use SwooleTest\Database\Manager;
use SwooleTest\Schema\TypeManager;
use SwooleTest\Schema\AppContext;
use GraphQL\Type\Definition\ResolveInfo;
use SwooleTest\Helpers\ClassHelper;

/**
 * Class DeleteAuthor
 * @package SwooleTest\Schema\Fields\Mutation
 */
class DeleteAuthor implements Field
{
    /**
     * @return array
     * @throws \Exception
     */
    public static function getField(): array
    {
        return [
            'name' => 'deleteAuthor',
            'args' => [
                'id' => TypeManager::nonNull(TypeManager::id())
            ],
            'type' => TypeManager::get('author'),
            'resolve' => function ($value, array $args, AppContext $appContext, ResolveInfo $resolveInfo) {
                return self::resolve($value, $args, $appContext, $resolveInfo);
            }
        ];
    }

    /**
     * @param $value
     * @param array $args
     * @param AppContext $appContext
     * @param ResolveInfo $resolveInfo
     * @return mixed
     * @throws \Exception
     */
    public static function resolve($value, array $args, AppContext $appContext, ResolveInfo $resolveInfo)
    {
        $author = Manager::getInstance()
            ->getEm()
            ->getRepository('SwooleTest\Database\Entities\Author')
            ->find( (int) $args['id']);


        Manager::getInstance()->getEm()->remove($author);
        Manager::getInstance()->getEm()->flush();

    }

    public static function getData(array $args)
    {
        // TODO: Implement getData() method.
    }

}