<?php

namespace pUnit;

class DelegateAssertion implements Interfaces\IAssertion
{
    
    private $mFunc;
    
    public function __construct($func)
    {
        $this->mFunc = $func;
    }
    
    public function Run($object)
    {
        $func = $this->mFunc;
        return $func($object);
    }
    
}