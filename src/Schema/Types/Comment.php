<?php declare(strict_types=1);

namespace SwooleTest\Schema\Types;

use GraphQL\Type\Definition\ObjectType;
use SwooleTest\Schema\TypeManager;
use SwooleTest\Schema\Fields\Author;

/**
 * Class Comment
 * @package SwooleTest\Schema\Types
 */
class Comment extends ObjectType
{
    /**
     * Artist constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        $config = [
            'name' => 'Comment',
            'description' => 'A comment for a blog post',
            'fields' => function() {
                return [
                    'id' => ['type' => TypeManager::ID()],
                    'author' => Author::getField(),
                    'title' => ['type' => TypeManager::string()],
                    'content' => ['type' => TypeManager::string()],
                    'date' => ['type' => TypeManager::string()],
                ];
            }
        ];

        parent::__construct($config);
    }
}
