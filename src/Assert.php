<?php

namespace pUnit;

abstract class Assert
{
    
    public static function AreEqual($expected, $actual, $message = '')
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
    
    public static function AreNotEqual($expected, $actual, $message = '')
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
    
    public static function AreSame($expected, $actual, $message = '')
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
    
    public static function AreNotSame($expected, $actual, $message = '')
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
    
    private static function Fail($message)
    {
        throw new AssertFailedException($message);
    }

}