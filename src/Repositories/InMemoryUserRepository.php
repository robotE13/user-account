<?php

/**
 * This file is part of the user-account.
 *
 * Copyright 2021 Evgenii Dudal <wolfstrace@gmail.com>.
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 * @package user-account
 */

namespace RobotE13\UserAccount\Repositories;

use RobotE13\UserAccount\Entities\User;

/**
 * Description of InMemoryUserRepository
 *
 * @author Evgenii Dudal <wolfstrace@gmail.com>
 */
class InMemoryUserRepository implements UserRepository
{

    /**
     * @var User[]
     */
    private static $items = [];

    public function add(User $user): void
    {
        static::$items[$user->getUid()->getString()] = $user;
    }

    public function findByEmail($email): User
    {
        foreach (static::$items as $user)
        {
            if($user->getRegistrationEmail() === $email)
            {
                return $user;
            }
        }
        throw new NotFoundException('User not found.');
    }

    public function findById($uid): User
    {
        if(!isset(static::$items[$uid]))
        {
            throw new NotFoundException('User not found.');
        }
        return clone static::$items[$uid];
    }

    public function remove($uid): void
    {
        $this->findById($uid);
        unset(static::$items[$uid]);
    }

    public function update(User $user): void
    {
        $this->add($user);
    }

}
