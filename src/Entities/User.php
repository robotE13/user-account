<?php

namespace RobotE13\UserAccount\Entities;

/**
 * Description of User
 *
 * @author robotR13
 */
class User
{

    private $uid;
    private $registrationEmail;
    private $password;
    private $isConfirmed;
    private $contacts = [];
    private $registeredOn;

    public function __construct(Id $uid, string $registrationEmail, Password $password)
    {
        $this->uid = $uid;
        $this->registrationEmail = $registrationEmail;
        $this->password = $password;
        $this->isConfirmed = false;
        $this->registeredOn = new \DateTimeImmutable();
    }

    /**
     * Смена текущего пароля пароля пользователя.
     * Метод сравнивает переданный {{@see $currentPassword}} для подтверждения смены и при
     * совпадении с установленным текущим паролем заменяет его на новый.
     * @param string $currentPassword строка содержащая текущий пароль для подтверждения смены
     * @param Password $newPassword объект представляющий новый пароль
     * @return bool результат смены пароля
     */
    public function changePassword(string $currentPassword, Password $newPassword): bool
    {
        if(!$this->password->verify($currentPassword))
        {
            return false;
        }
        $this->password = $newPassword;
        return true;
    }

    /**
     * Сброс пароля пользователя.
     * Заменяет текущий пароль на новый.
     * @param Password $password
     * @return void
     */
    public function resetPassword(Password $password): void
    {
        $this->password = $password;
    }

    public function addContact(Contact $contact)
    {
    }

    public function removeContact(Contact $contact)
    {
    }

    // Getters
    public function getUid(): Id
    {
        return $this->uid;
    }

    public function getRegistrationEmail(): string
    {
        return $this->registrationEmail;
    }

    public function getPassword(): Password
    {
        return $this->password;
    }

    public function isConfirmed(): bool
    {
        return $this->isConfirmed;
    }

    public function getRegisteredOn(): \DateTimeImmutable
    {
        return $this->registeredOn;
    }

    /**
     * @return Contact[]
     */
    public function getContacts(): array
    {
        return $this->contacts;
    }

}
