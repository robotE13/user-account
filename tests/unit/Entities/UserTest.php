<?php

namespace tests\unit\Entities;

use RobotE13\UserAccount\Entities\{
    Id,
};

class UserTest extends \Codeception\Test\Unit
{

    /**
     * @var \UnitTester
     */
    protected $tester;

    public function testSuccessfullyCreated()
    {
        $uid = new Id((new Id())->getUid()->getBytes());
        $user = (new \Helper\UserBuilder())->withUid($uid)->create();

        expect('Новый пользователь создается не подтвержденным', $user->getStatus()->isActive())->false();
        expect('UUID созданного пользователя совпадает с заданным UUID', $user->getUid()->isEqualTo($uid))->true();
        expect('Current password: ' . \Helper\UserBuilder::DEFAULT_PASSWORD, $user->getPassword()->verify(\Helper\UserBuilder::DEFAULT_PASSWORD))->true();
        expect('Registration date - immutable DateTime object', $user->getRegisteredOn())->isInstanceOf(\DateTimeImmutable::class);
    }

    public function testFailToCreateIncorrectUid()
    {
        expect('Cannot create with empty UUID',
                        fn() => (new \Helper\UserBuilder())->withUid(new Id(''))->create())
                ->throws(\Ramsey\Uuid\Exception\InvalidArgumentException::class);
        expect('Cannot create from non UUID',
                        fn() => (new \Helper\UserBuilder())->withUid(new Id('fewf'))->create())
                ->throws(\Ramsey\Uuid\Exception\InvalidArgumentException::class);
        expect('Cannot create non-time based UUID',
                        fn() => (new \Helper\UserBuilder())->withUid(new Id(\Ramsey\Uuid\Uuid::uuid1()->getBytes()))->create())
                ->throws(\Ramsey\Uuid\Exception\UnsupportedOperationException::class,
                        'Attempting to decode a non-time-based UUID using OrderedTimeCodec');
    }

    public function testFailToCallGetterFromStatusDirectly()
    {
        $user = (new \Helper\UserBuilder())->create();
        expect('Bad method call if called getter exist in Status', fn() => $user->getValue())
                ->throws(\BadMethodCallException::class);
    }

    public function testChangeStatus()
    {
        $user = (new \Helper\UserBuilder())->create();

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
