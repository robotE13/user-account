<?php

namespace Helper;

use RobotE13\UserAccount\Entities\{
    Id,
    User
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
    private $isConfirmed;
    private $registeredOn;

    public function __construct()
    {
        $this->uuid = Id::next();
        $this->registrationEmail = 'user1@usermail.com';
        $this->password = new \RobotE13\UserAccount\Entities\Password(self::DEFAULT_PASSWORD);
    }

    public function withUid(Id $uid)
    {
        $this->uuid = $uid;
        return $this;
    }

    public function create(): User
    {
        $user = new User(
                $this->uuid,
                $this->registrationEmail,
                $this->password
        );

        return $user;
    }

}
