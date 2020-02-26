<?php

/**
 * @package UserAccount
 */

namespace RobotE13\UserAccount\Entities;

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
        $complexity = self::checkComplexity($password);
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
    public static function checkComplexity($password): CheckResult
    {
        if(strlen($password) < 8)
        {
            return new CheckResult(false, 'The password must be at least 8 characters long.');
        } elseif(!preg_match('/^[A-Za-z\d\W_]+$/u', $password))
        {
            return new CheckResult(false, 'Only latin letters, numbers, and special characters are allowed.');
        } elseif(preg_match('/^[a-z\d\W_]+$/u', $password))
        {
            return new CheckResult(false, 'The password must contain at least one uppercase character.');
        }elseif(preg_match('/^[A-Za-z]+$/u', $password))
        {
            return new CheckResult(false, 'The password must contain at least one digit or special character.');
        }
        return new CheckResult(true);
    }

    public function getHash(): string
    {
        return $this->hash;
    }

}
