<?php

class Test_Checker_S extends PHPUnit_Framework_TestCase
{
    public function testChecker()
    {
        /** @var OpsWay\Test2\Solid\S $checker */
        $checker = OpsWay\Test2\Solid\Factory::create('s');

        if (file_exists($checker->getGodClassFileName())) {
            include_once $checker->getGodClassFileName();
            $godClass = new ReflectionClass('God');
            $this->assertEquals(0, count($godClass->getMethods()), 'Too much methods in God Class');
        }

        include_once $checker->getGodClassFileTmpName();

        $allPhpFileNames = glob(dirname($checker->getGodClassFileName()) . '/*.php');
        $this->assertEquals(3, count($allPhpFileNames), 'Incorrect file names in folder');

        $actualFileNames = [];
        foreach ($allPhpFileNames as $fileName) {
            include_once $fileName;
            $actualFileNames[] = basename($fileName);
        }
        sort($actualFileNames);

        $godTmpClass = new ReflectionClass('GodTmp');
        $this->checkExpectedClasses($godTmpClass->getMethods());
        $this->checkMethodsInNewClasses($godTmpClass->getMethods());
    }

    /**
     * @param array $methods
     */
    private function checkExpectedClasses($methods)
    {
        foreach ($methods as $method) {
            $class = $this->explodeCamel($method)[1];
            $this->assertTrue(class_exists($class), 'Class ' . $class . ' is not found');
        }
    }

    /**
     * @param ReflectionMethod[] $methods
     */
    private function checkMethodsInNewClasses($methods)
    {
        foreach ($methods as $method) {
            list($expectedMethod, $class) = $this->explodeCamel($method->getName());
            $this->assertTrue(method_exists($class, $expectedMethod), 'Method ' . $expectedMethod . ' is not found in class ' . $class);

            $newMethod = new ReflectionMethod($class, $expectedMethod);
            $this->assertEquals($method->getModifiers(), $newMethod->getModifiers(), 'Incorrect modifier for ' . $class . '::' . $expectedMethod);
            $this->assertEquals(substr_count(file_get_contents($method->getFileName()), $method->getName()),
                substr_count(file_get_contents($newMethod->getFileName()), $newMethod->getName()),
                'Incorrect usage for ' . $class . '::' . $expectedMethod
            );
        }
    }

    /**
     * @param ReflectionMethod[] $methods
     * @return array
     */
    private function getExpectedFileNames($methods)
    {
        $fileNames = [];

        foreach ($methods as $method) {
            $fileName = $this->explodeCamel($method->getName())[1] . '.php';
            if (!in_array($fileName, $fileNames)) {
                $fileNames[] = $fileName;
            }
        }

        sort($fileNames);
        return array_unique(array_values($fileNames));
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
}