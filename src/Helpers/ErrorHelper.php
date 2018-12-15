<?php

namespace SwooleTest\Helpers;

/**
 * Class ErrorHelper
 * @package SwooleTest\Helpers
 */
class ErrorHelper
{
    /**
     * @param \Exception $e
     * @return string
     */
    public static function simple(\Exception $e)
    {
        return $e->getMessage() . '<br>' . nl2br(htmlentities($e->getTraceAsString()));
    }

    /**
     * @param \Exception $e
     * @return string
     */
    public static function json(\Exception $e)
    {
        $error = new \stdClass();
        $error->data = new \stdClass();
        $error->errors = new \stdClass();
        $error->errors->message = $e->getMessage();


        $error->errors->line = $e->getLine();
        $error->errors->file = $e->getFile();
        $error->errors->trace = [];

        foreach ($e->getTrace() as $key => $trace) {
            $x = '';

            if (array_key_exists('function', $trace)) {
                $x .= '[internal function]';
            }

            if (array_key_exists('class', $trace)) {
                $x .= ' ' . $trace['class'];
            }

            if (array_key_exists('type', $trace)) {
                $x .= $trace['type'];
            }

            if (array_key_exists('function', $trace)) {
                $x .= $trace['function'];
            }

            if (array_key_exists('args', $trace)) {

                $x .= '(';

                foreach ($trace['args'] as $index => $item) {
                    $x .= ucfirst(gettype($item));
                    if (gettype($item) === 'object') {
                        $x .= '(' . get_class($item) . ')';
                    }

                    if ($index !== count($trace['args']) - 1) {
                        $x .= ', ';
                    }
                }

                $x .= ')';
            }

            $error->errors->trace[$key] = $x;
        }


        return $error;
    }
}