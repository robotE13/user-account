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

use RobotE13\UserAccount\Entities\PossibleState;

/**
 * Description of Contact
 *
 * @author robotR13
 */
class Contact
{

    private $value;
    private $type;
    private $possibleTypes;

    public function __construct($type, $value, PossibleState $possibleTypes)
    {
        $this->type = $type;
        $this->value = $value;
        $this->possibleTypes = $possibleTypes;
    }

    public function isEqualTo(self $contact)
    {
        return $this->value === $contact->getValue();
    }

    public function getValue()
    {
        return $this->value;
    }

    public function getType()
    {
        return $this->type;
    }

    public function getPossibleTypes(): PossibleState
    {
        return $this->possibleTypes;
    }

}
