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

        expect('Добавлен 1 контакт', count($user->getContacts()))->equals(1);
    }

    public function testCannotAddExisting(): void
    {
        $this->expectException(\InvalidArgumentException::class);
//        $this->expectErrorMessage('Contact already exists.');

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
        expect('После удаления осталя 1 контакт', count($user->getContacts()))->equals(1);
        expect('Оставшийся контакт - email', $user->getContacts()->toArray())->same([$contact]);
    }

    public function testRemoveNotExist(): void
    {
        $user = $this->tester->getUserBuilder()->create();

        expect('', fn() => $user->removeContact(111))->throws(\Webmozart\Assert\InvalidArgumentException::class, 'Contact with key `111` not present in collection.');
    }

}
