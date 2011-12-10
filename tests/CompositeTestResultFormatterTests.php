<?php

use \Mockery as m;
use \pUnit\CompositeTestResultFormatter as CompositeTestResultFormatter;

class CompositeTestResultFormatterTests
{
    
    public function TearDown()
    {
        m::close();
    }
    
    private function GetFormatterMock($methodName, $args = null)
    {
        $methods = array('StartTest' => null, 'StartSuite' => null, 'EndTest' => null, 'EndSuite' => null, 'Summarize' => null);
        
        unset($methods[$methodName]);
        
        $formatter = m::mock('\pUnit\Interfaces\ITestResultFormatter');
        $func = $formatter->shouldReceive($methodName)->once();
        call_user_func_array(array($func, 'with'), $args);
        
        return $formatter;
    }
    
    public function Should_Call_All_Start_Test()
    {
        $formatter = self::GetFormatterMock('StartTest', array('name'));
        
        $composite = new CompositeTestResultFormatter(array($formatter));
        $composite->StartTest('name');
    }
    
    public function Should_Call_All_End_Test()
    {
        $formatter = self::GetFormatterMock('EndTest', array(false, null));
        
        $composite = new CompositeTestResultFormatter(array($formatter));
        $composite->EndTest(false);
    }
    
    public function Should_Call_All_Start_Suite()
    {
        $formatter = self::GetFormatterMock('StartSuite', array('name', 5));
        
        $composite = new CompositeTestResultFormatter(array($formatter));
        $composite->StartSuite('name', 5);
    }
    
    public function Should_Call_All_End_Suite()
    {
        $formatter = self::GetFormatterMock('EndSuite', array());
        
        $composite = new CompositeTestResultFormatter(array($formatter));
        $composite->EndSuite();
    }
    
    public function Should_Call_All_Summarize()
    {
        $formatter = self::GetFormatterMock('Summarize', array());
        
        $composite = new CompositeTestResultFormatter(array($formatter));
        $composite->Summarize();
    }
    
}