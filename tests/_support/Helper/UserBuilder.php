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

    private $uuid;
    private $registrationEmail;
    private $password;
    private $isConfirmed;
    private $registeredOn;

    public function __construct(string $password)
    {
        $this->uuid = Id::next();
        $this->registrationEmail = 'user1@usermail.com';
        $this->password = new \RobotE13\UserAccount\Entities\Password($password);
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
