<?php

namespace RobotE13\UserAccount\Tests;

use Builders\UserBuilder;
use RobotE13\DDD\Entities\Uuid\Id;
use RobotE13\UserAccount\Repositories\{
    UserRepository,
    NotFoundException
};

abstract class UserRepositoryAbstractTest extends \Codeception\Test\Unit
{

    /**
     *
     * @var UserRepository
     */
    protected $repository;

    /**
     * @var \UnitTester
     */
    protected $tester;

    // tests
    public function testFind()
    {
        $id = Id::next();
        $email = 'test@mail.ru';

        $user = $this->tester->getUserBuilder()
                ->withUid($id)
                ->withEmail($email)
                ->create();
        $this->repository->add($user);

        expect('Пользователь найден по ID и UID найденного совпадает с UID ранее добавленного',
                        $this->repository->findById($id->getString())
                        ->getUid()
                        ->isEqualTo($id))
                ->true();

        expect('Пользователь найден по e-mail и UID найденного совпадает с UID ранее добавленного',
                        $this->repository->findByEmail($email)
                        ->getUid()
                        ->isEqualTo($id))
                ->true();
    }

    public function testNotFound()
    {
        expect('Not found', fn() => $this->repository->findById(Id::next()->getString()))
                ->throws(NotFoundException::class);

        expect('Not found', fn() => $this->repository->findByEmail('not-exist'))
                ->throws(NotFoundException::class);
    }

    public function testAdd()
    {
        $id = Id::next();
        $user = $this->tester->getUserBuilder()
                ->withUid($id)
                ->withEmail('test@mail.ru')
                ->create();


        $this->repository->add($user);
        $userFound = $this->repository->findById($id->getString());

        expect('Uid объекта полученного из репозитория совпадает с uid сохраненного объекта',
                $user->getUid()->isEqualTo($userFound->getUid()))->true();
        expect('Email объекта полученного из репозитория совпадает с email сохраненного объекта',
                $user->getRegistrationEmail() === $userFound->getRegistrationEmail())->true();
        expect('Хеш пароля объекта полученного из репозитория - соответствует паролю с которым был создан объект',
                $userFound->getPassword()->verify(UserBuilder::DEFAULT_PASSWORD))->true();
    }

    public function testRemove()
    {
        $id = Id::next();

        $user = $this->tester->getUserBuilder()->withUid($id)->create();
        $this->repository->add($user);

        expect('Пользователь найден по ID и UID найденного совпадает с UID ранее добавленного',
                        $this->repository->findById($id->getString())
                        ->getUid()
                        ->isEqualTo($id))
                ->true();

        $this->repository->remove($user->getUid()->getString());

        expect('Not found', fn() => $this->repository->findById($id->getString()))
                ->throws(NotFoundException::class);
    }

}
