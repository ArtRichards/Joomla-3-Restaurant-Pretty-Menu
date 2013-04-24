<?php // no direct access

defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
class PMenuModelsRestaurant extends PMenuModelsDefault
{

  //Define class level variables
  var $_restaurant_id = null;
  var $_user_id     = null;
  var $_published   = 1;

  function __construct()
  {
    parent::__construct();

    $app = JFactory::getApplication();
    $this->_restaurant_id = $app->input->get('restaurant_id',null);
    $this->_user_id = $app->input->get('user_id',JFactory::getUser()->id);
  }

 function getItem() 
  {
    $restaurant = parent::getItem(); 

    $menuModel = new PMenuModelsMenu();
    $menuModel->set('_user_id',$this->_user_id);  //### TODO: Favorites
    $restaurant->menus = $menuModel->listItems();

    return $restaurant;
  }

  function listItems()
  {
    $menuModel = new PMenuModelsMenu();
    $restaurants = parent::listItems();

    $n = count($restaurants);

    for($i=0;$i<$n;$i++)
    {
      $restaurant = $restaurants[$i];  //mutable type, will change original 
      
      $menuModel->_restaurant_id = $restaurant->id;
      $restaurant->menus = $menuModel->listItems();
    }

    return $restaurants;
  }

  protected function _buildQuery()
  {
    $db = JFactory::getDBO();
    $query = $db->getQuery(TRUE);

    $query->select("r.restaurant_id, r.name, r.info_object");
    $query->from("#__pmenu_restaurants as r");

    //### TODO:  Favorites
    //$query->select("u.username, u.name");   
    //$query->leftjoin("#__users as u ON u.id = r.user_id");

//    $query->select("p.*");
//    $query->leftjoin("#__user_profiles as p on p.user_id = u.id");

    return $query;
  }


  protected function _buildWhere(&$query)
  {

//    if(is_numeric($this->_user_id)) 
//    {
//      $query->where('r.user_id = ' . (int) $this->_user_id);
//    }

    if(is_numeric($this->_restaurant_id)) 
    {
      $query->where('r.restaurant_id = ' . (int) $this->_restaurant_id);
    }

    //$query->where('r.begin_publish < DATE_SUB(CURRENT_TIMESTAMP, INTERVAL 1 DAY)' );
    //$query->where('r.end_publish > DATE_ADD(CURRENT_TIMESTAMP, INTERVAL 1 DAY)' );
    
    $query->where('r.published = '. (int) $this->_published);

    return $query;
  }
   
}