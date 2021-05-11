<?php

/*
 * This file is part of the user-account.
 *
 * Copyright 2021 Evgenii Dudal <wolfstrace@gmail.com>.
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 * @package user-account
 */

namespace RobotE13\UserAccount\Entities;

/**
 * @author Evgenii Dudal <wolfstrace@gmail.com>
 */
interface UserEntity
{

    public function isSuspended(): bool;
    public function isArchived(): bool;
}
