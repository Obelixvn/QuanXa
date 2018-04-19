<?php
include "DB_POS.php";
include "global.php";
$money_style = '%.2n';





if(isset($_GET["defferTime"])){
    
    $date = new DateTime($_GET["defferTime"]);
    $date_0 = $date->format('Y-m-d');
    $date_1 = $date->modify(' +1 day ')->format('Y-m-d'); 
}else{

    $newDate = new Datetime();
    $date_0 = $newDate->format('Y-m-d');
    
    $date_1 = $newDate->modify(' +1 day ')->format('Y-m-d'); 
}

$sql = "SELECT OrderList.TableID,OrderList.OpenDateTime as Time,Config_table.TableName as TenBan, OrderList.Total as Tien,
        OrderList.Change, OrderList.Tips,OrderList.Cash,OrderList.Discount,
        CASE WHEN OrderList.Cash >= OrderList.Total THEN 'ALLTM'
            ELSE 'SPLIT' END AS 'Type'

        FROM OrderList INNER JOIN Config_table ON OrderList.TableID = Config_table.ID
        WHERE   OpenDateTime >= '".$date_0."' AND OpenDateTime <= '".$date_1."'
                AND OrderList.Status = 0 AND OrderList.Cash > 0
                AND OrderList.Note <> 'Paid_in_Full'";

//$sql = "SELECT  OrderItems.*,MenuCfg.Menu  FROM OrderItems INNER JOIN MenuCfg ON MenuID = MenuCfg.ID WHERE TableID= 206 AND OpenDateTime = '2018-04-13 19:34:37'  ORDER BY OpenDateTime DESC";
        


$conn = DB_POS_connect();
$result= sqlsrv_query($conn, $sql);

if ($result == FALSE){
    die( print_r( sqlsrv_errors(), true));
}
$i=0;
while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
?>
    <tr>
        <td>
        <div class = "order_sumary">
        <input onclick = "addUp_tongTien()" type="checkbox" name="tableCK" id="">
        <input type="hidden" name="tableID" value = "<?php echo $row["TableID"]; ?> ">
        <input type="hidden" name="tableTime" value = "<?php echo $row["Time"]->format('Y-m-d H:i:s'); ?> ">
        Table <?php echo $row["TenBan"]; ?> :
        <?php 
        if ($row["Type"] == 'ALLTM'){
            echo "<span name = \"TM_addUp\">".number_format($row["Tien"],2). "</span>"; 
        }else{
            echo "<span name = \"TM_addUp\">".number_format($row["Cash"]-$row["Change"],2)."</span>,(".number_format($row["Tien"],2).")"; 
        }
        
        
        ?>
        <button onclick = "show_chiTiet(<?php echo $i; ?>)">Chi tiet</button>  
        </div>
        <div class = "order_detail" id = "order_detail_<?php echo $i; ?>">

        </div>
        </td>
        
        
    </tr>

<?php
    $i++;
}
?>