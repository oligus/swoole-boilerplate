<?php

namespace SwooleTest\Helpers;

/**
 * Class ClassHelper
 * @package SwooleTest\Helpers
 */
class ClassHelper
{
    /**
     * @param $class
     * @param string $property
     * @return mixed|null
     * @throws \ReflectionException
     */
    public static function getPropertyValue($class, string $property)
    {
        $method = 'get' . ucfirst($property);

        if(method_exists($class, $method)) {
            return $class->$method();
        }

        $reflection = new \ReflectionClass($class);

        if($reflection->hasProperty($property)) {
            $reflectionProperty = $reflection->getProperty($property);
            $reflectionProperty->setAccessible(true);
            return $reflectionProperty->getValue($class);
        }

        return null;
    }

    /**
     * @param $class
     * @param string $property
     * @param $value
     * @throws \ReflectionException
     */
    public static function setPropertyValue($class, string $property, $value)
    {
        $method = 'set' . ucfirst($property);

        if (method_exists($class, $method)) {
            $class->$method($value);
            return;
        }

        $reflection = new \ReflectionClass($class);

        if ($reflection->hasProperty($property)) {
            $reflectionProperty = $reflection->getProperty($property);
            $reflectionProperty->setAccessible(true);
            $reflectionProperty->setValue($class, $value);
        }
    }

    /**
     * @param $class
     * @param string $property
     * @return bool
     * @throws \ReflectionException
     */
    public static function hasPropertyValue($class, string $property): bool
    {
        $method = 'set' . ucfirst($property);

        if (method_exists($class, $method)) {
            return true;
        }

        $reflection = new \ReflectionClass($class);

        return $reflection->hasProperty($property);
    }
}