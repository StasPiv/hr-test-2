<?php

class Test_Checker_O extends PHPUnit_Framework_TestCase
{
    const PRIVATE_MODIFIER = 'private';
    const PROTECTED_MODIFIER = 'protected';
    const PUBLIC_MODIFIER = 'public';

    public function testChecker()
    {
        $this->assertFileExists($leakFile = __DIR__ . '/../../test/O/Leak.php');
        include $leakFile;
        $this->assertTrue(class_exists('Leak'));

        $leakReflection = new ReflectionClass('Leak');
        $this->checkCountMethodsAndModifiers($leakReflection);
        $this->checkIfHelperExistsAndMethodIsCalledFromLeak($leakFile);
    }

    /**
     * @param ReflectionMethod $method
     * @return int
     */
    private function getMethodModifier($method)
    {
        switch ($method->getModifiers()) {
            case '134283520':
                return self::PUBLIC_MODIFIER;
            case '134283776':
                return self::PROTECTED_MODIFIER;
            case '134284288':
                return self::PRIVATE_MODIFIER;
            default:
                return self::PUBLIC_MODIFIER;
        }
    }

    /**
     * @param $leakFile
     */
    private function checkIfHelperExistsAndMethodIsCalledFromLeak($leakFile)
    {
        $leakHelperFile = __DIR__ . '/../../test/O/LeakHelper.php';
        $this->assertFileExists($leakHelperFile);
        include $leakHelperFile;
        $this->assertTrue(class_exists('LeakHelper'));
        $leakHelperReflection = new ReflectionClass('LeakHelper');

        foreach ($leakHelperReflection->getMethods() as $method) {
            $this->assertContains('$this->helper->' . $method->getName(), file_get_contents($leakFile));
            $this->assertContains('function ' . $method->getName(), file_get_contents($leakFile));
        }
    }

    /**
     * @param ReflectionClass $leakReflection
     */
    private function checkCountMethodsAndModifiers($leakReflection)
    {
        $this->assertGreaterThan(0, count($leakReflection->getMethods()));

        $countPrivate = $countProtected = $countPublic = 0;
        foreach ($leakReflection->getMethods() as $method) {
            if (strpos($method->getName(), 'set') !== false) {
                $this->assertEquals(self::PUBLIC_MODIFIER, $this->getMethodModifier($method));
            }

            if ($this->getMethodModifier($method) == self::PUBLIC_MODIFIER) {
                $this->assertNotFalse(strpos(file_get_contents($method->getFileName()), '$leak->' . $method->getName()), 'Incorrect modifier for ' . $method->getName());
                $countPublic++;
            }

            if ($this->getMethodModifier($method) == self::PROTECTED_MODIFIER) {
                $countProtected++;
            }

            if ($this->getMethodModifier($method) == self::PRIVATE_MODIFIER) {
                $countPrivate++;
            }
        }

        $this->assertEquals(2, $countPublic, 'Incorrect number of public methods');
        $this->assertEquals(0, $countProtected, 'Incorrect number of protected methods');
        $this->assertEquals(3, $countPrivate, 'Incorrect number of private methods');
    }

}