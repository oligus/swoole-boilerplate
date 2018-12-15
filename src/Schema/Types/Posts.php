<?php declare(strict_types=1);

namespace SwooleTest\Schema\Types;

use SwooleTest\Schema\TypeManager;
use GraphQL\Type\Definition\ObjectType;

/**
 * Class Posts
 * @package SwooleTest\Schema\Types
 */
class Posts extends ObjectType
{
    public function __construct()
    {
        $config = [
            'name' => 'Posts',
            'description' => 'Posts',
            'fields' => [
                'total' => [
                    'type' => TypeManager::int(),
                    'description' => 'Total number of records',
                ],
                'count' => [
                    'type' => TypeManager::int(),
                    'description' => 'Number of records in selection',
                ],
                'nodes' => [
                    'type' =>  TypeManager::listOf(TypeManager::get('post')),
                    'description' => 'Albums',
                ]
            ]
        ];

        parent::__construct($config);
    }
}
