<?php // No direct access

defined( '_JEXEC' ) or die( 'Restricted access' );

//sessions
jimport( 'joomla.session.session' );
 
//load tables
JTable::addIncludePath(JPATH_COMPONENT.'/tables');

//load classes
JLoader::registerPrefix('PMenu', JPATH_COMPONENT);

//Load plugins
JPluginHelper::importPlugin('pmenu');
 
//Load styles and javascripts
PMenuHelpersStyle::load();

//application
$app = JFactory::getApplication();
 
// Require specific controller if requested
$controllername = $app->input->get('controller','default');

$val= "Inside PMenu - Controller";               //### DEBUG
$obj = $controllername;              //### DEBUG
file_put_contents("/home/txdevnet/jmlog_pmenu", PHP_EOL."--".PHP_EOL. time() . PHP_EOL . $val . PHP_EOL . "~~" . PHP_EOL . var_export($obj, true), FILE_APPEND);  //### DEBUG

// Create the controller
$classname  = 'PMenuControllers'.ucwords($controllername);
$controller = new $classname();
 
// Perform the Request task
$controller->execute();