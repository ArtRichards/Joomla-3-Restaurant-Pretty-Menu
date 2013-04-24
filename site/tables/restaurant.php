<?php defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
class TableRestaurant extends JTable
{                      
  /**
  * Constructor
  *
  * @param object Database connector object
  */
  function __construct( &$db ) {
    parent::__construct('#__pmenu_restaurants', 'restaurant_id', $db);
  }
}