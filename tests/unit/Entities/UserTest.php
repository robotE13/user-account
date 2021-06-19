<?php

namespace tests\unit\Entities;

use RobotE13\DDD\Entities\Uuid\Id;
use RobotE13\UserAccount\Tests\Builders\UserBuilder;

class UserTest extends \Codeception\Test\Unit
{

    /**
     * @var \UnitTester
     */
    protected $tester;

    public function testSuccessfullyCreated()
    {
        $uid = Id::next();
        $user = $this->tester->getUserBuilder()->withUid($uid)->create();

        expect('Новый пользователь создается не подтвержденным', $user->getStatus()->isActive())->false();
        expect('UUID созданного пользователя совпадает с заданным UUID', $user->getUid()->isEqualTo($uid))->true();
        expect('Current password: ' . UserBuilder::DEFAULT_PASSWORD, $user->getPassword()->verify(UserBuilder::DEFAULT_PASSWORD))->true();
        expect('Registration date - immutable DateTime object', $user->getRegisteredOn())->isInstanceOf(\DateTimeImmutable::class);
    }

    public function testFailToCallGetterFromStatusDirectly()
    {
        $user = $this->tester->getUserBuilder()->create();
        expect('Bad method call if called getter exist in Status', fn() => $user->getValue())
                ->throws(\BadMethodCallException::class);
    }

    public function testChangeStatus()
    {
        $user = $this->tester->getUserBuilder()->create();
        $user->getStatus()->confirm();
        expect('Пользователь имеет статус подтвержденный', $user->getStatus()->isActive())->true();
        $user->getStatus()->suspend();
        expect('Пользователь имеет статус заблокированный', $user->getStatus()->isSuspended())->true();
        $user->getStatus()->archive();
        expect('Пользователь имеет статус заблокированный', $user->getStatus()->isArchived())->true();
        $user->getStatus()->restore();
        expect('После восстановления пользователь имеет статус "active"', $user->getStatus()->isActive())->true();
    }

}
