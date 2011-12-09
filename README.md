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
        
        function ClassSetUp()
        {
            // This will run before the first test
        }
        
        function ClassTearDown()
        {
            // This will run after the last test
        }
        
        function SetUp()
        {
            // This will run before any test
        }
        
        function TearDown()
        {
            // This will run after any test
        }
        
        function TestRunner_Should_Class_This()
        {
            Assert::AreEqual('expected', 'actual', 'Expected is not actual :(');
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
    
To do 
=====

1. Add more asserts
2. Create a (Recursive) Provider for a whole folder

For requests - add an issue :-)