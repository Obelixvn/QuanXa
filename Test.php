<?php 

$servername = "192.168.0.107,49277";
$username = "sahara";
$password = "Tony0186";
$db = "NgonNgon";
 phpinfo();
$user = 'username';
$pass = 'password';
//Use the machine name and instance if multiple instances are used
$server = '192.168.0.107\VDIT';
//Define Port
$port='Port=49277';
$database = 'NgonNgon';

$connection_string = "DRIVER={SQL Server Native Client 10.0};SERVER=$server;$port;DATABASE=$database";
$conn = odbc_connect($connection_string,$username,$password);
?>