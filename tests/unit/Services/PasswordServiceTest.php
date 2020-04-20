<?php

namespace tests\unit\Entities;

use RobotE13\UserAccount\Entities\Password;
use RobotE13\UserAccount\Services\PasswordService;
use Helper\Services\PasswordServiceWithoutCheckingLength;

class PasswordServiceTest extends \Codeception\Test\Unit
{

    use \Codeception\Specify;

    /**
     * @var \UnitTester
     */
    protected $tester;

    /**
     * @var PasswordService
     * @specify
     */
    protected $service;

    protected function _before()
    {
        $this->service = new PasswordService();
    }

    public function testCreatePasswordHash()
    {
        $this->specify('Successfully creating a password hash', function () {
            $password = $this->service->create('Xx123rtrtr#'); //password of sufficient complexity
            expect('The password entered correctly will be pass checking for a hash match',
                    $password->verify('Xx123rtrtr#'))->true();
            expect('An invalid password will not pass the hash match check',
                    $password->verify('invalid'))->false();
        });

        $this->specify('Trying to set a password that does not meet the complexity requirements.', function () {
            expect('Fail to create password object when trying to set a simple password (shorter than 8 characters)',
                            fn() => $this->service->create('tooShort'))
                    ->throws(\DomainException::class);
        });
    }

    public function testOrderExecution()
    {
        expect('If the password does not match according to several criteria, the error about the presence of invalid characters should be detected first.',
                        fn() => $this->service->create('zzzzЯ'))
                ->throws(\DomainException::class, 'Only latin letters, numbers, and special characters are allowed.');

        expect('The first error should be that the password length is less than 8 characters.',
                        fn() => $this->service->create('zzzz'))
                ->throws(\DomainException::class, 'The password must be at least 8 characters long.');
    }

    /**
     * @dataProvider getweakPasswordVariants
     */
    public function testValidationFail($password, $errorMessage)
    {
        expect('Пароль не прошедший по критериям сложности не будет создан',
                        fn() => $this->service->create($password))
                ->throws(\DomainException::class, $errorMessage);
    }

    public function getWeakPasswordVariants()
    {
        return[
            'Less than 8 lenght not allowed' => [
                'password' => '%4Az',
                'errorMessage' => 'The password must be at least 8 characters long.'
            ],
            'Illegal characters not allowed' => [
                'password' => '%4Azfertsdкириллица',
                'errorMessage' => 'Only latin letters, numbers, and special characters are allowed.'
            ],
            'Without uppercase letters not allowed' => [
                'password' => 'no_uppercase_password1',
                'errorMessage' => 'The password must contain at least one uppercase character.'
            ],
            'Without digital or special characters not allowed' => [
                'password' => 'noDigitalCharacters',
                'errorMessage' => 'The password must contain at least one digit or special character.'
            ],
        ];
    }

    public function testExcludeLengthRule()
    {
        $service = new PasswordServiceWithoutCheckingLength();
        expect('В дочернем классе сервиса, пароль короче 8 символов пройдет проверку сложности и хеш пароля будет создан.',
                        $service->create('Zzzz1'))
                ->isInstanceOf(Password::class);
    }

}
