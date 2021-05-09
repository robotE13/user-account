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

namespace RobotE13\UserAccount\Repositories;

use RobotE13\UserAccount\Entities\User;

/**
 *
 * @author Evgenii Dudal <wolfstrace@gmail.com>
 */
interface UserRepository
{

    /**
     * @param string $uid
     * @return User
     * @throws NotFoundException
     */
    public function findById($uid): User;

    /**
     * @param string $email
     * @return User
     * @throws NotFoundException
     */
    public function findByEmail($email): User;

    /**
     * @param User $user
     * @return void
     */
    public function add(User $user): void;

    /**
     * @param User $user
     * @return void
     */
    public function update(User $user): void;

    /**
     * @param string $uid UUID of the user being removed
     * @return void
     * @throws NotFoundException
     */
    public function remove($uid): void;
}
