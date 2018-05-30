<?php
//Must be DB_funtions inclued !!!
function Insert_Avg_diff($card,$cash,$roo,$uber,$jeat,$date){

$date_time = new DateTime($date);
$thu = $date_time->format('w') + 1;    
$sql_tmp = "SELECT * FROM NN.view_avg_sale WHERE Thu = ".$thu;

$result_tmp = DB_run_query($sql_tmp);

$row_tmp = $result_tmp->fetch_assoc();


$card = $card - $row_tmp["Card"];
$cash = $cash - $row_tmp["Cash"];
$roo = $roo - $row_tmp["Roo"];
$uber = $uber - $row_tmp["Uber"];
$jeat = $jeat - $row_tmp["JEat"];


$sql_tmp = "INSERT INTO `NN`.`Sale_process_atTime`
        (`date`,
        `card`,
        `cash`,
        `roo`,
        `uber`,
        `jeat`)
        VALUES
        ('".$date."',
        ".$card.",
        ".$cash.",
        ".$roo.",
        ".$uber.",
        ".$jeat."
        );
";
$result_tmp = DB_run_query($sql_tmp);
}

?>