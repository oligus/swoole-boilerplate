<?php declare(strict_types=1);

namespace SwooleTest\Schema\Types;

use SwooleTest\Schema\Fields;
use GraphQL\Type\Definition\ObjectType;

/**
 * Class QueryType
 * @package SwooleTest\Schema\Types
 */
class QueryType extends ObjectType
{
    /**
     * QueryType constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        $config = [
            'name' => 'Query',
            'fields' => [
                'author'    => Fields\Author::getField(),
                'authors'   => Fields\Authors::getField(),
                'post'      => Fields\Post::getField(),
                'posts'     => Fields\Posts::getField(),
                'comment'   => Fields\Comment::getField(),
                'comments'  => Fields\Comments::getField(),
            ]
        ];

        parent::__construct($config);
    }
}
