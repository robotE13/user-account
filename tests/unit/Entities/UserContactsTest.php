<?php

namespace tests\unit\Entities;

use RobotE13\UserAccount\Entities\Contact;

class UserContactsTest extends \Codeception\Test\Unit
{

    /**
     * @var \UnitTester
     */
    protected $tester;

    /*
      protected function _before()
      {
      }

      protected function _after()
      {
      }
     */

    public function testAdd(): void
    {
        $user = (new \Helper\UserBuilder('111'))->create();
        $user->addContact($contact = new Contact());

        expect('Добавлен 1 контакт', $user->getContacts())->count(1);
    }

    public function testRemove(): void
    {
        $user = (new \Helper\UserBuilder('111'))->create();

        $user->addContact($contact = new Contact());

        $user->removeContact($contact);
    }

    public function testRemoveNotExist(): void
    {
        $user = (new \Helper\UserBuilder('111'))->create();

        $user->removeContact($contact = new Contact());
    }

}
