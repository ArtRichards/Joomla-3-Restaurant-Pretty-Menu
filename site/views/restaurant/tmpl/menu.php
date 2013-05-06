<?php
//### DEBUG
$val = "Inside Restaurant Menu Tmpl -- This";               //### DEBUG
$obj = $this;              //### DEBUG
file_put_contents("/home/txdevnet/jmlog_pmenu", PHP_EOL . "--" . PHP_EOL . time() . PHP_EOL . $val . PHP_EOL . "~~" . PHP_EOL . var_export($obj, true), FILE_APPEND);  //### DEBUG
?>

<h1><a href="https://github.com/ArtRichards/Joomla-3-Restaurant-Pretty-Menu">com_pmenu can be found at https://github.com/ArtRichards/Joomla-3-Restaurant-Pretty-Menu</a></h1>
<h2 class="page-header"><?php echo JText::_('COM_PMENU_MENUS'); ?></h2>



<div class="row-fluid">
    <h2><?php echo $this->restaurant->name; ?></h2>
    <h2><?php echo $this->restaurant->info_object; ?></h2>

    <?
    //$this->restaurant->restaurant_id ###

    for ($i = 0, $n = count($this->restaurant->menus); $i < $n; $i++)
    {
                                        $val = "Inside Restaurant Menu Tmpl -- A Menu, a _menuView: ";               //### DEBUG
                                        $obj = array($this->restaurant->menus[$i], $this->_menuView);              //### DEBUG
                                        file_put_contents("/home/txdevnet/jmlog_pmenu", PHP_EOL . "--" . PHP_EOL . time() . PHP_EOL . $val . PHP_EOL . "~~" . PHP_EOL . var_export($obj, true), FILE_APPEND);  //### DEBUG

        $this->_menuView->menu = $this->restaurant->menus[$i];
        echo $this->_menuView->render();
    }
    ?>

</div>

