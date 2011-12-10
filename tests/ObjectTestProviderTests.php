<?php

use \pUnit\Assert as Assert;
use \pUnit\ObjectTestProvider as ObjectTestProvider;
use \Mockery as m;

class Class_With_One_Test
{
    public function MyTest()
    {
        
    }
}

class Class_With_Test_And_SetUp
{
    public $ClassSetUpCalled = false;

    public $SetUpCalled = false;

    public $ClassTearDownCalled = false;

    public $TearDownCalled = false;

    public $TestCalled = false;

    public function ClassSetUp()
    {
        $this->ClassSetUpCalled = true;
    }
    
    public function ClassTearDown()
    {
        $this->ClassTearDownCalled = true;
    }
    
    public function SetUp()
    {
        $this->SetUpCalled = true;
    }
    
    public function TearDown()
    {
        $this->TearDownCalled = true;
    }
    
    public function MyTest()
    {
        $this->TestCalled = true;
    }
}

class ObjectTestProviderTests
{
    
    public function TearDown()
    {
        m::close();
    }
    
    public function Should_Return_Class_Name_As_Suite_Name()
    {
        $provider = new ObjectTestProvider(new Class_With_One_Test());
        
        Assert::AreEqual('Class_With_One_Test', $provider->GetName());
    }
    
    public function Count_Should_Return_Count_Of_Public_Methods()
    {
        $provider = new ObjectTestProvider(new Class_With_One_Test());
        
        Assert::AreEqual(1, $provider->Count());
    }

    public function Get_Tests_Should_Return_Public_Methods_As_DelegateTest()
    {
        $provider = new ObjectTestProvider(new Class_With_One_Test());
        
        $tests = $provider->GetTests();

        Assert::AreEqual('MyTest', $tests[0]->GetName());
    }
    
    public function Class_SetUp_Should_Be_Called_On_SetUp()
    {
        $test = new Class_With_Test_And_SetUp();
        $provider = new ObjectTestProvider($test);
        
        $provider->SetUp();
        Assert::IsTrue($test->ClassSetUpCalled);
    }

    public function Class_TearDown_Should_Be_Called_On_TearDown()
    {
        $test = new Class_With_Test_And_SetUp();
        $provider = new ObjectTestProvider($test);
        
        $provider->TearDown();
        Assert::IsTrue($test->ClassTearDownCalled);
    }

    public function SetUp_Should_Be_Called_On_Test_SetUp()
    {
        $test = new Class_With_Test_And_SetUp();
        $provider = new ObjectTestProvider($test);
        
        $tests = $provider->GetTests();
        $tests[0]->SetUp();
        Assert::IsTrue($test->SetUpCalled);
    }

    public function TearDown_Should_Be_Called_On_Test_TearDown()
    {
        $test = new Class_With_Test_And_SetUp();
        $provider = new ObjectTestProvider($test);
        
        $tests = $provider->GetTests();
        $tests[0]->TearDown();
        Assert::IsTrue($test->TearDownCalled);
    }
    
    public function Test_Should_Be_Called_On_Test_Call()
    {
        $test = new Class_With_Test_And_SetUp();
        $provider = new ObjectTestProvider($test);
        
        $tests = $provider->GetTests();
        $tests[0]->Test();
        Assert::IsTrue($test->TestCalled);
    }

    
}