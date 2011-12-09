<?php

namespace pUnit;

class ClassTestProvider implements Interfaces\ITestProvider
{
    
    private $mObject;
    
    private $mSetUpMethod;
    
    private $mTearDownMethod;
    
    private static function GetMethodOrEmpty($object, $methodName)
    {
        $reflectionClass = new \ReflectionClass($object);
        
        return $reflectionClass->hasMethod($methodName)
               ? function() use($reflectionClass, $object, $methodName)
                 {
                     $reflectionClass->getMethod($methodName)->invoke($object);
                 }
               : function() { };
        
    }
    
    public function __construct($object)
    {
        $this->mObject = $object;

        $reflectionClass = new \ReflectionClass($this->mObject);
        
        $this->mSetUpMethod    = self::GetMethodOrEmpty($object, 'ClassSetUp');
        $this->mTearDownMethod = self::GetMethodOrEmpty($object, 'ClassTearDown');
        

    }
    
    public function GetName()
    {
        return get_class($this->mObject);
    }
    
    public function GetTests()
    {
        $reflectionClass = new \ReflectionClass($this->mObject);

        $object = $this->mObject;
        $setUp    = self::GetMethodOrEmpty($this->mObject, 'SetUp');
        $tearDown = self::GetMethodOrEmpty($this->mObject, 'TearDown');
        
        $retVal = array();
        
        foreach ($reflectionClass->getMethods() as $method)
        {
            $methodName = $method->getName();
            if ($methodName == 'SetUp' || 
                $methodName == 'TearDown')
            {
                continue;
            }
            
            $methodInvoke = function() use ($method, $object) 
            {
                $method->invoke($object);    
            };
            
            $test = new DelegateTest($method->getName(), $methodInvoke, $setUp, $tearDown);
  
            $retVal[] = $test;
        }
        
        return $retVal;
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