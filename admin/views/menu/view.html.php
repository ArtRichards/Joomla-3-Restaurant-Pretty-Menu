<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_pmenu
 *
 * @copyright   Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('_JEXEC') or die;

/**
 * HTML View class for the PMenu component
 *
 * @package     Joomla.Administrator
 * @subpackage  com_pmenu
 * @since       1.6
 */
class PMenuViewMenu extends JViewLegacy
{
	protected $form;

	protected $item;

	protected $state;

	protected $assoc;

	/**
	 * Display the view
	 */
	public function display($tpl = null)
	{
		$this->form  = $this->get('Form');
		$this->item  = $this->get('Item');
		$this->state = $this->get('State');
		$this->canDo = PMenuHelper::getActions($this->state->get('menu.component'));
		$this->assoc = $this->get('Assoc');

		$input = JFactory::getApplication()->input;

		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
			JError::raiseError(500, implode("\n", $errors));
			return false;
		}

		$input->set('hidemainmenu', true);
		$this->addToolbar();
		parent::display($tpl);
	}

	/**
	 * Add the page title and toolbar.
	 *
	 * @since   1.6
	 */
	protected function addToolbar()
	{
		$input      = JFactory::getApplication()->input;
		$extension	= $input->get('extension');
		$user		= JFactory::getUser();
		$userId		= $user->get('id');

		$isNew		= ($this->item->id == 0);
		$checkedOut	= !($this->item->checked_out == 0 || $this->item->checked_out == $userId);

		// Avoid nonsense situation.
		if ($extension == 'com_pmenu')
		{
			return;
		}

		// The extension can be in the form com_foo.section
		$parts = explode('.', $extension);
		$component = $parts[0];
		$section = (count($parts) > 1) ? $parts[1] : null;

		// Need to load the menu language file as mod_menu hasn't been loaded yet.
		$lang = JFactory::getLanguage();
			$lang->load($component, JPATH_BASE, null, false, false)
		||	$lang->load($component, JPATH_ADMINISTRATOR.'/components/'.$component, null, false, false)
		||	$lang->load($component, JPATH_BASE, $lang->getDefault(), false, false)
		||	$lang->load($component, JPATH_ADMINISTRATOR.'/components/'.$component, $lang->getDefault(), false, false);

		// Load the menu helper.
		require_once JPATH_COMPONENT.'/helpers/menus.php';

		// Get the results for each action.
		$canDo = PMenuHelper::getActions($component, $this->item->id);

		// If a component menus title string is present, let's use it.
		if ($lang->hasKey($component_title_key = $component.($section?"_$section":'').'_CATEGORY_'.($isNew?'ADD':'EDIT').'_TITLE'))
		{
			$title = JText::_($component_title_key);
		}
		// Else if the component section string exits, let's use it
		elseif ($lang->hasKey($component_section_key = $component.($section?"_$section":'')))
		{
			$title = JText::sprintf('COM_PMENU_CATEGORY_'.($isNew?'ADD':'EDIT').'_TITLE', $this->escape(JText::_($component_section_key)));
		}
		// Else use the base title
		else {
			$title = JText::_('COM_PMENU_CATEGORY_BASE_'.($isNew?'ADD':'EDIT').'_TITLE');
		}

		// Load specific css component
		JHtml::_('stylesheet', $component.'/administrator/menus.css', array(), true);

		// Prepare the toolbar.
		JToolbarHelper::title($title, 'menu-'.($isNew?'add':'edit').' '.substr($component, 4).($section?"-$section":'').'-menu-'.($isNew?'add':'edit'));

		// For new records, check the create permission.
		if ($isNew && (count($user->getAuthorisedPMenu($component, 'core.create')) > 0))
		{
			JToolbarHelper::apply('menu.apply');
			JToolbarHelper::save('menu.save');
			JToolbarHelper::save2new('menu.save2new');
		}

		// If not checked out, can save the item.
		elseif (!$checkedOut && ($canDo->get('core.edit') || ($canDo->get('core.edit.own') && $this->item->created_user_id == $userId)))
		{
			JToolbarHelper::apply('menu.apply');
			JToolbarHelper::save('menu.save');
			if ($canDo->get('core.create'))
			{
				JToolbarHelper::save2new('menu.save2new');
			}
		}

		// If an existing item, can save to a copy.
		if (!$isNew && $canDo->get('core.create'))
		{
			JToolbarHelper::save2copy('menu.save2copy');
		}

		if (empty($this->item->id))
		{
			JToolbarHelper::cancel('menu.cancel');
		}
		else
		{
			JToolbarHelper::cancel('menu.cancel', 'JTOOLBAR_CLOSE');
		}

		JToolbarHelper::divider();

		// Compute the ref_key if it does exist in the component
		if (!$lang->hasKey($ref_key = strtoupper($component.($section?"_$section":'')).'_CATEGORY_'.($isNew?'ADD':'EDIT').'_HELP_KEY'))
		{
			$ref_key = 'JHELP_COMPONENTS_'.strtoupper(substr($component, 4).($section?"_$section":'')).'_CATEGORY_'.($isNew?'ADD':'EDIT');
		}

		// Get help for the menu/section view for the component by
		// -remotely searching in a language defined dedicated URL: *component*_HELP_URL
		// -locally  searching in a component help file if helpURL param exists in the component and is set to ''
		// -remotely searching in a component URL if helpURL param exists in the component and is NOT set to ''
		if ($lang->hasKey($lang_help_url = strtoupper($component).'_HELP_URL'))
		{
			$debug = $lang->setDebug(false);
			$url = JText::_($lang_help_url);
			$lang->setDebug($debug);
		}
		else
		{
			$url = null;
		}
		JToolbarHelper::help($ref_key, JComponentHelper::getParams($component)->exists('helpURL'), $url, $component);
	}
}