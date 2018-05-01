<?php
include "DB_POS.php";
include "global.php";
$money_style = '%.2n';




$date_0 = $Ngay_hom_nay->format('Y-m-d');

if(isset($_GET["defferTime"])){
    
    $date = new DateTime($_GET["defferTime"]);
    $date_0 = $date->format('Y-m-d');
    $date_1 = $date->modify(' +1 day ')->format('Y-m-d'); 
}else{

    $newDate = new Datetime();
    $date_0 = $newDate->format('Y-m-d');
    
    $date_1 = $newDate->modify(' +1 day ')->format('Y-m-d'); 
}

$sql = "SELECT count(*) as sLL From OrderList 
        WHERE OpenDateTime >= '".$date_0."' 
        AND OpenDateTime <= '".$date_1."' 
        AND Note = 'Paid_in_Full'";

$conn = DB_POS_connect();
$result= sqlsrv_query($conn, $sql);


if ($result === FALSE){
    die( print_r( sqlsrv_errors(), true));
}
$row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
$orderUpd = $row["sLL"];
sqlsrv_free_stmt($result);



$sql = "SELECT count(*) as sLL From OrderItems 
        WHERE OpenDateTime >= '".$date_0."' 
        AND OpenDateTime <= '".$date_1."' 
        AND Note = 'Paid_in_Full'";


$result= sqlsrv_query($conn, $sql);


if ($result === FALSE){
    die( print_r( sqlsrv_errors(), true));
}
$row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
$itemUpd = $row["sLL"];

sqlsrv_free_stmt($result);
sqlsrv_close($conn);
include "display_TM_Paid_in_Full.php"
?>