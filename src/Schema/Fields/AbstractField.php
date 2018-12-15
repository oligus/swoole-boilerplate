<?php

namespace SwooleTest\Schema\Fields;

abstract class AbstractField
{
    /**
     * @var string
     */
    protected $name;

    /**
     * AbstractField constructor.
     * @param string $name
     */
    public function __construct(string $name) {
        $this->name = $name;
    }
}