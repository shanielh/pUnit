<?php

namespace pUnit;

class ConsoleTestResultFormatter implements Interfaces\ITestResultFormatter
{
    
    private $mSuccess;
    
    private $mFail;
    
    private $mColors;
    
    private $mIndentation = 0;
    
    public function __construct()
    {
        $this->mColors = new External\ConsoleColors();
        $this->mSuccess = $this->mColors->getColoredString('Success', 'green');
        $this->mFail = $this->mColors->getColoredString('Fail', 'red');
    }
    
    private function WriteLine($message, $indentation = true)
    {
        $this->Write($message . "\r\n", $indentation);    
    }
    
    private function Write($message, $indentation = true)
    {
        if ($indentation)
        {
            echo $this->GetIndentation();
        }
        echo $message;
    }
    
    private function GetIndentation()
    {
        return str_repeat("  ", $this->mIndentation);
    }
    
    public function StartTest($name)
    {
        $this->Write('Test : ' . $name);
    }
    
    public function EndTest($result, \Exception $e = null)
    {
        $this->WriteLine(' - ' . ($result ? $this->mSuccess : $this->mFail) . ($e == null ? '' : ' - ' . $e), false);
    }

    public function StartSuite($name, $count)
    {
        $this->WriteLine("$name ($count) : ");
        $this->mIndentation++;
    }
    
    public function EndSuite()
    {
        $this->mIndentation--;
    }
    
    public function Summarize()
    {
        $this->WRiteLine('<EOF>');
    }
    
}