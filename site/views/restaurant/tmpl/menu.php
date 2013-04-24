
<style>
 
a {
    text-decoration:underline;
    color:#00F;
    cursor:pointer;
}
 
.controls div, .controls div input {
    float:left;   
    margin-right: 10px;
}
 
#executeLink {
    clear:both;
    margin-top:20px;
}
 
</style>
 

<!--<h2 class="page-header"><?php echo JText::_('COM_PMENU_MENUS'); ?></h2>
<div class="row-fluid">
    <h2><?php echo $this->restaurant->name; ?></h2>
    <h2><?php echo $this->restaurant->info_object; ?></h2>
    <?php
//    $val = "Inside Restaurant Menu Tmpl -- This";               //### DEBUG
//    $obj = $this;              //### DEBUG
//    file_put_contents("/home/txdevnet/jmlog_pmenu", PHP_EOL . "--" . PHP_EOL . time() . PHP_EOL . $val . PHP_EOL . "~~" . PHP_EOL . var_export($obj, true), FILE_APPEND);  //### DEBUG
//
//    for ($i = 0, $n = count($this->restaurant->menus); $i < $n; $i++)
//    {
//
//        //check the type of item here, and append it to the parent item if necessary
//        //then render the items as a unit in sorted order
//        
//        $val = "Inside Restaurant Menu Tmpl -- A Menu, a _menuView: ";               //### DEBUG
//        $obj = array($this->restaurant->menus[$i], $this->_menuView);              //### DEBUG
//        file_put_contents("/home/txdevnet/jmlog_pmenu", PHP_EOL . "--" . PHP_EOL . time() . PHP_EOL . $val . PHP_EOL . "~~" . PHP_EOL . var_export($obj, true), FILE_APPEND);  //### DEBUG
//
//        $this->_menuView->menu = $this->restaurant->menus[$i];
//        echo $this->_menuView->render();
//    }
    ?>
</div>-->
<!--
            <a rel="{handler: 'iframe', size: {x: 800, y: 500}}" onclick="IeCursorFix(); return false;" href="http://txdev.net/sljml/administrator/index.php?option=com_media&amp;view=images&amp;tmpl=component&amp;e_name=jform_articletext&amp;asset=com_content&amp;author=" title="**Image**" class="modal-button btn"><i class="icon-picture"></i> **Image**</a>-->


<!--            <a title="**Image**" class="modal-button btn"><i class="icon-picture"></i> **Image**</a>-->
            
            
    <!-- Main sheepIt Form -->
    <label>Menus</label>
    
    
    <div id="restaurant_menus">
    
        <!-- Form template-->
        <div id="restaurant_menus_template">
            <label for="restaurant_menus_#index#_menu">Menu Name <span id="restaurant_menus_label"></span></label>
            <input id="restaurant_menus_#index#_menu" name="restaurant[menus][#index#][menu]" size="50" maxlength="100" type="text">
            <a id="restaurant_menus_remove_current"><img src="images/cross.png" width="16" border="0" height="16"></a>

            
            <!-- Embeded sheepIt Form -->
            <div style="margin-left:50px; overflow:hidden;">
                <label>Menu Items</label>
                
                <div id="restaurant_menus_#index#_items">
                
                    <!-- Nested form template-->
                    <div id="restaurant_menus_#index#_items_template">
                        <label for="restaurant_menus_#index#_items_#index_items#_item">Item Name <span id="restaurant_menus_#index#_items_label"></span></label>
                        <input id="restaurant_menus_#index#_items_#index_items#_item" name="restaurant[menus][#index#][items][#index_items#][item]" size="15" maxlength="10" type="text">
                        <a id="restaurant_menus_#index#_items_remove_current"><img src="images/cross.png" width="16" border="0" height="16"></a>
                    </div>
                    <!-- /Nested form template-->
                    
                    <!-- No forms template -->
                    <div id="restaurant_menus_#index#_items_noforms_template">No Items</div>
                    <!-- /No forms template-->
                    
                    <!-- Controls -->
                    <div id="restaurant_menus_#index#_items_controls" class="controls">
                        <div id="restaurant_menus_#index#_items_add"><a><span>Add item</span></a></div>
                        <div id="restaurant_menus_#index#_items_remove_last"><a><span>Remove</span></a></div>
                        <div id="restaurant_menus_#index#_items_remove_all"><a><span>Remove all</span></a></div>
                        <div id="restaurant_menus_#index#_items_add_n">
                            <input id="restaurant_menus_#index#_items_add_n_input" size="4" type="text">
                            <div id="restaurant_menus_#index#_items_add_n_button"><a><span>Add</span></a></div>
                        </div>
                    </div>
                    <!-- /Controls -->
                    
                </div>
                
            </div>
            <!-- /Embeded sheepIt Form -->
            
        </div>
        <!-- /Form template -->
        
        
        <!-- Pre-generated form -->
        <div id="pregenerated_form_1">
            <label for="restaurant_menus_#index#_menu">Address <span id="restaurant_menus_label"></span></label>
            <input id="restaurant_menus_#index#_menu" name="restaurant[menus][#index#][menu]" size="50" maxlength="100" type="text">
            <a id="restaurant_menus_remove_current"><img src="images/cross.png" width="16" border="0" height="16"></a>
            
            <!-- Embeded sheepIt Form -->
            <div style="margin-left:50px; overflow:hidden;">
                <label>Items</label>
                
                <div id="restaurant_menus_#index#_items">
                
                    <!-- Nested form template-->
                    <div id="restaurant_menus_#index#_items_template">
                        <label for="restaurant_menus_#index#_items_#index_items#_item">Item <span id="restaurant_menus_#index#_items_label"></span></label>
                        <input id="restaurant_menus_#index#_items_#index_items#_item" name="restaurant[menus][#index#][items][#index_items#][iteme]" size="15" maxlength="10" type="text">
                        <a id="restaurant_menus_#index#_items_remove_current"><img src="images/cross.png" width="16" border="0" height="16"></a>
                    </div>
                    <!-- /Nested form template-->
                    
                    <!-- No forms template -->
                    <div id="restaurant_menus_#index#_items_noforms_template">No items</div>
                    <!-- /No forms template-->
                    
                    <!-- Controls -->
                    <div id="restaurant_menus_#index#_items_controls" class="controls">
                        <div id="restaurant_menus_#index#_items_add"><a><span>Add item</span></a></div>
                        <div id="restaurant_menus_#index#_items_remove_last"><a><span>Remove</span></a></div>
                        <div id="restaurant_menus_#index#_items_remove_all"><a><span>Remove all</span></a></div>
                        <div id="restaurant_menus_#index#_items_add_n">
                            <input id="restaurant_menus_#index#_items_add_n_input" size="4" type="text">
                            <div id="restaurant_menus_#index#_items_add_n_button"><a><span>Add</span></a></div>
                        </div>
                    </div>
                    <!-- /Controls -->
                    
                </div>
                
            </div>
            <!-- /Embeded sheepIt Form -->
            
        </div>
        <!-- /Pre-generated form -->
        
        
        
        <!-- No forms template -->
        <div id="restaurant_menus_noforms_template">No menues</div>
        <!-- /No forms template -->
        
        <!-- Controls -->
        <div id="restaurant_menus_controls" class="controls">
            <div id="restaurant_menus_add"><a><span>Add menu</span></a></div>
            <div id="restaurant_menus_remove_last"><a><span>Remove</span></a></div>
            <div id="restaurant_menus_remove_all"><a><span>Remove all</span></a></div>
            <div id="restaurant_menus_add_n">
                <input id="restaurant_menus_add_n_input" size="4" type="text">
                <div id="restaurant_menus_add_n_button"><a><span>Add</span></a></div>
            </div>
        </div>
        <!-- /Controls -->
        
    </div>
    <!-- /Main sheepIt Form -->

	<p id="executeLink"><a href="javascript:executeAPI();"><span>Execute API</span></a></p>



