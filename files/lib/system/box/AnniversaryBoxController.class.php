<?php
namespace wcf\system\box;
use wcf\data\user\UserProfileList;
use wcf\system\box\AbstractDatabaseObjectListBoxController;
use wcf\system\request\LinkHandler;
use wcf\system\WCF;

/**
 * User anniversaries box controller.
 *
 * @author		2017-2022 Zaydowicz.de
 * @license		GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package		com.uz.wcf.box.anniversary
 */
class AnniversaryBoxController extends AbstractDatabaseObjectListBoxController {
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
			'username'
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
			'sidebarRight'
	];
	
	/**
	 * @inheritDoc
	 */
	protected $sortFieldLanguageItemPrefix = 'wcf.acp.box.anniversary';
	
	/**
	 * @inheritDoc
	 */
	public function getLink() {
		if (MODULE_MEMBERS_LIST) {
			$parameters = '';
			if ($this->box->sortField) {
				$parameters = 'sortField='.$this->box->sortField.'&sortOrder='.$this->box->sortOrder;
			}
			
			return LinkHandler::getInstance()->getLink('MembersList', [], $parameters);
		}
		
		return '';
	}
	
	/**
	 * @inheritDoc
	 */
	protected function getObjectList() {
		return new UserProfileList();
	}
	
	/**
	 * @inheritDoc
	 */
	protected function getTemplate() {
		return WCF::getTPL()->fetch('boxAnniversaryMembers', 'wcf', [
				'boxUserList' => $this->objectList,
				'boxSortField' => $this->sortField
		], true);
	}
	
	/**
	 * @inheritDoc
	 */
	public function hasContent() {
		if (!WCF::getSession()->getPermission('user.profile.canViewUserAnniversaries')) {
			return false;
		}
		
		return parent::hasContent();
	}
	
	/**
	 * @inheritDoc
	 */
	public function hasLink() {
		return MODULE_MEMBERS_LIST == 1;
	}
}
