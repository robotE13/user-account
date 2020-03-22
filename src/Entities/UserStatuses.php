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
 * Description of UserStatuses
 *
 * @author Evgenii Dudal <wolfstrace@gmail.com>
 */
class UserStatuses implements PossibleState
{

    use PossibleValues;

    const UNCONFIRMED = 1;
    const ACTIVE = 2;
    const SUSPENDED = 3;
    const ARCHIVED = 4;

    /**
     * Implements a method from the PossibleState interface.
     * @see PossibleState::getAllExisting()
     */
    public function getAllExisting(): array
    {
        return[
            self::UNCONFIRMED => 'Unconfirmed',
            self::ACTIVE => 'Active',
            self::SUSPENDED => 'Suspended',
            self::ARCHIVED => 'Archived'
        ];
    }

}
