<?php

namespace OpsWay\Test2\Solid;

use OpsWay\Test2\Solid;

class S extends Solid
{
    private $availableClassNames = [
        'Apple',
        'Microsoft',
        'Samsung',
        'Lg',
        'Sony',
        'Panasonic'
    ];

    private $availableMethodNames = [
        'create',
        'buy',
        'steal',
        'see',
        'sell'
    ];

    private $godMethodNames = [];
    private $godFileName = 'God.php';

    /**
     * @return array
     */
    public function getGodMethodNames()
    {
        return $this->godMethodNames;
    }

    public function getGodClassFileName()
    {
        return __DIR__ . '/../../' . $this->getBaseDirectory() . '/' . $this->godFileName;
    }

    public function getGodClassFileTmpName()
    {
        return __DIR__ . '/../../' . $this->getBaseDirectory() . '/../tmp/' . $this->godFileName . '.tmp';
    }

    protected function getBaseDirectory()
    {
        return 'test/S';
    }

    /**
     * @return \OpsWay\Test2\Solid\S
     */
    private function createGodClass()
    {
        $godContent = '<?php

class God
{
    public function ' . $this->godMethodNames[0] . '()
    {
        $this->' . $this->godMethodNames[2] . '();
    }

    public function ' . $this->godMethodNames[1] . '()
    {

    }

    private function ' . $this->godMethodNames[2] . '()
    {

    }
}';
        file_put_contents($this->getGodClassFileName(), $godContent);
        $tmpDir = dirname($this->getGodClassFileTmpName());
        if (!file_exists($tmpDir)) {
            mkdir($tmpDir);
        }
        file_put_contents($this->getGodClassFileTmpName(), str_replace('class God', 'class GodTmp', $godContent));
        return $this;
    }

    /**
     * @return \OpsWay\Test2\Solid\S
     */
    protected function createTask()
    {
        list($firstClassName, $secondClassName) = $this->getRandomProperties($this->availableClassNames);
        list($firstMethodName, $secondMethodName) = $this->getRandomProperties($this->availableMethodNames);

        $this->godMethodNames = [
            $firstMethodName . $firstClassName,
            $this->getRandomProperty($this->availableMethodNames) . $secondClassName,
            $secondMethodName . $firstClassName
        ];

        $this->createGodClass();

        return $this;
    }

    public function printQuestion()
    {
        return "\033[1mStep 1\033[0m. Go to " . $this->getBaseDirectory() . "/God.php, remove God class" . PHP_EOL .
        "\033[1mStep 2\033[0m. Choose correct name for new filenames and new classes." . PHP_EOL.
        "\033[1mStep 3\033[0m. Create new one (or more classes) with method from removed God class in " . $this->getBaseDirectory() . " folder to implement S-principe. Put removed methods from step 1 into them. Rename these methods in new classes. Be careful. ClassName is noun, MethodName is laconic verb." . PHP_EOL .
        "\033[1mStep 4\033[0m. Go to phpunit/Checker directory and run \033[1mphpunit Test_Checker_S.php\033[0m" . PHP_EOL;
    }


}