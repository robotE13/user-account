<?php

/**
 * @package UserAccount
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
