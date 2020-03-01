<?php

namespace tests\unit\Entities;

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

    protected function _before()
    {
        $this->user = (new \Helper\UserBuilder())->create();
    }

    public function testOrderExecution()
    {
        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('The password must be at least 8 characters long.');
        new Password('zzzz');
    }

    public function testLessThanEightLenghtNotAllowed()
    {
        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('The password must be at least 8 characters long.');
        new Password('%4Az');
    }

    public function testWithIllegalCharactersNotAllowed()
    {
        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('Only latin letters, numbers, and special characters are allowed.');
        new Password('%4Azfertsdкириллица');
    }

    public function testNotAllowedWithoutUppercaseLetters()
    {
        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('The password must contain at least one uppercase character.');
        new Password('no_uppercase_password1');
    }

    public function testNotAllowedWithoutDigitalOrSpecialCharacters()
    {
        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('The password must contain at least one digit or special character.');
        new Password('noDigitalCharacters');
    }

    public function testExcludeLengthRule()
    {
        $this->expectException(\DomainException::class);
        $this->expectExceptionMessage('Only latin letters, numbers, and special characters are allowed.');
        new \Helper\Entities\PasswordWithoutCheckingLength('яzzz');
    }

    public function testChange()
    {
        $this->specify('Correct old password', function () {
            $newPassword = new Password('nEw_password');
            expect('Пароль сменен успешно', $this->user->changePassword(\Helper\UserBuilder::DEFAULT_PASSWORD, $newPassword))->true();
            expect('Пароль сменился на: "new_password"', $this->user->getPassword()->verify('nEw_password'))->true();
        });

        $this->specify('Not correct old password', function () {
            $newPassword = new Password('nEw_password');
            expect('Пароль был сменен', $this->user->changePassword('wrong_old_password', $newPassword))->false();
            expect('Пароль осталcя: ' . \Helper\UserBuilder::DEFAULT_PASSWORD, $this->user->getPassword()->verify(\Helper\UserBuilder::DEFAULT_PASSWORD))->true();
        });
    }

    public function testReset()
    {
        $this->specify('Success', function () {
            $newPassword = new Password('nEw_password');

            expect('Текущий пароль: ' . \Helper\UserBuilder::DEFAULT_PASSWORD, $this->user->getPassword()->verify(\Helper\UserBuilder::DEFAULT_PASSWORD))->true();
            $this->user->resetPassword($newPassword);
            expect('Пароль сменился на "nEw_password"', $this->user->getPassword()->verify('nEw_password'))->true();
        });
    }

}
