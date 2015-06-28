<?php

namespace OpsWay\Test2\Solid;

use OpsWay\Test2\Solid;

class D extends Solid
{
    /**
     * @return string
     */
    public function printQuestion()
    {
        return "\033[1mStep 1\033[0m. Go to " . $this->getBaseDirectory() . PHP_EOL .
        "\033[1mStep 2\033[0m. Use \$reader property and IReader interface to implement D-principe" . PHP_EOL.
        "\033[1mStep 3\033[0m. Go to phpunit/Checker directory and run \033[1mphpunit Test_Checker_D.php\033[0m"  . PHP_EOL;
    }

    protected function createTask()
    {
        $content = '<?php

interface IReader
{

}';
        file_put_contents('IReader.php', $content);

        $content = '<?php

class CsvReader
{
    /**
      * @return array
      */
    public function read()
    {
        return [1, 2, 3];
    }
}';
        file_put_contents('CsvReader.php', $content);

        $content = '<?php

class App
{
    /** @var IReader */
    private $reader;

    public function __construct()
    {

    }

    public function parse()
    {
        $reader = new CsvReader();
        return $reader->read();
    }
}';
        file_put_contents('App.php', $content);

        $content = '<?php

$app = new App();
print_r($app->parse());
';
        file_put_contents('run.php', $content);
    }

    /**
     * @return string
     */
    protected function getBaseDirectory()
    {
        return 'test/D';
    }

}