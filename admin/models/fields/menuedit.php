<?php
/**
 * @package     Joomla.Administrator
 * @subpackage  com_pmenu
 *
 * @copyright   Copyright (C) 2005 - 2013 Open Source Matters, Inc. All rights reserved.
 * @license     GNU General Public License version 2 or later; see LICENSE.txt
 */

defined('JPATH_BASE') or die;

JFormHelper::loadFieldClass('list');

/**
 * Form Field class for the Joomla Framework.
 *
 * @package     Joomla.Administrator
 * @subpackage  com_pmenu
 * @since       1.6
 */
class JFormFieldMenuEdit extends JFormFieldList
{
	/**
	 * A flexible menu list that respects access controls
	 *
	 * @var        string
	 * @since   1.6
	 */
	public $type = 'MenuEdit';

	/**
	 * Method to get a list of menus that respects access controls and can be used for
	 * either menu assignment or parent menu assignment in edit screens.
	 * Use the parent element to indicate that the field will be used for assigning parent menus.
	 *
	 * @return  array  The field option objects.
	 * @since   1.6
	 */
	protected function getOptions()
	{
		$options = array();
		$published = $this->element['published'] ? $this->element['published'] : array(0, 1);
		$name = (string) $this->element['name'];

		// Let's get the id for the current item, either menu or content item.
		$jinput = JFactory::getApplication()->input;
		// Load the menu options for a given extension.

		// For menus the old menu is the menu id or 0 for new menu.
		if ($this->element['parent'] || $jinput->get('option') == 'com_pmenu')
		{
			$oldCat = $jinput->get('id', 0);
			$oldParent = $this->form->getValue($name, 0);
			$extension = $this->element['extension'] ? (string) $this->element['extension'] : (string) $jinput->get('extension', 'com_content');
		}
		else
			// For items the old menu is the menu they are in when opened or 0 if new.
		{
			$thisItem = $jinput->get('id', 0);
			$oldCat = $this->form->getValue($name, 0);
			$extension = $this->element['extension'] ? (string) $this->element['extension'] : (string) $jinput->get('option', 'com_content');
		}

		$db = JFactory::getDbo();
		$query = $db->getQuery(true)
			->select('a.id AS value, a.title AS text, a.level, a.published')
			->from('#__menus AS a')
			->join('LEFT', $db->quoteName('#__menus') . ' AS b ON a.lft > b.lft AND a.rgt < b.rgt');

		// Filter by the extension type
		if ($this->element['parent'] == true || $jinput->get('option') == 'com_pmenu')
		{
			$query->where('(a.extension = ' . $db->quote($extension) . ' OR a.parent_id = 0)');
		}
		else
		{
			$query->where('(a.extension = ' . $db->quote($extension) . ')');
		}
		// If parent isn't explicitly stated but we are in com_pmenu assume we want parents
		if ($oldCat != 0 && ($this->element['parent'] == true || $jinput->get('option') == 'com_pmenu'))
		{
			// Prevent parenting to children of this item.
			// To rearrange parents and children move the children up, not the parents down.
			$query->join('LEFT', $db->quoteName('#__menus') . ' AS p ON p.id = ' . (int) $oldCat)
				->where('NOT(a.lft >= p.lft AND a.rgt <= p.rgt)');

			$rowQuery = $db->getQuery(true);
			$rowQuery->select('a.id AS value, a.title AS text, a.level, a.parent_id')
				->from('#__menus AS a')
				->where('a.id = ' . (int) $oldCat);
			$db->setQuery($rowQuery);
			$row = $db->loadObject();
		}

		// Filter language
		if (!empty($this->element['language']))
		{

			$query->where('a.language = ' . $db->quote($this->element['language']));
		}

		// Filter on the published state

		if (is_numeric($published))
		{
			$query->where('a.published = ' . (int) $published);
		}
		elseif (is_array($published))
		{
			JArrayHelper::toInteger($published);
			$query->where('a.published IN (' . implode(',', $published) . ')');
		}

		$query->group('a.id, a.title, a.level, a.lft, a.rgt, a.extension, a.parent_id, a.published')
			->order('a.lft ASC');

		// Get the options.
		$db->setQuery($query);

		try
		{
			$options = $db->loadObjectList();
		}
		catch (RuntimeException $e)
		{
			JError::raiseWarning(500, $e->getMessage);
		}

		// Pad the option text with spaces using depth level as a multiplier.
		for ($i = 0, $n = count($options); $i < $n; $i++)
		{
			// Translate ROOT
			if ($this->element['parent'] == true || $jinput->get('option') == 'com_pmenu')
			{
				if ($options[$i]->level == 0)
				{
					$options[$i]->text = JText::_('JGLOBAL_ROOT_PARENT');
				}
			}
			if ($options[$i]->published == 1)
			{
				$options[$i]->text = str_repeat('- ', $options[$i]->level) . $options[$i]->text;
			}
			else
			{
				$options[$i]->text = str_repeat('- ', $options[$i]->level) . '[' . $options[$i]->text . ']';
			}
		}

		// Get the current user object.
		$user = JFactory::getUser();

		// For new items we want a list of menus you are allowed to create in.
		if ($oldCat == 0)
		{
			foreach ($options as $i => $option)
			{
				// To take save or create in a menu you need to have create rights for that menu
				// unless the item is already in that menu.
				// Unset the option if the user isn't authorised for it. In this field assets are always menus.
				if ($user->authorise('core.create', $extension . '.menu.' . $option->value) != true)
				{
					unset($options[$i]);
				}
			}
		}
		// If you have an existing menu id things are more complex.
		else
		{
			// If you are only allowed to edit in this menu but not edit.state, you should not get any
			// option to change the menu parent for a menu or the menu for a content item,
			// but you should be able to save in that menu.
			foreach ($options as $i => $option)
			{
				if ($user->authorise('core.edit.state', $extension . '.menu.' . $oldCat) != true && !isset($oldParent))
				{
					if ($option->value != $oldCat)
					{
						unset($options[$i]);
					}
				}
				if ($user->authorise('core.edit.state', $extension . '.menu.' . $oldCat) != true
					&& (isset($oldParent))
					&& $option->value != $oldParent
				)
				{
					unset($options[$i]);
				}

				// However, if you can edit.state you can also move this to another menu for which you have
				// create permission and you should also still be able to save in the current menu.
				if (($user->authorise('core.create', $extension . '.menu.' . $option->value) != true)
					&& ($option->value != $oldCat && !isset($oldParent))
				)
				{
					{
						unset($options[$i]);
					}
				}
				if (($user->authorise('core.create', $extension . '.menu.' . $option->value) != true)
					&& (isset($oldParent))
					&& $option->value != $oldParent
				)
				{
					{
						unset($options[$i]);
					}
				}
			}
		}
		if (($this->element['parent'] == true || $jinput->get('option') == 'com_pmenu')
			&& (isset($row) && !isset($options[0]))
			&& isset($this->element['show_root'])
		)
		{
			if ($row->parent_id == '1')
			{
				$parent = new stdClass;
				$parent->text = JText::_('JGLOBAL_ROOT_PARENT');
				array_unshift($options, $parent);
			}
			array_unshift($options, JHtml::_('select.option', '0', JText::_('JGLOBAL_ROOT')));
		}

		// Merge any additional options in the XML definition.
		$options = array_merge(parent::getOptions(), $options);

		return $options;
	}
}
