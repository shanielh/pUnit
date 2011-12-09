<?php

namespace pUnit;

abstract class Assert
{
    
    // Identical : using ===, !== operators
    public static function AreIdentical($expected, $actual, $message = '')
    {
        if ($expected === $actual)
        {
            return;
        }
        
        if ($message === '')
        {
            $message = "Expected '$expected', But actual is '$actual'";
        }
        
        self::Fail($message);
    }
    
    public static function AreNotIdentical($expected, $actual, $message = '')
    {
        if ($expected !== $actual)
        {
            return;
        }
        
        if ($message === '')
        {
            $message = "Expected anything but '$expected', But actual is the same";
        }
        
        self::Fail($message);
    }
    
    // Equal : using ==, != operators
    public static function AreEqual($expected, $actual, $message = '')
    {
        if ($expected == $actual)
        {
            return;
        }
        
        if ($message === '')
        {
            $message = "Expected '$expected', But actual is '$actual'";
        }
        
        self::Fail($message);
    }
    
    public static function AreNotEqual($expected, $actual, $message = '')
    {
        if ($expected != $actual)
        {
            return;
        }
        
        if ($message === '')
        {
            $message = "Expected any thing but '$expected', But actual is '$actual'";
        }
        
        self::Fail($message);
    }
    
    // IsTrue, IsFalse, with ==, != operators.
    // For ===, !== use AreIdentical.
    
    public static function IsTrue($actual, $message = '')
    {
        if ($actual)
        {
            return;
        }
        
        if ($message === '')
        {
            $message = "Expected '$actual' to be True";
        }
        
        self::Fail($message);
    }
    
    public static function IsFalse($actual, $message = '')
    {
        if (!$actual)
        {
            return;
        }
        
        if ($message === '')
        {
            $message = "Expected '$actual' to be False";
        }
        
        self::Fail($message);
    }
    
    // InstanceOf, NotInstanceOf - using instanceof operator.
    
    public static function IsInstanceOf($expectedType, $actual, $message = '')
    {
        if ($actual instanceof $expectedType)
        {
            return;
        }
        
        if ($message === '')
        {
            $message = "Expected '$actual' to be instance of '$expectedType'";
        }
        
        self::Fail($message);
    }
    
    public static function NotInstanceOf($expectedType, $actual, $message = '')
    {
        if (!($actual instanceof $expectedType))
        {
            return;
        }
        
        if ($message === '')
        {
            $message = "Expected '$actual' not to be instance of '$expectedType'";
        }
        
        self::Fail($message);        
    }
    
    public static function IsNull($actual, $message = '')
    {
        if (is_null($actual))
        {
            return;
        }
        
        if ($message === '')
        {
            $message = "Expected '$actual' to be null";
        }
        
        self::Fail($message);
    }
    
    public static function IsNotNull($actual, $message = '')
    {
        if (!is_null($actual))
        {
            return;
        }
        
        if ($message === '')
        {
            $message = "Expected '$actual' not to be null";
        }
        
        self::Fail($message);
    }
    
    private static function Fail($message)
    {
        throw new AssertFailedException($message);
    }

}