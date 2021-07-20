<?php
namespace Oness\Sincontrol\Classes;

class Verhoeff{

    public function __construct()
    {
        
    }
    protected static $multiplication = array(
        array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9),
        array(1, 2, 3, 4, 0, 6, 7, 8, 9, 5),
        array(2, 3, 4, 0, 1, 7, 8, 9, 5, 6),
        array(3, 4, 0, 1, 2, 8, 9, 5, 6, 7),
        array(4, 0, 1, 2, 3, 9, 5, 6, 7, 8),
        array(5, 9, 8, 7, 6, 0, 4, 3, 2, 1),
        array(6, 5, 9, 8, 7, 1, 0, 4, 3, 2),
        array(7, 6, 5, 9, 8, 2, 1, 0, 4, 3),
        array(8, 7, 6, 5, 9, 3, 2, 1, 0, 4),
        array(9, 8, 7, 6, 5, 4, 3, 2, 1, 0)
    );
    protected static $permutation = array(
        array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9),
        array(1, 5, 7, 6, 2, 8, 3, 0, 9, 4),
        array(5, 8, 0, 3, 7, 9, 6, 1, 4, 2),
        array(8, 9, 1, 6, 0, 4, 3, 5, 2, 7),
        array(9, 4, 5, 3, 1, 2, 6, 8, 7, 0),
        array(4, 2, 8, 6, 5, 7, 3, 9, 0, 1),
        array(2, 7, 9, 3, 8, 0, 6, 4, 1, 5),
        array(7, 0, 4, 6, 9, 1, 3, 2, 5, 8)
    );
    
    protected static $inverse = array(0, 4, 3, 2, 1, 5, 6, 7, 8, 9);

    /**
     *  return integer digito Veroheff
     */
    public function CheckSumDigit($partial) {
       
        settype($partial, "string");
        $partial = strrev($partial);
        $digitIndex = 0;
        for ($i = 0; $i < strlen($partial); $i++) {
            $digitIndex = self::$multiplication[$digitIndex][self::$permutation[($i + 1) % 8][$partial[$i]]];
        }
        return self::$inverse[$digitIndex];
    }

    /**
     *  return true|false verifica un numero que contiene digito Verhoeff
     */
    function isValid($num) {
        settype($num, "string");
        $expectedDigit = substr($num, -1);
        $actualDigit = $this->CheckSumDigit(substr($num, 0, -1));
        return ($expectedDigit == $actualDigit) ? $expectedDigit == $actualDigit : 0;
    }    

}
