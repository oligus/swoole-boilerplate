<?php declare(strict_types=1);

namespace SwooleTest\Schema\Fields;

use SwooleTest\Schema\AppContext;
use GraphQL\Type\Definition\ResolveInfo;

/**
 * Interface Field
 * @package CM\Schema\Fields
 */
interface Field
{
    /**
     * @return array
     */
    public static function getField(): array;

    /**
     * @param $value
     * @param $args
     * @param AppContext $appContext
     * @param ResolveInfo $resolveInfo
     * @return mixed
     */
    public static function resolve($value, array $args, AppContext $appContext, ResolveInfo $resolveInfo);

    /**
     * @param array $args
     * @return mixed
     */
    public static function getData(array $args);

}