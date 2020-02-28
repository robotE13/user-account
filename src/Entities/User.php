<?php

namespace RobotE13\UserAccount\Entities;

use RobotE13\UserAccount\Entities\Contact\{
    Contact,
    ContactsCollection
};

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
    private $contacts;
    private $registeredOn;

    /**
     *
     * @param Id $uid
     * @param string $registrationEmail
     * @param Password $password
     * @param array $contacts
     */
    public function __construct(Id $uid, string $registrationEmail, Password $password, $contacts = [])
    {
        $this->uid = $uid;
        $this->registrationEmail = $registrationEmail;
        $this->password = $password;
        $this->contacts = new ContactsCollection($contacts);
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

    /**
     * Добавление нового контакта.
     * @param Contact $contact
     */
    public function addContact(Contact $contact)
    {
        $this->contacts->add($contact);
    }

    /**
     * Удаление контакта.
     * @param type $index
     */
    public function removeContact($index)
    {
        $this->contacts->remove($index);
    }

    //////////////////////
    // Getters
    //////////////////////

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
     * Возвращает типизированную коллекцию контактов.
     * @return ContactsCollection
     */
    public function getContacts(): ContactsCollection
    {
        return $this->contacts;
    }

}
