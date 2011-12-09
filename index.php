<?php

require_once('src/autoloader.php');

use pUnit\Assert as Assert;

class MyTests implements pUnit\Interfaces\IStateTest
{
    
    public function SetUp()
    {
    //    echo 'SetUp';
    }
    
    public function TearDown()
    {
      //  echo 'TearDown';
    }
    
    public function TestSomething()
    {
        //echo 'Test Something';
    }
    
    public function TestOtherthing()
    {
//        echo 'Test Otherthing';
        Assert::AreEqual('a','b');
    }
    
    private function Not_A_Test()
    {
        
    }
    
}

$provider = new pUnit\ClassTestProvider(new MyTests());
$provider->SetUp();

$runner = new pUnit\TestRunner();
$runner->SetOutput(new pUnit\ConsoleTestResultFormatter());
$runner->SetTest($provider);

$runner->Run();
