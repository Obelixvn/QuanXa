<?php 
//TA 1-200
//DEL 236-245

include "DB_POS.php";
include "global.php";
$money_style = '%.2n';
$type = 0;//0 =soLuong; 
$time = 0; // 0 =S;1=C;
$name = '';
$listType = "('EatIn','TW','DEL')"; //1= Eat in; 2=TW; 3= DEL;
$top = "";

if (isset($_GET["type"])){
    $type = $_GET["type"];
}
if (isset($_GET["time"])){
    $time = $_GET["time"];
}
if (isset($_GET["name"])){
    $name = $_GET["name"];
}
if (isset($_GET["orderType"])){
    $orderType = $_GET["orderType"];
    $tempList = "(";
    foreach ($orderType as $key => $value) {
        $tempList .="'".$value."',";
    }
    $tempList = substr ($tempList ,0, -1);
    $listType = $tempList.")";
}
if (isset($_GET["top"])){
    $top = "";
}
//$name = "Rare Beef";
$sql = "SELECT ".$top." * FROM view_tkItem_v11 WHERE Ngay = '".$Ngay_hom_nay->format('Y-m-d')."' ";
if ($time == 1){
    $sql .= " AND Time = 'S' ";
}elseif($time == 2){
    $sql .= " AND Time = 'C' ";
}
if($name != ''){
    $sql .=" AND Ten = '".$name."'";
}

$sql .=" AND OrderType IN ".$listType;

if($type == 0){
    $sql .= " ORDER BY soLuong DESC ";
    $colName = "soLuong";
}else{
    $sql .= " ORDER BY tongTien DESC ";
    $colName = "tongTien";
}

$conn = DB_POS_connect();
$result= sqlsrv_query($conn, $sql);
while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
?>
    <tr>
        <td><?php echo $row["Ten"]; ?> </td>
        <td>
            <?php if ($type == 0){
                        echo $row[$colName];
                    }else{
                        echo money_format($money_style,$row[$colName]);
                    } 
            ?> 
        </td>
    </tr>

<?php

   // echo $row["Ngay"]->format('d-m-Y')."  -   ".$row["Ten"]."  -   ".$row["Time"]."  -   ".$row["OrderType"]."  -   ".$row["tongTien"]."  -   ".$row["soLuong"]."<br>";
}        


?>