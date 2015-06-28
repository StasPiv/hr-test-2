<?php

namespace OpsWay\Test2\Solid;

use OpsWay\Test2\Solid;

class L extends Solid
{
    /**
     * @return string
     */
    public function printQuestion()
    {
        return "\033[1mStep 1\033[0m. Go to " . $this->getBaseDirectory() . PHP_EOL .
        "\033[1mStep 2\033[0m. Your task is to remove one method for implementing L-principe." . PHP_EOL.
        "\033[1mStep 3\033[0m. Go to phpunit/Checker directory and run \033[1mphpunit Test_Checker_L.php\033[0m"  . PHP_EOL;
    }

    protected function createTask()
    {
        $content = '<?php

class LParent
{
    public function divide($a, $b)
    {
        if ($b == 0) {
            throw new RuntimeException("$b shouldn\'t be null");
        }
        return $a / $b;
    }

    public function plus($a, $b)
    {
        return $a + $b;
    }
}';
        file_put_contents('LParent.php', $content);

        $content = '<?php

class LChild extends LParent
{
    public function divide($a, $b)
    {
        if ($b == 0) {
            throw new Exception("$b shouldn\'t be null");
        }
        return $a / $b;
    }

    public function beautyPlus($a, $b)
    {
        echo "Your answer: " . $this->plus($a, $b);
    }
}';
        file_put_contents('LChild.php', $content);
    }

    /**
     * @return string
     */
    protected function getBaseDirectory()
    {
        return 'test/L';
    }

}