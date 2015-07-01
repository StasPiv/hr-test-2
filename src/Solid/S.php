<?php

namespace OpsWay\Test2\Solid;

use OpsWay\Test2\Solid;

class S extends Solid
{
    protected function getBaseDirectory()
    {
        return 'test/S';
    }

    /**
     * @return \OpsWay\Test2\Solid\S
     */
    protected function createTask()
    {
        $content = '<?php

class God
{
    public function create()
    {

    }

    public function read()
    {

    }

    public function write()
    {

    }
}';
        file_put_contents('God.php', $content);

        $content = '<?php

class Factory
{

}';
        file_put_contents('Factory.php', $content);

        $content = '<?php

class Reader
{

}';
        file_put_contents('Reader.php', $content);

        $content = '<?php

class Writer
{

}';
        file_put_contents('Writer.php', $content);

        return $this;
    }

    public function printQuestion()
    {
        return "\033[1mStep 1\033[0m. Go to " . $this->getBaseDirectory() . "/God.php" . PHP_EOL .
        "\033[1mStep 2\033[0m. Move methods from it to correct classes." . PHP_EOL.
        "\033[1mStep 4\033[0m. Go to phpunit/Checker directory and run \033[1mphpunit Test_Checker_S.php\033[0m" . PHP_EOL;
    }
}