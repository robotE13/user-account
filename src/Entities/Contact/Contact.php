<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace RobotE13\UserAccount\Entities\Contact;

/**
 * Description of Contact
 *
 * @author robotR13
 */
class Contact
{

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
