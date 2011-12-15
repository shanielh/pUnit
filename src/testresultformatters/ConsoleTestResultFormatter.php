<?php

namespace pUnit\TestResultFormatters;

class ConsoleTestResultFormatter implements \pUnit\Interfaces\ITestResultFormatter
{
    
    private $mSuccess;
    
    private $mFail;
    
    private $mColors;
    
    private $mIndentation = 0;
    
    private $mVerbose;
    
    private $mTestName;
    
    private $mSuiteName;
    
    private $mNumTests = 0;
    
    private $mNumTestsSuccess = 0;
    
    private $mNumSuites = 0;
    
    public function __construct($verbose = true)
    {
        $this->mVerbose = $verbose;
        $this->mColors = new \pUnit\External\ConsoleColors();
        $this->mSuccess = $this->mColors->getColoredString('Success', 'green');
        $this->mFail = $this->mColors->getColoredString('Fail', 'red');
    }
    
    private function WriteLine($message, $indentation = true)
    {
        $this->Write($message . "\r\n", $indentation);    
    }
    
    private function Write($message, $indentation = true)
    {
        if ($indentation && $this->mVerbose)
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
        $this->mTestName = $name;
        $this->mNumTests++;
        if ($this->mVerbose)
        {
            $this->Write('Test : ' . $name);        
        }
    }
    
    public function EndTest($result, \Exception $e = null)
    {
        if ($result)
        {
            $this->mNumTestsSuccess++;
        }
        
        if ($this->mVerbose)
        {
            $this->WriteLine(' - ' . ($result ? $this->mSuccess : $this->mFail) . ($e == null ? '' : ' - ' . $e), false);
            
        }
        else if (!$result)
        {
            $testName = $this->mColors->getBoldString("{$this->mSuiteName}::{$this->mTestName}");
            $this->WriteLine("{$testName} {$this->mFail} : $e");
        }
    }

    public function StartSuite($name, $count)
    {
        $this->mNumSuites++;
        $this->mSuiteName = $name;
        if ($this->mVerbose)
        {
            $this->WriteLine("$name ($count) : ");        
        }
        $this->mIndentation++;
    }
    
    public function EndSuite()
    {
        $this->mIndentation--;
    }
    
    public function Summarize()
    {
        if ($this->mNumTestsSuccess === $this->mNumTests)
        {
            $this->Write($this->mSuccess);
        }
        else
        {
            $this->Write($this->mFail);
        }
        $this->Write(', ');
        $this->WriteLine("{$this->mNumTestsSuccess}/{$this->mNumTests} Tests succeed in {$this->mNumSuites} test suites");
    }
    
}