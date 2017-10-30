<?php 
include "Global.php";
include "DB_functions_NN.php";

if (isset($_GET["ten"])){
    $name = $_GET["ten"];
}
else{
    echo "No Name !";
    exit;
}
if (isset($_GET["week_pay"])){
    $week_pay = $_GET["week_pay"];
}
else{
    echo "No week !";
    exit;
}
?>