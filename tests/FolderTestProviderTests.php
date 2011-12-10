<?php

use \pUnit\Assert as Assert;
use \pUnit\FolderTestProvider as FolderTestProvider;
use \pUnit\ObjectTestProvider as ObjectTestProvider;
use \Mockery as m;

class FolderTestProviderTests
{
    
    private static $pattern = "/.php$/i";
    
    public function TearDown()
    {
        m::close();
    }
    
    private static function GetFilesFromThisFolder($pattern)
    {
        $files = array();
        foreach (scandir(__DIR__) as $fileName)
        {
            $filePath = __DIR__ . DIRECTORY_SEPARATOR . $fileName;
            if (is_file($filePath) && preg_match($pattern, $fileName) > 0)
            {
                array_push($files, $fileName);
            }
        }
        return $files;
    }
    
    public function Should_Call_Class_Export_From_This_Folder()
    {
        $files = self::GetFilesFromThisFolder(self::$pattern);
        $calls = array();
        $classExport = function($fileName) use(&$calls) {
            array_push($calls, $fileName);
            return substr($fileName, 0, -4);
        };
        
        $provider = new FolderTestProvider(__DIR__, self::$pattern, $classExport, false);
        
        $provider->GetTests();
        
        Assert::AreIdentical($files, $calls);
    }
    
    public function Should_Return_Files_Matched_As_ObjectTestProvider()
    {
        $classExport = function($fileName) {
            return substr($fileName, 0, -4);
        };
        
        $provider = new FolderTestProvider(__DIR__, self::$pattern, $classExport, false);
        
        $tests = $provider->GetTests();
        
        foreach ($tests as $test)
        {
            Assert::IsInstanceOf('\pUnit\ObjectTestProvider', $tests[1]);            
        }
        
    }
    
    public function Recursive_Should_Return_Folders_As_FolderTestProvider()
    {
         $classExport = function($fileName) {
            return substr($fileName, 0, -4);
        };
        
        $provider = new FolderTestProvider(__DIR__ . '/../', self::$pattern, $classExport, true);
        
        $tests = $provider->GetTests();
        
        foreach ($tests as $test)
        {
            if ($test->GetName() == 'src')
            {
                Assert::IsInstanceOf('\pUnit\FolderTestProvider', $tests[1]);                            
            }
        }

    }
    
}
