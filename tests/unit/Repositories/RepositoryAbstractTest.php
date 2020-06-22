<?php

namespace tests\unit\Repositories;

use RobotR13\UserAccount\Repositories\NotFoundException;
use RobotE13\UserAccount\Entities\{
    Id,
    User
};

abstract class RepositoryAbstractTest extends \Codeception\Test\Unit
{

    /**
     *
     * @var \RobotR13\UserAccount\Repositories\UserRepository
     */
    protected $repository;

    /**
     * @var \UnitTester
     */
    protected $tester;

    // tests
    public function testFind()
    {
        $id = new Id();
        $user = (new \Helper\UserBuilder())
                ->withUid($id)
                ->withEmail('test@mail.ru')
                ->create();

        $this->repository->add($user);
        $userFound = $this->repository->findById($id);

        expect('Uid объекта полученного из репозитория совпадает с uid сохраненного объекта',
                $user->getUid()->isEqualTo($userFound->getUid()))->true();
        expect('Email объекта полученного из репозитория совпадает с email сохраненного объекта',
                $user->getRegistrationEmail() === $userFound->getRegistrationEmail())->true();
        expect('Хеш пароля объекта полученного из репозитория - соответствует паролю с которым был создан объект',
                $userFound->getPassword()->verify(\Helper\UserBuilder::DEFAULT_PASSWORD))->true();
    }

    public function testNotFound()
    {
        expect('Not found', fn() => $this->repository->findById(new Id()))
                ->throws(NotFoundException::class);
    }

    public function testAdd()
    {

    }

}
