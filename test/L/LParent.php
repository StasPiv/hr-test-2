<?php

class LParent
{
    public function divide($a, $b)
    {
        if ($b == 0) {
            throw new RuntimeException("$b shouldn't be null");
        }
        return $a / $b;
    }

    public function plus($a, $b)
    {
        return $a + $b;
    }
}