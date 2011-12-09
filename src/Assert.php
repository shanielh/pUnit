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
    
    // Todo : IsTrue, IsFalse
    
    // Todo : InstanceOf, NotInstanceOf
    
    
    
    
    private static function Fail($message)
    {
        throw new AssertFailedException($message);
    }

}