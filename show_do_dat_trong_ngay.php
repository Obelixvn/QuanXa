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
        include "show_listDatDo.php";
    } 
 ?>           
 
<div id ="tb_datDo_cat_<?php echo $supplier; ?>">
</div>
   