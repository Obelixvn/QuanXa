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
$sql_str_cat ="";
if (isset($_GET["cat_id"])){
    $cat_id = $_GET["cat_id"];
    $sql_str_cat = " INNER JOIN tb_mon ON ID_item = tb_mon.ID WHERE ";
    $sql_mon_cat = "SELECT  t2.ID as cat_ID, (t2.Cat_parent - 1000) as cat_name FROM `tb_mon_cat` t1 LEFT JOIN `tb_mon_cat` t2  ON t1.Combine_1 = t2.ID OR t1.Combine_2 = t2.ID OR t1.Combine_3 = t2.ID OR t1.ID = t2.ID where t1.ID in (";
    foreach ($cat_id as $element){
    
        $sql_mon_cat .= $element.','; 
        
    }
    $sql_mon_cat = substr($sql_mon_cat,0,-1);
    $sql_mon_cat .=')';
    
    $r_temp = DB_run_query($sql_mon_cat);
    while ($row_temp = $r_temp->fetch_assoc()){
        $sql_str_cat .= " `Cat_".$row_temp["cat_name"]."` = ".$row_temp["cat_ID"]." OR"; 
    }


    $sql_str_cat =substr($sql_str_cat,0,-2);
    
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
    $year_week_0 = $year_0 * 100 + $week_0;
    $year_week_1 = $year_1 * 100 + $week_1;
    $sql_date_updated = "SELECT year(Date) as y, week(Date,1) as w  FROM `tb_date_updated` 
                        WHERE (year(Date) *100 + week(Date,1))>= ".$year_week_0." AND (year(Date) *100 + week(Date,1)) <= ".$year_week_1." GROUP BY y,w";
    
}else{
    $sql_date_updated = "SELECT year(Date) as y, week(Date,1) as w FROM `tb_date_updated`  GROUP BY y,w";
}

$result_date_updated = DB_run_query($sql_date_updated);
while ($row_date_updated = $result_date_updated->fetch_assoc()){
    $tb_name = "tb_".$row_date_updated["y"]."w".sprintf("%02d", $row_date_updated["w"]);
    $sql = "SELECT ID_item, tongTien, soLuong, Gio FROM ".$tb_name ;
    $sql .= $sql_str_cat ;
    
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


switch ($sang_chieu) {
    case 1:
        $ThongKE = $Sang;
        break;
    
    case 2:
        $ThongKE = $Toi;
        break;
    case 3:
        $ThongKE = $Tong;
        break;
    
}

if($TOP_count > 0){
    arsort($ThongKE);
}else{
    asort($ThongKE);
    $TOP_count = $TOP_count * (-1);
}


$count = 1;
foreach ($ThongKE as $key => $value) {
    if(($count > $TOP_count) && ($TOP_count != 1)){
        exit;
    }
    if($value == 0){
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


