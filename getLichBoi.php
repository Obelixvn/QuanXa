<head>
    <link rel="stylesheet" href="Style.css">
</head>
<table id= "boi_tb">
<tr>
<?php
    include "functions_NN.php";
    //include "global.php";
    $date = new Datetime($_GET["date"]);
    $r = array("Mon","Tue","Wed","Thur","Fri","Sat","Sun");
    for ($j=1; $j <= count($r); $j++) { 
?>
    <th title = "<?php echo $date->format('d-m-Y');?>" class = "">
        <div class = "day_layer_1 day_<?php echo $r[$j-1]; ?>">
            <?php echo $r[$j-1]; ?>
        </div>
        <div class = "day_container" id = "closing_time_<?php echo $date->format('Y-m-d'); ?>">
                
                
                <div class = "day_time_hover" >
                    <?php
                    $sql = "
                            SELECT
                                
                                `tb_gioLam`.`Chieu` as gioLam

                            FROM `NN`.`tb_gioLam`

                            WHERE
                                `tb_gioLam`.`Date` = '".$date->format('Y-m-d')."'";
                                
                            
                    $result = DB_run_query($sql);
                    if ($result->num_rows > 0){
                        $row = $result->fetch_assoc();
                        
                        $time = 6 + $row["gioLam"];
                    }
                    else{
                        $time = 6 + $Gio_lam_cua_quan[$date->format('N')][1];
                        
                        
                    }
                    $closing_time = sprintf('%02d:%02d', (int) $time, fmod($time, 1) * 60);
                    echo $closing_time;
                    ?>
                </div>
                <div class = "day_adj_overlay">
                    <input  id = "input_closing_time_<?php echo $date->format('Y-m-d'); ?>"type = "time" value = "<?php echo $closing_time;?>"/>
                    <button onclick="update_giolam('<?php echo $date->format('Y-m-d'); ?>')">Save</button>
                </div>    
        </div>


           
    </th>
<?php
        
        $date->modify('+1 day');
    }
?>
</tr>
<tr>
    <?php
        
        
        $date = new Datetime($_GET["date"]);
        
        
        for ($i=1; $i<=7 ; $i++) {
            echo "<td id = \"".$date->format('Y-m-d')."\">"; 
            show_BoiData_BoiPage($date->format('Y-m-d'));
            echo "</td>";
            $date->modify('+1 day');
        }
        
    ?>
</tr>
</table>