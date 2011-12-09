<?php

namespace pUnit;

class ConsoleTestResultFormatter implements Interfaces\ITestResultFormatter
{
    
    private function WriteLine($message)
    {
        $this->Write($message . "\r\n");    
    }
    
    private function Write($message)
    {
        echo $message;
    }
    
    public function StartTest($name)
    {
        $this->Write('Test : ' . $name);
    }
    
    public function EndTest($result, \Exception $e = null)
    {
        $this->WriteLine(' - ' . ($result ? 'Success' : 'Fail') . ($e == null ? '' : ' - ' . $e));
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