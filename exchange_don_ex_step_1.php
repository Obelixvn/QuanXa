<?php

include "DB_POS.php";
include "global.php";

$auto = 0;

if(isset($_GET["auto"])){
    $auto = $_GET["auto"];
}
if(isset($_GET["date"])){
    
    $date = new DateTime($_GET["date"]);
    $date_0 = $date->format('Y-m-d');
    $date_1 = $date->modify(' +1 day ')->format('Y-m-d'); 
}else{

    $newDate = new Datetime();
    $date_0 = $newDate->format('Y-m-d');
    
    $date_1 = $newDate->modify(' +1 day ')->format('Y-m-d'); 
}
if (isset($_GET["ten_den"]) & isset($_GET["tien_den"]) & isset($_GET["tableID_goc"]) & isset($_GET["time"])  & isset($_GET["time_moi_ex"]) ){
    $conn = DB_POS_connect();
    $log = "";
    $ten = $_GET["ten_den"];
    $tien = $_GET["tien_den"];
    $time_moi_ex = $_GET["time_moi_ex"];
    //Don moi
    $sql_order_den = "SELECT TableID, OpenDateTime FROM OrderList INNER JOIN Config_table On OrderList.TableID = Config_table.ID
            WHERE OpenDateTime >= '".$date_0."' AND OpenDateTime <= '".$date_1."' AND 
            Config_table.TableName = '".$ten."' AND OrderList.Total = ".$tien." ORDER BY OpenDateTime DESC";
           
    $result_order_den = sqlsrv_query($conn, $sql_order_den);
    if ($result_order_den == FALSE){
        echo "Khong tim dc don den";
        die( print_r( sqlsrv_errors(), true));
    }else{
        $row_order_den = sqlsrv_fetch_array($result_order_den, SQLSRV_FETCH_ASSOC);
        $old_tableID = $row_order_den["TableID"];
        $old_openTime = $row_order_den["OpenDateTime"]->format('Y-m-d H:i:s');
        $log .= "Tim dc don den luc: ".$old_openTime."<br>";
        
    }
    
    //Exchange money
    if($auto == 0){
        $sql_ex_order = "   UPDATE OrderList SET OpenDateTime = '".$time_moi_ex."' ,CloseDateTime = '".$time_moi_ex."' WHERE TableID = ".$old_tableID."  AND OpenDateTime = '".$old_openTime."';
        UPDATE OrderItems SET OpenDateTime = '".$time_moi_ex."'  WHERE TableID = ".$old_tableID."  AND OpenDateTime = '".$old_openTime."' ";


    }else{
        $sql_ex_order = "   UPDATE OrderList SET Status = 0, CloseOrder = 2, SaleNoneVAT = Total, Card = Total, OpenDateTime = '".$time_moi_ex."' ,CloseDateTime = '".$time_moi_ex."' WHERE TableID = ".$old_tableID."  AND OpenDateTime = '".$old_openTime."';
        UPDATE OrderItems SET OpenDateTime = '".$time_moi_ex."'  WHERE TableID = ".$old_tableID."  AND OpenDateTime = '".$old_openTime."' ";

    }

    $result_ex_order = sqlsrv_query($conn, $sql_ex_order);
    //$log .= $sql_ex_order."<br>";
    if ($result_order_den === FALSE){
        $log.= "Khong exchange dc <br>";
        echo $log;
        die( print_r( sqlsrv_errors(), true));
    }else{
        $log.= "Exchange order to:".$time_moi_ex."<br>";
        
    }


    // $sql_ex_items = "";
    // $result_ex_items = sqlsrv_query($conn, $sql_ex_items);
    // if ($result_ex_items === FALSE){
    //     $log.= "Khong exchange dc <br>";
    //     echo $log;
    //     die( print_r( sqlsrv_errors(), true));
    // }else{
    //     $log.= "Exchange items to:".$time_moi_ex."<br>";
    
    // }
    

    //Don goc
    $tableID_goc = $_GET["tableID_goc"];
    $time = $_GET["time"];
    $sql_order = "  DELETE FROM OrderList WHERE TableID = ".$tableID_goc."  AND OpenDateTime = '".$time."';
                    DELETE FROM OrderItems WHERE TableID = ".$tableID_goc."  AND OpenDateTime = '".$time."'  
                ";
    
    
    if($auto == 1){
        $result_order= sqlsrv_query($conn, $sql_order);
        //$log .= $sql_order."<br>";
        if($result_order === false ){
            $log.= "Ko dc - order<br>";
            echo $log;
            exit;
        }else{
            $log.= "Order xong<br>";
        }
    }

    // $sql_item = "";
    // $result_item = sqlsrv_query($conn, $sql_item);
    // if($result_item === false ){
    //     $log.= "Ko dc - item<br>";
    //     echo $log;
    //     exit;
    // }else{
    //     $log.= "Item xong<br>";
    // }
    echo $log;
    sqlsrv_close($conn);
}else{
    echo "Error 101";
}

?>