<?php
/**
 * Created by PhpStorm.
 * User: stas
 * Date: 28.06.15
 * Time: 10:56
 */

class Test_Generator_S extends PHPUnit_Framework_TestCase
{
    public function testGenerator()
    {
        /** @var OpsWay\Test2\Solid\S $generator */
        $generator = OpsWay\Test2\Solid\Factory::create('s');

        for($i=0; $i<20; $i++) {
            $generator->generate();
            $this->checkIfMethodsAreUnique($generator->getGodMethodNames());
            $this->checkIfTwoClassesExist($generator->getGodMethodNames());
            $this->checkIfFileWithGodClassCreated($generator->getGodClassFileName());
        }
    }

    /**
     * @param string $fileName
     */
    private function checkIfFileWithGodClassCreated($fileName)
    {
        $this->assertFileExists($fileName);
    }

    /**
     * @param array $methodNames
     */
    private function checkIfTwoClassesExist($methodNames)
    {
        $classNames = [];

        foreach ($methodNames as $name) {
            $classNames[] = $this->explodeCamel($name)[1];
        }

        $this->assertEquals(2, count(array_unique($classNames)));
    }

    /**
     * @param string $str
     * @return $matches
     */
    private function explodeCamel($str)
    {
        preg_match_all('/((?:^|[A-Z])[a-z]+)/', $str, $matches);
        return $matches[0];
    }

    /**
     * @param array $methods
     */
    private function checkIfMethodsAreUnique($methods)
    {
        $this->assertEquals($methods, array_unique($methods));
    }
}