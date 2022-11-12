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
namespace wcf\system\box;

use wcf\data\user\UserProfileList;
use wcf\system\request\LinkHandler;
use wcf\system\WCF;

/**
 * User anniversaries box controller.
 */
class AnniversaryBoxController extends AbstractDatabaseObjectListBoxController
{
    /**
     * @inheritDoc
     */
    protected $conditionDefinition = 'com.uz.wcf.box.anniversary.condition';

    /**
     * @inheritDoc
     */
    public $defaultLimit = 5;

    public $maximumLimit = 100;

    /**
     * @inheritDoc
     */
    public $validSortFields = [
        'registrationDate',
        'username',
    ];

    /**
     * @inheritDoc
     */
    public $defaultSortField = 'registrationDate';

    /**
     * @inheritDoc
     */
    protected static $supportedPositions = [
        'sidebarLeft',
        'sidebarRight',
    ];

    /**
     * @inheritDoc
     */
    protected $sortFieldLanguageItemPrefix = 'wcf.acp.box.anniversary';

    /**
     * @inheritDoc
     */
    public function getLink()
    {
        if (MODULE_MEMBERS_LIST) {
            $parameters = '';
            if ($this->box->sortField) {
                $parameters = 'sortField=' . $this->box->sortField . '&sortOrder=' . $this->box->sortOrder;
            }

            return LinkHandler::getInstance()->getLink('MembersList', [], $parameters);
        }

        return '';
    }

    /**
     * @inheritDoc
     */
    protected function getObjectList()
    {
        return new UserProfileList();
    }

    /**
     * @inheritDoc
     */
    protected function getTemplate()
    {
        return WCF::getTPL()->fetch('boxAnniversaryMembers', 'wcf', [
            'boxUserList' => $this->objectList,
            'boxSortField' => $this->sortField,
        ], true);
    }

    /**
     * @inheritDoc
     */
    public function hasContent()
    {
        if (!WCF::getSession()->getPermission('user.profile.canViewUserAnniversaries')) {
            return false;
        }

        return parent::hasContent();
    }

    /**
     * @inheritDoc
     */
    public function hasLink()
    {
        return MODULE_MEMBERS_LIST == 1;
    }
}
