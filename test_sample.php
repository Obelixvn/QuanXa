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



if (isset($_POST["type"])){
    if($_GET["type"] == 2){
        $str_type = "tongTien";
    }
}
if(isset( $_POST["groupByDay"])){
    $group_byDay = $_POST["groupByDay"];
}
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
    
}else{
    $sql_date_updated = "SELECT year(Date) as y, week(Date,1) as w FROM `tb_date_updated`  GROUP BY y,w";
    $year_week_0 = 0;
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

$str_group_ID = "("
foreach ($array_ID as $element) {
    $dateseries[$element] = array();
    $Zero_value_data[$element] = false;
    $str_group_ID .= $element.",";
}
$str_group_ID = substr($str_group_ID,0,-1);
$str_group_ID .= ")";



$sql_data_name = "Select * from ".$tb_data_name." where id in ".$str_group_ID;
$result_data_name = DB_run_query($sql_data_name);
while($row_cat_name = $result_cat_name->fetch_assoc()){
    $dataname["ID"] = $row_cat_name["Name"];
    
    
}
if($cat_id !=0){
    $temp_num = $row["Cat_parent"]-1000;
    $col_id = "Cat_".$temp_num;
}
$sql_group_clause = " AND ".$col_id." in ".$str_group_ID;



if($group_byDay){
    $sql_group_clause.= " group by t.Ngay, ";
    $col_name .= ", t.Ngay as Ngay";
}

$result_date_updated = DB_run_query($sql_date_updated);
while ($row_date_updated = $result_date_updated->fetch_assoc()){
    $weeklable = $row_date_updated["y"]."w".sprintf("%02d", $row_date_updated["w"]);
    $tb_name = "tb_".$weeklable;
    
    if($group_byDay){

        $sql = "SELECT ".$col_id." as ID, t.Ngay as Ngay, sum(tongTien) as tongTien, sum(soLuong) as soLuong FROM ".$tb_name." as t INNER JOIN tb_mon On tb_mon.ID = t.ID_item WHERE 1=1 ";
        $sql .= $sql_group_clause;
        $sql.= " ORDER BY t.Ngay ASC";
        $result = DB_run_query($sql);
        $pre_ngay = "";
        while ($row = $result->fetch_assoc()){
            

            if($pre_ngay != $row["Ngay"]){
                
                array_push($categoryArray, array(
                    "label" => $row["Ngay"]
                )
                );
                foreach ($Zero_value_data as $key => $value) {
                    if($value){
                        array_push($dateseries[$key], array(
                            "value" => "0"
                            )
                        );
                    }else{
                        $value = true;
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
        $result = DB_run_query($sql);
        while ($row = $result->fetch_assoc()){
            
            if($group_byDay){
                
                array_push($categoryArray, array(
                    "label" => $row["Ngay"]
                )
                );
            }else{
                array_push($categoryArray, array(
                    "label" => $weeklable
                    )
                );
            }
            
            array_push($dataseries1, array(
                "value" => $row[$str_type]
                )
            );
        
            
        }
    }
    //$sql = "SELECT tb_mon.Name, sum(tongTien) as tongTien, sum(soLuong) as soLuong FROM ".$tb_name." as t INNER JOIN tb_mon On tb_mon.ID = t.ID_item WHERE t.ID_item = 33 ";
    
    
}

include("fusioncharts.php");
$arrData = array(
    "chart" => array(
        "caption"=> "Actual Revenues, Targeted Revenues & Profits",
        "subcaption"=> "Last year",
        "xaxisname"=> "Month",
        "yaxisname"=> "Amount (In USD)",
        "numberprefix"=> "$",
        "theme"=> "ocean"
        )
      );
$arrData["categories"]=array(array("category"=>$categoryArray));
$arrData["dataset"] = array(array("seriesName"=> "Actual Revenue","renderAs"=>"line", "data"=>$dataseries1));
$jsonEncodedData = json_encode($arrData);
$mscombi2dChart = new FusionCharts("mscombi2d", "ex3", "100%", 400, "chart-1", "json",$jsonEncodedData);
   
?>
<div id="chart-1"><!-- Fusion Charts will render here--></div>
 
</body>
</html>