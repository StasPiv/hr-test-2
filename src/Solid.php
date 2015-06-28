<?php

namespace OpsWay\Test2;

use OpsWay\Test2\Solid\Exception;

abstract class Solid
{
    /**
     * @return string
     */
    abstract public function printQuestion();

    abstract protected function createTask();

    /**
     * @return string
     */
    abstract protected function getBaseDirectory();

    public function generate()
    {
        $this->createDirectoryForTask();
        $this->createTask();
    }

    protected function createDirectoryForTask()
    {
        chdir(__DIR__ . '/..');

        if (!file_exists('test')) {
            mkdir('test');
        }

        if (file_exists($this->getBaseDirectory())) {
            exec("rm -rf " . $this->getBaseDirectory());
        }

        if (!mkdir($this->getBaseDirectory())) {
            throw new Exception ('Cannot create folder: ' . $this->getBaseDirectory());
        }

        chdir($this->getBaseDirectory());
    }

    /**
     * @param array $property
     * @return string
     */
    protected function getRandomProperty($property)
    {
        return $property[rand(0, count($property) - 1)];
    }

    /**
     * @param array $property
     * @return array
     */
    protected function getRandomProperties($property)
    {
        $first = $this->getRandomProperty($property);
        do {
            $second = $this->getRandomProperty($property);
        } while ($first == $second);

        return array($first, $second);
    }
}