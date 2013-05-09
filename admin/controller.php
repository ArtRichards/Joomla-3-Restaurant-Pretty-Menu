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
class PMenuController extends JControllerLegacy
{
	/**
	 * @var		string	The extension for which the menus apply.
	 * @since   1.6
	 */
	protected $extension;

	/**
	 * Constructor.
	 *
	 * @param   array An optional associative array of configuration settings.
	 * @see     JController
	 * @since   1.6
	 */
	public function __construct($config = array())
	{
		parent::__construct($config);

		// Guess the JText message prefix. Defaults to the option.
		if (empty($this->extension))
		{
			$this->extension = $this->input->get('extension', 'com_content');
		}
	}

	/**
	 * Method to display a view.
	 *
	 * @param   boolean			If true, the view output will be cached
	 * @param   array  An array of safe url parameters and their variable types, for valid values see {@link JFilterInput::clean()}.
	 *
	 * @return  JController		This object to support chaining.
	 * @since   1.5
	 */
	public function display($cachable = false, $urlparams = false)
	{
		// Get the document object.
		$document = JFactory::getDocument();

		// Set the default view name and format from the Request.
		$vName   = $this->input->get('view', 'menus');
		$vFormat = $document->getType();
		$lName   = $this->input->get('layout', 'default');
		$id      = $this->input->getInt('id');

		// Check for edit form.
		if ($vName == 'menu' && $lName == 'edit' && !$this->checkEditId('com_pmenu.edit.menu', $id))
		{
			// Somehow the person just went to the form - we don't allow that.
			$this->setError(JText::sprintf('JLIB_APPLICATION_ERROR_UNHELD_ID', $id));
			$this->setMessage($this->getError(), 'error');
			$this->setRedirect(JRoute::_('index.php?option=com_pmenu&view=menus&extension='.$this->extension, false));

			return false;
		}

		// Get and render the view.
		if ($view = $this->getView($vName, $vFormat))
		{
			// Get the model for the view.
			$model = $this->getModel($vName, 'PMenuModel', array('name' => $vName . '.' . substr($this->extension, 4)));

			// Push the model into the view (as default).
			$view->setModel($model, true);
			$view->setLayout($lName);

			// Push document object into the view.
			$view->document = $document;

			// Load the submenu.
			require_once JPATH_COMPONENT.'/helpers/menus.php';

			PMenuHelper::addSubmenu($model->getState('filter.extension'));
			$view->display();
		}

		return $this;
	}
}
