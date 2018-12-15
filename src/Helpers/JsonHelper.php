<?php

namespace SwooleTest\Helpers;

/**
 * Class JsonHelper
 * @package SwooleTest\Helpers
 */
class JsonHelper
{
    /**
     * @param $json mixed
     * @return array
     * @throws \Exception
     */
    public static function toArray($json): array
    {
        if(is_array($json)) {
            return $json;
        }

        if(empty($json)) {
            return [];
        }

        if($json === 'undefined') {
            return [];
        }

        $json = self::sanitize($json);

        $jsonArray = [];

        if(is_string($json)) {

            if(empty($json)) {
                return [];
            }

            $jsonArray = json_decode($json, true);

            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new \Exception('Could not decode json string:' . $json);
            }
        }

        return $jsonArray;

    }

    /**
     * @param string $json
     * @return string
     */
    public static function sanitize(string $json): string
    {
        $json = trim($json);
        $json = preg_replace('/\s+/', ' ', $json);
        $json = preg_replace('/[\n|\t|\r]/', '', $json);
        $json = preg_replace('/\'/', '"', $json);
        $json = preg_replace('/,\s?}/', ' }', $json); // Trailing comma
        $json = preg_replace('/\s?([_A-Za-z][_0-9A-Za-z]*)\s?:/', ' "\1":', $json); // Double quotes

        return $json;
    }
}