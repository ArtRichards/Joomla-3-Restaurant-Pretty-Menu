<?php // No direct access

defined( '_JEXEC' ) or die( 'Restricted access' );

//load classes
JLoader::registerPrefix('PMenu', JPATH_COMPONENT_ADMINISTRATOR);

//Load plugins
JPluginHelper::importPlugin('pmenu');
 
//application
$app = JFactory::getApplication();
 
// Require specific controller if requested
$controller = $app->input->get('controller','display');

// Create the controller
$classname  = 'PMenuControllers'.ucwords($controller);
$controller = new $classname();
 
// Perform the Request task
$controller->execute();