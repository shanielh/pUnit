<?php

namespace pUnit;

class FolderTestProvider implements Interfaces\ITestProvider
{
    
    private $mFolderName;
    
    private $mRecursive;
    
    private $mFilePattern;
    
    private $mClassPattern;
    
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
        $retVal = array();
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
                $retVal[] = new FolderTestProvider($filePath, $this->mFilePattern, $this->mClassPattern);
            }
            else if (is_file($filePath) && preg_match($this->mFilePattern, $filePath) > 0)
            {
                require_once($filePath);
                
                $className = $classExport($file);
                
                if (class_exists($className))
                {
                    $retVal[] = new ObjectTestProvider(new $className());
                }
            }
        }
        
        return $retVal;
    }
    
    
    
}