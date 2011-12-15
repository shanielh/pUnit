<?php

namespace pUnit;

class Is
{
    
    private static function Delegate($func)
    {
        return new DelegateAssertion($func);    
    }
    
    public static function True()
    {
        return self::Delegate(function ($obj) { return $obj === true; });
    }
    
    public static function False()
    {
        return self::Delegate(function($obj) { return $obj === false; });
    }
    
    public static function Equal($value)
    {
        return self::Delegate(function ($obj) use ($value) { return $obj === $value; });
    }
    
    public static function Not($assertion)
    {
        return self::Delegate(function ($obj) use ($assertion) { return !$assertion->Run($obj); });
    }
}