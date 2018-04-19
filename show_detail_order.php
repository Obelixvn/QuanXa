<?php

include "DB_POS.php";
include "global.php";
$money_style = '%.2n';

if (isset($_GET["tableID"])){
    if(isset($_GET["tableTime"])){
        $tableID = $_GET["tableID"];
        $tableTime = $_GET["tableTime"];
        $sql = "SELECT OrderItems.Quantity as q, 
                        MenuCfg.Menu as ten, 
                         
                        (OrderItems.Quantity*Prices) as tong, 
                        OrderItems.Note as Note
                FROM OrderItems INNER JOIN MenuCfg On OrderItems.MenuID = MenuCfg.ID 
                WHERE TableID = ".$tableID." AND OpenDateTime = '".$tableTime."'
                ORDER BY OrderItemIndex";
        $conn = DB_POS_connect();
        $result= sqlsrv_query($conn, $sql);

        if ($result == FALSE){
            die( print_r( sqlsrv_errors(), true));
        }
        $tong = 0;
        while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
            $tong += $row["tong"];

?>
            <div class = "detail_order_item">
                <div><?php if ($row["q"] > 1) {echo $row["q"];} ?></div>
                <div><?php echo $row["ten"] ?></div>
                <div><?php echo number_format($row["tong"],2) ?></div>
                <div><?php echo $row["Note"] ?></div>
            </div>
            <div class = "clearFix"></div>
<?php
        }
    }
}

?>
            