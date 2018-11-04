<?php

function DB_POS_connect(){
    include "Server_name.php";
    $conn = sqlsrv_connect($serverName, $connectionOptions);
    if( $conn === false ) {
       die( print_r( sqlsrv_errors(), true));
    }
 
    return $conn;
} 


if(isset($_GET['ngay'])){
    $ngay = $_GET['ngay'];
    if($ngay == ''){
        $date = new Datetime();
        $ngay = $date->format('Y-m-d');
    }else{
        $date = new Datetime($ngay);
    }
    
    $ngay_1 = $date->modify('+1 day')->format('Y-m-d');
    $sql_card = "SELECT TableName,  Card 
            FROM OrderList 
            INNER JOIN Config_table On OrderList.TableID = Config_table.ID 
            WHERE OpenDateTime >= '".$ngay."' and OpenDateTime < '".$ngay_1."' 
            AND card > 0 
            AND TableID NOT IN (236,238,239,240,245)
            AND TableID NOT IN (237,241,242,243,244)
            order by Card desc";
   
    $conn = DB_POS_connect();
    
    $result_card = sqlsrv_query($conn, $sql_card);
 
    while ($row = sqlsrv_fetch_array($result_card, SQLSRV_FETCH_ASSOC)) {
        
        ?>
        <input type="checkbox" name="test" id="">
        
        <?php
        echo $row["TableName"]." - - ";
        echo $row["Card"];
        echo "<br>";
        
    }
    Echo "<hr>";
    $sql_roo = "SELECT TableName,  Total 
            FROM OrderList 
            INNER JOIN Config_table On OrderList.TableID = Config_table.ID 
            WHERE OpenDateTime >= '".$ngay."' and OpenDateTime < '".$ngay_1."' 
             
            AND TableID IN (236,238,239,240,245)
            order by OpenDateTime desc";
    $result_roo = sqlsrv_query($conn,$sql_roo );
    while ($row = sqlsrv_fetch_array($result_roo, SQLSRV_FETCH_ASSOC)) {
        
        ?>
        <input type="checkbox" name="test" id="">
        
        <?php
        echo $row["TableName"]." - - ";
        echo $row["Total"];
        echo "<br>";
        
    }
    Echo "<hr>";
    $sql_uber = "SELECT TableName,  Total 
            FROM OrderList 
            INNER JOIN Config_table On OrderList.TableID = Config_table.ID 
            WHERE OpenDateTime >= '".$ngay."' and OpenDateTime < '".$ngay_1."' 
             
            AND TableID IN (237,241,242,243,244)
            order by OpenDateTime Asc";
    $result_uber = sqlsrv_query($conn,$sql_uber );
    while ($row = sqlsrv_fetch_array($result_uber, SQLSRV_FETCH_ASSOC)) {
        
        ?>
        <input type="checkbox" name="test" id="">
        
        <?php
        echo $row["TableName"]." - - ";
        echo $row["Total"];
        echo "<br>";
        
    }
}
else{
    Echo "Error: 109";
    exit;
}
?>
