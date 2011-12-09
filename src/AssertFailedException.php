<?php

namespace pUnit;

class AssertFailedException extends \Exception
{
    
    public AssertFailedException($message)
    {
        parent::__construct($message);
    }
    
}