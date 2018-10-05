<html>
<head>


<script type="text/javascript" src="fusioncharts.js"></script>


</head>
<body>
<?php


//include "DB_functions_NN.php";
include "DB_functions_NN_itemline.php";
include "global.php";
$dataseries1=array();
$dataseries2=array();
$dataseries3=array();
$categoryArray=array();
$sql = "Select sum(Cash+Card) as from tb_sale";
$sql = "select DATE_FORMAT(Date, '%D %M' ) as Date, round(sum((`tb_sale`.`Card` + `tb_sale`.`Cash`)),2) AS `An_day`, round(sum(((`tb_sale`.`Roo` + `tb_sale`.`Uber`) + `tb_sale`.`JEat`)),2) AS `Extra` from `NN`.`tb_sale` where dayofweek(`NN`.`tb_sale`.`Date`) = 6 group by `tb_sale`.`Date` ";
$sql = "select Yearweek(Date,1) as Date, round(sum((`tb_sale`.`Card` + `tb_sale`.`Cash`)),2) AS `An_day`, round(sum(((`tb_sale`.`Roo` + `tb_sale`.`Uber`) + `tb_sale`.`JEat`)),2) AS `Extra` from `NN`.`tb_sale`  group by Yearweek(Date,1)  ";
$sql = "SELECT Gio,sum(soTien) as soTien FROM nn_itemline.tb_tk_theogio where dayofweek(ngay) = 2 group by  Gio ";
$result = DB_run_query($sql);
while ($row = $result->fetch_assoc()){
    array_push($categoryArray, array(
        "label" => $row["Gio"]
    )
    );
    array_push($dataseries1, array(
        "value" => $row["soTien"]
    )
    );
}
include("fusioncharts.php");
$arrData = array(
    "chart" => array(
        "caption"=> "Tong thu nhap",
        "subcaption"=> "Tu ngay bat dau",
        "xaxisname"=> "Ngay",
        "yaxisname"=> "Tien",
        "numberprefix"=> "£",
        "theme"=> "ocean"
        )
      );
$arrData["categories"]=array(array("category"=>$categoryArray));


//$arrData["dataset"] = array(array("seriesName"=> "Actual Revenue","renderAs"=>"line", "data"=>$dataseries1));
$arrData["dataset"] = array();
array_push($arrData["dataset"], array(
    "seriesName"=> "An day",
    "renderAs"=>"line", 
    "showValues" => "0",
    "data"=>$dataseries1
));


// $result = DB_run_query($sql);
// while ($row = $result->fetch_assoc()){
//     array_push($categoryArray, array(
//         "label" => $row["Date"]
//     )
//     );
//     $tongSale = $row["An_day"] +  $row["Extra"];
//     array_push($dataseries1, array(
//         "value" => $row["An_day"]
//     )
//     );
//     array_push($dataseries2, array(
//         "value" => $row["Extra"]
//     )
//     );
//     array_push($dataseries3, array(
//         "value" => $tongSale
//     )
//     );
// }


// include("fusioncharts.php");
// $arrData = array(
//     "chart" => array(
//         "caption"=> "Tong thu nhap",
//         "subcaption"=> "Tu ngay bat dau",
//         "xaxisname"=> "Ngay",
//         "yaxisname"=> "Tien",
//         "numberprefix"=> "£",
//         "theme"=> "ocean"
//         )
//       );
// $arrData["categories"]=array(array("category"=>$categoryArray));


// //$arrData["dataset"] = array(array("seriesName"=> "Actual Revenue","renderAs"=>"line", "data"=>$dataseries1));
// $arrData["dataset"] = array();
// array_push($arrData["dataset"], array(
//     "seriesName"=> "An day",
//     "renderAs"=>"line", 
//     "showValues" => "0",
//     "data"=>$dataseries1
// ));
// array_push($arrData["dataset"], array(
//     "seriesName"=> "Delivery",
//     "renderAs"=>"Area", 
//     "showValues" => "0",
//     "data"=>$dataseries2
// ));
// array_push($arrData["dataset"], array(
//     "seriesName"=> "Tong Sale",
//     "showValues" => "1",
//     "data"=>$dataseries3
// ));

$jsonEncodedData = json_encode($arrData);
$mscombi2dChart = new FusionCharts("mscombi2d", "ex3", "120%", 600, "chart-1", "json",$jsonEncodedData);

$mscombi2dChart->render();
?>
<div id="chart-1"><!-- Fusion Charts will render here--></div>
 
</body>
</html>

?>