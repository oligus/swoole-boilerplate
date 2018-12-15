<?php declare(strict_types=1);

namespace SwooleTest;

use SwooleTest\Schema\AppContext;
use SwooleTest\Schema\Types\MutationType;
use SwooleTest\Schema\Types\QueryType;
use SwooleTest\Helpers\JsonHelper;
use GraphQL\GraphQL;
use GraphQL\Type\Schema;
use GraphQL\Error\Debug;

/**
 * Class Response
 * @package SwooleTest
 */
class Response
{
    /**
     * @var array $data
     */
    private $data;

    /**
     * Response constructor.
     * @param $data
     */
    public function __construct(array $data = [])
    {
        $this->data = $data;
    }

    /**
     * @return mixed
     * @throws \Exception
     */
    public function get()
    {
        $appContext = new AppContext();
        $appContext->rootUrl = 'http://localhost:8080';
        $appContext->request = $_REQUEST;

        // GraphQL schema to be passed to query executor:
        $schema = new Schema([
            'query' => new QueryType(),
            'mutation' => new MutationType()
        ]);

        $result = GraphQL::executeQuery(
            $schema,
            $this->data['query'],
            null,
            $appContext,
            JsonHelper::toArray($this->data['variables'])
        );

        $debug = Debug::INCLUDE_DEBUG_MESSAGE | Debug::INCLUDE_TRACE;

        return $result->toArray($debug);
    }
}
