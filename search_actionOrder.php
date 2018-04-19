<?php 

include "DB_POS.php";
include "global.php";
$money_style = '%.2n';

$date = $Ngay_hom_nay->format('Y-m-d');

if (isset($_GET['date'])){
    $date = $_GET["date"];
}
if (isset($_GET['ten'])){
    $ten = $_GET["ten"];
}
if (isset($_GET['tien'])){
    $tien = $_GET["tien"];
}

if($tien != '' & $ten != ''){
    $sql = "SELECT OpenDateTime as Time, Total, Cash, Card ,TableID
            From OrderList 
            INNER JOIN Config_table ON OrderList.TableID = Config_table.ID
            WHERE OrderList.Total = ".$tien." AND Config_table.TableName = '".$ten."' 
            ORDER BY OpenDateTime DESC";
    $conn = DB_POS_connect();
    $result= sqlsrv_query($conn, $sql);
    $num_row = sqlsrv_rows_affected($result);
    if ($num_row == 0 ){
        Echo "Khong thay";
        exit;
    }
    $i = 0;
    while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
        ?>
        <div class = "order_item_Search" id = "orderToReFund_<?php echo $i; ?>" >
            
                <input type="hidden" name="ID_ban" value = "<?php echo $row["TableID"]; ?>">
                <input type="hidden" name="Time_ban" value = "<?php echo $row['Time']->format('Y-m-d H:i:s'); ?>">
                <?php echo $row['Time']->format('H:i:s'); ?> - 
                Cr<input type="number" name="card_ban" id="" value = "<?php echo $row["Card"]; ?>">
                Cs<input type="number" name="cash_ban" id="" value = "<?php echo $row["Cash"]; ?>">
                
                <button name = "Save_button" onclick = "refund_action(<?php echo $i; ?>)">Save</button>
        
        </div>
        <?php
        $i++;
    }
}else{
    Echo "Khong thay";
}



?>