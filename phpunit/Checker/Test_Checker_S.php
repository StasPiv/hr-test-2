<?php

class Test_Checker_S extends PHPUnit_Framework_TestCase
{

    /** @var OpsWay\Test2\Solid\S $generator */
    private $generator;

    public function setUp()
    {
        $this->generator = OpsWay\Test2\Solid\Factory::create('s');
    }

    public function testFactory()
    {
        $this->checkIfFileClassCreated('Factory.php', 'Factory');
        $this->assertFileExists($file = __DIR__ . '/../../test/S/Factory.php');
        require_once $file;

        $god = new ReflectionClass('Factory');

        $this->assertNotFalse($god->getMethod('create')->getName());
    }

    public function testReader()
    {
        $this->checkIfFileClassCreated('Reader.php', 'Reader');
        $this->assertFileExists($file = __DIR__ . '/../../test/S/Reader.php');
        require_once $file;

        $god = new ReflectionClass('Reader');

        $this->assertNotFalse($god->getMethod('read')->getName());
    }

    public function testWriter()
    {
        $this->checkIfFileClassCreated('Writer.php', 'Writer');
        $this->assertFileExists($file = __DIR__ . '/../../test/S/Writer.php');
        require_once $file;

        $god = new ReflectionClass('Writer');

        $this->assertNotFalse($god->getMethod('write')->getName());
    }

    /**
     * @param string $fileName
     */
    private function checkIfFileClassCreated($fileName, $className)
    {
        $fileName = $this->generator->getFullBaseDirectory() . '/' . $fileName;
        $this->assertFileExists($fileName);
        include_once $fileName;

        $this->assertTrue(class_exists($className), $className . ' is not exists');
    }


}