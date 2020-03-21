<?php

namespace Helper;

use RobotE13\UserAccount\Entities\{
    Id,
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

    private $uuid;
    private $registrationEmail;
    private $password;
    private $status;
    //private $registeredOn;

    public function __construct()
    {
        $this->uuid = Id::next();
        $this->registrationEmail = 'user1@usermail.com';
        $this->password = new \RobotE13\UserAccount\Entities\Password(self::DEFAULT_PASSWORD);
        $this->status = UserStatuses::UNCONFIRMED;
    }

    /**
     * Задать создаваемому пользователю определенный ID
     * @param Id $uid
     * @return $this
     */
    public function withUid(Id $uid)
    {
        $this->uuid = $uid;
        return $this;
    }

    /**
     * Создать пользователя с определенным статусом.
     * @param int $status
     * @return $this
     */
    public function withStatus(int $status)
    {
        $this->status = $status;
        return $this;
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

}
