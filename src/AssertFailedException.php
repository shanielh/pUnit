<?php

namespace pUnit;

class AssertFailedException extends \Exception
{
    
    public function __construct($message)
    {
        parent::__construct($message);
    }
    
}