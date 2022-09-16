<?php
namespace wcf\system\condition\anniversary;
use wcf\data\DatabaseObjectList;
use wcf\data\user\UserList;
use wcf\system\condition\AbstractIntegerCondition;
use wcf\system\condition\IObjectListCondition;

/**
 * Condition implementation to include fuzziness.
 * 
 * @author		2017-2022 Zaydowicz.de
 * @license		GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package		com.uz.wcf.box.anniversary
 */
class AnniversaryFuzzyCondition extends AbstractIntegerCondition implements IObjectListCondition {
	/**
	 * @inheritDoc
	 */
	protected $fieldName = 'registrationDateFuzzy';
	
	/**
	 * @inheritDoc
	 */
	protected $label = 'wcf.acp.box.anniversary.condition.fuzzy';
	
	/**
	 * @inheritDoc
	 */
	protected $description = 'wcf.acp.box.anniversary.condition.fuzzy.description';
	
	/**
	 * @inheritDoc
	 */
	protected $minValue = -15;
	protected $maxValue = 15;
	protected $lessThan = 1;
	protected $greaterThan = -1;
	
	
	/**
	 * @inheritDoc
	 */
	protected function getIdentifier() {
		return 'fuzzy';
	}
	
	/**
	 * @inheritDoc
	 */
	public function getData() {
		$data = [];
		
		if ($this->lessThan !== null) {
			$data['lessThan'] = $this->lessThan;
		}
		else {
			$data['lessThan'] = 1;
		}
		if ($this->greaterThan !== null) {
			$data['greaterThan'] = $this->greaterThan;
		}
		else {
			$data['greaterThan'] = -1;
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
		
		$low = $high = date('m-d');
		
		if (isset($conditionData['greaterThan'])) {
			$minus = (string) ($conditionData['greaterThan'] + 1) . ' days';
			$low = date("m-d", strtotime($minus));
		}
		if (isset($conditionData['lessThan'])) {
			$plus = (string) ($conditionData['lessThan'] - 1) . ' days';
			$high = date("m-d", strtotime($plus));
		}
		
		$objectList->getConditionBuilder()->add("DATE_FORMAT(FROM_UNIXTIME(user_table.registrationDate), '%m-%d') >= ?", [$low]);
		$objectList->getConditionBuilder()->add("DATE_FORMAT(FROM_UNIXTIME(user_table.registrationDate), '%m-%d') <= ?", [$high]);
	}
}
