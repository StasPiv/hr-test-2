<?php
/**
 * Created by PhpStorm.
 * User: stas
 * Date: 28.06.15
 * Time: 18:07
 */

class Test_Generator_I extends PHPUnit_Framework_TestCase
{
    public function testGenerator()
    {
        /** @var OpsWay\Test2\Solid\I $generator */
        $generator = OpsWay\Test2\Solid\Factory::create('i');
        $generator->generate();

        $this->assertFileExists($file = __DIR__ . '/../../test/I/IGeometric.php');
        include $file;
        $this->assertTrue(interface_exists('IGeometric'));

        $this->assertFileExists($file = __DIR__ . '/../../test/I/IAngular.php');
        include $file;
        $this->assertTrue(interface_exists('IAngular'));

        $this->assertFileExists($file = __DIR__ . '/../../test/I/ISquarable.php');
        include $file;
        $this->assertTrue(interface_exists('ISquarable'));

        $this->assertFileExists($file = __DIR__ . '/../../test/I/Square.php');
        include $file;
        $this->assertTrue(class_exists('Square'));
        $this->assertTrue(in_array('IGeometric', class_implements('Square')));

        $this->assertFileExists($file = __DIR__ . '/../../test/I/Circle.php');
        include $file;
        $this->assertTrue(class_exists('Circle'));
        $this->assertTrue(in_array('IGeometric', class_implements('Circle')));

        $this->assertTrue(method_exists('IGeometric', 'square'));
        $this->assertTrue(method_exists('ISquarable', 'square'));
        $this->assertTrue(method_exists('IAngular', 'countAngles'));

    }

    public function testQuestion()
    {
        /** @var OpsWay\Test2\Solid\I $generator */
        $generator = OpsWay\Test2\Solid\Factory::create('i');
        $this->assertGreaterThan(100, strlen($generator->printQuestion()));
    }
}