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

/**
 * Description of Status
 *
 * @author robotR13
 */
class Status
{

    private $value;
    private $possibleStates;

    /**
     *
     * @param int $value
     * @param PossibleState $possibleStates
     */
    public function __construct(int $value, PossibleState $possibleStates)
    {
        Assert::true($possibleStates->isValidValue($value));
        $this->value = $value;
        $this->possibleStates = $possibleStates;
    }

    public function isConfirmed()
    {
        return $this->value !== UserStatuses::UNCONFIRMED;
    }

    public function isActive(): bool
    {
        return $this->value === UserStatuses::ACTIVE;
    }

    public function isInactive(): bool
    {
        return $this->value === UserStatuses::SUSPENDED || $this->value === UserStatuses::ARCHIVED;
    }

    public function isSuspended(): bool
    {
        return $this->value === UserStatuses::SUSPENDED;
    }

    public function isArchived(): bool
    {
        return $this->value === UserStatuses::ARCHIVED;
    }

    public function confirm()
    {
        if($this->isConfirmed())
        {
            throw new \DomainException('The user has been already confirmed.');
        }
        $this->value = UserStatuses::ACTIVE;
    }

    public function suspend()
    {
        if(!$this->isActive())
        {
            throw new \DomainException('Can suspend only active user.');
        }
        $this->value = UserStatuses::SUSPENDED;
    }

    public function archive()
    {
        if($this->isArchived())
        {
            throw new \DomainException('User already archived.');
        } elseif(!$this->isConfirmed())
        {
            throw new \DomainException('An unconfirmed user cannot be archived.');
        }
        $this->value = UserStatuses::ARCHIVED;
    }

    public function restore()
    {
        if(!$this->isInactive())
        {
            throw new \DomainException('Can restore only archived or suspended user.');
        }
        $this->value = UserStatuses::ACTIVE;
    }

    /**
     * Get an object that represents a list of valid status values.
     * @return PossibleState
     */
    public function getPossibleStates(): PossibleState
    {
        return $this->possibleStates;
    }

    public function getValue(): int
    {
        return $this->value;
    }

    public function getTextValue(): string
    {
        return $this->possibleStates->getTextValue($this->value);
    }

}
