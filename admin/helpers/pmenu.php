<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_pmenu
 *
 * @copyright   Copyright (C) 2013 Art Richards.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/**
 * PMenu component helper.
 *
 * @package     Joomla.Administrator
 * @subpackage  com_pmenu
 */
class PMenuHelpersPMenu
{
	public static $extension = 'com_pmenu';

	/**
	 * @return  JObject
	 */
	public static function getActions()
	{
		$user	= JFactory::getUser();
		$result	= new JObject;

		$assetName = 'com_pmenu';
		$level = 'component';

		$actions = JAccess::getActions('com_pmenu', $level);

		foreach ($actions as $action)
		{
			$result->set($action->name,	$user->authorise($action->name, $assetName));
		}

		return $result;
	}
}