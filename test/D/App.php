<?php

class App
{
    /** @var IReader */
    private $reader;

    public function __construct(IReader $reader)
    {
        $this->reader = $reader;
    }

    public function parse()
    {
        return $this->reader->read();
    }
}