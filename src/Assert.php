<?php

namespace pUnit;

abstract class Assert
{
    
    public function AreEqual($expected, $actual, $message = '')
    {
        if ($expected === $actual)
        {
            return;
        }
        
        if ($message === '')
        {
            $message = "Expected '$expected', But actual is '$actual'";
        }
        
        self::Throw($message);
    }
    
    public function AreNotEqual($expected, $actual, $message = '')
    {
        if ($expected !== $actual)
        {
            return;
        }
        
        if ($message === '')
        {
            $message = "Expected anything but '$expected', But actual is the same";
        }
        
        self::Throw($message);
    }
    
    public function AreSame($expected, $actual, $message = '')
    {
        if ($expected == $actual)
        {
            return;
        }
        
        if ($message === '')
        {
            $message = "Expected '$expected', But actual is '$actual'";
        }
        
        self::Throw($message);
    }
    
    public function AreNotSame($expected, $actual, $message = '')
    {
        if ($expected != $actual)
        {
            return;
        }
        
        if ($message === '')
        {
            $message = "Expected any thing but '$expected', But actual is '$actual'";
        }
        
        self::Throw($message);
    }
    
    private static function Throw($message)
    {
        throw new AssertFailedException($message);
    }

}