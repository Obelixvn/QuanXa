<table class = "tb_datDoPage ">
<?php
    include 'functions_NN.php';
    $date= $_GET["Date"];
    $item_q = $_GET["quality"];
    $item_name = $_GET["name"];
    $item_cost = $_GET["cost"];
    $supplier = $_GET["supplier"];
    $item_unit = array();
    $item_id = array();
    $purchase_id = array(); 
    $item_price = array();   
    for ($i=0; $i < count($item_name) ; $i++) { 
        $sql_item ="
                Select id_item,unit from tb_items
                Where   name = '".$item_name[$i]."' and
                        supplier = '".$supplier."'
                Order by id_item        
        ";
        $item_price[$i] = $item_cost[$i]/$item_q[$i];
        $item_price[$i] = number_format((float)$item_price[$i], 2, '.', '');
        
        

        $result = DB_run_query($sql_item);
        if ($result->num_rows > 0){
            $num_item_exist = 0;
            while($row = $result->fetch_assoc()) {
                
                $item_id[$i][$num_item_exist] = $row["id_item"];
                
                $item_unit[$i][$num_item_exist] = $row["unit"];
                $num_item_exist +=1;
                
            }
            
            
        }
        else{
            $sql_item ="
                INSERT INTO `NN`.`tb_items`
                        (
                        `name`,
                        `supplier`)
                        VALUES
                        (
                        '".$item_name[$i]."',
                        '".$supplier."'
                        );
           
            ";
            $item_id[$i][0] = Get_insertIDQuery($sql_item);
            $item_unit[$i][0] = null;
            
        }
        $sql_purchase = "
            INSERT INTO `NN`.`tb_purchase`
                    (`item_id`,
                    `date`,
                    `quality`,
                    `status`,
                    `cost`,
                    `price`
                    )
                    VALUES
                    (
                    ".$item_id[$i][0].",
                    '".$date."',
                    ".$item_q[$i].",
                    0,
                    ".$item_cost[$i].",
                    ".$item_price[$i]."
                    )";
        $purchase_id[$i] = Get_insertIDQuery($sql_purchase);
        
    }
 
if (count($purchase_id) == 0){
    ?>
    <tr>
        <td colspan = "5"> Khong co du lieu
            </td>
    </tr>    
    <?php
}else{
    ?>
    
        <tr>
            <th>Ten Item</th>
            <th class = "w25">Unit</th>
            <th class = "w10">Quatity</th>
            <th class = "w10">Gia</th>
            <th class = "w10">Tien</th>
            <th></th>
        </tr>
    <?php
}
$done_button = true;
for ($i=0; $i < count($purchase_id) ; $i++) {?> 
<tr>
    <td class = "datDo_ten"><span class = "span_purchaseId" id = "span_purchanseId_<?php echo $purchase_id[$i]; ?>">[Updated]</span> 
        <?php 
            echo $item_name[$i];
        ?>
     </td>
     <td class = "datDo_unit">   
        <?php  
            $save_button = true;  
            if (count($item_unit[$i]) > 1){
                $done_button = false;
                echo "<select name = \"purchaseID_".$purchase_id[$i]."\">";
                for ($u=0; $u < count($item_unit[$i]); $u++) { 
                    echo "<option value = \"".$item_id[$i][$u]."\">".$item_unit[$i][$u]."</option>";
                }
                echo "</select>";
            }else if ($item_unit[$i][0] ==null){
                $done_button = false;
                echo "<input type = \"text\" name = \"purchaseID_".$purchase_id[$i]."\" >";
                echo "<input type = \"hidden\" name = \"itemID_".$purchase_id[$i]."\" value = \"".$item_id[$i][0]."\">";
            }else{
                $save_button = false;
                
                echo " [ ".$item_unit[$i][0]." ]";
            }
        ?>
    
    </td>
    <td class = "datDo_quality"><?php echo $item_q[$i]; ?></td>
    <td class = "datDo_gia"><?php echo $item_price[$i]; ?></td>
    <td class = "datDo_tien"><?php echo $item_cost[$i]; ?></td>
    <td>
        <?php 
            if ($save_button){
                echo "<button name =\"save_button_".$purchase_id[$i]."\" type = \"button\" onclick =\"save_itemUnit_datDoPage(".$purchase_id[$i].")\">Save</button>";
            }  
        ?>
    </td>
</tr>
 
<?php }?> 
</table>
<button type = "button" <?php if (!$done_button){echo("disabled");} ?> onclick = "hoan_thanh_them_do('<?php echo ($supplier); ?>')">Done</button> 