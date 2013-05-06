<?php defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
class TableItem extends JTable
{                      
  /**
  * Constructor
  *
  * @param object Database connector object
  */
  function __construct( &$db ) {
    parent::__construct('#__pmenu_items', 'item_id', $db);
  }
}