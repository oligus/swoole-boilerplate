<?php declare(strict_types=1);

namespace SwooleTest\Schema\Fields;

use SwooleTest\Database\Entities\Comment as CommentEntity;
use SwooleTest\Schema\TypeManager;
use SwooleTest\Schema\AppContext;
use SwooleTest\Database\Manager;
use SwooleTest\Helpers\ClassHelper;
use GraphQL\Type\Definition\ResolveInfo;

/**
 * Class Comment
 * @package SwooleTest\Schema\Fields
 */
class Comment implements Field
{
    /**
     * @return array
     * @throws \Exception
     */
    public static function getField(): array
    {
        return [
            'type' => TypeManager::get('comment'),
            'args' => [
                'id' => [
                    'type' => TypeManager::ID(),
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
     * @throws \ReflectionException
     */
    public static function resolve($value, $args, AppContext $appContext, ResolveInfo $resolveInfo)
    {
        if(!empty($value) && array_key_exists('comment', $value)) {
            $comment = $value['comment'];
        } else {
            $comment = self::getData($args);
        }

        if(!$comment instanceof CommentEntity) {
            return null;
        }

        return [
            'id' => ClassHelper::getPropertyValue($comment, 'id'),
            'author' => ClassHelper::getPropertyValue($comment, 'author'),
            'title' => ClassHelper::getPropertyValue($comment, 'title'),
            'content' => ClassHelper::getPropertyValue($comment, 'content'),
            'date' => ClassHelper::getPropertyValue($comment, 'date')->format('Y-m-d'),
        ];
    }

    /**
     * @param array $args
     * @return mixed|null|object
     */
    public static function getData(array $args)
    {
        $id = array_key_exists('id', $args) ? $args['id'] : 0;

        /** @var \Doctrine\ORM\EntityManager $em */
        $em = Manager::getInstance()->getEm();

        return $em->getRepository(CommentEntity::class)->find($id);
    }
}
