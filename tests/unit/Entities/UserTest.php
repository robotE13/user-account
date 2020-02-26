<?php

namespace tests\unit\Entities;

use RobotE13\UserAccount\Entities\Id;

class UserTest extends \Codeception\Test\Unit
{

    /**
     * @var \UnitTester
     */
    protected $tester;

    public function testSuccessfullyCreated()
    {
        $user = (new \Helper\UserBuilder())->withUid($uid = Id::next())->create();

        expect('Новый пользователь создается не подтвержденным', $user->isConfirmed())->false();
        expect('UUID созданного пользователя совпадает с заданным UUID', $user->getUid()->isEqualTo($uid))->true();
        expect('Текущий пароль: ' . \Helper\UserBuilder::DEFAULT_PASSWORD, $user->getPassword()->verify(\Helper\UserBuilder::DEFAULT_PASSWORD))->true();
        expect('Дата регистрации - неизменяемый объект', $user->getRegisteredOn())->isInstanceOf(\DateTimeImmutable::class);
    }

    public function testFailToCreateWithoutId()
    {
        $this->expectException(\InvalidArgumentException::class);
        (new \Helper\UserBuilder())->withUid(new Id(''))->create();
    }

}
