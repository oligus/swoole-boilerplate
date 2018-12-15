<?php declare(strict_types=1);

namespace SwooleTest\Schema\Types\Scalars;

use GraphQL\Language\AST\Node;
use SwooleTest\Schema\Fields\Field;
use SwooleTest\Schema\TypeManager;
use SwooleTest\Schema\AppContext;
use GraphQL\Type\Definition\ResolveInfo;
use GraphQL\Type\Definition\InputObjectType;
use GraphQL\Error\Error;
use GraphQL\Error\InvariantViolation;
use GraphQL\Language\AST\StringValueNode;
use GraphQL\Type\Definition\ScalarType;
use GraphQL\Utils\Utils;

/**
 * Class PostInputType
 * @package SwooleTest\Schema\Fields\Mutation
 */
class DateTimeType extends ScalarType
{
    /**
     * @var string
     */
    public $name = 'DateTime';

    public function serialize($value)
    {
        // TODO: Implement serialize() method.
    }

    public function parseValue($value)
    {
        // TODO: Implement parseValue() method.
    }

    public function parseLiteral($valueNode, array $variables = null)
    {
        // TODO: Implement parseLiteral() method.
    }


}