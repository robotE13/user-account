<?php

/**
 * @package UserAccount
 */

namespace RobotE13\UserAccount\Entities;

use Webmozart\Assert\Assert;

/**
 * Description of Status
 *
 * @author robotR13
 */
class Status
{

    const UNCONFIRMED = 1;
    const ACTIVE = 2;
    const SUSPENDED = 3;
    const ARCHIVED = 4;

    private $value;

    public function __construct(int $value)
    {
        Assert::keyExists(static::getAllExisting(), $value);
        $this->value = $value;
    }

    public static function getAllExisting()
    {
        return[
            self::UNCONFIRMED => 'Unconfirmed',
            self::ACTIVE => 'Active',
            self::SUSPENDED => 'Suspended',
            self::ARCHIVED => 'Archived'
        ];
    }

    public function getValue(): int
    {
        return $this->value;
    }

    public function getTextValue(): string
    {
        return static::getAllExisting()[$this->value];
    }

}
