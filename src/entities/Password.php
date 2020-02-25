<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

namespace robote13\user_account\entities;

/**
 * Description of Password
 *
 * @author robotR13
 */
class Password
{

    private $hash;

    /**
     *
     * @param string $password
     * @param int $algo a password algorithm constant denoting the algorithm to use when hashing the password.
     */
    public function __construct(string $password, $algo = PASSWORD_DEFAULT)
    {
        $this->hash = password_hash($password, $algo);
    }

    /**
     * Verifies that a password matches a hash.
     * @param string $password
     * @return bool
     */
    public function verify($password):bool
    {
        return password_verify($password, $this->hash);
    }

    public function getHash(): string
    {
        return $this->hash;
    }
}
