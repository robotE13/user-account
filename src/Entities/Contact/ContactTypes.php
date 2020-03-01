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

namespace RobotE13\UserAccount\Entities\Contact;

use RobotE13\UserAccount\Entities\PossibleState;

/**
 * Description of ContactTypes
 *
 * @author Evgenii Dudal <wolfstrace@gmail.com>
 */
class ContactTypes implements PossibleState
{

    use \RobotE13\UserAccount\Entities\PossibleValues;

    const TYPE_EMAIL = 'email';
    const TYPE_PHONE = 'phone';

    public function getAllExisting(): array
    {
        return[
            self::TYPE_EMAIL => 'Email',
            self::TYPE_PHONE => 'Phone'
        ];
    }

}
