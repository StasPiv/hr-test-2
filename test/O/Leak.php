<?php

/**
  * USAGE:
  * $leak = new Leak();
  * $leak->setHelper(new LeakHelper());
  * $leak->closeDoor();
  */
class Leak
{
    /** @var LeakHelper */
    private $helper; // helper for doing useful thing

    public function closeDoor()
    {
        $this->doSomethingSpecific();
        $this->catchBird();
    }

    public function setHelper($helper)
    {
        $this->helper = $helper;
    }

    private function doSomethingSpecific()
    {
        $this->doSomethingVerySpecific2();
    }

    private function catchBird()
    {
        $this->helper->catchBird();
    }

    private function doSomethingVerySpecific2()
    {

    }
}
