<?php

// no direct access
defined( '_JEXEC' ) or die( 'Restricted access' ); 

//Display partial views
class PMenuViewsMenuPhtml extends JViewHTML
{

    function render()
    {    
        
            $val= "Inside MenuPHTML -- This";               //### DEBUG
            $obj = $this;              //### DEBUG
            file_put_contents("/home/txdevnet/jmlog_pmenu", PHP_EOL."--".PHP_EOL. time() . PHP_EOL . $val . PHP_EOL . "~~" . PHP_EOL . var_export($obj, true), FILE_APPEND);  //### DEBUG

    	return parent::render();
        
 	}
}