<?php
include "DB_POS.php";
include "global.php";
$money_style = '%.2n';


$conn = DB_POS_connect();
if(isset($_GET["release"])){
    $time = new Datetime();
    $time = $time->modify(' -5 minutes ');
    
    
    $sql = "UPDATE OrderList SET OrderList.Status = 0, OrderList.CloseOrder = 2
            WHERE OrderList.Status > 1 AND TableID >= 236 AND TableID <= 245 AND OpenDateTime <= '".$time->format('Y-m-d H:i:s')."'";
    $result= sqlsrv_query($conn, $sql);
    if ($result == FALSE){
        die( print_r( sqlsrv_errors(), true));
    }       
}

$sql = "SELECT Config_table.TableName as Name,  OpenDateTime as [Time], Total 
        FROM OrderList INNER JOIN Config_table ON OrderList.TableID = Config_table.ID
        WHERE TableID >= 236 AND TableID <= 245 AND OrderList.Status <> 0
        ORDER BY OpenDateTime DESC";


$result= sqlsrv_query($conn, $sql);
if ($result == FALSE){
    die( print_r( sqlsrv_errors(), true));
}
while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {

?>
<div class = "del_order_item">
    <div title = "<?php echo $row["Time"]->format('H:m'); ?>"class = "<?php echo substr($row["Name"], 0, -2); ?>"><?php echo $row["Name"]; ?></div>
    <div><?php echo money_format($money_style, $row["Total"]); ?></div>
    <div class = "clearFix"></div>
</div>

<?php

}
?><div class = "clearFix"></div>