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
 * Class CreateAuthor
 * @package SwooleTest\Schema\Fields\Mutation
 */
class CreateAuthor implements Field
{
    /**
     * @return array
     * @throws \Exception
     */
    public static function getField(): array
    {
        return [
            'name' => 'createAuthor',
            'args' => [
                'name' => TypeManager::nonNull(TypeManager::string())
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
        $author = Author::create($args['name']);

        Manager::getInstance()->getEm()->persist($author);
        Manager::getInstance()->getEm()->flush();

        return [
            'id' => ClassHelper::getPropertyValue($author, 'id'),
            'name' => ClassHelper::getPropertyValue($author, 'name'),
        ];
    }

    public static function getData(array $args)
    {
        // TODO: Implement getData() method.
    }

}