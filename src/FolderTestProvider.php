<?php

namespace pUnit;

class FolderTestProvider implements Interfaces\ITestProvider
{
    
    private $mFolderName;
    
    private $mRecursive;
    
    private $mFilePattern;
    
    private $mClassPattern;
    
    private $mTests;
    
    public function __construct($folderName, $filePattern, $classPattern, $recursive = true)
    {
        $this->mFolderName = $folderName;
        $this->mRecursive = $recursive;
        $this->mFilePattern = $filePattern;
        $this->mClassPattern = $classPattern;
    }
    
    public function TearDown()
    {
        
    }
    
    public function SetUp()
    {
        
    }
    
    public function GetName()
    {
        return $this->mFolderName;
    }
    
    public function GetTests()
    {
        if ($this->mTests !== null)
        {
            return $this->mTests;
        }
        $this->mTests = array();
        $classExport = $this->mClassPattern;
        
        foreach (scandir($this->mFolderName) as $file)
        {
            if ($file === '..' || $file === '.')
            {
                continue;
            }
            
            $filePath = $this->mFolderName . DS . $file;
            
            if ($this->mRecursive && is_dir($filePath))
            {
                $this->mTests[] = new FolderTestProvider($filePath, $this->mFilePattern, $this->mClassPattern);
            }
            else if (is_file($filePath) && preg_match($this->mFilePattern, $filePath) > 0)
            {
                require_once($filePath);
                
                $className = $classExport($file);
                
                if (class_exists($className))
                {
                    $this->mTests[] = new ObjectTestProvider(new $className());
                }
            }
        }
        
        return $this->mTests;
    }
    
    public function Count()
    {
        return self::CountProvider($this);
    }
    
    private static function CountProvider($provider)
    {
        $retVal = 0;
        foreach ($provider->GetTests() as $test)
        {
            if ($test instanceof Interfaces\ITest)
            {
                $retVal++;
            }
            else if ($test instanceof Interfaces\ITestProvider)
            {
                $retVal += self::CountProvider($test);
            }

        }
        return $retVal;
    }
}