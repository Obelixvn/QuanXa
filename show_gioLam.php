<?php
include "DB_functions_NN.php";
include "global.php";

$date = new Datetime($_POST["Date"]);
$closing_time = $_POST["closing_time"] ;
$time = explode(":",$_POST["closing_time"]) ;
$hour = $time[0] + number_format($time[1]/60,1) - 6 ;

$sql_sel = "Select * from tb_gioLam 
        WHERE
            Date = '".$date->format('Y-m-d')."'";

$result = DB_run_query($sql_sel);
if ($result->num_rows > 0){
    $sql = "
        UPDATE `NN`.`tb_gioLam`
        SET
            `Chieu` = ".$hour."
        WHERE
            Date = '".$date->format('Y-m-d')."'";
}
else{
   $sang = $Gio_lam_cua_quan[$date->format('N')][0];
   $sql ="
            INSERT INTO `NN`.`tb_gioLam`
            (`Date`,
            `Sang`,
            `Chieu`)
            
            VALUES
            (
            '".$date->format('Y-m-d')."',
            ".$sang.",
            ".$hour."
            )
            ";
    
}

            
        
$result = DB_run_query($sql);



?>

<div class = "day_time_hover" >
        <?php
        
        echo $closing_time;
        ?>
</div>
<div class = "day_adj_overlay">
<input  id = "input_closing_time_<?php echo $date->format('Y-m-d'); ?>"type = "time" value = "<?php echo $closing_time;?>"/>
<button onclick="update_giolam('<?php echo $date->format('Y-m-d'); ?>')">Save</button>
</div>     