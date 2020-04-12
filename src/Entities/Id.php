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
use Ramsey\Uuid\{
    UuidFactory,
    Codec\OrderedTimeCodec,
    Rfc4122\UuidV1
};

/**
 * Description of Id
 *
 * @author Evgenii Dudal <wolfstrace@gmail.com>
 */
class Id
{

    private $uid;

    /**
     * Constructor.
     *
     * Initializes the UUID object from given bytes representation `$bytes`,
     * or creates new ordered by time UUID if `$bytes` is not set.
     * @param string $bytes A binary string
     */
    public function __construct(string $bytes = null)
    {
        $factory = new UuidFactory();
        $factory->setCodec(new OrderedTimeCodec($factory->getUuidBuilder()));

        $this->uid = $bytes !== null ? $factory->fromBytes($bytes) : $factory->uuid1();
        Assert::isInstanceOf($this->uid, UuidV1::class);
    }

    public function getUid(): UuidV1
    {
        return $this->uid;
    }

    public function isEqualTo(self $other): bool
    {
        return $this->getUid()->equals($other->getUid());
    }

}
