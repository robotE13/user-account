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

namespace RobotE13\UserAccount\Services\Security\PasswordCreate;

/**
 * PasswordValidator.
 * Checks the complexity of the password.
 *
 * @author Evgenii Dudal <wolfstrace@gmail.com>
 */
class PasswordComplexityChecker implements \League\Tactician\Middleware
{

    /**
     *
     * @var callable
     * @return \RobotE13\UserAccount\Entities\CheckResult
     */
    private $complexityChecker;

    /**
     * Constructor.
     * @param array $rules description of the password complexity and validation rules.
     * @see \RobotE13\UserAccount\createValidator()
     */
    public function __construct($rules)
    {
        $this->complexityChecker = \RobotE13\UserAccount\reduce(
                fn($nextCall, $rule) => \RobotE13\UserAccount\createValidator($rule, $nextCall),
                array_reverse($rules),
                null
        );
    }

    /**
     * This method checks the complexity of the password.
     * @param object $command
     * @param callable $next
     * @return mixed
     * @throws \DomainException
     */
    public function execute($command, callable $next)
    {
        if($command instanceof PasswordCreate)
        {
            /* @var $result \RobotE13\UserAccount\Entities\CheckResult */
            $result = call_user_func_array($this->complexityChecker, [$command->getUnhashed()]);
            if(!$result->getTruth())
            {
                throw new \DomainException($result->getErrorMessage());
            }
        }
        return $next($command);
    }

}
