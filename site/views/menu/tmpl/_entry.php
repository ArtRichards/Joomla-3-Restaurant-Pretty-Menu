ENTRY <?php echo $this->menu->menu_id; ?>

<?php 

//if item type is 1 item is entry, display normally
//else if item type is 0 item is description entry, 


?>

<br>

<tr>
  <td>
    <div class="media" id="menu-row-<?php echo $this->menu->menu_id; ?>">
      <div class="media-body">
        <h4 class="media-heading"><a href="<?php //open accordion ?>"><?php echo $this->menu->title; ?></a></h4>
        <p>TEST PROPERTY: <?php echo $this->menu->TESTPROPERTY; ?></p>
      </div>
    </div>
  </td>
 <td class="small">
    <?php if(isset($this->menu->waitlist_id) && $this->menu->waitlist_id > 0) { ?>
      <span class="label label-warning"><?php echo JText::_('COM_PMENU_REQUESTED'); ?></span>
    <?php } else { ?>
      <span class="label label-<?php echo $this->menu->lent ? 'warning' : 'success'; ?>"><?php echo $this->menu->lent ? JText::_('COM_PMENU_LENT') : JText::_('COM_PMENU_AVAILABLE'); ?></span>
    <?php } ?>
  </td>
  
</tr>
