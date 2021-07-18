<?php

namespace Services;

use RobotE13\UserAccount\ServiceLocator;
use RobotE13\UserAccount\Services\User\Create\UserCreate;
use RobotE13\UserAccount\Services\Security\PasswordCreate\PasswordCreate;
use RobotE13\UserAccount\Repositories\{
    UserRepository,
    InMemoryUserRepository
};

class UserServicesTest extends \Codeception\Test\Unit
{

    /**
     * @var \UnitTester
     */
    protected $tester;

    /**
     *
     * @var UserRepository;
     */
    protected $users;

    protected function _before()
    {
        $this->users = new InMemoryUserRepository();
        ServiceLocator::getInstance()->getContainer()->add(UserRepository::class, InMemoryUserRepository::class);
    }

    public function testSuccessfullCreate()
    {
        /* @var $user \RobotE13\UserAccount\Entities\User */
        $password = $this->tester->getCommandBus()->handle(new PasswordCreate('Xx123rtrtr#'));
        $user = $this->tester->getCommandBus()->handle(new UserCreate($password, 'test@mail.ru'));
        expect('', $user->getRegistrationEmail())->equals('test@mail.ru');
        expect('Хранилище содержит созданного пользователя', $this->users->findById($user->getUid()->getString())->getRegistrationEmail())->equals('test@mail.ru');
    }

}
