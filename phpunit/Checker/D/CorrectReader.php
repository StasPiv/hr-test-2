<?php
/**
 * Created by PhpStorm.
 * User: stas
 * Date: 28.06.15
 * Time: 20:50
 */

class CorrectReader implements IReader
{
    private $result;

    public function read()
    {
        if (!isset($this->result)) {
            return $this->result;
        }

        return $this->result = [5,6,7,rand(0,100)];
    }

}