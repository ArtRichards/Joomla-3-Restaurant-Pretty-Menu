<?php defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
class TableMenu extends JTable
{                      
  /**
  * Constructor
  *
  * @param object Database connector object
  */
  function __construct( &$db ) {
    parent::__construct('#__pmenu_menus', 'menu_id', $db);
  }
}