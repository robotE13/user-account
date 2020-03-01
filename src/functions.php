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

namespace RobotE13\UserAccount;


/**
 * Wrapper over array_reduce function.
 * @see array_reduce()
 * @param callable $callback
 * @param array $items
 * @param mixed $initial
 * @return mixed Returns the resulting value.
 */
function reduce(callable $callback, $items, $initial = null)
{
    return array_reduce($items, $callback, $initial);
}

/**
 * Создает валидатор из описания.
 * @param array $description массив описывающий правило валидации.
 * Формат массива ['validator', 'condition'=>'condition','message'=>'Error message'] {@see RobotE13\UserAccount\Entities\Password}
 * @param callable|null $next
 * @return callable цепочку функций-валидаторов пароля
 */
function createValidator($description, $next = null):callable
{
    return function($password) use ($description, $next) {
        $functionName = function_exists($description[0]) ? $description[0] : "RobotE13\\UserAccount\\{$description[0]}";
        return !$functionName($password, $description['condition']) ?
                new Entities\CheckResult(false, $description['message']) :
                (is_callable($next) ? $next($password) : new Entities\CheckResult(true));
    };
}

function lengthLessThan(string $string, int $length): bool
{
    return strlen($string) < $length;
}

function lengthGreaterThan(string $string, int $length): bool
{
    return strlen($string) > $length;
}

function match($subject, $pattern)
{
    return preg_match($pattern, $subject);
}
