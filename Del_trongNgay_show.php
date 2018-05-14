<?php
include "DB_POS.php";
include "global.php";
$money_style = '%.2n';




if(isset($_GET["date"])){
    
    $date = new DateTime($_GET["date"]);
    $date_0 = $date->format('Y-m-d');
    $date_1 = $date->modify(' +1 day ')->format('Y-m-d'); 
}else{

    $newDate = new Datetime();
    $date_0 = $newDate->format('Y-m-d');
    
    $date_1 = $newDate->modify(' +1 day ')->format('Y-m-d'); 
}
if (isset($_GET["ten"]) & isset($_GET["tien"])){
    $ten = $_GET["ten"];
    $tien = $_GET["tien"];

    $sql_order = "SELECT TableID, OpenDateTime, Card FROM OrderList INNER JOIN Config_table On OrderList.TableID = Config_table.ID
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
    
    if ( !sqlsrv_has_rows($result_order)){
        echo "Khong tim thay";
        exit;
    }
    $cout = 0;
    while($row_order = sqlsrv_fetch_array($result_order, SQLSRV_FETCH_ASSOC)){
        $tableID = $row_order["TableID"];
        $openTime = $row_order["OpenDateTime"]->format('Y-m-d H:i:s');
        ?>

            <ul>
               <li>
                    <?php echo $row_order["Card"]; ?>/<?php echo $tien; ?>
                    <input type="hidden" name = "tableID_don" value = "<?php echo $tableID; ?>">
                    <input type="hidden" name = "openDateTime" value = "<?php echo $openTime; ?>">
               </li> 
               <li id = "order_suaDon_<?php echo $cout ?>"><?php echo $tien; ?></li>
        <?php
        
        
        $sql_items = "SELECT
                        OrderItems.ID as ID, 
                        OrderItems.Quantity as q, 
                        MenuCfg.Menu as ten, 
                         
                        (OrderItems.Quantity*Prices) as tong, 
                        OrderItems.Note as Note
                FROM OrderItems INNER JOIN MenuCfg On OrderItems.MenuID = MenuCfg.ID 
                WHERE TableID = ".$tableID." AND OpenDateTime = '".$openTime."'
                ORDER BY OrderItemIndex";
            
        $result_items = sqlsrv_query($conn, $sql_items);
        if ($result_items == FALSE){
    
            die( print_r( sqlsrv_errors(), true));
        }
        while ($row_items = sqlsrv_fetch_array($result_items, SQLSRV_FETCH_ASSOC)){
?>
            <li>
                <div>
                    <?php 
                    if($row_items["q"] > 1){
                        echo $row_items["q"]." X ";
                    }
                    ?>
                    
                </div>
                <div>
                    <?php echo $row_items["ten"]; ?>
                </div>
                <div name = "items_price">
                    <?php echo $row_items["tong"]; ?>
                </div>
                <div>
                    <input type="hidden" name="item_ID" value = "<?php echo $row_items["ID"]; ?>">
                    <input type="checkbox" checked name="items_select" onchange = "cal_totaleOrder(<?php echo $cout; ?>)">
                    
                </div>
            </li>

<?php
        }
        
        ?>
        <li><button onclick = "Update_don(<?php echo $cout; ?>)">Update</button></li>
        </ul>
        <hr>
        <?php
        
    sqlsrv_free_stmt($result_items);
    $cout ++;
    }
    
}            

sqlsrv_free_stmt($result_order);

sqlsrv_close($conn);

?>
