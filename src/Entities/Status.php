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
