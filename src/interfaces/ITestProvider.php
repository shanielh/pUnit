<?php

namespace pUnit\Interfaces;

interface ITestProvider extends IStateTest
{

    public function GetName();
    
    public function GetTests();
    
}