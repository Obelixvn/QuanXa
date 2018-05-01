<?php
include "DB_POS.php";
include "global.php";

if(isset($_GET["tableID"])){
    $tableID = $_GET["tableID"];
}
if(isset($_GET["tableTime"])){
    $tableTime = $_GET["tableTime"];
}
if(isset($_GET["defferTime"])){
    
    $date = new DateTime($_GET["defferTime"]);
    $date_0 = $date->format('Y-m-d');
    $date_1 = $date->modify(' +1 day ')->format('Y-m-d'); 
}else{

    $newDate = new Datetime();
    $date_0 = $newDate->format('Y-m-d');
    
    $date_1 = $newDate->modify(' +1 day ')->format('Y-m-d'); 
}

$orderUpd = 0;
$itemUpd = 0;
$count = count($tableID);
$conn = DB_POS_connect();
for ($i=0; $i < $count; $i++) { 

    $sql = "UPDATE OrderList  SET Note = 'Paid_in_Full' WHERE TableID = ".$tableID[$i]." AND OpenDateTime ='".trim($tableTime[$i])."'";
    $sql_item = "UPDATE OrderItems SET Note = 'Paid_in_Full'  WHERE TableID = ".$tableID[$i]." AND OpenDateTime ='".trim($tableTime[$i])."'";
    
    $resul_item= sqlsrv_query($conn, $sql_item);

    if ($resul_item == FALSE) {
        echo "Order:".$orderUpd;
        echo "Item:".$orderUpd;
        die( print_r( sqlsrv_errors(), true));
    }else{

        $itemUpd += sqlsrv_rows_affected($resul_item);
    }
    $result= sqlsrv_query($conn, $sql);
    if ($result == FALSE) {
        echo "Order:".$orderUpd;
        echo "Item:".$orderUpd;
        die( print_r( sqlsrv_errors(), true));
    }else{
        $orderUpd += sqlsrv_rows_affected($result);
    }
    
}
echo "All done: Order: ".$orderUpd." - Items: ".$itemUpd;
include "display_TM_Paid_in_Full.php";
?>

