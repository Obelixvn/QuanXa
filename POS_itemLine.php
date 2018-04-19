<?php 
include "DB_POS.php";
include "global.php";
?>


<?php

$date_0 = $_GET["date_0"];
$date_1 = $_GET["date_1"];
if ($date_0 == $date_1 and $date_1 == ''){
    $date = new Datetime();
    $date_0 = $date->format('Y-m-d');
    $date_1 = $date_0;
}
$sql = "SELECT * FROM view_tkItem_v11 WHERE Ngay >= '".$date_0."' AND Ngay <= '".$date_1."' ORDER BY Ngay DESC";
$conn = DB_POS_connect();
$result= sqlsrv_query($conn, $sql);

while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
    ?>
    <tr>
        <td><?php echo $row["Ngay"]->format('Y-d-m') ?></td>
        <td><?php echo $row["Ten"] ?></td>
        <td><?php echo $row["Time"] ?></td>
        <td><?php echo $row["OrderType"] ?></td>
        <td><?php echo $row["tongTien"] ?></td>
        <td><?php echo $row["soLuong"] ?></td>
    </tr>
    <?php

}


?>