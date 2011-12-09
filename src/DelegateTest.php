<?php

namespace pUnit;

class DelegateTest implements Interfaces\ITest
{
    
    private $mTestMethod;
    
    private $mSetUpMethod;
    
    private $mTearDownMethod;
    
    private $mName;
    
    public function __construct($name, $testMethod, $setUpMethod, $tearDownMethod)
    {
        $this->mName = $name;
        $this->mTestMethod = $testMethod;
        $this->mSetUpMethod = $setUpMethod;
        $this->mTearDownMethod = $tearDownMethod;
    }
    
    public function GetName()
    {
        return $this->mName;
    }
    
    public function Test()
    {
        $method = $this->mTestMethod;
        $method();
    }
    
    public function SetUp()
    {
        $method = $this->mSetUpMethod;
        $method();
    }
    
    public function TearDown()
    {
        $method = $this->mTearDownMethod;
        $method();
    }
    
}