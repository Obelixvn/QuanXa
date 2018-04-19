<?php
include "DB_POS.php";
include "global.php";
$money_style = '%.2n';




$date_0 = $Ngay_hom_nay->format('Y-m-d');

if(isset($_GET["date"])){
    
    $date = new DateTime($_GET["date"]);
    $date_0 = $date->format('Y-m-d');
    $date_1 = $date->modify(' +1 day ')->format('Y-m-d'); 
}else{

    $newDate = new Datetime();
    $date_0 = $newDate->format('Y-m-d');
    
    $date_1 = $newDate->modify(' +1 day ')->format('Y-m-d'); 
}
$orderUpd = 0;
$ItemsUpd = 0;
$sql = "DELETE OrderList
        WHERE OpenDateTime >= '".$date_0."' 
        AND OpenDateTime <= '".$date_1."' 
        AND Note = 'Paid_in_Full'";


$conn = DB_POS_connect();
$result= sqlsrv_query($conn, $sql);
if ($result == FALSE){
    echo "Only ".$orderUpd." - ".$ItemsUpd;
    die( print_r( sqlsrv_errors(), true));
}else{
    $orderUpd += sqlsrv_rows_affected($result);
}

$sql = "DELETE OrderItems
        WHERE OpenDateTime >= '".$date_0."' 
        AND OpenDateTime <= '".$date_1."' 
        AND Note = 'Paid_in_Full'";



$result= sqlsrv_query($conn, $sql);

if ($result == FALSE){
    echo "Only ".$orderUpd." - ".$ItemsUpd;
    die( print_r( sqlsrv_errors(), true));
}else{
    $ItemsUpd += sqlsrv_rows_affected($result);
}
?>
Update Xong !! <?php echo $orderUpd." - ".$ItemsUpd; ?>