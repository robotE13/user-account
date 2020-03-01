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
 * Description of CheckResult
 *
 * @author Evgenii Dudal <wolfstrace@gmail.com>
 */
class CheckResult
{

    private $truth;
    private $errorMessage;

    public function __construct(bool $truth, string $errorMessage = '')
    {
        $this->truth = $truth;
        if(!$this->truth)
        {
            Assert::notEmpty($errorMessage, 'If the test result is "FALSE", the error message must be set');
        }
        $this->errorMessage = $errorMessage;
    }

    public function getTruth(): bool
    {
        return $this->truth;
    }

    public function getErrorMessage(): string
    {
        return $this->errorMessage;
    }

}
