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
 * Description of Contact
 *
 * @author robotR13
 */
class Contact
{

    const TYPE_EMAIL = 'email';
    const TYPE_PHONE = 'phone';

    private $type;
    private $value;

    public function __construct($type, $value)
    {
        $this->type = $type;
        $this->value = $value;
    }

    public function isEqualTo(self $contact)
    {
        return $this->value === $contact->getValue();
    }

    public function getValue()
    {
        return $this->value;
    }

}
