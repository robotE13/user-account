<?php

use RobotE13\UserAccount\Functions;

class FunctionsTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    // tests
    public function testReduceExist()
    {
        expect('Wrapper over array_reduce return same result', Functions\reduce(fn($carry,$item)=> $carry += $item, [1,2,3],0))->equals(6);
    }
}