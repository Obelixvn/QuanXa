<?php
include "DB_functions_NN_itemline.php";
include "global.php";
$str_type = "soLuong";
$TOP_count = 10;
$time = 0;
$sang_chieu = 3;
if (isset($_GET["type"])){
    if($_GET["type"] == 2){
        $str_type = "tongTien";
    }
}

if (isset($_GET["top_count"])){
    $TOP_count = $_GET["top_count"];
}

if (isset($_GET["sang_chieu"])){
    $sang_chieu = $_GET["sang_chieu"];
}
if (isset($_GET["week_0"])){
    $str_date = $_GET["week_0"];
    $year_0 = substr($str_date,0,4);
    $week_0 = substr($str_date,-2);
}
if (isset($_GET["week_1"])){
    $str_date = $_GET["week_1"];
    $year_1 = substr($str_date,0,4);
    $week_1 = substr($str_date,-2);
}
if (isset($_GET["time"])){
    $time = $_GET["time"];
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

if ($time == 1){
    $sql_date_updated = "SELECT year(Date) as y, week(Date,1) as w FROM `tb_date_updated` WHERE y >=  GROUP BY y,w";
}else{
    $sql_date_updated = "SELECT year(Date) as y, week(Date,1) as w FROM `tb_date_updated`  GROUP BY y,w";
}

$result_date_updated = DB_run_query($sql_date_updated);
while ($row_date_updated = $result_date_updated->fetch_assoc()){
    $tb_name = "tb_".$row_date_updated["y"]."w".sprintf("%02d", $row_date_updated["w"]);
    $sql = "SELECT ID_item, tongTien, soLuong, Gio FROM ".$tb_name ;
    $result = DB_run_query($sql);
    while ($row = $result->fetch_assoc()){
       
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
$count = 1;
foreach ($ThongKE as $key => $value) {
    if($count > $TOP_count){
        continue;
    }
    ?>
    <tr>
        <td><?php echo $count; ?></td>
        <td><?php echo $ten_mon[$key]; ?></td>
        <td><?php if( $str_type == "tongTien") {echo money_format ('%(#10.2n',$value);}
                else{ echo $value;} ?></td>
    </tr>
    <?php
    
    $count++;
}
?>


