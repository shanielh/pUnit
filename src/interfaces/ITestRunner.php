<?php

namespace pUnit\Interfaces;

interface ITestRunner 
{
    public function SetOutput(ITestResultFormatter $formatter);
    
    public function SetTest(IStateTest $provider);
 
    public function Run(); 
}