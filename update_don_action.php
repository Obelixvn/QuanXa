<?php
include "DB_POS.php";
include "global.php";
$log = 0;




if(isset($_GET["tableID"]) & isset($_GET["time"]) & isset($_GET["tong"]) & isset($_GET["strID"])){
    $vat = round($_GET["tong"] / 6, 2);
    $sql = "UPDATE OrderList SET Card = ".$_GET["tong"]." , VAT = ".$vat." , SaleNoneVAT = 0 ,
                                NetTotal = ".$_GET["tong"]." , Value = ".$_GET["tong"]." , Cash = 0 ,
                                Change = 0 , Total = ".$_GET["tong"]."
                                WHERE TableID = ".$_GET["tableID"]." AND OpenDateTime = '".$_GET["time"]."' ";
    
    
    $result = DB_POS_runQuery($sql);
    if ($result === FALSE){
        $log = "Update orderList false !";
    }
    else{
        $log = "Update orderList ".$_GET["tableID"].",".$_GET["time"]."  xong";
    }

    $log .= "<br>";

    $sql = "DELETE OrderItems WHERE ID in ".$_GET["strID"];
    $result = DB_POS_runQuery($sql);
    if ($result === FALSE){
        $log .= "Update orderItems false !";
    }
    else{
        $log .= "Update orderItems xong";
    }
    Echo $log;
}else{
    echo "Wrong !";
}

?>