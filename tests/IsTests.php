<?php

use \pUnit\Assert as Assert;
use \pUnit\Is as Is;
use \Mockery as m;

class IsTests 
{

    public function True_Should_Return_False_When_Not_True()
    {
        Assert::IsFalse(Is::True()->Run(false));
    }
    
    public function False_Should_Return_False_When_Not_False()
    {
        Assert::IsFalse(Is::False()->Run(true));
    }
    
    public function Equal_Should_Return_False_When_Not_Equal()
    {
        Assert::IsFalse(Is::Equal(5)->Run(4));
    }
    
    public function Not_Should_Return_The_Oposite()
    {
        Assert::IsTrue(Is::Not(Is::True())->Run(false));
    }

}