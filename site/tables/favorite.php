<?php defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
class TableReview extends JTable
{                      
  /**
  * Constructor
  *
  * @param object Database connector object
  */
  function __construct( &$db ) {
    parent::__construct('#__pmenu_favorites', 'favorite_id', $db);
  }
}