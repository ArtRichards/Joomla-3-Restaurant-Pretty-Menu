<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_pmenu
 *
 * @copyright   Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

$input = JFactory::getApplication()->input;

if (!JFactory::getUser()->authorise('core.manage', $input->get('extension')))
{
	return JError::raiseWarning(404, JText::_('JERROR_ALERTNOAUTHOR'));
}

JLoader::register('JHtmlPMenuAdministrator', JPATH_ADMINISTRATOR . '/components/com_pmenu/helpers/html/menusadministrator.php');

$task = $input->get('task');

$controller	= JControllerLegacy::getInstance('PMenu');
$controller->execute($input->get('task'));
$controller->redirect();
