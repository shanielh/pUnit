<?php

use pUnit\Assert as Assert;
use pUnit\DelegateTest as DelegateTest;

class DelegateTestTests
{
    
    private static function GetEmptyFunction()
    {
        return function() { };
    }
    
    private static function GetCounterFunction(&$counter)
    {
        return function() use(&$counter) { $counter++; };
    }
    
    public function GetName_Should_Return_Name()
    {
        $name = 'MyName';
        $emptyFunction = self::GetEmptyFunction();
        $object = new DelegateTest($name, $emptyFunction, $emptyFunction, $emptyFunction);
        
        Assert::AreEqual($name, $object->GetName());
    }
    
    public function SetUp_Should_Call_SetUp()
    {
        $counter = 0;
        $counterFunction = self::GetCounterFunction($counter);
        $emptyFunction = self::GetEmptyFunction();
        $object = new DelegateTest(null, $emptyFunction, $counterFunction, $emptyFunction);
        
        $object->SetUp();
        
        Assert::AreEqual(1, $counter);
    }
    
    public function Test_Should_Call_Test()
    {
        $counter = 0;
        $counterFunction = self::GetCounterFunction($counter);
        $emptyFunction = self::GetEmptyFunction();
        $object = new DelegateTest(null, $counterFunction, $emptyFunction, $emptyFunction);
        
        $object->Test();
        
        Assert::AreEqual(1, $counter);
    }
    
    public function TearDown_Should_Call_TearDown()
    {
        $counter = 0;
        $counterFunction = self::GetCounterFunction($counter);
        $emptyFunction = self::GetEmptyFunction();
        $object = new DelegateTest(null, $emptyFunction, $emptyFunction, $counterFunction);
        
        $object->TearDown();
        
        Assert::AreEqual(1, $counter);        
    }
    
}