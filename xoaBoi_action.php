<?php
include "functions_NN.php";
$date = $_GET["Date"];
$Boi_sang_0 = $_GET["Boi_sang_Bixoa"];
$Boi_sang_1 = trim(strtoupper($_GET["Boi_sang_Dcthem"]));

$Boi_toi_0 = $_GET["Boi_toi_Bixoa"];
$Boi_toi_1 = trim(strtoupper(  $_GET["Boi_toi_Dcthem"]) );

//Boi sang
//Xoa boi sang
$sql = "
        Select Shift from `NN`.`tb_Boi_hour`
        Where Date = '".$date."' and
              Name = '".$Boi_sang_0."'

    ";


$result = DB_run_query($sql);
if ($result->num_rows > 0){
        while($row = $result->fetch_assoc()) {
            $gio_lam = $row["Shift"];
        
        }
        switch ($gio_lam) {
            case '1':
                $sql = "
                        DELETE FROM `NN`.`tb_Boi_hour`
                        Where Date = '".$date."' and
                        Name = '".$Boi_sang_0."'
                        ";
                break;
            
            case '3':
                
                $sql = "
                        UPDATE `NN`.`tb_Boi_hour`
                        SET
                        `Shift` = 2
                        WHERE 
                            Date = '".$date."' and
                            Name = '".$Boi_sang_0."'
                            
                        ";

                break;

        }
        $result = DB_run_query($sql);
}


//Them boi sang
if ($Boi_sang_1!=""){
    $sql = "
            Select Shift from `NN`.`tb_Boi_hour`
            Where Date = '".$date."' and
                Name = '".$Boi_sang_1."'

        ";
    $result = DB_run_query($sql);
    if ($result->num_rows > 0){
            while($row = $result->fetch_assoc()) {
                $gio_lam = $row["Shift"];
            
            }
            switch ($gio_lam) {
                case '2':
                    $sql = "
                            UPDATE `NN`.`tb_Boi_hour`
                            SET
                            `Shift` = 3
                            WHERE 
                                Date = '".$date."' and
                                Name = '".$Boi_sang_1."'
                                
                            ";

                    break;

            }
            $result = DB_run_query($sql);
            
    }else{
        $sql = "INSERT INTO `NN`.`tb_Boi_hour`
                        (`Date`,
                        `Name`,
                        `Shift`,
                        `Adj`,
                        `Note`)
                        VALUES
                        ('".$date."',
                        '".$Boi_sang_1."',
                        1,
                        0,
                        '')";
        $result = DB_run_query($sql);                

    }
}


//Boi toi
//Xoa boi toi
$sql = "
        Select Shift from `NN`.`tb_Boi_hour`
        Where Date = '".$date."' and
              Name = '".$Boi_toi_0."'

    ";
$result = DB_run_query($sql);
if ($result->num_rows > 0){
        while($row = $result->fetch_assoc()) {
            $gio_lam = $row["Shift"];
        
        }
        switch ($gio_lam) {
            case '2':
                $sql = "
                        DELETE FROM `NN`.`tb_Boi_hour`
                        Where Date = '".$date."' and
                        Name = '".$Boi_toi_0."'
                        ";
                break;
            
            case '3':
                
                $sql = "
                        UPDATE `NN`.`tb_Boi_hour`
                        SET
                        `Shift` = 1
                        WHERE 
                            Date = '".$date."' and
                            Name = '".$Boi_toi_0."'
                            
                        ";

                break;

        }
        $result = DB_run_query($sql);
}
//Them boi toi

if ($Boi_toi_1!=""){
    $sql = "
            Select Shift from `NN`.`tb_Boi_hour`
            Where Date = '".$date."' and
                Name = '".$Boi_toi_1."'

        ";
    $result = DB_run_query($sql);
    if ($result->num_rows > 0){
            while($row = $result->fetch_assoc()) {
                $gio_lam = $row["Shift"];
            
            }
            switch ($gio_lam) {
                case '1':
                    $sql = "
                            UPDATE `NN`.`tb_Boi_hour`
                            SET
                            `Shift` = 3
                            WHERE 
                                Date = '".$date."' and
                                Name = '".$Boi_toi_1."'
                                
                            ";

                    $result = DB_run_query($sql);        
                    break;

            }
            
            
    }else{
        $sql = "INSERT INTO `NN`.`tb_Boi_hour`
                        (`Date`,
                        `Name`,
                        `Shift`,
                        `Adj`,
                        `Note`)
                        VALUES
                        ('".$date."',
                        '".$Boi_toi_1."',
                        2,
                        0,
                        '')";
        $result = DB_run_query($sql);
    }
}
show_BoiData_BoiPage($date);
?>