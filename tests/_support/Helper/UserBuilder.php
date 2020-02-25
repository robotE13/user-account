<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace Helper;

use robote13\user_account\entities\Id;
use robote13\user_account\entities\User;

/**
 * Description of UserBuilder
 *
 * @author robotR13
 */
class UserBuilder
{
    private $uuid;
    private $registrationEmail;
    private $password;
    private $isConfirmed;
    private $registeredOn;


    public function __construct(string $password)
    {
        $this->uuid = Id::next();
        $this->registrationEmail = 'user1@usermail.com';
        $this->password = new \robote13\user_account\entities\Password($password);
    }

    public function withUid(Id $uid)
    {
        $this->uuid = $uid;
        return $this;
    }

    public function create(): User
    {
        $user = new User(
            $this->uuid,
            $this->registrationEmail,
            $this->password
        );

        return $user;
    }
}
