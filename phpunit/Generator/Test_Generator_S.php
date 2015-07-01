<?php
/**
 * Created by PhpStorm.
 * User: stas
 * Date: 28.06.15
 * Time: 10:56
 */

class Test_Generator_S extends PHPUnit_Framework_TestCase
{

    /** @var OpsWay\Test2\Solid\S $generator */
    private $generator;

    public function setUp()
    {
        $this->generator = OpsWay\Test2\Solid\Factory::create('s');
        $this->generator->generate();

    }

    public function testGod()
    {
        $this->checkIfFileClassCreated('God.php', 'God');
        $this->assertFileExists($file = __DIR__ . '/../../test/S/God.php');
        require_once $file;

        $god = new ReflectionClass('God');

        $this->assertNotFalse($god->getMethod('create')->getName());
        $this->assertNotFalse($god->getMethod('write')->getName());
        $this->assertNotFalse($god->getMethod('read')->getName());
    }

    public function testReader()
    {
        $this->checkIfFileClassCreated('Reader.php', 'Reader');
    }

    public function testWriter()
    {
        $this->checkIfFileClassCreated('Writer.php', 'Writer');
    }

    public function testFactory()
    {
        $this->checkIfFileClassCreated('Factory.php', 'Factory');
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