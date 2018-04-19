<?php 

include "DB_POS.php";
include "global.php";
$money_style = '%.2n';
$tableid = 0;
$date = $Ngay_hom_nay->format('Y-m-d');

if (isset($_GET['time'])){
    $time = $_GET["time"];
}
if (isset($_GET['tableid'])){
    $tableid = $_GET["tableid"];
}
if (isset($_GET['card'])){
    $card = $_GET["card"];
}
if (isset($_GET['cash'])){
    $cash = $_GET["cash"];
}

$sql = "SELECT Total FROM OrderList WHERE OpenDateTime = '".$time."' AND TableID = ".$tableid;
$conn = DB_POS_connect();
$result= sqlsrv_query($conn, $sql);
$num_row = sqlsrv_rows_affected($result);
    if ($result === NULL ){
        Echo "Khong thay";
        exit;
    }
    $row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
    $total = $row["Total"];
    if ($total != $card + $cash){
        Echo "Tong khong dung";
        exit;
    }else{
        $sql = "UPDATE OrderList 
                SET Card = ".$card.", Cash = ".$cash."
                WHERE OpenDateTime = '".$time."' AND TableID = ".$tableid;
        $result= sqlsrv_query($conn, $sql);
        $num_row = sqlsrv_rows_affected($result);   
        
        if ($num_row > 0 ){
            Echo "Thanh cong - Card: ".$card." Cash: ".$cash;
        }    
    }
?>