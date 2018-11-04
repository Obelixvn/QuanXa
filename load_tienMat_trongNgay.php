<?php
include "DB_POS.php";
include "global.php";
include "DB_functions_NN.php";
$money_style = '%.2n';

if(isset($_GET["defferTime"])){
    
    $date = new DateTime($_GET["defferTime"]);
    $date_0 = $date->format('Y-m-d');
    $date_1 = $date->modify(' +1 day ')->format('Y-m-d'); 
}else{

    $date = new Datetime();
    $date_0 = $date->format('Y-m-d');
    
    $date_1 = $date->modify(' +1 day ')->format('Y-m-d'); 
}
$conn = DB_POS_connect();



$sql = "SELECT count(*) as sLL From OrderList 
        WHERE OpenDateTime >= '".$date_0."' 
        AND OpenDateTime <= '".$date_1."' 
        AND Note = 'Paid_in_Full'";


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




$sql = "SELECT sum(Cash-Change) as TongTM, sum(Card) as TongThe
        FROM OrderList 
        WHERE OpenDateTime >= '".$date_0."' 
        AND OpenDateTime <= '".$date_1."' 
        AND (TableID <236 OR TableID >245)";


$result= sqlsrv_query($conn, $sql);

if ($result === FALSE){
    die( print_r( sqlsrv_errors(), true));
}
$row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC);
$Card = $row["TongThe"];
$TM = $row["TongTM"];
$percent = $TM/$Card * 100;

sqlsrv_free_stmt($result);

$Roo_del = "";
$Uber_del = "";

$sql_Del = "SELECT  'Uber' as Del, sum(OrderList.Total) as Total FROM OrderList WHERE TableID IN  (237,241,242,243,244) and OpenDateTime >= '".$date_0."' AND OpenDateTime < '".$date_1."' UNION " ;

$sql_Del .= "SELECT  'Roo' as Del,sum(OrderList.Total) as Total FROM OrderList WHERE TableID IN (236,238,239,240,245) and OpenDateTime >= '".$date_0."' AND OpenDateTime < '".$date_1."'" ;



$result= sqlsrv_query($conn, $sql_Del);

if ($result === FALSE){
    die( print_r( sqlsrv_errors(), true));
}
while($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)){
    if($row["Del"] == 'Roo'){
        $Roo_del = $row["Total"];
    }else{
        $Uber_del = $row["Total"];
    }
};


$sql = "SELECT OrderList.TableID,OrderList.OpenDateTime as Time,Config_table.TableName as TenBan, OrderList.Total as Tien,
        OrderList.Change, OrderList.Tips,OrderList.Cash,OrderList.Discount,
        CASE WHEN (OrderList.Cash - OrderList.Change) >= OrderList.Total THEN 'ALLTM'
            ELSE 'SPLIT' END AS 'Type'

        FROM OrderList INNER JOIN Config_table ON OrderList.TableID = Config_table.ID
        WHERE   OpenDateTime >= '".$date_0."' AND OpenDateTime <= '".$date_1."'
                AND OrderList.Status = 0 AND OrderList.Cash > 0
                AND OrderList.Note <> 'Paid_in_Full'";

//$sql = "SELECT  OrderItems.*,MenuCfg.Menu  FROM OrderItems INNER JOIN MenuCfg ON MenuID = MenuCfg.ID WHERE TableID= 206 AND OpenDateTime = '2018-04-13 19:34:37'  ORDER BY OpenDateTime DESC";
        



$result= sqlsrv_query($conn, $sql);

if ($result === FALSE){
    die( print_r( sqlsrv_errors(), true));
}
$i=0;
$thu = $date->modify(' -1 day ')->format('w') +1 ;
$sql_avg = "SELECT cash FROM NN.view_avg_sale where thu = ".$thu ;

$result_avg = DB_run_query($sql_avg);
$row_avg = $result_avg->fetch_assoc();
$avg_cash = $row_avg["cash"];
?>
<div id = "Paid_in_Full" >
<?php  include "display_TM_Paid_in_Full.php"; ?>
            
</div>
<div id = "TM_tren_the" >
    <div class = "display_TMThe">
        <div>Tiền Thẻ <br><span  id = "fix_card"><?php echo $Card; ?></span> </div>
        <div>Tiền mặt <br><?php echo number_format($TM,2); ?></div>
        <div>Tiền mặt Bình Quân <br><?php echo number_format($avg_cash,2); ?></div>
        <div class = "clear_Fix"></div>
        <br>
        <div>Phầm trăm tiền mặt trên tiền thẻ: <?php echo number_format($percent,2); ?>%</div>
        <div>Tiền Roo: <?php echo number_format($Roo_del,2); ?></div>
        <div>Tiền Uber: <?php echo number_format($Uber_del,2); ?></div>
        <div class = "clear_Fix"></div>
    </div>
    <div class = "display_TMThe">
        <div> </div>
        <div>Tổng tiền mặt đã chọn: <br><span id = "adj_TM"></span></div>
        <div>Phần trăm tiền mặt trên tiền thẻ<br><span id = "adj_percent"></span>%</div>
        <div class = "clear_Fix"></div>
    </div>
    <hr>
    
</div>

<table id = "tb_tienMat">

<?php
$don_tra_toanTM = 0;
while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
    
?>

    <tr>
        <td>
        <div class = "order_sumary">
        
        <input onclick = "addUp_tongTien()" 
        <?php
            if ($row["Type"] != 'ALLTM'){
                echo "Checked='checked'";
            }
        ?>
        type="checkbox" name="tableCK" id="">
        <input type="hidden" name="tableID" value = "<?php echo $row["TableID"]; ?> ">
        <input type="hidden" name="tableTime" value = "<?php echo $row["Time"]->format('Y-m-d H:i:s'); ?> ">
        Table <?php echo $row["TenBan"]; ?> :
        <?php 
        if ($row["Type"] == 'ALLTM'){
            $don_tra_toanTM +=1;
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
sqlsrv_free_stmt($result);
sqlsrv_close($conn);
?>
</table>
<br>
<div>Tổng số đơn có trả tất bằng tiền mặt là: <?php echo $don_tra_toanTM; ?> </div>
<br>
<button class = "mar_r_15" onclick= "Xapxep()">Xap xep</button>
<button class = "mar_r_15" onclick= "loc_thongKe_TM()">Xóa đơn không được tick </button>
<button onclick = "checkALL_TM()">Chọn tất cả</button>