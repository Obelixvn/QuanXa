<?php 
    if (isset($_GET["cat"])){
        $cat = $_GET["cat"];
    }
    else {
        $cat = '';
    }
    $supplier = $_GET["supplier"]; 
    if ($cat == ''){
        $cat = $supplier;
    }
    include "functions_NN.php";
?>
<datalist id="items_list_<?php echo $cat; ?>"<>
<?php 
    
    $sql = "
            SELECT name,unit From tb_items
            Where supplier = '".$supplier."'
    ";
    
    
    $result = DB_run_query($sql);
    if ($result->num_rows > 0){

            while($row = $result->fetch_assoc()) {
                echo "<option onclick = \"test()\"value=\"".$row["name"]."\">".$row["unit"]."</option>";
            }
    }
    

?>
                
                
</datalist>

<div id = "<?php echo($cat); ?>_them_do">
<table id = "tb_datDo_<?php echo ($cat);?>"  class = "tb_them_do">
<tbody >
    <tr>    
        <th>Ten</th>
        <th>Unit</th>
        <th>So luong</th>
        <th>Price</th>
        <th>Tien</th>
        </tr>

    <tr>
        
        <td><input onblur = "item_selected_datDoPage(this)" class = "them_do_ten" list="items_list_<?php echo $cat; ?>" name="item_dat_do_<?php echo $cat; ?>">
            
        </td>
        <td></td>
        <td><input onblur = "item_quality_selected_datDoPage(this)" class = "them_do_q" type = "number"  min = "0" name ="q_item_<?php echo $cat; ?>"></td>
        <td></td>
        <td><input onblur = "item_cost_input_datDoPage(this)" class = "them_do_tien" type = "number"  min = "0" name ="cost_item_<?php echo $cat; ?>"></td>
        
    </tr>
    
       
    

</tbody>
</table>
<button type = "button" onclick = "them_item_datDo('<?php echo $cat;?>')">Them</button>
<button type = "button" onclick = "update_puchase('<?php echo $cat;?>')">Confirm</button>
<span class = "tongTien_datDo"><b>Tong tien: £</b><i id = "tongTien_<?php echo $cat;?>">0</i>    </span>
</div>

