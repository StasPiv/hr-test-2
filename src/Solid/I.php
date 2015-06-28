<?php

namespace OpsWay\Test2\Solid;

use OpsWay\Test2\Solid;

class I extends Solid
{
    /**
     * @return string
     */
    public function printQuestion()
    {
        return "\033[1mStep 1\033[0m. Go to " . $this->getBaseDirectory() . PHP_EOL .
        "\033[1mStep 2\033[0m. Choose correct interfaces for classes to implement I-principe." . PHP_EOL.
        "\033[1mStep 3\033[0m. Go to phpunit/Checker directory and run \033[1mphpunit Test_Checker_I.php\033[0m"  . PHP_EOL;
    }

    protected function createTask()
    {
        $content = '<?php

class Square implements IGeometric
{
    public function square()
    {
    }
}
';
        file_put_contents('Square.php', $content);

        $content = '<?php

class Circle implements IGeometric
{
    public function square()
    {
    }
}
';
        file_put_contents('Circle.php', $content);

        $content = '<?php

interface IGeometric
{
    public function square();
}
';
        file_put_contents('IGeometric.php', $content);

        $content = '<?php

interface IAngular
{
    public function countAngles();
}
';
        file_put_contents('IAngular.php', $content);

        $content = '<?php

interface ISquarable
{
    public function square();
}
';
        file_put_contents('ISquarable.php', $content);
    }

    /**
     * @return string
     */
    protected function getBaseDirectory()
    {
        return 'test/I';
    }

}