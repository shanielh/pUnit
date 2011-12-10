<?php

namespace pUnit;

class ObjectTestProvider implements Interfaces\ITestProvider
{
    
    private $mObject;
    
    private $mSetUpMethod;
    
    private $mTearDownMethod;
    
    private $mTests;
    
    private static $MethodsToBypass = array('SetUp' => true, 'TearDown' => true, 
                                            'ClassSetUp' => true, 'ClassTearDown' => true);
    
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
        if ($this->mTests !== null)
        {
            return $this->mTests;
        }
        
        $reflectionClass = new \ReflectionClass($this->mObject);

        $object = $this->mObject;
        $setUp    = self::GetMethodOrEmpty($this->mObject, 'SetUp');
        $tearDown = self::GetMethodOrEmpty($this->mObject, 'TearDown');
        
        $this->mTests = array();
        
        foreach ($reflectionClass->getMethods() as $method)
        {
            $methodName = $method->getName();
            if (array_key_exists($methodName, self::$MethodsToBypass) ||
                !$method->isPublic())
            {
                continue;
            }
            
            $methodInvoke = function() use ($method, $object) 
            {
                $method->invoke($object);    
            };
            
            $test = new DelegateTest($method->getName(), $methodInvoke, $setUp, $tearDown);
  
            $this->mTests[] = $test;
        }
        
        return $this->mTests;
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