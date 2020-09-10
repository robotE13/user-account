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

use Webmozart\Assert\Assert;
use Ramsey\Uuid\{
    UuidFactory,
    Codec\OrderedTimeCodec,
    Rfc4122\UuidV1
};

/**
 * Description of Id
 *
 * @method string getBytes() returns the binary string representation of the UUID
 * @method \Ramsey\Uuid\Type\Hexadecimal getHex() returns the hexadecimal representation of the UUID
 * @method \Ramsey\Uuid\Type\Integer getInteger() returns the integer representation of the UUID
 * @method string getString() returns the string standard representation of the UUID
 * @author Evgenii Dudal <wolfstrace@gmail.com>
 */
class Id
{

    /**
     * @var UuidV1
     */
    private $uuid;

    /**
     * Constructor.
     *
     * Initializes the UUID object from given bytes representation `$bytes`,
     * or creates new ordered by time UUID if `$bytes` is not set.
     * @param string $bytes A binary string
     */
    public function __construct(string $bytes = null)
    {
        $factory = new UuidFactory();
        $factory->setCodec(new OrderedTimeCodec($factory->getUuidBuilder()));

        $this->uuid = $bytes !== null ? $factory->fromBytes($bytes) : $factory->uuid1();
        Assert::isInstanceOf($this->uuid, UuidV1::class);
    }

    /**
     * Calls the named method which is not a class method.
     *
     * This method creates wrapper methods over some methods of the Uuid1 getters.
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
        $isAllowedGetter = strpos($name, 'get') === 0 && in_array($name, ['getBytes', 'getHex', 'getInteger']);
        if($isAllowedGetter && method_exists($this->uuid, $name))
        {
            return $this->uuid->$name();
        } elseif($name === "getString")
        {
            return $this->uuid->toString();
        }
        throw new \BadMethodCallException('Calling unknown method: ' . get_class($this) . "::$name()");
    }

    public function getUuid(): UuidV1
    {
        return $this->uuid;
    }

    /**
     * Checks that the ID is equal to the provided object.
     *
     * @param self $other An object to test for equality with this ID
     * @return bool True if the other object is equal to this ID
     */
    public function isEqualTo(self $other): bool
    {
        return $this->uuid->equals($other->getUuid());
    }

}
