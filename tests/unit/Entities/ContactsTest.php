<?php

namespace tests\unit\Entities;

use RobotE13\UserAccount\Entities\Contact\ContactTypes;

class ContactsTest extends \Codeception\Test\Unit
{

    /**
     * @var \UnitTester
     */
    protected $tester;
    private $contactBuilder;

    protected function _before()
    {
        $this->contactBuilder = new \Helper\ContactBuilder();
    }

    public function testAdd(): void
    {
        $user = (new \Helper\UserBuilder())->create();
        $user->addContact($contact = $this->contactBuilder->create());

        expect('Добавлен 1 контакт', $user->getContacts()->getAll())->count(1);
    }

    public function testCannotAddExisting(): void
    {
        $this->expectException(\DomainException::class);
        $this->expectErrorMessage('Contact already exists.');

        $user = (new \Helper\UserBuilder())->create();

        $user->addContact($this->contactBuilder->create());
        $user->addContact($this->contactBuilder->create());
    }

    public function testRemove(): void
    {
        $user = (new \Helper\UserBuilder())->create();

        $user->addContact($contact = $this->contactBuilder->create());
        $user->addContact($this->contactBuilder->withType(ContactTypes::TYPE_PHONE)->withValue('+781')->create());
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
