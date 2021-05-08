<?php

namespace Helper\Builders;

use League\Tactician\CommandBus;
use RobotE13\DDD\Entities\Uuid\Id;
use RobotE13\UserAccount\Services\Security\PasswordCreate\PasswordCreate;
use RobotE13\UserAccount\Entities\{
    User,
    UserStatuses,
    Status
};

/**
 * Description of UserBuilder
 *
 * @author robotR13
 */
class UserBuilder
{

    const DEFAULT_PASSWORD = 'Asd5%_password';

    /**
     * @var CommandBus
     */
    private $commandBus;
    private $uuid;
    private $registrationEmail;
    private $password;
    private $status;

    //private $registeredOn;

    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
        $this->uuid = Id::next();
        $this->registrationEmail = 'user1@usermail.com';
        $this->password = $this->commandBus->handle(new PasswordCreate(self::DEFAULT_PASSWORD));
        $this->status = UserStatuses::UNCONFIRMED;
    }

    /**
     * Задать создаваемому пользователю определенный ID
     * @param Id|null $uid
     * @return $this
     */
    public function withUid($uid): self
    {
        return $this->getClone('uuid', $uid);
    }

    /**
     * Задать создаваемому пользователю определенный ID
     * @param Id|null $uid
     * @return $this
     */
    public function withEmail($email):self
    {
        return $this->getClone('registrationEmail', $email);
    }

    /**
     * Создать пользователя с определенным статусом.
     * @param int $status
     * @return self
     */
    public function withStatus(int $status):self
    {
        return $this->getClone('status', $status);
    }

    public function create(): User
    {
        $user = new User(
                $this->uuid,
                $this->registrationEmail,
                $this->password,
                new Status($this->status, new UserStatuses())
        );

        return $user;
    }

    private function getClone($attribute, $value): self
    {
        $clone = clone $this;
        $clone->{$attribute} = $value;
        return $clone;
    }

}
