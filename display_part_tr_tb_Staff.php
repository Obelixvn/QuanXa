<td>
    <input type="text" name="nV_<?php echo $no_NV; ?>" disabled value = "<?php echo $name ?>">
</td>
<td>
    <input class = "invisibale_text_1"type="number" name="nV_<?php echo $no_NV; ?>" disabled value = "<?php echo $rate ?>">
</td>
<td>
    
    <select disabled="disabled" name="nV_<?php echo $no_NV; ?>" id="">
        <Option value = "0" <?php if( $status == 0) {echo "selected" ;}?>>OFF</Option>
        <Option value = "1" <?php if( $status == 1) {echo "selected" ;}?> >ON</Option>
    </select>
    
</td>
<td>
    <button id = "edit_button_<?php echo $no_NV;?>" onclick = "edit_active_staff(<?php echo $no_NV;?>)">Edit</button>
    <button id = "save_button_<?php echo $no_NV;?>" onclick = "saveInfo_staff(<?php echo $no_NV;?>)" style = "display : none;" onclick = "save_staffInfo(<?php echo $no_NV;?>)">Save</button>
</td>