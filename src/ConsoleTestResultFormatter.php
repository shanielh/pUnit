<?php

namespace pUnit;

class ConsoleTestResultFormatter implements Interfaces\ITestResultFormatter
{
    
    private function WriteLine($message)
    {
        echo $message . "\r\n";    
    }
    
    public function StartTest($name)
    {
        $this->WriteLine('Start Test : ' . $name);
    }
    
    public function EndTest($result, \Exception $e = null)
    {
        $this->WriteLine('End Test With Result ' . ($result ? 'Success' : 'Fail') . ' - ' . $e);
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