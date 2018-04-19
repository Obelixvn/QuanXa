<?php

include "DB_POS.php";
include "global.php";
$money_style = '%.2n';



$sql = "SELECT TOP 20 Config_table.TableName as tb, OpenDateTime as openTime, Total, Cash, Card, Tips, UserID, CloseDateTime 
        From OrderList 
        INNER JOIN Config_table ON OrderList.TableID = Config_table.ID
        ORDER BY [OpenDateTime] DESC";
 
//$result = DB_POS_runQuery($sql);
$conn = DB_POS_connect();
$result= sqlsrv_query($conn, $sql);
while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
?>
<tr>
    <td><?php echo $row["tb"]; ?></td>
    <td>
        <?php
            //$time = new Datetime($row["openTime"]); 
            echo $row["openTime"]->format("H:s"); 
        ?>
    </td>
    <td><?php echo money_format($money_style,$row["Total"]); ?></td>
    <td>
    <?php 
        if($row["Cash"] > 0){
            ?>
            <button class = "pay_cash" disabled="disabled">CASH</button>
            <?php
        }
        if($row["Card"] > 0){
            ?>
            <button class = "pay_card" disabled="disabled">CARD</button>
            <?php
        }
        if($row["Tips"] > 0){
            ?>
            <button class = "pay_tip" disabled="disabled">TIP</button>
            <?php
        }
    ?>
    </td>
    <td><?php echo $row["UserID"]; ?></td>
</tr>

<?php

} 
?>