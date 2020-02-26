<?php

namespace tests\unit\Entities;

use RobotE13\UserAccount\Entities\Contact\Contact;

class UserContactsTest extends \Codeception\Test\Unit
{

    /**
     * @var \UnitTester
     */
    protected $tester;

    public function testAdd(): void
    {
        $user = (new \Helper\UserBuilder())->create();
        $user->addContact($contact = new Contact('email','email'));

        expect('Добавлен 1 контакт', $user->getContacts()->getAll())->count(1);
    }

    public function testRemove(): void
    {
        $user = (new \Helper\UserBuilder())->create();

        $user->addContact($contact = new Contact('email','email'));

        $user->removeContact(0);
    }

    public function testRemoveNotExist(): void
    {
        $this->expectException(\InvalidArgumentException::class);
        $this->expectErrorMessage('Contact with index 111 not found.');
        $user = (new \Helper\UserBuilder())->create();

        $user->removeContact(111);
    }

}
