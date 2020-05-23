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

namespace RobotE13\UserAccount\Services;

use Webmozart\Assert\Assert;
use samdark\hydrator\Hydrator;
use RobotE13\UserAccount\Entities\{
    Password,
    CheckResult
};

/**
 * Description of PasswordService
 *
 * @author Evgenii Dudal <wolfstrace@gmail.com>
 */
class PasswordService
{

    private $hydrator;
    private $complexityChecker;

    public function __construct()
    {
        $this->complexityChecker = \RobotE13\UserAccount\reduce(
                fn($nextCall, $rule) => \RobotE13\UserAccount\createValidator($rule, $nextCall),
                array_reverse($this->complexityDescription()),
                null
        );
        $this->hydrator = new Hydrator([
            'hash' => 'hash'
        ]);
    }

    /**
     * This method checks the complexity of the password.
     * @param string $unhashed
     * @return CheckResult
     */
    final public function checkComplexity($unhashed): CheckResult
    {
        return call_user_func_array($this->complexityChecker, [$unhashed]);
    }

    /**
     * Creates a password hash from the passed string contained an unhashed password.
     * @param string $unhashed
     * @param int $algo a password algorithm constant denoting the algorithm to use when hashing the password.
     * @return Password
     * @throws \DomainException if the password did not pass the complexity check.
     */
    public function create($unhashed, $algo = PASSWORD_DEFAULT): Password
    {
        $checkResult = $this->checkComplexity($unhashed);
        if(!$checkResult->getTruth())
        {
            throw new \DomainException($checkResult->getErrorMessage());
        }
        return $this->createFromHash(password_hash($unhashed, $algo));
    }

    public function createFromHash($hash): Password
    {
        Assert::notEq(password_get_info($hash)['algo'], 0, 'The `$hash` is not a password hash calculated by the `password_hash()` function.');
        return $this->hydrator->hydrate(compact('hash'), Password::class);
    }

    /**
     * Description of the password validation rules.
     * @return array
     */
    public function complexityDescription()
    {
        return [
            'onlyLatin' => ['match', 'condition' => '/^[A-Za-z\d\W_]+$/u', 'message' => 'Only latin letters, numbers, and special characters are allowed.'],
            'length' => ['lengthGreaterThan', 'condition' => 8, 'message' => 'The password must be at least 8 characters long.'],
            'uppercaseRequired' => ['match', 'condition' => '/[A-Z]+/u', 'message' => 'The password must contain at least one uppercase character.'],
            'specialOrDigitRequired' => ['match', 'condition' => '/[\d\W_]+/u', 'message' => 'The password must contain at least one digit or special character.']
        ];
    }

}
