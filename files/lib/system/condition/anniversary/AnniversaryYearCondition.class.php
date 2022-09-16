<?php
namespace wcf\system\condition\anniversary;
use wcf\data\DatabaseObjectList;
use wcf\data\user\UserList;
use wcf\system\condition\AbstractIntegerCondition;
use wcf\system\condition\IObjectListCondition;

/**
 * Condition implementation to include years of membership.
 * 
 * @author		2017-2022 Zaydowicz.de
 * @license		GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package		com.uz.wcf.box.anniversary
 */
class AnniversaryYearCondition extends AbstractIntegerCondition implements IObjectListCondition {
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
	protected function getIdentifier() {
		return 'year';
	}
	
	/**
	 * @inheritDoc
	 */
	public function getData() {
		$data = [];
		
		if ($this->lessThan !== null) {
			$data['lessThan'] = $this->lessThan;
		}
		
		if ($this->greaterThan !== null) {
			$data['greaterThan'] = $this->greaterThan;
		}
		else {
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
	public function addObjectListCondition(DatabaseObjectList $objectList, array $conditionData) {
		if (!($objectList instanceof UserList)) {
			throw new \InvalidArgumentException("Object list is no instance of '".UserList::class."', instance of '".get_class($objectList)."' given.");
		}
		
		if (isset($conditionData['greaterThan'])) {
			$objectList->getConditionBuilder()->add("YEAR(FROM_UNIXTIME(registrationDate)) <= ?", [date('Y') - ($conditionData['greaterThan'] + 1)]);
		}
		
		if (isset($conditionData['lessThan'])) {
			$objectList->getConditionBuilder()->add("YEAR(FROM_UNIXTIME(registrationDate)) <= ?", [date('Y') - $conditionData['lessThan']]);
		}
	}
}
