<?php

class LChild extends LParent
{
    public function divide($a, $b)
    {
        return parent::divide($a, $b);
    }

    public function beautyPlus($a, $b)
    {
        echo "Your answer: " . $this->plus($a, $b);
    }
}