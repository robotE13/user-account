<?php

/**
 * This file is part of the user-account.
 *
 * Copyright 2020 Evgenii Dudal <wolfstrace@gmail.com>.
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 * @package user-account
 */

namespace RobotE13\UserAccount\Entities;

use RobotE13\UserAccount\Entities\Contact\{
    Contact,
    ContactsCollection
};

/**
 * Description of User
 *
 * @method bool isConfirmed() Description
 * @method bool isActive() Description
 * @method bool isInactive() Description
 * @method bool isSuspended() Description
 * @method bool isArchived() Description
 * @method void confirm() Confirmation the newly registered account. Wrapper over {@see Status::confirm}
 * @method void suspend() {@see Status::suspend}
 * @method void archive() {@see Status::archive}
 * @method void restore() {@see Status::restore}
 * @author Evgenii Dudal <wolfstrace@gmail.com>
 */
class User
{

    private $uid;
    private $registrationEmail;
    private $password;
    private $status;
    private $contacts;
    private $registeredOn;

    /**
     *
     * @param Id $uid
     * @param string $registrationEmail
     * @param Password $password
     * @param Status $status
     * @param array $contacts
     */
    public function __construct(Id $uid, string $registrationEmail, Password $password, Status $status, $contacts = [])
    {
        $this->uid = $uid;
        $this->registrationEmail = $registrationEmail;
        $this->password = $password;
        $this->contacts = new ContactsCollection($contacts);
        $this->status = $status;
        $this->registeredOn = new \DateTimeImmutable();
    }

    /**
     * Calls the named method which is not a class method.
     *
     * This method creates wrapper methods over methods of the Status class
     * that are used to check or change the user account status.
     *
     * Do not call this method directly as it is a PHP magic method that
     * will be implicitly called when an unknown method is being invoked.
     * @param string $name the method name
     * @param array $arguments method parameters
     * @return mixed the method return value
     * @throws \BadMethodCallException when calling unknown method
     */
    public function __call($name, $arguments)
    {
        $status = $this->getStatus();
        $isGetter = strpos($name,'get') === 0;
        if(!$isGetter && method_exists($status, $name))
        {
            return $status->$name();
        }
        throw new \BadMethodCallException('Calling unknown method: ' . get_class($this) . "::$name()");
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

    /**
     * Регистрационный e-mail полльзователя.
     * @return string
     */
    public function getRegistrationEmail(): string
    {
        return $this->registrationEmail;
    }

    /**
     * Возвращает объект представляющий пароль и методы работы с ним.
     * @return Password
     */
    public function getPassword(): Password
    {
        return $this->password;
    }

    /**
     * Возвращает объект представляющий текущий статус пользователя.
     * @return Status
     */
    public function getStatus(): Status
    {
        return $this->status;
    }

    /**
     * Дата регистрации пользователя.
     * @return \DateTimeImmutable
     */
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
