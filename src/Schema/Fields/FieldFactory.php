<?php

namespace SwooleTest\Schema\Fields;

/**
 * Class FieldFactory
 * @package SwooleTest\Schema\Fields
 */
class FieldFactory
{
    /**
     * @param string $name
     * @return null|AbstractField
     */
    public static function create(string $name): ?AbstractField
    {
        switch($name) {
            case 'MediaTypes':
                return new MediaTypes($name);
                break;
        }

        return null;
    }
}