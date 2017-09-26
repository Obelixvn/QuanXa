<?php
    include "DB_functions_NN.php";
    $week = $_GET["week"];
    $nv_id = $_GET["nv_id"];
    $d_o_w = $_GET["ca_lam"];
    var_dump ($d_o_w);
    for ($i=0; $i < count($nv_id); $i++) { 
        $sql = "
            INSERT INTO `NN`.`tb_Bep`
                        (`Week`,
                        `nv_ID`,
                        `d_o_w`
                        )
                        VALUES
                        (
                        ".$week.",
                        ".$nv_id[$i].",
                        '".$d_o_w[$i]."'
                        )

            ";
            
        $result = DB_run_query($sql);    
    }
?>