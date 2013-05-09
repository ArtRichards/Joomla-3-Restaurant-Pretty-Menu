<?php // No direct access

defined( '_JEXEC' ) or die( 'Restricted access' );

//load classes
JLoader::registerPrefix('PMenu', JPATH_COMPONENT_ADMINISTRATOR);

//Load plugins
JPluginHelper::importPlugin('pmenu');
 
//application
$app = JFactory::getApplication();


//# from categories.php
                //$input = $app->input; 
                //if (!JFactory::getUser()->authorise('core.manage', $input->get('extension')))
                //{
                //	return JError::raiseWarning(404, JText::_('JERROR_ALERTNOAUTHOR'));
                //}
                //
                //# Helper
                //JLoader::register('JHtmlCategoriesAdministrator', JPATH_ADMINISTRATOR . '/components/com_categories/helpers/html/categoriesadministrator.php');


// Require specific controller if requested
$controller = $app->input->get('controller','display');

// Create the controller
$classname  = 'PMenuControllers'.ucwords($controller);
$controller = new $classname();
 
// Perform the Request task
$controller->execute();