<?php

include "DB_functions_NN.php";

if (isset($_GET["name"])){
    $name = $_GET["name"];
}
else {
    echo "Khong du du lieu";
    exit;
}
if (isset($_GET["sup"])){
    $sup = $_GET["sup"];
}
else {
    echo "Khong du du lieu";
    exit;
}

$sql = "Select unit,id_item from tb_items where name = '".$name."' and supplier = '".$sup."'";
$result = DB_run_query($sql);

if ($result->num_rows > 0){
    
    $row = $result->fetch_assoc();
    $unit = $row["unit"];
    $id = $row["id_item"];

}else{
    echo "NULL,NULL";
}

$sql = "Select price from tb_purchase where item_id = ".$id." ORDER BY date DESC limit 1";

$result = DB_run_query($sql);
if ($result->num_rows > 0){
    
    $row = $result->fetch_assoc();
    $price = $row["price"];

}else{
    $price = "NULL";
}
echo $unit.",".$price;
?>
