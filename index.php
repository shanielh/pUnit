<?php

set_include_path(get_include_path() . PATH_SEPARATOR . __DIR__ . '/src/external/mockery/library/');

require_once('src/autoloader.php');
require_once('Mockery/Loader.php');

$loader = new \Mockery\Loader();
$loader->register();

\Mockery::getConfiguration()->allowMockingMethodsUnnecessarily(false);



use pUnit\Assert as Assert;

$pattern = '/.php$/i';
$classExport = function($fileName) {
    return substr($fileName,0 ,-4);
    
};
$provider = new pUnit\FolderTestProvider(__DIR__ . DS . 'tests', $pattern, $classExport);

$runner = new pUnit\TestRunner();
$formatter = new pUnit\CompositeTestResultFormatter(array(
    new pUnit\GrowlTestResultFormatter('127.0.0.1','password'),
    new pUnit\ConsoleTestResultFormatter(false)
    ));
$runner->SetOutput($formatter);
$runner->SetTest($provider);

$runner->Run();
