<?php declare(strict_types=1);

namespace SwooleTest\Schema\Fields\Mutation;

use SwooleTest\Database\Entities\Comment;
use SwooleTest\Schema\Fields\Field;
use SwooleTest\Database\Entities\Author;
use SwooleTest\Database\Manager;
use SwooleTest\Schema\TypeManager;
use SwooleTest\Schema\AppContext;
use GraphQL\Type\Definition\ResolveInfo;
use SwooleTest\Helpers\ClassHelper;

/**
 * Class UpdateAuthor
 * @package SwooleTest\Schema\Fields\Mutation
 */
class UpdateComment implements Field
{
    /**
     * @return array
     * @throws \Exception
     */
    public static function getField(): array
    {
        return [
            'name' => 'updateComment',
            'args' => [
                'id' => TypeManager::nonNull(TypeManager::id()),
                'title' => TypeManager::string(),
                'content' => TypeManager::string()
            ],
            'type' => TypeManager::get('comment'),
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
        /** @var Comment $comment */
        $comment = Manager::getInstance()
            ->getEm()
            ->getRepository('SwooleTest\Database\Entities\Comment')
            ->find( (int) $args['id']);

        if(isset($args['title'])) {
            $comment->setTitle($args['title']);
        }

        if(isset($args['content'])) {
            $comment->setContent($args['content']);
        }

        Manager::getInstance()->getEm()->flush();

        return [
            'id' => ClassHelper::getPropertyValue($comment, 'id'),
            'author' => ClassHelper::getPropertyValue($comment, 'author'),
            'title' => ClassHelper::getPropertyValue($comment, 'title'),
            'content' => ClassHelper::getPropertyValue($comment, 'content'),
            'date' => ClassHelper::getPropertyValue($comment, 'date')->format('Y-m-d'),
        ];
    }

    public static function getData(array $args)
    {
        // TODO: Implement getData() method.
    }

}