<?php

/**
 * This file is part of the user-account.
 *
 * Copyright 2020 Evgenii Dudal <wolfstrace@gmail.com>.
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 * @package user-account
 */

namespace RobotE13\UserAccount\Entities\Contact;

use Webmozart\Assert\Assert;

/**
 * Description of Contacts
 *
 * @author robotR13
 */
class ContactsCollection
{
    private $contacts = [];

    public function __construct(array $contacts = [])
    {
        foreach ($contacts as $contact) {
            $this->add($contact);
        }
    }

    public function add(Contact $contact): void
    {
        foreach ($this->contacts as $item) {
            if ($item->isEqualTo($contact)) {
                throw new \DomainException('Contact already exists.');
            }
        }
        $this->contacts[] = $contact;
    }

    public function remove($index): Contact
    {
        Assert::keyExists($this->contacts, $index, 'Contact with index %s not found.');

        $contact = $this->contacts[$index];
        unset($this->contacts[$index]);
        return $contact;
    }

    public function getAll(): array
    {
        return $this->contacts;
    }
}
