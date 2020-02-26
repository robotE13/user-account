<?php

namespace tests\unit\Entities;

use RobotE13\UserAccount\Entities\Status;

class StatusTest extends \Codeception\Test\Unit
{

    /**
     * @var \UnitTester
     */
    protected $tester;

    /**
     * @dataProvider getAllExisting
     */
    public function testCreate($value, $text)
    {
        $status = new Status($value);
        expect("Объект создан и содержит соответствующие текстовое значения для статуса",$status->getTextValue())->equals($text);

    }

    public function testFailToCreateWithInvalidStatus()
    {
        $this->expectException(\InvalidArgumentException::class);
        new Status(9999);
    }

    public function getAllExisting()
    {
        $dataProvider = [];
        foreach (Status::getAllExisting() as $value => $text)
        {
            $dataProvider["{$text}"] = ['value' => $value, 'text' => $text];
        }
        return $dataProvider;
    }

}
