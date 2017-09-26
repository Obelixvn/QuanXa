<?php 
include "functions_NN.php";
$supplier = $_GET["supplier"];
$Ngay_dat_do = $_GET["ngay_dat_do"];
$tongtien ='';

?>


    
<?php


$sql = "
            SELECT name,price,quality,cost,unit From tb_purchase join tb_items on tb_purchase.item_id = tb_items.id_item
            Where supplier = '".$supplier."'
            and date = '".$Ngay_dat_do."'
            
    
    ";
    
    $result = DB_run_query($sql);
    if ($result->num_rows > 0){

?>
<table class = "tb_datDoPage">
    <tbody >
        
    <tr>
        <th>Ten Item</th>
        <th class = "w25">Unit</th>
        <th class = "w10">Quality</th>
        <th class = "w10">Gia</th>
        <th class = "w10">Tien</th>
    </tr>
<?php
            $tongtien = 0;
            while($row = $result->fetch_assoc()) {
                $tongtien += $row["cost"]; 
                ?>
                </tr>
        
                    <td class = "datDo_ten"><?php echo ($row["name"])?></td>
                    <td class = "datDo_unit"><?php echo ("[".$row["unit"]."]") ;?></td>
                    <td class = "datDo_quality"><?php echo ($row["quality"]) ;?></td>
                    <td class = "datDo_gia"><?php echo ($row["price"]) ;?></td>
                    <td class = "datDo_tien"><?php echo ($row["cost"]) ;?></td>
                </tr>
                <?php
            }
    

?>
    <tr>
        <td class = "tong_tien" colspan ="4">Tong Tien:</td>
        <td class= "sum_tong"><?php echo $tongtien; ?></td>    
    <tr> 
<?php } ?>           
 </tbody>
</table>
<div id ="tb_datDo_cat_<?php echo $supplier; ?>">
</div>
   