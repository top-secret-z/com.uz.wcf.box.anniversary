<?php
namespace wcf\system\template\plugin;
use wcf\system\template\TemplateEngine;

/**
 * Template modifier plugin which calculates the years since registration.
 * 
 * Usage:
 *	{$timestamp|anniversary}
 * 
 * @author		2017-2022 Zaydowicz.de
 * @license		GNU Lesser General Public License <http://opensource.org/licenses/lgpl-license.php>
 * @package		com.uz.wcf.box.anniversary
 */
class AnniversaryModifierTemplatePlugin implements IModifierTemplatePlugin {
	/**
	 * @inheritDoc
	 */
	public function execute($tagArgs, TemplateEngine $tplObj) {
		return date('Y', TIME_NOW) - date('Y', $tagArgs[0]);
	}
}