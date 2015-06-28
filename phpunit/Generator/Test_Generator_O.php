<?php
/**
 * Created by PhpStorm.
 * User: stas
 * Date: 28.06.15
 * Time: 14:56
 */

class Test_Generator_O extends PHPUnit_Framework_TestCase
{
    const PRIVATE_MODIFIER = 'private';
    const PROTECTED_MODIFIER = 'protected';
    const PUBLIC_MODIFIER = 'public';

    public function testGenerator()
    {
        /** @var OpsWay\Test2\Solid\O $generator */
        $generator = OpsWay\Test2\Solid\Factory::create('o');
        $generator->generate();

        $this->assertFileExists($leakFile = __DIR__ . '/../../test/O/Leak.php');
        include $leakFile;
        $this->assertTrue(class_exists('Leak'));

        $leakReflection = new ReflectionClass('Leak');
        $this->checkCountMethodsAndModifiers($leakReflection);
        $this->checkIfHelperExistsAndMethodIsCalledFromLeak($leakFile);
    }

    public function testQuestion()
    {
        /** @var OpsWay\Test2\Solid\O $generator */
        $generator = OpsWay\Test2\Solid\Factory::create('o');
        $this->assertGreaterThan(100, strlen($generator->printQuestion()));
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
            if ($this->getMethodModifier($method) == self::PUBLIC_MODIFIER) {
                $countPublic++;
            }

            if ($this->getMethodModifier($method) == self::PROTECTED_MODIFIER) {
                $countProtected++;
            }

            if ($this->getMethodModifier($method) == self::PRIVATE_MODIFIER) {
                $this->assertContains('set', $method->getName());
                $countPrivate++;
            }
        }

        $this->assertGreaterThan(1, $countPublic);
        $this->assertGreaterThan(1, $countProtected);
        $this->assertEquals(1, $countPrivate);
    }
}