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
if (isset($_GET["monday_date"])){
    $week_pay = $_GET["monday_date"];
}
else{
    echo "No week !";
    exit;
}
if (isset($_GET["tip"])){
    $tip = $_GET["tip"];
}
else{
    $tip = 0;
}


$date = new Datetime($week_pay[0]);
echo $date->format('Y-m-d');
?>