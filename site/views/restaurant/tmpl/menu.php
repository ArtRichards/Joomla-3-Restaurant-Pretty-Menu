
 
<h1><a href="https://github.com/ArtRichards/com_prettymenu">com_prettymenu can be found at https://github.com/ArtRichards/com_prettymenu</a></h1>
<h2 class="page-header"><?php echo JText::_('COM_PMENU_MENUS'); ?></h2>
<div class="row-fluid">
    <h2><?php echo $this->restaurant->name; ?></h2>
    <h2><?php echo $this->restaurant->info_object; ?></h2>
    <?php
    $val = "Inside Restaurant Menu Tmpl -- This";               //### DEBUG
    $obj = $this;              //### DEBUG
    file_put_contents("/home/txdevnet/jmlog_pmenu", PHP_EOL . "--" . PHP_EOL . time() . PHP_EOL . $val . PHP_EOL . "~~" . PHP_EOL . var_export($obj, true), FILE_APPEND);  //### DEBUG

    for ($i = 0, $n = count($this->restaurant->menus); $i < $n; $i++)
    {

        //check the type of item here, and append it to the parent item if necessary
        //then render the items as a unit in sorted order
        
        $val = "Inside Restaurant Menu Tmpl -- A Menu, a _menuView: ";               //### DEBUG
        $obj = array($this->restaurant->menus[$i], $this->_menuView);              //### DEBUG
        file_put_contents("/home/txdevnet/jmlog_pmenu", PHP_EOL . "--" . PHP_EOL . time() . PHP_EOL . $val . PHP_EOL . "~~" . PHP_EOL . var_export($obj, true), FILE_APPEND);  //### DEBUG

        $this->_menuView->menu = $this->restaurant->menus[$i];
        echo $this->_menuView->render();
    }
    ?>
</div>
<!--
            <a rel="{handler: 'iframe', size: {x: 800, y: 500}}" onclick="IeCursorFix(); return false;" href="http://txdev.net/sljml/administrator/index.php?option=com_media&amp;view=images&amp;tmpl=component&amp;e_name=jform_articletext&amp;asset=com_content&amp;author=" title="**Image**" class="modal-button btn"><i class="icon-picture"></i> **Image**</a>-->


<!--            <a title="**Image**" class="modal-button btn"><i class="icon-picture"></i> **Image**</a>-->
            


