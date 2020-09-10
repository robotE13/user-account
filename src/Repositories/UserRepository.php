<?php

/*
 * This file is part of the user-account.
 *
 * Copyright 2020 Evgenii Dudal <wolfstrace@gmail.com>.
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 * @package user-account
 */

namespace RobotR13\UserAccount\Repositories;

use RobotE13\UserAccount\Entities\User;

/**
 *
 * @author Evgenii Dudal <wolfstrace@gmail.com>
 */
interface UserRepository
{
    /**
     *
     * @param type $id
     * @return User
     * @throws NotFoundException
     */
    public function findById($id):User;
    public function findByEmail($email):User;

    public function add(User $user);
    public function update(User $user);
    public function remove($id);
}
