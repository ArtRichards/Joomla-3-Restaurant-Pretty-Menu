<?php

// no direct access

defined('_JEXEC') or die('Restricted access');

class PMenuModelsMenu extends PMenuModelsDefault {

    /**
     * Protected fields
     * */
    var $_menu_id = null;
    var $_user_id = null;  //for favorites //### TODO:  Favorites
    var $_restaurant_id = null;
    var $_pagination = null;
    var $_total = null;
    var $_published = 1;
    var $_favorites = FALSE;

    function __construct() {
        parent::__construct();
//        
//        $app = JFactory::getApplication();
//        $this->_restaurant_id = $app->input->get('id', null);
//        $this->_user_id = $app->input->get('user_id',JFactory::getUser()->id);
        

    }

    /**
     * Builds the query to be used by the menu model
     * @return   object  Query object
     *
     *
     */
    protected function _buildQuery() {
        $db = JFactory::getDBO();
        $query = $db->getQuery(TRUE);

        $query->select('m.menu_id, m.restaurant_id, m.begin_publish, m.end_publish, m.published'); //m.parent_id, m.type, m.text, m.price, m.info, 
        $query->from('#__pmenu_menus as m');

        $query->select('i.item_id, i.menu_id as item_menu_id, i.parent_id, i.type, i.text, i.price, i.info_object as json_object, 
                    i.begin_publish, i.end_publish, i.published');
        $query->join('INNER', '#__pmenu_items as i on i.menu_id = m.menu_id');
        
        $val= "Inside ModelsMenu _buildQuery - this, query";               //### DEBUG
        $obj = array($this, $query->__toString());              //### DEBUG
        file_put_contents("/home/txdevnet/jmlog_pmenu", PHP_EOL."--".PHP_EOL. time() . PHP_EOL . $val . PHP_EOL . "~~" . PHP_EOL . var_export($obj, true), FILE_APPEND);  //### DEBUG

        
        //we want our model to represent a menu item which 
        
        
        return $query;
    }
    

    /**
     * Builds the filter for the query
     * @param    object  Query object
     * @return   object  Query object
     *
     */
    protected function _buildWhere(&$query) {
        
        if (is_numeric($this->_menu_id)) {
            $query->where('m.menu_id = ' . (int) $this->_menu_id);
            //$query->where('item_menu_id = ' . (int) $this->_menu_id);
        }

        if (is_numeric($this->_restaurant_id)) {
            $query->where('m.restaurant_id = ' . (int) $this->_restaurant_id);
        }
        //where is the escaping???  //### TODO:  SECURITY!  escape outputs?
        
        //LAZIEST TIME CHECK EVAR ### TODO: FIX TIMECHECK
//        $query->where('m.begin_publish < DATE_SUB(CURRENT_TIMESTAMP, INTERVAL 1 DAY)' );
//        $query->where('i.begin_publish < DATE_SUB(CURRENT_TIMESTAMP, INTERVAL 1 DAY)' );
//        $query->where('m.end_publish > DATE_ADD(CURRENT_TIMESTAMP, INTERVAL 1 DAY)' );
//        $query->where('i.end_publish > DATE_ADD(CURRENT_TIMESTAMP, INTERVAL 1 DAY)' );

        $query->where('m.published = ' . (int) $this->_published);
        $query->where('i.published = ' . (int) $this->_published);

        $val= "Inside ModelsMenu _buildWhere - this, query";               //### DEBUG
        $obj = array($this, $query->__toString());              //### DEBUG
        file_put_contents("/home/txdevnet/jmlog_pmenu", PHP_EOL."--".PHP_EOL. time() . PHP_EOL . $val . PHP_EOL . "~~" . PHP_EOL . var_export($obj, true), FILE_APPEND);  //### DEBUG
        
        return $query;
    }
    
        
    /**
     * Build a query, where clause and return an object
     *
     */
    public function getItem()
    {
        $db = JFactory::getDBO();

        $query = $this->_buildQuery();
        $this->_buildWhere($query);
        $db->setQuery($query);

        $item = $db->loadObject();
        
        //JSON Load here from field "json_object"
        $object = new JObject(json_decode(json_decode(json_encode($item->json_object))));  //### TODO: Security Check 
        foreach ($object->getProperties() as $k => $v)
        {
            $item->$k = $v;
        }
        
        return $item;
    }

    
  function listItems()
  {
    $menus = parent::listItems();

    $n = count($menus);

    for($i=0;$i<$n;$i++)
    {
        $menu = $menus[$i];  //mutable type, will change original 
      
        //JSON Load here from field "json_object"
        $object = new JObject(json_decode(json_decode(json_encode($menu->json_object))));  //### TODO: Security Check 
        foreach ($object->getProperties() as $k => $v)
        {
            $menu->$k = $v;
        }
      
    }

    return $menus;
  }
    

//    public function lend($data = null) {
//        $data = isset($data) ? $data : JRequest::get('post');
//
//        if (isset($data['lend']) && $data['lend'] == 1) {
//            $date = date("Y-m-d H:i:s");
//
//            $data['lent'] = 1;
//            $data['lent_date'] = $date;
//            $data['lent_uid'] = $data['borrower_id'];
//
//            $waitlistData = array('waitlist_id' => $data['waitlist_id'], 'fulfilled' => 1, 'fulfilled_time' => $date, 'table' => 'Waitlist');
//            $waitlistModel = new PMenuModelsWaitlist();
//            $waitlistModel->store($waitlistData);
//        } else {
//            $data['lent'] = 0;
//            $data['lent_date'] = NULL;
//            $data['lent_uid'] = NULL;
//        }
//
//        $row = parent::store($data);
//
//        return $row;
//    }

}