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

namespace RobotE13\UserAccount\Services\User\Create;

use RobotE13\UserAccount\Entities\Password;

/**
 * Description of SignUp
 *
 * @author Evgenii Dudal <wolfstrace@gmail.com>
 */
class UserCreate
{

    /**
     * @var Password
     */
    private $password;

    /**
     * @var string
     */
    public $email;

    public function __construct(Password $password, string $email)
    {
        $this->password = $password;
        $this->email = $email;
    }

    public function getPassword(): Password
    {
        return $this->password;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

}
