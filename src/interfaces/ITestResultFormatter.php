<?php

namespace pUnit\Interfaces;

interface ITestResultFormatter
{
    public function StartTest($name);
    
    public function EndTest($result, \Exception $e = null);

    public function StartSuite($name, $count);
    
    public function EndSuite();

}