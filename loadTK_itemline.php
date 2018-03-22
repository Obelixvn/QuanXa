<?php
include "DB_functions_NN_itemline.php";

$str_type = "soLuong";

if (isset($_GET["type"])){
    if($_GET["type"] == 2){
        $str_type = "soLuong";
    }
}


$sql_mon = "SELECT MAX(ID) as maxID FROM `tb_mon`";
$result_mon = DB_run_query($sql_mon);
$row_mon  = $result_mon->fetch_assoc();
$maxID = $row_mon["maxID"];

$Sang = array_fill(1,$maxID,0);
$Toi = array_fill(1,$maxID,0);
$Tong = array_fill(1,$maxID,0);
$ten_mon = array_fill(1,$maxID,0);

$sql_mon = "SELECT * FROM `tb_mon`";
$result_mon = DB_run_query($sql_mon);
while($row_mon = $result_mon->fetch_assoc()){
    $ten_mon[$row_mon["ID"]] = $row_mon["Name"];
}


$sql_date_updated = "SELECT year(Date) as y, week(Date,1) as w FROM `tb_date_updated`  GROUP BY y,w";
$result_date_updated = DB_run_query($sql_date_updated);
while ($row_date_updated = $result_date_updated->fetch_assoc()){
    $tb_name = "tb_".$row_date_updated["y"]."w".sprintf("%02d", $row_date_updated["w"]);
    $sql = "SELECT ID_item, tongTien, soLuong, Gio FROM ".$tb_name ;
    $result = DB_run_query($sql);
    while ($row = $result->fetch_assoc()){
        if($row["ID_item"] == 265){
            echo $tb_name."<br>";
        }
        if($row["Gio"] == "S"){
            $Sang[$row["ID_item"]] += $row[$str_type];
            
        }else{
            $Toi[$row["ID_item"]] += $row[$str_type];
        }
        $Tong[$row["ID_item"]] += $row[$str_type];
    }
}
$ThongKE = $Tong;
if (isset($_GET["time"])){
    switch ($_GET["time"]) {
        case 1:
            $ThongKE = $Sang;
            break;
        
        case 2:
            $ThongKE = $Toi;
            break;
        
    }
}

arsort($ThongKE);
foreach ($ThongKE as $key => $value) {
    if($value > 0){
        echo $ten_mon[$key].":  ".$value."<br>";
    }
    
}
?>


