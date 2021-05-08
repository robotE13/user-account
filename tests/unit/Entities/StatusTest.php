<?php

namespace tests\unit\Entities;

use RobotE13\UserAccount\Entities\{
    User,
    Status,
    UserStatuses,
};

class StatusTest extends \Codeception\Test\Unit
{

    use \Codeception\Specify;

    /**
     * @var \UnitTester
     */
    protected $tester;

    /**
     * @dataProvider getAllExisting
     */
    public function testCreate($value, $text)
    {
        $status = new Status($value, new UserStatuses());
        expect("Объект создан и содержит соответствующие текстовое значения для статуса", $status->getTextValue())->equals($text);
    }

    public function testFailToCreateWithInvalidStatus()
    {
        $this->expectException(\InvalidArgumentException::class);
        new Status(9999, new UserStatuses());
    }

    /**
     * * @param int $value Description
     * @dataProvider getAllExisting
     */
    public function testConfirmation($value)
    {
        $user = $this->tester->getUserBuilder()->withStatus($value)->create();
        if(!$user->isConfirmed())
        {
            $user->confirm();
            expect('Пользователь будет считаться подтвержденным', $user->isConfirmed())->true();
            expect('Пользователь будет считаться "активным" (может быть авторизован)', $user->isActive())->true();
            expect('Пользователь НЕ считается неактивным (НЕ заблокирован и НЕ в архиве)', $user->isInactive())->false();
            expect('Пользователь НЕ будет считаться заблокированным', $user->isSuspended())->false();
            expect('Пользователь НЕ будет считаться удаленным (отправленным в архив)', $user->isArchived())->false();
        } else
        {
            expect('Не поулчится подтвердить, если уже был подтвержден ранее', fn() => $user->confirm())
                    ->throws(\DomainException::class, 'The user has been already confirmed.');
        }
    }

    /**
     * @param int $value Description
     * @dataProvider getAllExisting
     */
    public function testSuspending($value)
    {
        $user = $this->tester->getUserBuilder()->withStatus($value)->create();
        if($user->isActive())
        {
            $user->suspend();
            expect('Пользователь будет считаться подтвержденным', $user->isConfirmed())->true();
            expect('Пользователь НЕ будет считаться "активным"', $user->isActive())->false();
            expect('Пользователь неактивен (заблокирован или удален(в архиве))', $user->isInactive())->true();
            expect('Пользователь будет считаться заблокированным', $user->isSuspended())->true();
            expect('Пользователь НЕ будет считаться удаленным (отправленным в архив)', $user->isArchived())->false();
        } else
        {
            expect('Не поулчится приостановить, если пользователь не является действующим', fn() => $user->suspend())
                    ->throws(\DomainException::class, 'Can suspend only active user.');
        }
    }

    /**
     * @param int $value Description
     * @dataProvider getAllExisting
     */
    public function testArchivation($value)
    {
        $user = $this->tester->getUserBuilder()->withStatus($value)->create();
        switch ($user->getStatus()->getValue())
        {
            case UserStatuses::SUSPENDED:
                $user->archive();
                break;
            case UserStatuses::ACTIVE:
                $user->archive();
                expect('Пользователь будет считаться подтвержденным', $user->isConfirmed())->true();
                expect('Пользователь НЕ будет считаться "активным"', $user->isActive())->false();
                expect('Пользователь неактивен (заблокирован или удален(в архиве))', $user->isInactive())->true();
                expect('Пользователь НЕ будет считаться заблокированным', $user->isSuspended())->false();
                expect('Пользователь будет считаться удаленным (отправленным в архив)', $user->isArchived())->true();
                break;
            case UserStatuses::ARCHIVED:
                expect('Нельзя отправить в архив уже находящегося в архиве', fn() => $user->archive())
                        ->throws(\DomainException::class, 'User already archived.');
                break;
            case UserStatuses::UNCONFIRMED:
                expect('An unconfirmed user cannot be archived.', fn() => $user->archive())
                        ->throws(\DomainException::class, 'An unconfirmed user cannot be archived.');
        }
    }

    public function getAllExisting()
    {
        $dataProvider = [];

        foreach ((new UserStatuses())->getAllExisting() as $value => $text)
        {
            $dataProvider["{$value} - {$text}"] = ['value' => $value, 'text' => $text];
        }
        return $dataProvider;
    }

}
