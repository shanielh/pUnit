<?php

use \pUnit\Assert as Assert;
use \Mockery as m;

class TestRunnerTests
{
    private static function GetMock($interface, $methods)
    {
        $methodsHash = array();
        foreach ($methods as $method)
        {
            $methodsHash[$method] = null;
        }
        
        $mock = m::mock($interface, $methodsHash);
        return $mock;
    }
    
    private static function GetTestMock($methods)
    {
        return self::GetMock('\pUnit\Interfaces\ITest', func_get_args());
    }
    
    private static function GetProviderMock($methods)
    {
        return self::GetMock('\pUnit\Interfaces\ITestProvider', func_get_args());        
    }
    
    private static function GetFormatterMock($methods)
    {
        return self::GetMock('\pUnit\Interfaces\ITestResultFormatter', func_get_args());
    }
    
    private static function RunWithNullFormatter($test)
    {
        $formatter = self::GetFormatterMock('StartSuite', 'EndSuite', 'StartTest', 'EndTest', 'Summarize');

        self::RunWithFormatter($test, $formatter);
    }
    
    private static function RunWithFormatter($test, $formatter)
    {
        $runner = new \pUnit\TestRunner();
        
        $runner->SetOutput($formatter);
        $runner->SetTest($test);
        
        $runner->Run();
    }

    public function TearDown()
    {
        m::close();
    }
    
    // Interaction With ITest
    
    public function Should_Call_Test_GetName()
    {
        $test = self::GetTestMock('SetUp','TearDown','Test');
        $test->shouldReceive('GetName')->once();
    
        self::RunWithNullFormatter($test);
    }
    
    public function Should_Call_Test_Once()
    {
        $test = self::GetTestMock('GetName','TearDown','SetUp');
        $test->shouldReceive('Test')->once();

        self::RunWithNullFormatter($test);
    }
    
    public function Should_Call_Test_Procedure_In_Right_Order()
    {
        $test = self::GetTestMock('GetName');
        $test->shouldReceive('SetUp')->once()->ordered();
        $test->shouldReceive('Test')->once()->ordered();
        $test->shouldReceive('TearDown')->once()->ordered();
         
        self::RunWithNullFormatter($test);
    }
    
    public function Should_Not_Call_Test_And_TearDown_If_SetUp_Failed()
    {
        $test = self::GetTestMock('GetName');
        $test->shouldReceive('SetUp')->once()->andThrow(new Exception());

        self::RunWithNullFormatter($test);
    }
    
    public function Should_Call_TearDown_Even_If_Test_Failed()
    {
        $test = self::GetTestMock('GetName');
        $test->shouldReceive('SetUp')->once()->ordered();
        $test->shouldReceive('Test')->once()->andThrow(new Exception())->ordered();
        $test->shouldReceive('TearDown')->once()->ordered();
         
        self::RunWithNullFormatter($test);
    }
    
    // Interaction With ITestProvider Tests
    
    public function Should_Call_Get_Tests()
    {
        $test = self::GetTestMock('GetName','SetUp','Test','TearDown');
        
        $provider = self::GetProviderMock('GetName');
        $provider->shouldReceive('GetTests')->atLeast(1)->andReturn(array($test));
        
        self::RunWithNullFormatter($provider);
    }
    
    public function Should_Test_Inner_Tests()
    {
        $test = self::GetTestMock('GetName');
        $test->shouldReceive('SetUp')->once()->ordered();
        $test->shouldReceive('Test')->once()->ordered();
        $test->shouldReceive('TearDown')->once()->ordered();
        
        $provider = self::GetProviderMock('GetName', 'SetUp', 'TearDown');
        $provider->shouldReceive('GetTests')->atLeast(1)->andReturn(array($test));
        
        self::RunWithNullFormatter($provider);
    }
    
    public function Should_Test_Inner_Provider()
    {
        $innerProvider = self::GetProviderMock('GetName', 'SetUp', 'TearDown');
        $innerProvider->shouldReceive('GetTests')->atLeast(1)->andReturn(array());
        
        $provider = self::GetProviderMock('GetName', 'SetUp', 'TearDown');
        $provider->shouldReceive('GetTests')->atLeast(1)->andReturn(array($innerProvider));
        
        self::RunWithNullFormatter($provider);
    }
    
    // Interaction With Formatter Tests
    
    public function Shouuld_Call_Start_Suite_When_Walking_On_Provider()
    {
        $formatter = self::GetFormatterMock('EndSuite','StartTest','EndTest','Summarize');
        $formatter->shouldReceive('StartSuite')->with('Hey', 1)->once();
        
        $provider = self::GetProviderMock('SetUp','TearDown');
        $provider->shouldReceive('GetTests')->andReturn(array(self::GetTestMock('GetName')))->atLeast(1);
        $provider->shouldReceive('GetName')->andReturn('Hey');
        
        self::RunWithFormatter($provider, $formatter);
    }
    
    public function Shouuld_Call_End_Suite_When_Walking_On_Provider()
    {
        $formatter = self::GetFormatterMock('StartSuite','StartTest','EndTest','Summarize');
        $formatter->shouldReceive('EndSuite')->once();
        
        $provider = self::GetProviderMock('SetUp','TearDown', 'GetName');
        $provider->shouldReceive('GetTests')->andReturn(array());
        $provider->shouldReceive('Count')->andReturn(0);
        
        self::RunWithFormatter($provider, $formatter);
    }
    
    public function Should_Call_Sumarize()
    {
        $formatter = self::GetFormatterMock('StartSuite', 'EndSuite', 'StartTest', 'EndTest');
        $formatter->shouldReceive('Summarize')->once();
        
        $provider = self::GetProviderMock('SetUp','TearDown', 'GetName');
        $provider->shouldReceive('GetTests')->andReturn(array());
        $provider->shouldReceive('Count')->andReturn(0);
        
        self::RunWithFormatter($provider, $formatter);
    }
    
    public function Should_Call_StartTest_When_Got_Test()
    {
        $formatter = self::GetFormatterMock('StartSuite', 'EndSuite', 'Summarize', 'EndTest');
        $formatter->shouldReceive('StartTest')->with('Hey');
        
        $test = self::GetTestMock('SetUp','Test','TearDown');
        $test->shouldReceive('GetName')->andReturn('Hey');
        
        self::RunWithFormatter($test, $formatter);
    }
    
    public function Should_Call_EndTest_When_Got_Test()
    {
        $formatter = self::GetFormatterMock('StartSuite', 'EndSuite', 'Summarize', 'StartTest');
        $formatter->shouldReceive('EndTest')->with(true);
        
        $test = self::GetTestMock('SetUp','Test','TearDown');
        $test->shouldReceive('GetName')->andReturn('Hey');
        
        self::RunWithFormatter($test, $formatter);
    }
    
    public function Should_Call_With_Exception_When_Got_Failed_Test()
    {
        $e = new \Exception();
    
        $formatter = self::GetFormatterMock('StartSuite', 'EndSuite', 'Summarize', 'StartTest');
        $formatter->shouldReceive('EndTest')->with(false, m::Type('\Exception'));
        
        $test = self::GetTestMock('SetUp','TearDown');
        $test->shouldReceive('GetName')->andReturn('Hey');
        $test->shouldReceive('Test')->andThrow($e);
        
        self::RunWithFormatter($test, $formatter);
    }
    
}