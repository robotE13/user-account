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

namespace RobotE13\UserAccount\Entities;

/**
 * Преставляет хеш пароля.
 *
 * @author Evgenii Dudal <wolfstrace@gmail.com>
 */
class Password
{

    private $hash;

    /**
     * Constructor.
     *
     * Direct creation by the "new" operator is not supported.
     * To create an object representing the password hash,
     * use the appropriate methods of the class: {@see \RobotE13\UserAccount\Services\PasswordService}.
     * @throws \DomainException
     */
    final public function __construct()
    {
        throw new \DomainException('To create an object representing the password hash, use the appropriate methods of the class: ' . \RobotE13\UserAccount\Services\PasswordService::class);
    }

    /**
     * Verifies that a password matches a hash.
     * @param string $password
     * @return bool
     */
    public function verify(string $password): bool
    {
        return password_verify($password, $this->hash);
    }

}
