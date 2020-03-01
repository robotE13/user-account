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

namespace Helper;

use RobotE13\UserAccount\Entities\Contact\{
    Contact,
    ContactTypes
};

/**
 * Description of ContactBuilder
 *
 * @author Evgenii Dudal <wolfstrace@gmail.com>
 */
class ContactBuilder
{

    private $value;
    private $type;

    public function __construct()
    {
        $this->value = 'email';
        $this->type = ContactTypes::TYPE_EMAIL;
    }

    public function withType($type)
    {
        $this->type = $type;
        return $this;
    }

    public function withValue($value)
    {
        $this->value = $value;
        return $this;
    }

    public function create(): Contact
    {
        return new Contact(
                $this->type,
                $this->value,
                new ContactTypes()
        );
    }

}
