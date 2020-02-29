<?php
class FunctionsTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    // tests
    public function testReduceExist()
    {
        expect('Wrapper over array_reduce return same result', RobotE13\UserAccount\reduce(fn($carry,$item)=> $carry += $item, [1,2,3],0))->equals(6);
    }
}