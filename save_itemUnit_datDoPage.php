<?php
include "functions_NN.php";

$purchase_id = $_POST["purchase_id"];
$unit = $_POST["unit"];
$item_id = $_POST["item_id"];

if ($unit == ''){
    $sql = "
        UPDATE `NN`.`tb_purchase`
        SET
        `item_id` = '".$item_id."'
        WHERE `purchase_id` = ".$purchase_id;

}else{
    $sql = "
        UPDATE `NN`.`tb_items`
        SET
        `unit` = '".$unit."'
        WHERE `id_item` = ".$item_id;

}
$result = DB_run_query($sql);
if ($result){
    echo "<i>Updated roi</i>";
}
 ?>