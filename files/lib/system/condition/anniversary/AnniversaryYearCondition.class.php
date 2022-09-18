<?php

/*
 * Copyright by Udo Zaydowicz.
 * Modified by SoftCreatR.dev.
 *
 * License: http://opensource.org/licenses/lgpl-license.php
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU Lesser General Public
 * License as published by the Free Software Foundation; either
 * version 3 of the License, or (at your option) any later version.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the GNU
 * Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public License
 * along with this program; if not, write to the Free Software Foundation,
 * Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 */
namespace wcf\system\condition\anniversary;

use InvalidArgumentException;
use wcf\data\DatabaseObjectList;
use wcf\data\user\UserList;
use wcf\system\condition\AbstractIntegerCondition;
use wcf\system\condition\IObjectListCondition;

/**
 * Condition implementation to include years of membership.
 */
class AnniversaryYearCondition extends AbstractIntegerCondition implements IObjectListCondition
{
    /**
     * @inheritDoc
     */
    protected $fieldName = 'registrationDateYear';

    /**
     * @inheritDoc
     */
    protected $label = 'wcf.acp.box.anniversary.condition.year';

    /**
     * @inheritDoc
     */
    protected $description = 'wcf.acp.box.anniversary.condition.year.description';

    /**
     * @inheritDoc
     */
    protected $minValue = 0;

    protected $greaterThan = 0;

    /**
     * @inheritDoc
     */
    protected function getIdentifier()
    {
        return 'year';
    }

    /**
     * @inheritDoc
     */
    public function getData()
    {
        $data = [];

        if ($this->lessThan !== null) {
            $data['lessThan'] = $this->lessThan;
        }

        if ($this->greaterThan !== null) {
            $data['greaterThan'] = $this->greaterThan;
        } else {
            $data['greaterThan'] = 0;
        }

        if (!empty($data)) {
            return $data;
        }

        return null;
    }

    /**
     * @inheritDoc
     */
    public function addObjectListCondition(DatabaseObjectList $objectList, array $conditionData)
    {
        if (!($objectList instanceof UserList)) {
            throw new InvalidArgumentException("Object list is no instance of '" . UserList::class . "', instance of '" . \get_class($objectList) . "' given.");
        }

        if (isset($conditionData['greaterThan'])) {
            $objectList->getConditionBuilder()->add("YEAR(FROM_UNIXTIME(registrationDate)) <= ?", [\date('Y') - ($conditionData['greaterThan'] + 1)]);
        }

        if (isset($conditionData['lessThan'])) {
            $objectList->getConditionBuilder()->add("YEAR(FROM_UNIXTIME(registrationDate)) <= ?", [\date('Y') - $conditionData['lessThan']]);
        }
    }
}
