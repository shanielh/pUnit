<?php

use pUnit\Assert as Assert;

class TestRunnerTests
{
    
    private $mSetUpCalled = 0;
    
    private $mTestCalled = 0;
    
    private $mTearDownCalled = 0;
    
    public function SetUp()
    {
        Assert::AreEqual(0, $this->mSetUpCalled);
        Assert::AreEqual(0, $this->mTestCalled);
        Assert::AreEqual(0, $this->mTearDownCalled);
        
        $this->mSetUpCalled++;
    }
    
    public function SetUp_Should_Be_Called_Before_This()
    {
        Assert::AreEqual(1, $this->mSetUpCalled);
        Assert::AreEqual(0, $this->mTestCalled);
        Assert::AreEqual(0, $this->mTearDownCalled);
        
        $this->mTestCalled++;
    }
    
    public function TearDown()
    {
        Assert::AreEqual(1, $this->mSetUpCalled);
        Assert::AreEqual(1, $this->mTestCalled);
        Assert::AreEqual(0, $this->mTearDownCalled);
        
        $this->mTearDownCalled++;
    }
    
}