<?php defined( '_JEXEC' ) or die( 'Restricted access' ); 
 
class PMenuViewsRestaurantHtml extends JViewHtml
{
  function render()
  {
    $app = JFactory::getApplication();
    $layout = $this->getLayout();


    //retrieve task list from model
    $restaurantModel = $this->model;//new PMenuModelsRestaurant();
    
    //$this->_modalMessage = PMenuHelpersView::load('Profile','_message','phtml');
    
    $val= "Inside RestaurantHTML:  This, Model, Layout";                       //### DEBUG
    $obj = array($this, $restaurantModel, $layout);                                                        //### DEBUG
    file_put_contents("/home/txdevnet/jmlog_pmenu", PHP_EOL."--".PHP_EOL. time() . PHP_EOL . $val . PHP_EOL . "~~" . PHP_EOL . var_export($obj, true), FILE_APPEND);  //### DEBUG

    switch($layout) {

      case "menu":
      default:
        $this->restaurant = $restaurantModel->getItem();//listItems();
        $this->_menuView = PMenuHelpersView::load('menu','_entry','phtml');
        
      break;
    }
    
    //display
    return parent::render();
  } 
}