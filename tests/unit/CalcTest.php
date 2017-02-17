<?php

use App\Services\Calc;

class CalcTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    protected function _before()
    {
        $this->tester = new Calc(45, 15);
    }

    protected function _after()
    {
    }

    // tests
    public function testMe()
    {
        $this->assertEquals(60, $this->tester->calculate('+'));
        $this->assertEquals(30, $this->tester->calculate('-'));
        $this->assertEquals(675, $this->tester->calculate('*'));
        $this->assertEquals(3, $this->tester->calculate('/'));

        $this->assertTrue($this->tester->calculate('+') == 60);
    }
}