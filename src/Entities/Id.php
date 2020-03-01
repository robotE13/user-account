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

use Webmozart\Assert\Assert;
use Ramsey\Uuid\Uuid;

/**
 * Description of Id
 *
 * @author robotR13
 */
class Id
{

    private $uid;

    public function __construct(string $id)
    {
        Assert::notEmpty($id);

        $this->uid = $id;
    }

    public static function next(): self
    {
        return new self(Uuid::uuid1()->toString());
    }

    public function getUid(): string
    {
        return $this->uid;
    }

    public function isEqualTo(self $other): bool
    {
        return $this->getUid() === $other->getUid();
    }

}
