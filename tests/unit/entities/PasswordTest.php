<?php

namespace tests\unit\entities;

use robote13\user_account\entities;

class PasswordTest extends \Codeception\Test\Unit
{

    use \Codeception\Specify;

    /**
     * @var \UnitTester
     */
    protected $tester;

    /**
     * @var entities\User
     * @specify
     */
    protected $user;

    protected function _before()
    {
        $this->user = (new \Helper\UserBuilder('old_password'))->create();
    }

    protected function _after()
    {

    }

    public function testChange()
    {
        $this->specify('Correct old password', function () {
            $newPassword = new entities\Password('new_password');
            expect('Пароль сменен успешно', $this->user->changePassword('old_password', $newPassword))->true();
            expect('Пароль сменился на: "new_password"', $this->user->getPassword()->verify('new_password'))->true();
        });

        $this->specify('Not correct old password', function () {
            $newPassword = new entities\Password('new_password');
            expect('Пароль был сменен', $this->user->changePassword('wrong_old_password', $newPassword))->false();
            expect('Пароль осталcя: "old_password"', $this->user->getPassword()->verify('old_password'))->true();
        });
    }

    public function testReset()
    {

        $this->specify('Success', function () {
            $newPassword = new entities\Password('new_password');

            expect('Текущий пароль: "old_password"', $this->user->getPassword()->verify('old_password'))->true();
            $this->user->resetPassword($newPassword);
            expect('Пароль сменился на "new_password"', $this->user->getPassword()->verify('new_password'))->true();
        });
    }

}
