<?php

$id = $_POST["id"];
$x = $_POST["x"];
$ca_lam = $_POST["ca_lam"];
include "DB_functions_NN.php";

$sql_lich = "
                        SELECT d_o_w
                        FROM tb_Bep
                        WHERE ID = ".$id."
                            
            ";
$result_lich = DB_run_query($sql_lich);
$row_lich = $result_lich->fetch_assoc();

$d_o_w = substr_replace($row_lich["d_o_w"],$ca_lam,$x,1);


$sql = "
        UPDATE `NN`.`tb_Bep`
        SET
        `d_o_w` = '".$d_o_w."'
        
        WHERE ID = ".$id;


$result = DB_run_query($sql);

?>

                        <div class = "layer_1">
                            <span>
                                <?php
                                switch ($ca_lam) {
                                    case '1':
                                        echo ("Sang");
                                    break;

                                    case '2':
                                        echo ("Chieu");
                                    break;

                                    case '0':
                                        echo ("OFF");
                                    break;
                                    
                                    
                                }
                                ?>
                            </span>
                        </div>
                        <div class = "overlay">
                            <button onclick ="show_change_BepPage(this,'bep_<?php echo $id ?>_<?php echo $x; ?>')">Change</button>  
                        </div>
                        <div class = "layer_2" id= "bep_<?php echo $id; ?>_<?php echo $x; ?>">
                            <select id = "select_ca_lam_<?php echo $id ?>_<?php echo $x;  ?>">
                                <option value = "1">Sang</option>
                                <option value = "2">Chieu</option>
                                <option value = "3">Full</option>
                                 <option value = "0">Off</option>
                            </select>
                            <button onclick = "update_lichBep(<?php echo $id;  ?>,<?php echo $x;  ?>)" class = "">Save</button>
                        </div>