<?php

namespace pUnit;

abstract class TestProvider
{
    
    public static function Count(Interfaces\ITestProvider $provider)
    {
        $retVal = 0;
        foreach ($provider->GetTests() as $test)
        {
            if ($test instanceof Interfaces\ITestProvider)
            {
                $retVal += self::Count($test);
            }
            else if ($test instanceof Interfaces\ITest)
            {
                $retVal++;
            }
            else
            {
                throw new Exception("ITestProvider::GetTests() must return an array of" .
                                    "ITest / ITestProvider");
            }
            
        }
        return $retVal;
    }
    
    
}