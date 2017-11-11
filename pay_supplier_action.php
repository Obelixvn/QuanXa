<?php 
include "Global.php";
include "DB_functions_NN.php";
if(isset($_GET["date1"])){
    $date1 = new Datetime( $_GET["date1"]);
}
if(isset($_GET["date2"])){
    $date_2 = new Datetime ( $_GET["date2"]);
}
if(isset($_GET["supplier"])){
    $supplier =  $_GET["supplier"];
}

$thu = $date1->format('N');
$start_midOf_week = "No";
$end_midOf_week = "No";
if ($thu <> 1){
    $start_midOf_week = "Yes";
}
$monday = $date1->modify('-'.$thu.'day')->format('Y-m-d');
$partly = "";
do {
    $monday =  $date1->modify('+1 day')->format('Y-m-d');
    $sunday = $date1->modify('+6 day')->format('Y-m-d');
    if ($date1 > $date_2){
       
        $end_midOf_week = "Yes";
    }

    $sql = "
    
        Select sum(cost) as tong
        From tb_purchase INNER JOIN tb_items On item_id = id_item
        Where status = 0 and supplier = '".$supplier."'
        and Date >= '".$monday."' and Date <=   
    ";
    if ( $end_midOf_week == "Yes"){
        $sql .= "'".$date_2->format('Y-m-d')."'";
    }
    else{
        $sql .= "'".$sunday."'";
    }   
    $result = DB_run_query($sql);
    if ($result->num_rows > 0){
        $row = $result->fetch_assoc();
        $tien = $row["tong"];
    }
    
        


    if( $start_midOf_week == "Yes"){
        //Update tb_expense
        $sql_expense = "UPDATE `tb_expense` 
                        SET `Amount`=[value-1],`From`=[value-2],`To`=[value-3],`Name`=[value-4],`Cat 1`=[value-5],`ID`=[value-6],`Cat 2`=[value-7],`Cat 3`=[value-8] 
                        WHERE 1";
        $start_midOf_week = "No";
    }else{
        $sql_expense = "INSERT INTO `tb_expense`(`Amount`, `From`, `To`, `Name`, `Cat 1`, `ID`, `Cat 2`, `Cat 3`) 
                                        VALUES ([value-1],[value-2],[value-3],[value-4],[value-5],[value-6],[value-7],[value-8])";

    }

    echo $sql_expense;
    
    

    
    
    

    
    
} while ($date1 < $date_2 );


?>