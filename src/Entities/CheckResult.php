<?php

/**
 * @package UserAccount
 */

namespace RobotE13\UserAccount\Entities;

use Webmozart\Assert\Assert;

/**
 * Description of CheckResult
 *
 * @author robotR13
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
