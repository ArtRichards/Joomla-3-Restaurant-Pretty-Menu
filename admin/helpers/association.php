<?php
/**
 * @package     Joomla.Site
 * @subpackage  com_pmenu
 *
 * @copyright   Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

JLoader::register('PMenuHelper', JPATH_ADMINISTRATOR . '/components/com_pmenu/helpers/menus.php');

/**
 * Menu Component Association Helper
 *
 * @package     Joomla.Site
 * @subpackage  com_pmenu
 * @since       3.0
 */
abstract class PMenuHelperAssociation
{
	public static $menu_association = true;

	/**
	 * Method to get the associations for a given menu
	 *
	 * @param   integer  $id         Id of the item
	 * @param   string   $extension  Name of the component
	 *
	 * @return  array   Array of associations for the component menus
	 *
	 * @since  3.0
	 */

	public static function getMenuAssociations($id = 0, $extension = 'com_content')
	{
		$return = array();

		if ($id)
		{
			// Load route helper
			jimport('helper.route', JPATH_COMPONENT_SITE);
			$helperClassname = ucfirst(substr($extension, 4)) . 'HelperRoute';

			$associations = PMenuHelper::getAssociations($id, $extension);
			foreach ($associations as $tag => $item)
			{
				if (class_exists($helperClassname) && is_callable(array($helperClassname, 'getMenuRoute')))
				{
					$return[$tag] = $helperClassname::getMenuRoute($item, $tag);
				}
				else
				{
					$return[$tag] = 'index.php?option='.$extension.'&view=menu&id='.$item;
				}
			}
		}

		return $return;
	}
}
