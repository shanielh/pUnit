<?php

require_once('src/autoloader.php');

use pUnit\Assert as Assert;

$pattern = '/.php$/i';
$classExport = function($fileName) {
    return substr($fileName,0 ,-4);
    
};
$provider = new pUnit\FolderTestProvider(__DIR__ . DS . 'tests', $pattern, $classExport);

$runner = new pUnit\TestRunner();
$runner->SetOutput(new pUnit\ConsoleTestResultFormatter());
$runner->SetTest($provider);

$runner->Run();
