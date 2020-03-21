<?php

namespace tests\unit\Entities;

use RobotE13\UserAccount\Entities\{
    UserStatuses,
    Status
};

class StatusTest extends \Codeception\Test\Unit
{

    use \Codeception\Specify;

    /**
     * @var \UnitTester
     */
    protected $tester;

    /**
     * @var Status
     * @specify
     */
    private $status;

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
     * @param Status $status Description
     * @dataProvider getAllStatuses
     */
    public function testConfirmation($status)
    {
        if(!$status->isConfirmed())
        {
            $status->confirm();
            expect('Пользователь будет считаться подтвержденным', $status->isConfirmed())->true();
            expect('Пользователь будет считаться "активным" (может быть авторизован)', $status->isActive())->true();
            expect('Пользователь НЕ считается неактивным (НЕ заблокирован и НЕ в архиве)', $status->isInactive())->false();
            expect('Пользователь НЕ будет считаться заблокированным', $status->isSuspended())->false();
            expect('Пользователь НЕ будет считаться удаленным (отправленным в архив)', $status->isArchived())->false();
        } else
        {
            expect('Не поулчится подтвердить, если уже был подтвержден ранее', fn() => $status->confirm())
                    ->throws(\DomainException::class, 'The user has been already confirmed.');
        }
    }

    /**
     * @param Status $status Description
     * @dataProvider getAllStatuses
     */
    public function testSuspending($status)
    {
        if($status->isActive())
        {
            $status->suspend();
            expect('Пользователь будет считаться подтвержденным', $status->isConfirmed())->true();
            expect('Пользователь НЕ будет считаться "активным"', $status->isActive())->false();
            expect('Пользователь неактивен (заблокирован или удален(в архиве))', $status->isInactive())->true();
            expect('Пользователь будет считаться заблокированным', $status->isSuspended())->true();
            expect('Пользователь НЕ будет считаться удаленным (отправленным в архив)', $status->isArchived())->false();
        } else
        {
            expect('Не поулчится приостановить, если пользователь не является действующим', fn() => $status->suspend())
                    ->throws(\DomainException::class, 'Can suspend only active user.');
        }
    }

    /**
     * @param Status $status Description
     * @dataProvider getAllStatuses
     */
    public function testArchivation($status)
    {
        switch ($status->getValue())
        {
            case UserStatuses::SUSPENDED:
                $status->archive();
                break;
            case UserStatuses::ACTIVE:
                $status->archive();
                expect('Пользователь будет считаться подтвержденным', $status->isConfirmed())->true();
                expect('Пользователь НЕ будет считаться "активным"', $status->isActive())->false();
                expect('Пользователь неактивен (заблокирован или удален(в архиве))', $status->isInactive())->true();
                expect('Пользователь НЕ будет считаться заблокированным', $status->isSuspended())->false();
                expect('Пользователь будет считаться удаленным (отправленным в архив)', $status->isArchived())->true();
                break;
            case UserStatuses::ARCHIVED:
                expect('Нельзя отправить в архив уже находящегося в архиве', fn() => $status->archive())
                        ->throws(\DomainException::class, 'User already archived.');
                break;
            case UserStatuses::UNCONFIRMED:
                expect('An unconfirmed user cannot be archived.', fn() => $status->archive())
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

    public function getAllStatuses()
    {
        return array_map(fn($item) => ['status' => new Status($item, new UserStatuses())],
                [
                    UserStatuses::UNCONFIRMED,
                    UserStatuses::ACTIVE,
                    UserStatuses::SUSPENDED,
                    UserStatuses::ARCHIVED
                ]
        );
    }

}
