<?php
include "functions_NN.php";
$date = $_GET["Date"];
$Boi_sang = explode(",", substr( strtoupper($_GET["Boi_sang"]),0,-1));
$Boi_toi = explode(",", substr( strtoupper($_GET["Boi_toi"]),0,-1));

foreach ($Boi_sang as $name ) {
    $name = trim($name);
    if ($name !=''){
        $sql_1 = 
        "
        Select * from `NN`.`tb_Boi_hour`
        Where Date = '".$date."' and
              Name = '".$name."' and
              (Shift = 1 or Shift = 3) 
        ";
        $result = DB_run_query($sql_1);
        if ($result->num_rows == 0){
            $sql_1 = 
            "
            Select * from `NN`.`tb_Boi_hour`
            Where Date = '".$date."' and
                Name = '".$name."' and
                Shift = 2  
            ";
            $result = DB_run_query($sql_1);
            if ($result->num_rows == 0){
                $sql_2 = "
                    INSERT INTO `NN`.`tb_Boi_hour`
                    (`Date`,
                    `Name`,
                    `Shift`,
                    `Adj`,
                    `Note`)
                    VALUES
                    ('".$date."',
                    '".$name."',
                    1,
                    0,
                    '')";
                
            }else{
                $sql_2 = 
                "
                UPDATE `NN`.`tb_Boi_hour`
                SET
                    `Shift` = 3
                WHERE 
                    Date = '".$date."' and
                    Name = '".$name."'
                ";
            }
            $result = DB_run_query($sql_2);
        }
        
        
    }     
}

foreach ($Boi_toi as $name) {
    $name = trim($name);
    if ($name !='') {
        $sql_1 = 
        "
        Select * from `NN`.`tb_Boi_hour`
        Where Date = '".$date."' and
              Name = '".$name."' and
              (Shift = 2 or Shift = 3) 
        ";
        $result = DB_run_query($sql_1);
        if ($result->num_rows == 0){
            $sql_1 = 
            "
            Select * from `NN`.`tb_Boi_hour`
            Where Date = '".$date."' and
                Name = '".$name."' and
                Shift = 1  
            ";
            $result = DB_run_query($sql_1);
            if ($result->num_rows > 0){
                $sql_2 = 
                "
                UPDATE `NN`.`tb_Boi_hour`
                SET
                    `Shift` = 3
                WHERE 
                    Date = '".$date."' and
                    Name = '".$name."'
                ";
            }else{
                $sql_2 =
                "
                INSERT INTO `NN`.`tb_Boi_hour`
                (`Date`,
                `Name`,
                `Shift`,
                `Adj`,
                `Note`)
                VALUES
                ('".$date."',
                '".$name."',
                2,
                0,
                '')
                ";
            }
            $result = DB_run_query($sql_2);
        }
            
    }
    
       
}
show_BoiData_BoiPage($date);
?>