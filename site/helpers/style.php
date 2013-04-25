<?php
// no direct access
defined('_JEXEC') or die('Restricted access');

class PMenuHelpersStyle
{
	static function load()
	{
		$document = JFactory::getDocument();

		//stylesheets
		//$document->addStylesheet(JURI::base().'components/com_pmenu/assets/css/style.css');
                
                JHtml::_('jquery.framework');
                JHtml::_('bootstrap.framework');
            
		//javascripts
                //JHtml::_('jquery.ui');
		//$document->addScript(JURI::base().'components/com_pmenu/assets/js/jquery-1.4.1.min.js', 'text/javascript', false);
                //$document->addScript(JURI::base().'components/com_pmenu/assets/js/jquery.sheepItPlugin.js', 'text/javascript', false);
                $document->addScript(JURI::base().'components/com_pmenu/assets/js/pmenu.js', 'text/javascript', false);
		

                //JHtml::_('behavior.modal');
	}
}