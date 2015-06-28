<?php

include 'vendor/autoload.php';


if (php_sapi_name() != 'cli') {
    die('This script works only in CLI mode'.PHP_EOL);
}

if (!isset($argv[1]) || isset($argv[2])) {
    die('Need one argument for running'.PHP_EOL);
}

try {
    $generator = OpsWay\Test2\Solid\Factory::create($argv[1]);
    $generator->generate();
    echo $generator->printQuestion();
} catch (OpsWay\Test2\Solid\Exception $e) {
    echo $e->getMessage() . "\n";
}
