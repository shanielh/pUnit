pUnit
=====

A Test Driven Development framework for PHP.

Usage
=====

First, Create a test class :

    <?php
    
    using pUnit\Assert as Assert;
    
    class MyTests // Optinally : Implements pUnit\Interfaces\IStateTest
    {
        
        public function ClassSetUp()
        {
            // This will run before the first test
        }
        
        public function ClassTearDown()
        {
            // This will run after the last test
        }
        
        public function SetUp()
        {
            // This will run before any test
        }
        
        public function TearDown()
        {
            // This will run after any test
        }
        
        public function TestRunner_Should_Class_This()
        {
            Assert::AreEqual('expected', 'actual', 'Expected is not actual :(');
        }
        
        private function MyHelperFunction()
        {
            // This will not be called.
        }
        
    }
    
Then, Create a runner (as shown in index.php) :
    
    <?php 
    
    // require_once('MyTests.php')
    
    $provider = new pUnit\ClassTestProvider(new MyTests());
    
    $runner = new pUnit\TestRunner();
    $runner->SetOutput(new pUnit\ConsoleTestResultFormatter);
    $runner->SetTest($provider);
    
    $runner->Run();

Now, Run your tests from the console :

    php index.php
    
How to contribute ? 
===================

See [Issues](https://github.com/morishani/pUnit/issues?sort=created&direction=desc&state=open) . 

Thanks.