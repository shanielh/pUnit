<?php

use pUnit\Assert as Assert;
use \Mockery as m;

class AssertTests 
{
    
    public function TearDown()
    {
        m::close();   
    }
    
    // Throws :
    
    public function Throws_Should_Throw_When_Exception_Not_Thrown()
    {
        $func = function() {};
        try
        {
            Assert::Throws($func, 'Exception');
        }
        catch (Exception $e)
        {
            return;
        }
        
        throw new Exception('Exception should have been thrown, but wasn\'t');
    }
    
    public function Throws_Should_Not_Throw_When_Exception_Thrown()
    {
        $func = function() { throw new Exception(); };
        
        Assert::Throws($func, 'Exception');
    }
    
    public function Throws_Should_Throw_When_Exception_Thrown_Of_Wrong_Type()
    {
        $func = function() { throw new Exception(); };
        
        try
        {
            Assert::Throws($func, 'My_Not_Exists_Exception_Type');        
        }
        catch (Exception $e)
        {
            return;
        }
        
        throw new Exception('Exception should have been thrown, But wasn\'t');
    }
    
    // IsTrue, IsFalse :
    
    public function IsTrue_Should_Throw_When_Not_True()
    {
        $func = function() {Assert::IsTrue(0);};
        Assert::Throws($func, 'Exception');    
    }
    
    public function IsTrue_Should_Not_Throw_When_True()
    {
        Assert::IsTrue(1);
    }
    
    public function IsFalse_Should_Throw_When_Not_False()
    {
        $func = function() {Assert::IsFalse(1);};
        Assert::Throws($func, 'Exception');
    }
    
    public function IsFalse_Should_Not_Throw_When_False()
    {
        Assert::IsFalse(0);
    }
    
    // AreEqual, AreIdentical :
    
    public function AreEqual_Should_Throw_When_Not_Equals()
    {
        $func = function() {Assert::AreEqual(1,0);};
        Assert::Throws($func, 'Exception');
    }
    
    public function AreEqual_Should_Not_Throw_When_Equals()
    {
        Assert::AreEqual(1,'1');
    }
    
    public function AreIdentical_Should_Throw_When_Not_Identical()
    {
        $func = function() {Assert::AreIdentical(1,'1');};
        Assert::Throws($func, 'Exception');
    }
    
    public function AreIdentical_Should_Not_Throw_When_Identical()
    {
        Assert::AreIdentical(1,1);
    }
    
    // IsNull, IsNotNull
    
    public function IsNull_Should_Throw_When_Not_Null()
    {
        $func = function() {Assert::IsNull(1);};
        Assert::Throws($func, 'Exception');
    }

    public function IsNull_Should_Not_Throw_When_Null()
    {
        Assert::IsNull(null);
    }
    
    public function IsNotNull_Should_Throw_When_Null()
    {
        $func = function() {Assert::IsNotNull(null);};
        Assert::Throws($func, 'Exception');
    }
    
    public function IsNotNull_Should_Not_Throw_When_Null()
    {
        Assert::IsNotNull(1);
    }
    
    // InstanceOf, NotInstanceOf
    
    public function IsInstanceOf_Should_Throw_When_Not_Instance_Of()
    {
        $func = function() {Assert::IsInstanceOf('Exception', 1);};
        Assert::Throws($func, 'Exception');
    }
    
    public function IsInstanceOf_Should_Not_Throw_When_Instance_Of()
    {
        Assert::IsInstanceOf('Exception', new Exception());
    }
    
    public function NotInstanceOf_Should_Throw_When_Instance_Of()
    {
        $func = function() {Assert::NotInstanceOf('Exception', new Exception());};
        Assert::Throws($func, 'Exception');        
    }
    
    public function NotInstanceOf_Should_Not_Throw_When_Not_Instance_Of()
    {
        Assert::NotInstanceOf('Exception', 1);
    }
    
    
    // That :
    
    public function That_Should_Not_Catch_Exceptions()
    {
        $mock = m::mock('\pUnit\Interfaces\IAssertion');
        $mock->shouldReceive('Run')->andThrow(new \Exception());
        try
        {
            Assert::That(5, $mock);
        }
        catch (\Exception $e)
        {
            return;
        }
        
        Assert::Fail('Exception was swallowed');
    }
    
}