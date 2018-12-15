<?php declare(strict_types=1);

namespace SwooleTest\Schema\Types\Inputs;

use SwooleTest\Schema\TypeManager;
use GraphQL\Type\Definition\InputObjectType;

/**
 * Class UpdatePostInputType
 * @package SwooleTest\Schema\Types\Inputs
 */
class UpdatePostInputType extends InputObjectType
{
    /**
     * PostInputType constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        $config = [
            'name' => 'UpdatePostInputType',
            'description' => 'Post item input type',
            'fields' => [
                'title' => [
                    'type' => TypeManager::string(),
                    'description' => 'Post title'
                ],
                'content' => [
                    'type' => TypeManager::string(),
                    'description' => 'Post content'
                ],
            ]
        ];

        parent::__construct($config);
    }
}
