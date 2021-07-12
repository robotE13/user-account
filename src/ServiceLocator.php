<?php

/**
 * This file is part of the user-account.
 *
 * Copyright 2021 Evgenii Dudal <wolfstrace@gmail.com>.
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 * @package user-account
 */

namespace RobotE13\UserAccount;

use RobotE13\UserAccount\Services\Security\PasswordCreate\PasswordComplexityChecker;
use League\Container\{
    Container,
    ReflectionContainer
};
use League\Container\Definition\{
    Definition,
    DefinitionAggregate
};

/**
 * Description of Container
 *
 * @author Evgenii Dudal <wolfstrace@gmail.com>
 */
class ServiceLocator
{

    /**
     * @var self
     */
    private static $instance;

    /**
     * @var Container
     */
    private $container;

    private function __construct()
    {
        $definitions = [
            (new Definition(PasswordComplexityChecker::class))->addArgument([
                'onlyLatin' => ['matchRegular', 'condition' => '/^[A-Za-z\d\W_]+$/u', 'message' => 'Only latin letters, numbers, and special characters are allowed.'],
                'length' => ['lengthGreaterThan', 'condition' => 8, 'message' => 'The password must be at least 8 characters long.'],
                'uppercaseRequired' => ['matchRegular', 'condition' => '/[A-Z]+/u', 'message' => 'The password must contain at least one uppercase character.'],
                'specialOrDigitRequired' => ['matchRegular', 'condition' => '/[\d\W_]+/u', 'message' => 'The password must contain at least one digit or special character.']
            ])
        ];
        $this->container = new Container(new DefinitionAggregate($definitions));
        $this->container->delegate(new ReflectionContainer());
    }

    /**
     * @return self
     */
    public static function getInstance(): self
    {
        if(self::$instance === null)
        {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function getContainer(): Container
    {
        return $this->container;
    }

}
