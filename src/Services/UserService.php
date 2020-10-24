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

namespace RobotE13\UserAccount\Services;

use RobotE13\UserAccount\Repositories\UserRepository;
use RobotE13\UserAccount\Entities\{
    Id,
    Password,
    Status,
    User,
    UserStatuses
};

/**
 * Description of UserService
 *
 * @author Evgenii Dudal <wolfstrace@gmail.com>
 */
class UserService
{

    private $users;

    public function __construct(UserRepository $users)
    {
        $this->users = $users;
    }

    public function create(UserDTO $dto): User
    {
        $user = new User(
                new Id(),
                $dto->email,
                new Password($dto->password),
                new Status(
                        UserStatuses::UNCONFIRMED,
                        new UserStatuses()
                )
        );
        $this->users->add($user);
        return $user;
    }

    public function register($dto)
    {

    }

    public function activate($id)
    {

    }

    public function suspend($id)
    {

    }

}
