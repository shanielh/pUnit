<?php

namespace pUnit;

class ConsoleTestResultFormatter implements Interfaces\ITestResultFormatter
{
    
    private $mSuccess;
    
    private $mFail;
    
    private $mColors;
    
    public function __construct()
    {
        $this->mColors = new External\ConsoleColors();
        $this->mSuccess = $this->mColors->getColoredString('Success', 'green');
        $this->mFail = $this->mColors->getColoredString('Fail', 'red');
    }
    
    private function WriteLine($message)
    {
        $this->Write($message . "\r\n");    
    }
    
    private function Write($message)
    {
        echo $message;
    }
    
    public function StartTest($name)
    {
        $this->Write('Test : ' . $name);
    }
    
    public function EndTest($result, \Exception $e = null)
    {
        $this->WriteLine(' - ' . ($result ? $this->mSuccess : $this->mFail) . ($e == null ? '' : ' - ' . $e));
    }

    public function StartSuite($name, $count)
    {
        $this->WriteLine('Start Suite ' . $name . ' ('. $count . ')');
    }
    
    public function EndSuite()
    {
        $this->WriteLine('End Suite');
    }
    
}