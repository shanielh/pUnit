<?php

namespace pUnit\TestResultFormatters;

class CompositeTestResultFormatter implements \pUnit\Interfaces\ITestResultFormatter
{
    private $mFormatters;
    
    public function __construct($formatters)
    {
        $this->mFormatters = $formatters;
    }
    
    public function StartTest($name)
    {
        foreach ($this->mFormatters as $formatter)
        {
            $formatter->StartTest($name);
        }
    }
    
    public function EndTest($result, \Exception $e = null)
    {
        foreach ($this->mFormatters as $formatter)
        {
            $formatter->EndTest($result, $e);
        }
    }

    public function StartSuite($name, $count)
    {
        foreach ($this->mFormatters as $formatter)
        {
            $formatter->StartSuite($name, $count);
        }        
    }
    
    public function EndSuite()
    {
        foreach ($this->mFormatters as $formatter)
        {
            $formatter->EndSuite();
        }        
    }
    
    public function Summarize()
    {
        foreach ($this->mFormatters as $formatter)
        {
            $formatter->Summarize();
        }
        
    }

}