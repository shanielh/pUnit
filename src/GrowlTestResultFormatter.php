<?php

namespace pUnit;

require_once(__DIR__ . '/external/php-growl/class.growl.php');

class GrowlTestResultFormatter implements Interfaces\ITestResultFormatter
{
    
    private $mGrowl;
    
    private $mConnection;
    
    private $mTestName;
    
    private $mSuiteName;
    
    public function __construct($ip, $password)
    {
        $this->mGrowl = new \Growl();
        $this->mConnection = array('address' => $ip, 'password' => $password);

        // Adding and registering your notifications with Growl
        // only needs to be done once per computer. Growl will
        // remember your app after this.
        $this->mGrowl->addNotification('pUnit');
        $this->mGrowl->register($this->mConnection);
    
    }
    
    public function StartTest($name)
    {
        $this->mTestName = $name;   
    }
    
    public function StartSuite($name, $count)
    {
        $this->mSuiteName = $name;
    }
    
    public function EndSuite()
    {
        
    }
    
    public function Summarize()
    {
        
    }
    
    public function EndTest($result, \Exception $e = null)
    {
        if (!$result)
        {
            $this->mGrowl->notify($this->mConnection, 'pUnit', "{$this->mSuiteName} Failed", $this->mTestName);
        }
    }
    
}