<?php
include "DB_POS.php";
include "global.php";
$money_style = '%.2n';

$orderUpd =0;
$ItemsUpd = 0;


if(isset($_GET["date"])){
    
    $date = new DateTime($_GET["date"]);
    $date_0 = $date->format('Y-m-d');
    $date_1 = $date->modify(' +1 day ')->format('Y-m-d'); 
}else{

    $newDate = new Datetime();
    $date_0 = $newDate->format('Y-m-d');
    
    $date_1 = $newDate->modify(' +1 day ')->format('Y-m-d'); 
}
$sql = "SELECT count(*) as sLL FROM OrderList 
        WHERE TableID >=236 AND TableID <=245 
        AND OpenDateTime >= '".$date_0."' AND OpenDateTime <= '".$date_1."'";



$conn = DB_POS_connect();
$result= sqlsrv_query($conn, $sql);
if ($result == FALSE){
    
    die( print_r( sqlsrv_errors(), true));
}else{
    $row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
    $orderUpd =$row["sLL"] ;
}            
sqlsrv_free_stmt($result);
$sql = "SELECT count(*) as sLL FROM OrderItems
            WHERE TableID >=236 AND TableID <=245 
            AND OpenDateTime >= '".$date_0."' AND OpenDateTime <= '".$date_1."'";

$result= sqlsrv_query($conn, $sql);

if ($result == FALSE){
    echo "Only ".$orderUpd." - ".$ItemsUpd;
    die( print_r( sqlsrv_errors(), true));
}else{
    $row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
    $ItemsUpd = $row["sLL"] ;
}
sqlsrv_free_stmt($result);
sqlsrv_close($conn);
echo "Order: ".$orderUpd." - "."Items: ".$ItemsUpd;
?>
