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

use RobotE13\UserAccount;

/**
 * Преставляет хеш пароля.
 * @author Evgenii Dudal <wolfstrace@gmail.com>
 */
class Password
{

    private $hash;

    /**
     *
     * @param string $password
     * @param int $algo a password algorithm constant denoting the algorithm to use when hashing the password.
     * @throws \DomainException if the password did not pass the complexity check.
     */
    public function __construct(string $password, $algo = PASSWORD_DEFAULT)
    {
        $complexity = static::checkComplexity($password);
        if(!$complexity->getTruth())
        {
            throw new \DomainException($complexity->getErrorMessage());
        }
        $this->hash = password_hash($password, $algo);
    }

    /**
     * Verifies that a password matches a hash.
     * @param string $password
     * @return bool
     */
    public function verify($password): bool
    {
        return password_verify($password, $this->hash);
    }

    /**
     * This method checks the complexity of the password.
     * @param string $password
     * @return CheckResult
     */
    public final static function checkComplexity($password): CheckResult
    {
        return UserAccount\reduce(
                        fn($nextCall, $rule) => UserAccount\createValidator($rule, $nextCall),
                        array_reverse(static::complexityDescription()),
                        null
                )($password);
    }

    /**
     * Description of the password validation rules.
     * @return array
     */
    protected static function complexityDescription()
    {
        return [
            'length' => ['lengthGreaterThan', 'condition' => 8, 'message' => 'The password must be at least 8 characters long.'],
            'onlyLatin' => ['match', 'condition' => '/^[A-Za-z\d\W_]+$/u', 'message' => 'Only latin letters, numbers, and special characters are allowed.'],
            'uppercaseRequired' => ['match', 'condition' => '/[A-Z]+/u', 'message' => 'The password must contain at least one uppercase character.'],
            'specialOrDigitRequired' => ['match', 'condition' => '/[\d\W_]+/u', 'message' => 'The password must contain at least one digit or special character.']
        ];
    }

    public function getHash(): string
    {
        return $this->hash;
    }

}
