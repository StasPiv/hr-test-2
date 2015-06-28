<?php

class Test_Checker_D extends PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        $this->assertFileExists($file = __DIR__ . '/../../test/D/IReader.php');
        include_once $file;
        $this->assertTrue(interface_exists('IReader'), 'interface IReader not exists');

        $this->assertFileExists($file = __DIR__ . '/../../test/D/CsvReader.php');
        include_once $file;
        $this->assertTrue(class_exists('CsvReader'), 'class CsvReader not exists');

        $this->assertTrue(method_exists('CsvReader', 'read'), 'Method read not exists in CsvReader');

        $this->assertFileExists($file = __DIR__ . '/../../test/D/App.php');
        include_once $file;
        $this->assertTrue(class_exists('App'), 'class App not exists');
    }

    public function testIReader()
    {
        $this->assertTrue(method_exists('IReader', 'read') , 'Method read must be declared in IReader');
    }

    /**
     * @throw Exception
     */
    public function testFakeReader()
    {
        require_once (__DIR__ . '/D/FakeReader.php');
        try {
            new App(new FakeReader());
        } catch (PHPUnit_Framework_Error $e) {
            return;
        } catch (Exception $e) {
            $this->assertTrue(false, 'Exception without typing');
        }
        $this->assertTrue(false, 'No exception. No typing for param in __construct');
    }

    public function testCorrectReader()
    {
        require_once (__DIR__ . '/D/CorrectReader.php');
        $throwException = false;
        try {
            new App(new CorrectReader());
        } catch (Exception $e) {
            $throwException = true;
        }

        $this->assertFalse($throwException, 'Passed IReader type to App and catch exception');

        $app = new App($reader = new CorrectReader());
        $this->assertEquals($reader->read(), $app->parse(), 'App parse must return reader result.');
    }
}