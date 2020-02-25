<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace robote13\user_account\entities;

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
