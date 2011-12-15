<?php

use \pUnit\Assert as Assert;
use \pUnit\Is as Is;
use \Mockery as m;

class IsTests 
{

    public function True_Should_Throw_When_Not_True()
    {
        Assert::Throws(function() {
            Is::True()->Run(false);
        }, 'Exception');
    }
    
    public function False_Should_Throw_When_Not_False()
    {
        Assert::Throws(function() {
            Is::False()->Run(true);
        }, 'Exception');
    }

}