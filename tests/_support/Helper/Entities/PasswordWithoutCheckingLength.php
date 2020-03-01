<?php

/**
 * This file is part of the user-account.
 *
 * Copyright 2020 Evgenii Dudal <wolfstrace@gmail.com>.
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 * @package user-account/tests
 */

namespace Helper\Entities;

use RobotE13\UserAccount\Entities\Password;

/**
 * Для проверки настройки правил валидации пароля.
 * Класс переопределяет метод, описывающий правила валидации пароля.
 * @author Evgenii Dudal <wolfstrace@gmail.com>
 */
class PasswordWithoutCheckingLength extends Password
{

    protected static function complexityDescription()
    {
        $rules = parent::complexityDescription();
        unset($rules['length']);
        return $rules;
    }

}
