<?php

namespace tests\unit\Entities;

use RobotE13\UserAccount\Services\PasswordService;
use RobotE13\UserAccount\Entities\{
    User,
    Password
};

class PasswordTest extends \Codeception\Test\Unit
{

    use \Codeception\Specify;

    /**
     * @var \UnitTester
     */
    protected $tester;

    /**
     * @var User
     * @specify
     */
    protected $user;

    /**
     * @var PasswordService
     * @specify
     */
    protected $service;

    protected function _before()
    {
        $this->user = (new \Helper\UserBuilder())->create();
        $this->service = new PasswordService();
    }

    public function testFailToCreate()
    {
        expect('Direct creation by the "new" operator is not allowed.', fn() => new Password())->throws(\DomainException::class);
    }

    public function testChange()
    {
        $this->specify('Correct old password', function () {
            $newPassword = $this->service->create('nEw_password');
            expect('Пароль сменен успешно', $this->user->changePassword(\Helper\UserBuilder::DEFAULT_PASSWORD, $newPassword))->true();
            expect('Пароль сменился на: "new_password"', $this->user->getPassword()->verify('nEw_password'))->true();
        });

        $this->specify('Not correct old password', function () {
            $newPassword = $this->service->create('nEw_password');
            expect('Пароль не был сменен', $this->user->changePassword('wrong_old_password', $newPassword))->false();
            expect('Остался пароль по-умолчанию создаваемый \Helper\UserBuilder', $this->user->getPassword()->verify(\Helper\UserBuilder::DEFAULT_PASSWORD))->true();
        });
    }

    public function testReset()
    {
        $this->specify('Success', function () {
            $newPassword = $this->service->create('nEw_password');

            expect('Текущий пароль - пароль устанавливаемый по умолчанию в \Helper\UserBuilder', $this->user->getPassword()->verify(\Helper\UserBuilder::DEFAULT_PASSWORD))->true();
            $this->user->resetPassword($newPassword);
            expect('Пароль сменился на "nEw_password"', $this->user->getPassword()->verify('nEw_password'))->true();
        });
    }

}
