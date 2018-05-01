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
$sql = "SELECT sum(Cash-Change) as TongTM, sum(Card) as TongThe
        FROM OrderList 
        WHERE OpenDateTime >= '".$date_0."' 
        AND OpenDateTime <= '".$date_1."' 
        AND (TableID <=236 OR TableID >=245)";
echo $sql;
exit;
$conn = DB_POS_connect();
$result= sqlsrv_query($conn, $sql);

if ($result === FALSE){
    die( print_r( sqlsrv_errors(), true));
}
$row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
$Card = $row["TongTien"];
$percent = $TM/$Card * 100;

sqlsrv_free_stmt($result);
sqlsrv_close($conn);
?>
<div class = "display_TMThe">
    <div id = "fix_card"> <?php echo $Card; ?></div>
    <div><?php echo number_format($TM,2); ?></div>
    <div><?php echo number_format($percent,2); ?></div>
    <div class = "clear_Fix"></div>
</div>
<div class = "display_TMThe">
    <div> </div>
    <div id = "adj_TM"></div>
    <div id = "adj_percent"></div>
    <div class = "clear_Fix"></div>
</div>
<hr>
