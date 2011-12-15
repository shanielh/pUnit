<?php

namespace pUnit;

class Is
{
    
    public static function True()
    {
        return new DelegateAssertion(function($obj) {
            if ($obj !== true)
            {
                throw new \Exception("Object wasn't true");
            }
        });   
    }
    
}