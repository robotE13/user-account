<?php

namespace Helper;

use Helper\ServiceLocator;
use RobotE13\UserAccount\Services\Security\PasswordCreate\PasswordComplexityChecker;
use League\Tactician\CommandBus;
use League\Tactician\Handler\{
    CommandHandlerMiddleware,
    CommandNameExtractor\ClassNameExtractor,
    Locator\CallableLocator,
    MethodNameInflector\HandleInflector
};

// here you can define custom actions
// all public methods declared in helper class will be available in $I

class Unit extends \Codeception\Module
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
        $this->commandBus = new \League\Tactician\CommandBus([
            ServiceLocator::createObject(PasswordComplexityChecker::class),
            new CommandHandlerMiddleware(
                    new ClassNameExtractor(),
                    new CallableLocator(fn($commandName) => ServiceLocator::createObject("{$commandName}Handler", true)),
                    new HandleInflector()
            )
        ]);

        $this->userBuilder = new Builders\UserBuilder($this->commandBus);
        $this->contactBuilder = new Builders\ContactBuilder();
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
     * @return \Helper\Builders\UserBuilder
     */
    public function getUserBuilder(): Builders\UserBuilder
    {
        return $this->userBuilder;
    }

    /**
     *
     * @return \Helper\Builders\ContactBuilder
     */
    public function getContactBuilder(): Builders\ContactBuilder
    {
        return $this->contactBuilder;
    }

}
