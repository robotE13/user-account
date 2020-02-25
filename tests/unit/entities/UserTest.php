<?php

namespace tests\unit\entities;

use robote13\user_account\entities\Id;

class UserTest extends \Codeception\Test\Unit
{

    /**
     * @var \UnitTester
     */
    protected $tester;

    protected function _before()
    {

    }

    protected function _after()
    {

    }

    public function testSuccessfullyCreated()
    {
        $user = (new \Helper\UserBuilder('pass123'))->withUid($uid = Id::next())->create();

        expect('UUID созданного пользователя совпадает с заданным UUID', $user->getUid()->isEqualTo($uid))->true();
        expect('Текущий пароль: "pass123"', $user->getPassword()->verify('pass123'))->true();
        expect('Дата регистрации - неизменяемый объект', $user->getRegisteredOn())->isInstanceOf(\DateTimeImmutable::class);
    }

    public function testFailToCreateWithoutId()
    {
        $this->expectException(\InvalidArgumentException::class);
        (new \Helper\UserBuilder('pass123'))->withUid(new Id(''))->create();
    }

}
