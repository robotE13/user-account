<?php

namespace tests\unit\Entities;

use RobotE13\UserAccount\Entities\Contact\Contact;

class ContactsTest extends \Codeception\Test\Unit
{

    /**
     * @var \UnitTester
     */
    protected $tester;

    public function testAdd(): void
    {
        $user = (new \Helper\UserBuilder())->create();
        $user->addContact($contact = new Contact('email', 'email'));

        expect('Добавлен 1 контакт', $user->getContacts()->getAll())->count(1);
    }

    public function testRemove(): void
    {
        $user = (new \Helper\UserBuilder())->create();

        $user->addContact($contact = new Contact('email', 'email'));
        $user->addContact(new Contact('phone', '+781'));
        $user->removeContact(1);
        expect('После удаления осталя 1 контакт', $user->getContacts()->getAll())->count(1);
        expect('Оставшийся контакт - email', $user->getContacts()->getAll())->same([$contact]);
    }

    public function testRemoveNotExist(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectErrorMessage('Contact with index 111 not found.');
        $user = (new \Helper\UserBuilder())->create();

        $user->removeContact(111);
    }

}
