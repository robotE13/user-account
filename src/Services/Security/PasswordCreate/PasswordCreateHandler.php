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

use samdark\hydrator\Hydrator;
use RobotE13\UserAccount\Entities\Password;

/**
 * Description of CreatePasswordHandler
 *
 * @author Evgenii Dudal <wolfstrace@gmail.com>
 */
class PasswordCreateHandler
{

    private $hydrator;

    public function __construct()
    {
        $this->hydrator = new Hydrator([
            'hash' => 'hash'
        ]);
    }

    /**
     * Creates a password hash from the passed string contained an unhashed password.
     * @param PasswordCreate $command
     * @return Password
     * @throws \DomainException if the password did not pass the complexity check.
     */
    public function handle($command): Password
    {
        return $this->hydrator->hydrate(['hash' => password_hash($command->getUnhashed(), $command->getAlgorithm())], Password::class);
    }

}
