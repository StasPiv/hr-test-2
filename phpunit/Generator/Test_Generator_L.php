<?php
/**
 * Created by PhpStorm.
 * User: stas
 * Date: 28.06.15
 * Time: 17:18
 */

class Test_Generator_L extends PHPUnit_Framework_TestCase
{
    public function testGenerator()
    {
        /** @var OpsWay\Test2\Solid\O $generator */
        $generator = OpsWay\Test2\Solid\Factory::create('l');
        $generator->generate();

        $this->assertFileExists($file = __DIR__ . '/../../test/L/LParent.php');
        include $file;
        $this->assertTrue(class_exists('LParent'));

        $this->assertFileExists($file = __DIR__ . '/../../test/L/LChild.php');
        include $file;
        $this->assertTrue(class_exists('LChild'));
        $this->assertInstanceOf('LParent', new LChild);

        $this->assertTrue(method_exists('LParent', 'divide'));
        $this->assertTrue(method_exists('LParent', 'plus'));
        $this->assertTrue(method_exists('LChild', 'beautyPlus'));

        $this->checkFirstSubstitution();
        $this->checkSecondSubstitution();
    }

    public function testQuestion()
    {
        /** @var OpsWay\Test2\Solid\O $generator */
        $generator = OpsWay\Test2\Solid\Factory::create('l');
        $this->assertGreaterThan(100, strlen($generator->printQuestion()));
    }

    private function checkFirstSubstitution()
    {
        $lParent = new LParent();
        $lChild = new LChild();

        try {
            $lParent->divide(5, 0);
        } catch (Exception $e) {
            $this->assertInstanceOf('RuntimeException', $e);
        }

        try {
            $lChild->divide(5, 0);
        } catch (Exception $e) {
            $this->assertInstanceOf('Exception', $e);
        }

    }

    private function checkSecondSubstitution()
    {
        $lParent = new LParent();
        $lChild = new LChild();

        $this->assertEquals($lParent->plus(5, 2), $lChild->plus(5, 2));
    }
}