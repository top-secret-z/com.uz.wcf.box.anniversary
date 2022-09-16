<?php
namespace wcf\system\condition\anniversary;
use wcf\data\DatabaseObjectList;
use wcf\data\user\UserList;
use wcf\system\condition\AbstractCheckboxCondition;
use wcf\system\condition\IObjectListCondition;

/**
 * Condition implementation to exclude disabled users.
 * 
 * @author		2017-2022 Zaydowicz.de
 * @license		GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package		com.uz.wcf.box.anniversary
 */
class AnniversaryDisabledCondition extends AbstractCheckboxCondition implements IObjectListCondition {
		/**
		 * @inheritDoc
		 */
		protected $fieldName = 'activationCode';
		
		/**
		 * @inheritDoc
		 */
		protected $label = 'wcf.acp.box.anniversary.condition.disabled';
		
		/**
		 * @inheritDoc
		 */
		public function addObjectListCondition(DatabaseObjectList $objectList, array $conditionData) {
			if (!($objectList instanceof UserList)) {
				throw new \InvalidArgumentException("Object list is no instance of '".UserList::class."', instance of '".get_class($objectList)."' given.");
			}
			
			$objectList->getConditionBuilder()->add('user_table.activationCode = ?', [0]);
		}
	}
	