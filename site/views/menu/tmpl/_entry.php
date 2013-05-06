ENTRY <?php echo "<BR>ITEM:". $this->menu->item_id; ?>

<?php 

//if item type is 1 item is entry, display normally
//else if item type is 0 item is description entry, 

        echo isset($this->menu->item->ALSO) ? "<BR>ALSOOOO:".$this->menu->item->ALSO : "<BR>No Also";
        foreach ($this->menu->item as $property => $value)
        {
            if (is_string($property)) 
                echo "<br><br>" . $property . "--" . $value;
        }
        