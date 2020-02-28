<?php

namespace RobotE13\UserAccount\Entities;

use Webmozart\Assert\Assert;

/**
 * Трейт реализует общие методы интерфейса {{@see PossibleState}}
 * @see PossibleState
 * @author robotR13
 */
trait PossibleValues
{

    /**
     * Implements a method from the PossibleState interface.
     * @see PossibleState::isValidValue($value)
     */
    public function isValidValue(int $value): bool
    {
        return array_key_exists($value, $this->getAllExisting());
    }

    /**
     * Implements a method from the PossibleState interface.
     * @see PossibleState::isValidValue($value)
     */
    public function getTextValue($value): string
    {
        Assert::keyExists($this->getAllExisting(), $value);
        return $this->getAllExisting()[$value];
    }

    /**
     * @see PossibleState::getAllExisting()
     */
    abstract public function getAllExisting(): array;
}
