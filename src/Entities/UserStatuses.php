<?php

namespace RobotE13\UserAccount\Entities;

/**
 * Description of AvailableValues
 *
 * @author robotR13
 */
class UserStatuses implements PossibleState
{

    use PossibleValues;

    const UNCONFIRMED = 1;
    const ACTIVE = 2;
    const SUSPENDED = 3;
    const ARCHIVED = 4;

    /**
     * Implements a method from the PossibleState interface.
     * @see PossibleState::getAllExisting()
     */
    public function getAllExisting(): array
    {
        return[
            self::UNCONFIRMED => 'Unconfirmed',
            self::ACTIVE => 'Active',
            self::SUSPENDED => 'Suspended',
            self::ARCHIVED => 'Archived'
        ];
    }

}
