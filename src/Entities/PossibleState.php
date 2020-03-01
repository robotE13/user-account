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

/**
 *
 * @author robotR13
 */
interface PossibleState
{

    /**
     * Checks that this state value is valid.
     * @param int $value
     * @return bool
     */
    public function isValidValue(int $value): bool;

    /**
     * Get state in a text form.
     * @param int $value
     * @return string
     * @throws \InvalidArgumentException when a non-existent value is passed.
     */
    public function getTextValue($value): string;

    /**
     * Get all possible states.
     * Returns a list of all possible states, in array of a key-value pairs.
     * @return array
     */
    public function getAllExisting(): array;
}
