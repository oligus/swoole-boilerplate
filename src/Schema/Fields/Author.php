<?php declare(strict_types=1);

namespace SwooleTest\Schema\Fields;

use SwooleTest\Database\Entities\Author as AuthorEntity;
use SwooleTest\Schema\TypeManager;
use SwooleTest\Schema\AppContext;
use SwooleTest\Database\Manager;
use SwooleTest\Helpers\ClassHelper;
use GraphQL\Type\Definition\ResolveInfo;

/**
 * Class Author
 * @package SwooleTest\Schema\Fields
 */
class Author implements Field
{
    /**
     * @return array
     * @throws \Exception
     */
    public static function getField(): array
    {
        return [
            'type' => TypeManager::get('author'),
            'description' => 'dfsd',
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
        if(!empty($value) && array_key_exists('author', $value)) {
            $author = $value['author'];
        } elseif ($value instanceof AuthorEntity) {
            $author = $value;
        } else {
            $author = self::getData($args);
        }

        if(!$author instanceof AuthorEntity) {
            return null;
        }

        return [
            'id' => ClassHelper::getPropertyValue($author, 'id'),
            'name' => ClassHelper::getPropertyValue($author, 'name'),
            'posts' => ClassHelper::getPropertyValue($author, 'posts'),

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

        return $em->getRepository(AuthorEntity::class)->find($id);
    }
}
