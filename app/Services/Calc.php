<?php

namespace App\Services;

class Calc
{
    const WRONT_SIGN = 'Not exist sing';
    
    private $num1;
    private $num2;
    
    function __construct( $num1, $num2) {
        $this->num1 = $num1;
        $this->num2 = $num2;
    }
    
    /**
     * @return int
     */
    private function summation()
    {
        return $this->num1 + $this->num2;
    }

    /**
     * @return int
     */
    private function subtraction()
    {
        return $this->num1 - $this->num2;
    }

    /**
     * @return int
     */
    private function multiplication()
    {
        return $this->num1 * $this->num2;
    }

    /**
     * @return float
     */
    private function division()
    {
        return $this->num1 / $this->num2;
    }

    private function signMap($sign)
    {
        $signs = [
            '+' => 'summation',
            '-' => 'subtraction',
            '*' => 'multiplication',
            '/' => 'division'
        ];
        if (isset($signs[$sign])) {
            return $signs[$sign];
        }

        return false;
    }

    function calculate($sign)
    {
        if (!$func = $this->signMap($sign) ) {
            return self::WRONT_SIGN;
        }

        return $this->$func();
    }
}