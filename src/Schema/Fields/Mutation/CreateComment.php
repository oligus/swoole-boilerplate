<?php declare(strict_types=1);

namespace SwooleTest\Schema\Fields\Mutation;

use SwooleTest\Database\Entities\Comment;
use SwooleTest\Database\Entities\Post;
use SwooleTest\Schema\Fields\Field;
use SwooleTest\Database\Entities\Author;
use SwooleTest\Database\Manager;
use SwooleTest\Schema\TypeManager;
use SwooleTest\Schema\AppContext;
use GraphQL\Type\Definition\ResolveInfo;
use SwooleTest\Helpers\ClassHelper;

/**
 * Class CreateComment
 * @package SwooleTest\Schema\Fields\Mutation
 */
class CreateComment implements Field
{
    /**
     * @return array
     * @throws \Exception
     */
    public static function getField(): array
    {
        return [
            'name' => 'createComment',
            'args' => [
                'commentInput' => [
                    'type' => TypeManager::getInput('CommentInputType'),
                    'name' => 'CommentInputType',
                ]
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
        $values = $args['CommentInputType'];

        $author = Manager::getInstance()->getEm()->getReference(Author::class, $values['authorId']);
        $post = Manager::getInstance()->getEm()->getReference(Post::class, $values['postId']);

        $comment = Comment::create($values['title'], $values['content'], $author, $post);

        Manager::getInstance()->getEm()->persist($comment);
        Manager::getInstance()->getEm()->flush();

        return [
            'id' => ClassHelper::getPropertyValue($comment, 'id'),
            'author' => ClassHelper::getPropertyValue($comment, 'author'),
            'title' => ClassHelper::getPropertyValue($comment, 'title'),
            'content' => ClassHelper::getPropertyValue($comment, 'content'),
            'date' => ClassHelper::getPropertyValue($comment, 'date')->format('Y-m-d')
        ];
    }

    public static function getData(array $args)
    {
        // TODO: Implement getData() method.
    }

}