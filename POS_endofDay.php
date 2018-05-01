<?
 $serverName = "192.168.0.107\VDIT, 49277";
 $connectionOptions = array(
     "Database" => "NgonNgon",
     "Uid" => "sahara",
     "PWD" => "Tony0186"
 );
 
 //Establishes the connection
 $connPOS = sqlsrv_connect($serverName, $connectionOptions);
 if( $POS === false ) {
    die( print_r( sqlsrv_errors(), true));
 }
 ?>