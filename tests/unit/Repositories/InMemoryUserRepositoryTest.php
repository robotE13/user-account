<?php

/**
 * This file is part of the user-account.
 *
 * Copyright 2021 Evgenii Dudal <wolfstrace@gmail.com>.
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 * @package user-account
 */

namespace tests\unit\Repositories;

use RobotE13\UserAccount\Tests\UserRepositoryAbstractTest;
use RobotE13\UserAccount\Repositories\InMemoryUserRepository;

/**
 * Description of InMemoryUserRepositoryTest
 *
 * @author Evgenii Dudal <wolfstrace@gmail.com>
 */
class InMemoryUserRepositoryTest extends UserRepositoryAbstractTest
{

    /**
     * @var \UnitTester
     */
    protected $tester;

    protected function _before()
    {
        parent::_before();
        $this->repository = new \RobotE13\UserAccount\Repositories\InMemoryUserRepository();
    }
}
