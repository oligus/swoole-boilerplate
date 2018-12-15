<?php declare(strict_types=1);

namespace SwooleTest\Schema\Types;

use GraphQL\Type\Definition\ObjectType;
use SwooleTest\Schema\Fields\Mutation\CreateAuthor;
use SwooleTest\Schema\Fields\Mutation\CreateComment;
use SwooleTest\Schema\Fields\Mutation\CreatePost;
use SwooleTest\Schema\Fields\Mutation\DeleteAuthor;
use SwooleTest\Schema\Fields\Mutation\UpdateAuthor;
use SwooleTest\Schema\Fields\Mutation\UpdateComment;
use SwooleTest\Schema\Fields\Mutation\UpdatePost;

/**
 * Class QueryType
 * @package CM\Schema\Type
 */
class MutationType extends ObjectType
{
    /**
     * MutationType constructor.
     * @throws \Exception
     */
    public function __construct()
    {
        $config = [
            'name' => 'Mutation',
            'fields' => function() {
                return [
                    'createAuthor'  => CreateAuthor::getField(),
                    'updateAuthor'  => UpdateAuthor::getField(),
                    'deleteAuthor'  => DeleteAuthor::getField(),

                    'createPost'    => CreatePost::getField(),
                    'updatePost'    => UpdatePost::getField(),

                    'createComment' => CreateComment::getField(),
                    'updateComment' => UpdateComment::getField(),
                ];
            }
        ];

        parent::__construct($config);
    }
}