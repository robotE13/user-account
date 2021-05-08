<?php

namespace tests\unit\Entities;

use RobotE13\UserAccount\Entities\Contact\ContactTypes;

class ContactsTest extends \Codeception\Test\Unit
{

    /**
     * @var \UnitTester
     */
    protected $tester;

    public function testAdd(): void
    {

        $user = $this->tester->getUserBuilder()->create();
        $user->addContact($this->tester->getContactBuilder()->create());

        expect('Добавлен 1 контакт', $user->getContacts()->getAll())->count(1);
    }

    public function testCannotAddExisting(): void
    {
        $this->expectException(\DomainException::class);
        $this->expectErrorMessage('Contact already exists.');

        $user = $this->tester->getUserBuilder()->create();

        $user->addContact($this->tester->getContactBuilder()->create());
        $user->addContact($this->tester->getContactBuilder()->create());
    }

    public function testRemove(): void
    {
        $user = $this->tester->getUserBuilder()->create();

        $user->addContact($contact = $this->tester->getContactBuilder()->create());
        $user->addContact($this->tester->getContactBuilder()->withType(ContactTypes::TYPE_PHONE)->withValue('+781')->create());
        $user->removeContact(1);
        expect('После удаления осталя 1 контакт', $user->getContacts()->getAll())->count(1);
        expect('Оставшийся контакт - email', $user->getContacts()->getAll())->same([$contact]);
    }

    public function testRemoveNotExist(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectErrorMessage('Contact with index 111 not found.');
        $user = $this->tester->getUserBuilder()->create();

        $user->removeContact(111);
    }

}
