<?php

namespace OpsWay\Test2\Solid;

class Factory
{
    /**
     * @param string $letter
     * @throws \OpsWay\Test2\Solid\Exception
     * @return \OpsWay\Test2\Solid
     */
    public static function create($letter)
    {
        switch ($letter) {
            case 's' :
                return new S;
            case 'o' :
                return new O;
            case 'l' :
                return new L;
            case 'i' :
                return new I;
            case 'd' :
                return new D;
            default :
                throw new Exception('Undefined letter. Please choose one of s, o, l, i, d');
        }
    }
}