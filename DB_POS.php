<?php 

function DB_POS_connect(){
    $serverName = "192.168.0.107\VDIT, 49277";
    $connectionOptions = array(
        "Database" => "NgonNgon",
        "Uid" => "sahara",
        "PWD" => "Tony0186"
    );
    
    //Establishes the connection
    $conn = sqlsrv_connect($serverName, $connectionOptions);
    if( $conn === false ) {
       die( print_r( sqlsrv_errors(), true));
    }
 
    return $conn;
} 

function DB_POS_runQuery($sql){
    
    $conn = DB_POS_connect();
    
    $result = sqlsrv_query($conn, $sql);
    
    if ($result === FALSE){
        
        die( print_r( sqlsrv_errors(), true));
    }else{
        return $result;
    }
    
    
}
?>