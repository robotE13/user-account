<?php

namespace tests\unit\entities;

use robote13\user_account\entities;

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
        $user->addContact($contact = new entities\Contact());
    }

    public function testRemove(): void
    {
        $user = (new \Helper\UserBuilder('111'))->create();

        $user->addContact($contact = new entities\Contact());

        $user->removeContact($contact);
    }

    public function testRemoveNotExist(): void
    {
        $user = (new \Helper\UserBuilder('111'))->create();

        $user->removeContact($contact = new entities\Contact());
    }
}