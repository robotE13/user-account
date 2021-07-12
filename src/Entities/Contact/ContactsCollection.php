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

/**
 * Description of Contacts
 *
 * @author robotR13
 */
class ContactsCollection extends \RobotE13\DDD\Entities\Collection\AbstractCollection
{


    public function getItemClass(): string
    {
        return Contact::class;
    }

    public static function getItemName(): string
    {
        return 'Contact';
    }

}
