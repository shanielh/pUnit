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
    
    public function Shutdown()
    {
        if (!is_null($e = error_get_last()))
        {
            $exception = new \ErrorException($e['message'], 0, $e['type'], $e['file'], $e['line']);
            $this->mFormatter->FatalError($exception);       
        }
        
        exit();
    }
 
    public function Run()
    {
        register_shutdown_function(array($this, 'Shutdown'));
        $this->RunPolymorphic($this->mProvider);
        
        $this->mFormatter->Summarize();
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
        else
        {
            throw new Exception("TestProvider should return as tests only classes that implement ITestProvide / ITest.");   
        }
    }
    
    private function RunProvider(Interfaces\ITestProvider $provider)
    {
        $tests = $provider->GetTests();
        $count = TestProvider::Count($provider);
        $this->mFormatter->StartSuite($provider->GetName(), $count);
        
        try
        {
            $provider->SetUp();
            
            foreach ($tests as $test)
            {
                $this->RunPolymorphic($test);
            }
            
            $provider->TearDown();
        }
        catch (\Exception $e)
        {
            $this->mFormatter->EndSuite($e);    
        }
        
        $this->mFormatter->EndSuite();
        
    }
    
    private function RunTest(Interfaces\ITest $test)
    {
        $testEnded = false;
        $this->mFormatter->StartTest($test->GetName());

        try
        {            
            $test->SetUp();               
        }
        catch (\Exception $e)
        {
            $this->mFormatter->EndTest(false, $e);
            
            // SetUp failed, down run the rest of the test it.
            return;
        }
        
        try
        {
            $test->Test();
        }
        catch (\Exception $e)
        {
            $this->mFormatter->EndTest(false, $e);
            $testEnded = true;
        }
        
        try
        {
            $test->TearDown();   
            if (!$testEnded)
            {
                $this->mFormatter->EndTest(true);   
            }         
        }
        catch (\Exception $e)
        {
            if (!$testEnded)
            {
                $this->mFormatter->EndTest(false, $e);            
            }
        }
        
    }
    
}