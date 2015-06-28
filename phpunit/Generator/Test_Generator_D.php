<?php
/**
 * Created by PhpStorm.
 * User: stas
 * Date: 28.06.15
 * Time: 18:48
 */

class Test_Generator_D extends PHPUnit_Framework_TestCase
{
    public function testGenerator()
    {
        /** @var OpsWay\Test2\Solid\I $generator */
        $generator = OpsWay\Test2\Solid\Factory::create('d');
        $generator->generate();

        $this->assertFileExists($file = __DIR__ . '/../../test/D/IReader.php');
        include $file;
        $this->assertTrue(interface_exists('IReader'), 'interface IReader not exists');

        $this->assertFileExists($file = __DIR__ . '/../../test/D/CsvReader.php');
        include $file;
        $this->assertTrue(class_exists('CsvReader'), 'class CsvReader not exists');

        $this->assertTrue(method_exists('CsvReader', 'read'), 'Method read not exists in CsvReader');

        $this->assertFileExists($file = __DIR__ . '/../../test/D/App.php');
        include $file;
        $this->assertTrue(class_exists('App'), 'class App not exists');
        $this->assertContains('private $reader', file_get_contents($file));

        $this->assertFileExists($file = __DIR__ . '/../../test/D/run.php');
        $this->assertContains('$app = new App();', file_get_contents($file));
        $this->assertContains('print_r($app->parse());', file_get_contents($file));

        $app = new ReflectionClass('App');
        $this->assertGreaterThan(0, count($app->getMethods()), 'Too less methods in ' . $app->getName());

        $construct = $app->getMethod('__construct');
        $this->assertNotFalse($construct->getName());

        $construct = $app->getMethod('parse');
        $this->assertNotFalse($construct->getName());

        $this->assertEquals(0, count($construct->getParameters()), 'Too less arguments in ' . $construct->getName());

        $this->assertContains('$reader = new CsvReader();', file_get_contents($app->getFileName()));
        $this->assertContains('return $reader->read();', file_get_contents($app->getFileName()));

        $this->checkRead(new App());
    }

    /**
     * @param App $app
     */
    private function checkRead($app)
    {
        $this->assertEquals([1, 2, 3], $app->parse());
    }

    public function testQuestion()
    {
        /** @var OpsWay\Test2\Solid\I $generator */
        $generator = OpsWay\Test2\Solid\Factory::create('d');
        $this->assertGreaterThan(100, strlen($generator->printQuestion()));
    }
}