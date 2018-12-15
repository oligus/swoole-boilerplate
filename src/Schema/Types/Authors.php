<?php declare(strict_types=1);

namespace SwooleTest\Schema\Types;

use SwooleTest\Schema\TypeManager;
use GraphQL\Type\Definition\ObjectType;

/**
 * Class Authors
 * @package SwooleTest\Schema\Types
 */
class Authors extends ObjectType
{
    /**
     * Authors constructor.
     */
    public function __construct()
    {
        $config = [
            'name' => 'Authors',
            'description' => 'A list of authors',
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
                    'type' =>  TypeManager::listOf(TypeManager::get('author')),
                    'description' => 'Authors',
                ]
            ]
        ];

        parent::__construct($config);
    }
}
