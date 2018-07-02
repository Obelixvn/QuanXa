<!DOCTYPE html>
<html>
<head>


<script type="text/javascript" src="fusioncharts.js"></script>


</head>
<body>
<?php


include "DB_functions_NN_itemline.php";
include "global.php";
$str_type = "soLuong";
$yaxisname = "So luong Order";
$caption = "Total Number Order";
$numberprefix = "";
$group_byDay = false;
$time = 0;
$sang_chieu = 3;
$item_ID = 0;
$cat_id = 0;

$categoryArray=array();
$dateseries = array();
$Zero_value_data = array();
$dataseries1=array();
$dataseries2=array();
$dataseries3=array();
$dataname = array();

var_dump($_POST);


if (isset($_POST["type"])){
    if($_POST["type"] == 2){
        $str_type = "tongTien";
        $yaxisname = "Amount in (£)";
        $caption = "Total Sale From Order";
        $numberprefix = "£";
    }
}
if(isset( $_POST["groupByDay"])){
    if($_POST["groupByDay"] == 1){
        $group_byDay = true;
    }
    
}

var_dump($group_byDay);
if(isset($_POST["sang_chieu"])){
    $sang_chieu = $_POST["sang_chieu"];
}



if(isset($_POST["cat_id"])){
    $cat_id = $_POST["cat_id"];
    
}
if(isset($_POST["item_ID"])){
    $item_ID = $_POST["item_ID"];

}

if(isset($_POST["time"])){
    $time = $_POST["time"];
}



if ($time == 1){
    $str_date = $_POST["week_0"];
    if($str_date != 0){
        $time = 1;
        $year_0 = substr($str_date,0,4);
        $week_0 = substr($str_date,-2);
    }
    
    $str_date = $_POST["week_1"];
    if($str_date != 0){
        $time = 1;
        $year_1 = substr($str_date,0,4);
        $week_1 = substr($str_date,-2);
    }
    $year_week_0 = $year_0 * 100 + $week_0;
    $year_week_1 = $year_1 * 100 + $week_1;
    $sql_date_updated = "SELECT year(Date) as y, week(Date,1) as w  FROM `tb_date_updated` 
                        WHERE (year(Date) *100 + week(Date,1))>= ".$year_week_0." AND (year(Date) *100 + week(Date,1)) <= ".$year_week_1." GROUP BY y,w";
    $subcaption = "From ".$_POST["week_0"]." To ".$_POST["week_1"];
    
}else{
    $sql_date_updated = "SELECT year(Date) as y, week(Date,1) as w FROM `tb_date_updated`  GROUP BY y,w";
    $year_week_0 = 0;
    $subcaption = "ALL TIME";
}
if($year_week_0 < 201815 ){
    $group_byDay = false;
}





if( $item_ID != 0){
    $array_ID = $item_ID;
    $tb_data_name = "tb_mon";
    $col_id = "tb_mon.id";
    
}elseif($cat_id != 0){
    $array_ID = $cat_id;
    $tb_data_name = "tb_mon_cat";
   
}else{
    echo "Error: 101 - input";
    exit;
}

$str_group_ID = "(";
foreach ($array_ID as $element) {
    $dateseries[$element] = array();
    $Zero_value_data[$element] = false;
    $str_group_ID .= $element.",";
}
$str_group_ID = substr($str_group_ID,0,-1);
$str_group_ID .= ")";



$sql_data_name = "Select * from ".$tb_data_name." where id in ".$str_group_ID;
$result_data_name = DB_run_query($sql_data_name);
while($row_cat_name = $result_data_name->fetch_assoc()){
    $dataname[$row_cat_name["ID"]] = $row_cat_name["Name"];
    $temp_num = $row_cat_name["Cat_parent"]-1000;
    
}
if($cat_id !=0){
    
    $col_id = "Cat_".$temp_num;
}
$sql_group_clause = " AND ".$col_id." in ".$str_group_ID;


$result_date_updated = DB_run_query($sql_date_updated);
$pre_week = "";
while ($row_date_updated = $result_date_updated->fetch_assoc()){
    $weeklable = $row_date_updated["y"]."w".sprintf("%02d", $row_date_updated["w"]);
    $tb_name = "tb_".$weeklable;
    
    if($group_byDay){
        $xaxisname = "Daily";
        $sql = "SELECT ".$col_id." as ID, t.Date as Ngay, ROUND(sum(tongTien),2) as tongTien, sum(soLuong) as soLuong 
                FROM ".$tb_name." as t INNER JOIN tb_mon On tb_mon.ID = t.ID_item WHERE  ".$col_id." in ".$str_group_ID." ";
        
        $sql .= " group by t.Date, ".$col_id." ORDER BY t.Date ASC";
        
        
       
        
        $result = DB_run_query($sql);
        $pre_ngay = "";
        while ($row = $result->fetch_assoc()){
            

            if($pre_ngay != $row["Ngay"]){
                
                array_push($categoryArray, array(
                    "label" => substr($row["Ngay"],0,10)
                )
                );
                foreach ($Zero_value_data as $key => $value) {
                    if($value){
                        
                        array_push($dateseries[$key], array(
                            "value" => "0"
                            )
                        );
                    }else{
                        
                        $Zero_value_data[$key] = true;
                        
                    }

                }
                $pre_ngay = $row["Ngay"];
            }
            array_push($dateseries[$row["ID"]], array(
                "value" => $row[$str_type]
                )
            );
            $Zero_value_data[$row["ID"]] = false;
            
        
            
        }
        
    }else{
        $xaxisname = "Weekly";
        $sql = "SELECT ".$col_id." as ID, ROUND(sum(tongTien),2) as tongTien, sum(soLuong) as soLuong 
                FROM ".$tb_name." as t INNER JOIN tb_mon On tb_mon.ID = t.ID_item WHERE  ".$col_id." in ".$str_group_ID." ";

        $sql .= " group by ".$col_id;
        
        
        $result = DB_run_query($sql);
        
        while ($row = $result->fetch_assoc()){
            if($pre_week != $weeklable){
                array_push($categoryArray, array(
                    "label" => $weeklable
                    )
                );
                foreach ($Zero_value_data as $key => $value) {
                    if($value){
                        array_push($dateseries[$key], array(
                            "value" => "0"
                            )
                        );
                    }else{
                        $Zero_value_data[$key] = true;
                    }

                }
                $pre_week = $weeklable;
            
            }
            array_push($dateseries[$row["ID"]], array(
                "value" => $row[$str_type]
                )
            );
            $Zero_value_data[$row["ID"]] = false;
            
            
        }
    }
    //$sql = "SELECT tb_mon.Name, sum(tongTien) as tongTien, sum(soLuong) as soLuong FROM ".$tb_name." as t INNER JOIN tb_mon On tb_mon.ID = t.ID_item WHERE t.ID_item = 33 ";
    
    
}
var_dump($dateseries[163]);
echo "<br>";
var_dump($Zero_value_data[163]);
include("fusioncharts.php");
$arrData = array(
    "chart" => array(
        "caption"=> $caption,
        "subcaption"=> $subcaption,
        "xaxisname"=> $xaxisname,
        "yaxisname"=> $yaxisname,
        "numberprefix"=> $numberprefix,
        "theme"=> "ocean"
        )
      );
$arrData["categories"]=array(array("category"=>$categoryArray));


//$arrData["dataset"] = array(array("seriesName"=> "Actual Revenue","renderAs"=>"line", "data"=>$dataseries1));
$arrData["dataset"] = array();
foreach ($dateseries as $key => $value) {
   array_push($arrData["dataset"], array(
    "seriesName"=> $dataname[$key],
    "renderAs"=>"line", 
    "data"=>$value
   ));
}

$jsonEncodedData = json_encode($arrData);
$mscombi2dChart = new FusionCharts("mscombi2d", "ex3", "100%", 600, "chart-1", "json",$jsonEncodedData);

$mscombi2dChart->render();
?>
<div id="chart-1"><!-- Fusion Charts will render here--></div>
 
</body>
</html>