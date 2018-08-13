<?php 

include "DB_POS.php";
include "global.php";

if(isset($_GET["date"])){
    
    $date = new DateTime($_GET["date"]);
    $date_0 = $date->format('Y-m-d');
    $date_1 = $date->modify(' +1 day ')->format('Y-m-d'); 
}else{

    $newDate = new Datetime();
    $date_0 = $newDate->format('Y-m-d');
    
    $date_1 = $newDate->modify(' +1 day ')->format('Y-m-d'); 
}

if (isset($_GET["ten_goc"]) & isset($_GET["tien_goc"])){
    $ten = $_GET["ten_goc"];
    $tien = $_GET["tien_goc"];

    $sql_order = "SELECT TableID, OpenDateTime FROM OrderList INNER JOIN Config_table On OrderList.TableID = Config_table.ID
            WHERE OpenDateTime >= '".$date_0."' AND OpenDateTime <= '".$date_1."' AND 
            Config_table.TableName = '".$ten."' AND OrderList.Total = ".$tien;

            
    
}else{
    echo "Error :101";
}

$conn = DB_POS_connect();
$result_order= sqlsrv_query($conn, $sql_order);



if ($result_order == FALSE){
    
    die( print_r( sqlsrv_errors(), true));
}else{
    while($row_order = sqlsrv_fetch_array($result_order, SQLSRV_FETCH_ASSOC)){
        ?>
            <input type="radio" name="OpenDateTime" id="" onclick = "click_openTime_Ex_don(this)"value = "<?php echo $row_order["OpenDateTime"]->format('Y-m-d H:i:s'); ?>"><?php echo $row_order["OpenDateTime"]->format('Y-m-d H:i:s'); ?> 
            <input type="hidden" id="table_goc_ID_Ex" value = "<?php echo $row_order["TableID"] ?>">
        <?php
    }
}
?>