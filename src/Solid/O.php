<?php

namespace OpsWay\Test2\Solid;

use OpsWay\Test2\Solid;

class O extends Solid
{
    private $availablePublicMethods = ['openWindow', 'closeDoor', 'catchBird', 'throwStone'];

    public function printQuestion()
    {
        return "\033[1mStep 1\033[0m. Go to " . $this->getBaseDirectory() . "/Leak.php" . PHP_EOL .
        "\033[1mStep 2\033[0m. Close/open methods in Leak to implement O-principe." . PHP_EOL.
        "\033[1mStep 3\033[0m. Go to phpunit/Checker directory and run \033[1mphpunit Test_Checker_O.php\033[0m"  . PHP_EOL;
    }

    protected function createTask()
    {
        $this->createLeakAndHelper();
    }

    /**
     * @return string
     */
    protected function getBaseDirectory()
    {
        return 'test/O';
    }

    protected function createLeakAndHelper()
    {
        $publicMethod = $this->getRandomProperty($this->availablePublicMethods);

        do {
            $publicHelperMethod = $this->getRandomProperty($this->availablePublicMethods);
        } while ($publicHelperMethod == $publicMethod);

        $content = '<?php

/**
  * USAGE:
  * $leak = new Leak();
  * $leak->setHelper(new LeakHelper());
  * $leak->' . $publicMethod . '();
  */
class Leak
{
    /** @var LeakHelper */
    private $helper; // helper for doing useful thing

    public function ' . $publicMethod . '()
    {
        $this->doSomethingSpecific();
        $this->' . $publicHelperMethod . '();
    }

    private function setHelper($helper)
    {
        $this->helper = $helper;
    }

    public function doSomethingSpecific()
    {
        $this->doSomethingVerySpecific2();
    }

    protected function ' . $publicHelperMethod . '()
    {
        $this->helper->' . $publicHelperMethod . '();
    }

    protected function doSomethingVerySpecific2()
    {

    }
}
';
        file_put_contents('Leak.php', $content);
        $content = '<?php

class LeakHelper
{
    public function ' . $publicHelperMethod . '()
    {

    }
}
';
        file_put_contents('LeakHelper.php', $content);
    }

}