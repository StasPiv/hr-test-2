<?php

/**
  * USAGE:
  * $leak = new Leak();
  * $leak->setHelper(new LeakHelper());
  * $leak->catchBird();
  */
class Leak
{
    /** @var LeakHelper */
    protected $helper; // helper for doing useful thing

    public function catchBird()
    {
        $this->doSomethingSpecific();
        $this->closeDoor();
    }

    public function setHelper($helper)
    {
        $this->helper = $helper;
    }

    private function doSomethingSpecific()
    {
        $this->doSomethingVerySpecific2();
    }

    private function closeDoor()
    {
        $this->helper->closeDoor();
    }

    private function doSomethingVerySpecific2()
    {

    }
}
