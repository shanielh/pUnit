<?php

namespace pUnit;

class TestRunner implements Interfaces\ITestRunner
{
    
    private $mFormatter;
    
    private $mProvider;
    
    public function SetOutput(Interfaces\ITestResultFormatter $formatter)
    {
        $this->mFormatter = $formatter;
        
        return $this;
    }
    
    public function SetTest(Interfaces\IStateTest $provider)
    {
        $this->mProvider = $provider;
        
        return $this;
    }
 
    private function Validate()
    {
        if ($this->mFormatter == null)
        {
            throw new Exception("You must call SetOutput before running tests");
        }
        if ($this->mProvider == null)
        {
            throw new Exception("You must call SetTest before running tests");
        }
    }
 
    public function Run()
    {
        $this->RunPolymorphic($this->mProvider);
    }
    
    private function RunPolymorphic(Interfaces\IStateTest $test)
    {
        if ($test instanceof Interfaces\ITestProvider)
        {
            $this->RunProvider($test);
        }
        else if ($test instanceof Interfaces\ITest)
        {
            $this->RunTest($test);
        }
    }
    
    private function RunProvider(Interfaces\ITestProvider $provider)
    {
        $tests = $provider->GetTests();
        $this->mFormatter->StartSuite($provider->GetName(), count($tests));
        
        $provider->SetUp();
        
        foreach ($tests as $test)
        {
            $this->RunPolymorphic($test);
        }
        
        $provider->TearDown();
        
        $this->mFormatter->EndSuite();
        
    }
    
    private function RunTest(Interfaces\ITest $test)
    {
        $this->mFormatter->StartTest($test->GetName());
        
        $test->SetUp();
        try
        {
            $test->Test();
            $this->mFormatter->EndTest(true);
        }
        catch (\Exception $e)
        {
            $this->mFormatter->EndTest(false, $e);
        }
        $test->TearDown();
        
    }
    
}