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

namespace RobotE13\UserAccount\Services\Security\PasswordFromHash;

use Webmozart\Assert\Assert;
use samdark\hydrator\Hydrator;
use RobotE13\UserAccount\Entities\Password;

/**
 * Description of PasswordFromHashHandler
 *
 * @author Evgenii Dudal <wolfstrace@gmail.com>
 */
class PasswordFromHashHandler
{
    private $hydrator;

    public function __construct()
    {
        $this->hydrator = new Hydrator([
            'hash' => 'hash'
        ]);
    }

    public function handle(PasswordFromHash $command): Password
    {
        Assert::notEq(password_get_info($command->getHash())['algo'], 0, 'The `$hash` is not a password hash calculated by the `password_hash()` function.');
        return $this->hydrator->hydrate(compact('hash'), Password::class);
    }

}
