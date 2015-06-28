<?php

class Test_Checker_L extends PHPUnit_Framework_TestCase
{
    protected function setUp()
    {
        $this->assertFileExists($file = __DIR__ . '/../../test/L/LParent.php');
        include_once $file;
        $this->assertTrue(class_exists('LParent'));

        $this->assertFileExists($file = __DIR__ . '/../../test/L/LChild.php');
        include_once $file;
        $this->assertTrue(class_exists('LChild'));
        $this->assertInstanceOf('LParent', new LChild);
    }

    public function testPlus()
    {
        $lParent = new LParent();
        $lChild = new LChild();

        for($i=0; $i<10; $i++) {
            $randomNumber = rand(0, 5);
            $this->assertEquals($lChild->plus($i, $randomNumber), $lParent->plus($i, $randomNumber));
        }
    }

    public function testDivide()
    {
        $lParent = new LParent();
        $lChild = new LChild();

        $this->assertEquals($lParent->divide(5, 2), $lChild->divide(5, 2));

        try {
            $lChild->divide(5, 0);
        } catch (Exception $e) {
            $this->assertInstanceOf('RuntimeException', $e);
        }
    }
}