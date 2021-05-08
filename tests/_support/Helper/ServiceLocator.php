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

namespace Helper;

use RobotE13\UserAccount\Services\Security\PasswordCreate\PasswordComplexityChecker;
use League\Container\Container;
use League\Container\Definition\{
    Definition,
    DefinitionAggregate
};

/**
 * Description of Common
 *
 * @author Evgenii Dudal <wolfstrace@gmail.com>
 */
class ServiceLocator extends \Codeception\Module
{

    /**
     * @var Container
     */
    private static $container;

    public static function getContainer(): Container
    {
        if(!isset(self::$container))
        {
            $definitions = [
                (new Definition(PasswordComplexityChecker::class))->addArgument([
                    'onlyLatin' => ['match', 'condition' => '/^[A-Za-z\d\W_]+$/u', 'message' => 'Only latin letters, numbers, and special characters are allowed.'],
                    'length' => ['lengthGreaterThan', 'condition' => 8, 'message' => 'The password must be at least 8 characters long.'],
                    'uppercaseRequired' => ['match', 'condition' => '/[A-Z]+/u', 'message' => 'The password must contain at least one uppercase character.'],
                    'specialOrDigitRequired' => ['match', 'condition' => '/[\d\W_]+/u', 'message' => 'The password must contain at least one digit or special character.']
                ])
            ];
            self::$container = new Container(new DefinitionAggregate($definitions));
        }
        return self::$container;
    }

    public static function createObject($type)
    {
        if(self::getContainer()->has($type))
        {
            return self::getContainer()->get($type);
        }
        return new $type();
    }

}
