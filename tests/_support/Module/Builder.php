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

namespace RobotE13\UserAccount\Tests\Module;

use RobotE13\UserAccount\ServiceLocator;
use RobotE13\UserAccount\Services\Security\PasswordCreate\PasswordComplexityChecker;
use Builders\{
    UserBuilder,
    ContactBuilder
};
use League\Tactician\CommandBus;
use League\Tactician\Handler\{
    CommandHandlerMiddleware,
    CommandNameExtractor\ClassNameExtractor,
    Locator\CallableLocator,
    MethodNameInflector\HandleInflector
};

/**
 * Description of CommandBus
 *
 * @author Evgenii Dudal <wolfstrace@gmail.com>
 */
class Builder extends \Codeception\Module
{

    /**
     * @var CommandBus
     */
    private $commandBus;

    /**
     * @var Builders\UserBuilder
     */
    private $userBuilder;

    /**
     * @var Builders\ContactBuilder
     */
    private $contactBuilder;

    public function _beforeSuite($settings = array())
    {
        $container = ServiceLocator::getInstance()->getContainer();
        $this->commandBus = new \League\Tactician\CommandBus([
            $container->get(PasswordComplexityChecker::class),
            new CommandHandlerMiddleware(
                    new ClassNameExtractor(),
                    new CallableLocator(fn($commandName) => $container->get("{$commandName}Handler")),
                    new HandleInflector()
            )
        ]);

        $this->userBuilder = new UserBuilder($this->commandBus);
        $this->contactBuilder = new ContactBuilder();
    }

    /**
     *
     * @return \League\Tactician\CommandBus
     */
    public function getCommandBus(): CommandBus
    {
        return $this->commandBus;
    }

    /**
     *
     * @return \Builders\UserBuilder
     */
    public function getUserBuilder(): UserBuilder
    {
        return $this->userBuilder;
    }

    /**
     *
     * @return \Builders\ContactBuilder
     */
    public function getContactBuilder(): ContactBuilder
    {
        return $this->contactBuilder;
    }

}
