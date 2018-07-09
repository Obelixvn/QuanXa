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
if (isset($_GET["hour_pay"])){
    $hour_pay = $_GET["hour_pay"];
}
else{
    $hour_pay = 0;
}
$sql_rate = "
SELECT
`tb_nhanVien`.`Rate`
FROM `NN`.`tb_nhanVien`
WHERE 
    `tb_nhanVien`.`Name` ='".$name."'

";
$payByDay = false;
$result_rate = DB_run_query($sql_rate);
if($result_rate->num_rows > 0){
    $row_rate = $result_rate->fetch_assoc();
    $rate = $row_rate["Rate"];
    if ($rate > 20){
        $payByDay = true;
    } 
}else{
    $rate = 6.7;
}

$tip_rate = round($tip/$hour_pay,2);
foreach ($week_pay as $week) {
    $week_day = new Datetime($week);
    $monday = $week_day->format('Y-m-d');
    $sunday = $week_day->modify('+6 day')->format('Y-m-d');
    if ($payByDay){
        $sql = "
            Select  Shift, tb_boi_hour.Date,Adj
            From `NN`.`tb_boi_hour` 
            
            Where   tb_boi_hour.Date >= '".$monday."' and
                    tb_boi_hour.Date <= '".$sunday."'and
                    Name = '".$name."' and 
                    Paid = 0
        
                
                ";
    }else{
        $sql = "
        Select  Shift, tb_boi_hour.Date,Adj,Sang, Chieu 
        From `NN`.`tb_boi_hour` 
        Left Join `NN`.`tb_gioLam` On tb_boi_hour.Date = tb_gioLam.Date
        Where   tb_boi_hour.Date >= '".$monday."' and
                tb_boi_hour.Date <= '".$sunday."'and
                Name = '".$name."' and 
                Paid = 0
    
              
            ";
    }
    
    $result = DB_run_query($sql);
    
    $tong_gio = 0;
    if ($result->num_rows > 0){
            while($row = $result->fetch_assoc()) { 
                $date = new Datetime($row["Date"]);

                if ($payByDay){
                    switch ($row["Shift"]) {
                        case 3 :
                            $tong_gio += 1;
                            break;
                        default:
                            $tong_gio += 0.5;
                            break;        
                    }
                }
                else{
                    $thu = $date->format('N'); 
                    
                    if ($row["Sang"] == ''){
                        $giolam_sang = $Gio_lam_cua_quan[$thu][0];
                    }else{
                        $giolam_sang = $row["Sang"];
                    }
                    
                    if ($row["Chieu"] == ''){
                        $giolam_chieu = $Gio_lam_cua_quan[$thu][1];
                    }else{
                        $giolam_chieu = $row["Chieu"];
                    }
                    switch ($row["Shift"]) {
                        case 1 :
                            $tong_gio+= $giolam_sang;
                            
                            break;
                        
                        case 2 :
                            $tong_gio += $giolam_chieu;
                           
                            break;
    
                        case 3 :
                            $tong_gio += $giolam_sang + $giolam_chieu +1;
                            
                            
                            break;    
                    }
                }
                $tong_gio += $row["Adj"];
            }

        $luong = $tong_gio * $rate;
        $tip_tuan = $tong_gio * $tip_rate;
        $sql_expense_luong  ="
            
        INSERT INTO `NN`.`tb_expense`
                    (`Amount`,
                    `From`,
                    `To`,
                    `Name`,
                    `Cat 1`,
                    
                    `Cat 2`,
                    `Cat 3`)
        VALUES
                    (
                     ".$luong.",
                     '".$monday."',
                     '".$sunday."',
                     '".$name."',
                     'Luong',
                     'Boi',
                     'Basic'   
                    );
                   
        
        ";
        $paid_id = 0;
        $paid_id = Get_insertIDQuery($sql_expense_luong);
        if ($paid_id > 0){

            $sql_update_BoiHr = "
            UPDATE `NN`.`tb_boi_hour`
            SET
                `Paid` = 1,
                
                `Paid_id` = ".$paid_id."
            WHERE 
                
            tb_boi_hour.Date >= '".$monday."' and
            tb_boi_hour.Date <= '".$sunday."'and
                Name = '".$name."'
            
            ";
            $result_update = DB_run_query($sql_update_BoiHr);
            if (!$result_update){
                echo "Update Fail : Paid_id".$paid_id;
                exit;
            }

            if($tip_rate > 0){
                $sql_expense_tip  ="
                
                INSERT INTO `NN`.`tb_expense`
                            (`Amount`,
                            `From`,
                            `To`,
                            `Name`,
                            `Cat 1`,
                            
                            `Cat 2`,
                            `Cat 3`)
                VALUES
                            (
                            ".$tip_tuan.",
                            '".$monday."',
                            '".$sunday."',
                            '".$name."',
                            'Luong',
                            'Boi',
                            'Tip'   
                            );
                        
                
                ";
                $result_tip_expense = DB_run_query($sql_expense_tip);
                if (!$result_tip_expense){
                    echo "Insert Tip Date Failed";
                    exit;
                }
            }

        } 
    }

         
}

$length = count($week_pay);

?>
 <i>Done !__</i>Tra Boi: <u><?php echo $name; ?></u> tu tuan <u><?php echo $week_pay[0]; ?></u> den tuan <u><?php echo $week_pay[$length-1]; ?></u>