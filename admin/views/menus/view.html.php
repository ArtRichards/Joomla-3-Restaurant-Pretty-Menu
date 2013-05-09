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
 * PMenu view class for the Menu package.
 *
 * @package     Joomla.Administrator
 * @subpackage  com_pmenu
 * @since       1.6
 */
class PMenuViewMenus extends JViewLegacy
{
	protected $items;

	protected $pagination;

	protected $state;

	protected $assoc;

	/**
	 * Display the view
	 */
	public function display($tpl = null)
	{
		$this->state		= $this->get('State');
		$this->items		= $this->get('Items');
		$this->pagination	= $this->get('Pagination');
		$this->assoc		= $this->get('Assoc');

		// Check for errors.
		if (count($errors = $this->get('Errors')))
		{
			JError::raiseError(500, implode("\n", $errors));
			return false;
		}

		// Preprocess the list of items to find ordering divisions.
		foreach ($this->items as &$item)
		{
			$this->ordering[$item->parent_id][] = $item->id;
		}

		// Levels filter.
		$options	= array();
		$options[]	= JHtml::_('select.option', '1', JText::_('J1'));
		$options[]	= JHtml::_('select.option', '2', JText::_('J2'));
		$options[]	= JHtml::_('select.option', '3', JText::_('J3'));
		$options[]	= JHtml::_('select.option', '4', JText::_('J4'));
		$options[]	= JHtml::_('select.option', '5', JText::_('J5'));
		$options[]	= JHtml::_('select.option', '6', JText::_('J6'));
		$options[]	= JHtml::_('select.option', '7', JText::_('J7'));
		$options[]	= JHtml::_('select.option', '8', JText::_('J8'));
		$options[]	= JHtml::_('select.option', '9', JText::_('J9'));
		$options[]	= JHtml::_('select.option', '10', JText::_('J10'));

		$this->f_levels = $options;

		$this->addToolbar();
		$this->sidebar = JHtmlSidebar::render();
		parent::display($tpl);
	}

	/**
	 * Add the page title and toolbar.
	 *
	 * @since   1.6
	 */
	protected function addToolbar()
	{
		$menuId	= $this->state->get('filter.menu_id');
		$component	= $this->state->get('filter.component');
		$section	= $this->state->get('filter.section');
		$canDo		= null;
		$user		= JFactory::getUser();

		// Get the toolbar object instance
		$bar = JToolBar::getInstance('toolbar');

		// Avoid nonsense situation.
		if ($component == 'com_pmenu')
		{
			return;
		}

		// Need to load the menu language file as mod_menu hasn't been loaded yet.
		$lang = JFactory::getLanguage();
			$lang->load($component, JPATH_BASE, null, false, false)
		||	$lang->load($component, JPATH_ADMINISTRATOR.'/components/'.$component, null, false, false)
		||	$lang->load($component, JPATH_BASE, $lang->getDefault(), false, false)
		||	$lang->load($component, JPATH_ADMINISTRATOR.'/components/'.$component, $lang->getDefault(), false, false);

		// Load the menu helper.
		require_once JPATH_COMPONENT.'/helpers/menus.php';

		// Get the results for each action.
		$canDo = PMenuHelper::getActions($component, $menuId);

		// If a component menus title string is present, let's use it.
		if ($lang->hasKey($component_title_key = strtoupper($component.($section?"_$section":'')).'_MENU_TITLE'))
		{
			$title = JText::_($component_title_key);
		}
		// Else if the component section string exits, let's use it
		elseif ($lang->hasKey($component_section_key = strtoupper($component.($section?"_$section":''))))
		{
			$title = JText::sprintf('COM_PMENU_MENU_TITLE', $this->escape(JText::_($component_section_key)));
		}
		// Else use the base title
		else
		{
			$title = JText::_('COM_PMENU_MENU_BASE_TITLE');
		}

		// Load specific css component
		JHtml::_('stylesheet', $component.'/administrator/menus.css', array(), true);

		// Prepare the toolbar.
		JToolbarHelper::title($title, 'menus '.substr($component, 4).($section?"-$section":'').'-menus');

		if ($canDo->get('core.create') || (count($user->getAuthorisedPMenu($component, 'core.create'))) > 0 )
		{
			JToolbarHelper::addNew('menu.add');
		}

		if ($canDo->get('core.edit') || $canDo->get('core.edit.own'))
		{
			JToolbarHelper::editList('menu.edit');
		}

		if ($canDo->get('core.edit.state'))
		{
			JToolbarHelper::publish('menus.publish', 'JTOOLBAR_PUBLISH', true);
			JToolbarHelper::unpublish('menus.unpublish', 'JTOOLBAR_UNPUBLISH', true);
			JToolbarHelper::archiveList('menus.archive');
		}

		if (JFactory::getUser()->authorise('core.admin'))
		{
			JToolbarHelper::checkin('menus.checkin');
		}

		if ($this->state->get('filter.published') == -2 && $canDo->get('core.delete', $component))
		{
			JToolbarHelper::deleteList('', 'menus.delete', 'JTOOLBAR_EMPTY_TRASH');
		}
		elseif ($canDo->get('core.edit.state'))
		{
			JToolbarHelper::trash('menus.trash');
		}

		// Add a batch button
		if ($canDo->get('core.edit'))
		{
			JHtml::_('bootstrap.modal', 'collapseModal');
			$title = JText::_('JTOOLBAR_BATCH');
			$dhtml = "<button data-toggle=\"modal\" data-target=\"#collapseModal\" class=\"btn btn-small\">
						<i class=\"icon-checkbox-partial\" title=\"$title\"></i>
						$title</button>";
			$bar->appendButton('Custom', $dhtml, 'batch');
		}

		if ($canDo->get('core.admin'))
		{
			JToolbarHelper::custom('menus.rebuild', 'refresh.png', 'refresh_f2.png', 'JTOOLBAR_REBUILD', false);
			JToolbarHelper::preferences($component);
		}

		// Compute the ref_key if it does exist in the component
		if (!$lang->hasKey($ref_key = strtoupper($component.($section?"_$section":'')).'_MENU_HELP_KEY'))
		{
			$ref_key = 'JHELP_COMPONENTS_'.strtoupper(substr($component, 4).($section?"_$section":'')).'_MENU';
		}

		// Get help for the menus view for the component by
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
		JToolbarHelper::help($ref_key, JComponentHelper::getParams($component)->exists('helpURL'), $url);

		JHtmlSidebar::setAction('index.php?option=com_pmenu&view=menus');

		JHtmlSidebar::addFilter(
			JText::_('JOPTION_SELECT_MAX_LEVELS'),
			'filter_level',
			JHtml::_('select.options', $this->f_levels, 'value', 'text', $this->state->get('filter.level'))
		);

		JHtmlSidebar::addFilter(
			JText::_('JOPTION_SELECT_PUBLISHED'),
			'filter_published',
			JHtml::_('select.options', JHtml::_('jgrid.publishedOptions'), 'value', 'text', $this->state->get('filter.published'), true)
		);

		JHtmlSidebar::addFilter(
			JText::_('JOPTION_SELECT_ACCESS'),
			'filter_access',
			JHtml::_('select.options', JHtml::_('access.assetgroups'), 'value', 'text', $this->state->get('filter.access'))
		);

		JHtmlSidebar::addFilter(
			JText::_('JOPTION_SELECT_LANGUAGE'),
			'filter_language',
			JHtml::_('select.options', JHtml::_('contentlanguage.existing', true, true), 'value', 'text', $this->state->get('filter.language'))
		);

		JHtmlSidebar::addFilter(
		'-' . JText::_('JSELECT') . ' ' . JText::_('JTAG') . '-',
		'filter_tag',
		JHtml::_('select.options', JHtml::_('tag.options', true, true), 'value', 'text', $this->state->get('filter.tag'))
		);

	}

	/**
	 * Returns an array of fields the table can be sorted by
	 *
	 * @return  array  Array containing the field name to sort by as the key and display text as value
	 *
	 * @since   3.0
	 */
	protected function getSortFields()
	{
		return array(
			'a.lft' => JText::_('JGRID_HEADING_ORDERING'),
			'a.state' => JText::_('JSTATUS'),
			'a.title' => JText::_('JGLOBAL_TITLE'),
			'a.access' => JText::_('JGRID_HEADING_ACCESS'),
			'language' => JText::_('JGRID_HEADING_LANGUAGE'),
			'a.id' => JText::_('JGRID_HEADING_ID')
		);
	}
}
