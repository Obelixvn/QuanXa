<?php
   
    include "functions_NN.php"; 
    $date =  $_POST["date"];
    $TM = $_POST["TM"];
    $Pos = $_POST["POS"];
    $Roo = $_POST["Roo"];
    
    $TT = $_POST["TT"];
    $JE = $_POST["JE"];
    $Uber = $_POST["Uber"];
    $no_row = count($date);
    
    
    for ($i=0; $i < $no_row; $i++) { 
        if  (
            ($TM[$i]!== '') and
            ($TT[$i] !== '') and
            ($date[$i] !== '') and
            ($Pos[$i] !== '') and
            ($JE[$i] !== '') and
            ($Roo[$i] !== '') and
            ($Uber[$i] !== '') 
            )
            {
                
                $sql = "INSERT INTO `NN`.`tb_Sale`
                (`Date`,
                `Cash`,
                `Card`,
                `POS`,
                `Roo`,
                `Uber`,
                `JEat`)
                VALUES('".
                $date[$i]."',".
                $TM[$i].",".
                $TT[$i].",".
                $Pos[$i].",".
                $Roo[$i].",".
                $Uber[$i].",".
                $JE[$i]
                .")";

                $result = DB_run_query($sql);
                if($result){
                    
                     header ("Location: http://localhost/~Trang/?Date_selected=$date[0]");
                
                    
                }
                
            }
    }
    
    
?>