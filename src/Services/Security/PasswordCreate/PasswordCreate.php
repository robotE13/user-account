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

namespace RobotE13\UserAccount\Services\Security\PasswordCreate;

/**
 * Description of PasswordCreateCommand
 *
 * @author Evgenii Dudal <wolfstrace@gmail.com>
 */
class PasswordCreate
{

    /**
     * @var string
     */
    protected $unhashed;

    /**
     * @var mixed a password algorithm constant denoting the algorithm to use when hashing the password.
     */
    protected $algorithm;

    public function __construct(string $unhashed, $algorithm = PASSWORD_DEFAULT)
    {
        $this->unhashed = $unhashed;
        $this->algorithm = $algorithm;
    }

    public function getUnhashed(): string
    {
        return $this->unhashed;
    }

    /**
     * Get password algorithm.
     * @return mixed
     */
    public function getAlgorithm()
    {
        return $this->algorithm;
    }



}
