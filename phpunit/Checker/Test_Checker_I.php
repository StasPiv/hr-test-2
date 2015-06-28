<?php

class Test_Checker_I extends PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        include_once __DIR__ . '/../../test/I/IGeometric.php';

        $this->assertFileExists($file = __DIR__ . '/../../test/I/IAngular.php');
        include_once $file;
        $this->assertTrue(interface_exists('IAngular'));

        $this->assertFileExists($file = __DIR__ . '/../../test/I/ISquarable.php');
        include_once $file;
        $this->assertTrue(interface_exists('ISquarable'));

        $this->assertFileExists($file = __DIR__ . '/../../test/I/Square.php');
        include_once $file;
        $this->assertTrue(class_exists('Square'));

        $this->assertFileExists($file = __DIR__ . '/../../test/I/Circle.php');
        include_once $file;

        $this->assertTrue(class_exists('Circle'));
    }

    public function testCountAngles()
    {
        $square = new Square();

        if ($square instanceof IAngular) {
            $square->countAngles();
        } else {
            $this->assertTrue(false, 'Square must have angles');
        }
    }

    public function testCircleSquare()
    {
        $circle = new Circle();

        if ($circle instanceof ISquarable) {
            $circle->square();
        } else {
            $this->assertTrue(false, 'Circle must have square');
        }
    }

    public function testSquareSquare()
    {
        $square = new Square();

        if ($square instanceof ISquarable) {
            $square->square();
        } else {
            $this->assertTrue(false, 'Square must have square');
        }
    }

}