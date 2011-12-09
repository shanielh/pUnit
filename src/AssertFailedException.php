<?php

namespace pUnit;

class AssertFailedException extends \Exception
{
    
    public function __construct($message)
    {
        parent::__construct($message);
    }
    
    private function GetSlicedStack()
    {
        $stack = $this->getTrace();

        for ($i = count($stack); $i--; $i >= 0)
        {
            $frame = $stack[$i];
            if (array_key_exists('class', $frame) &&
                $frame['class'] === 'pUnit\Assert')
            {
                // Where to start from is here.
                $stack = array_slice($stack, 1, $i + 1);
                break;
            }    
        }
        
        return $stack;
    }
    
    public function __ToString()
    {
        $stack = $this->GetSlicedStack();
        $retVal = '';
        
        foreach ($stack as $key => $frame)
        {
            if (array_key_exists('class', $frame))
            {
                $class = $frame['class'] . '->';
            }
            else
            {
                $class = '';
            }
            
            $retVal .= "($key) $class{$frame['function']} \r\n";
        }
        
        $retVal = substr($retVal, 0, strlen($retVal) - 2);
        
        return $this->getMessage() . ", Stack Trace : \r\n" . $retVal;
    }
    
}