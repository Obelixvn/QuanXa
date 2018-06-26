<?php

include "DB_functions_NN_itemline.php";

$id_mon = $_POST["id_mon"];
$cat_1 = $_POST["FORD"];
$cat_2 = $_POST["Couse"];
$cat_3 = $_POST["Cook"];
$cat_4 = $_POST["Prepare"];
$cat_5 = $_POST["Menu_Cat"];
$cat_6 = $_POST["Main_Ingre_1"];
$cat_7 = $_POST["Main_Ingre_2"];
$cat_8 = $_POST["Sub_Main_Ingre_2"];

for ($i=0; $i < count($id_mon); $i++) { 
    


$sql = "
        UPDATE `nn_itemline`.`tb_mon`
        SET
        
        
        `Cat_1` = ".$cat_1[$i].",
        `Cat_2` = ".$cat_2[$i].",
        `Cat_3` = ".$cat_3[$i].",
        `Cat_4` = ".$cat_4[$i].",
        `Cat_5` = ".$cat_5[$i].",
        `Cat_6` = ".$cat_6[$i].",
        `Cat_7` = ".$cat_7[$i].",
        `Cat_8` = ".$cat_8[$i].",
        `Status` = 1
        
        WHERE `ID` = ".$id_mon[$i];



$r = DB_run_query($sql);

}
?>
OKe da nhap
							