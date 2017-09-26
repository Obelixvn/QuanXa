<?php
    include "DB_functions_NN.php";
    $id = $_POST["id"];
    $adj = $_POST["adj"];
    $note = $_POST["note"];


    $sql = "
        UPDATE `NN`.`tb_Boi_hour`
        SET
        
        `Adj` = ".$adj.",
        `Note` = '".$note."'
        WHERE   id = ".$id."
                
        ";

    
        
    $result = DB_run_query($sql);
    
    $sql = "
        SELECT * from tb_Boi_hour where id = ".$id."
    ";
    $result = DB_run_query($sql);
    $row = $result->fetch_assoc();
       
?>
<div class = "layer_1_tenBoi">
        <div class = "ten_boi">
                    <?php
                        if ($row["Adj"] != 0){
                            echo "<i title = \"".$row["Note"]."\">";
                            echo ucwords(strtolower($row["Name"]));
                            echo "(".$row["Adj"].")</i>";    
                        }else{
                            echo ucwords(strtolower($row["Note"]));
                        } 
                        //echo "<br>";
                    ?> 
                     
        </div>
</div>    

<div class="overlay">
                
    <input  onclick = "show_adj_gioLam_boi(this)" type = "checkbox"/> Adj

    <input name = "adj_number_<?php echo $row["id"]; ?>"style = "width:40px" type = "number" >
    <button onclick = "save_adj_boi(<?php echo $row["id"]; ?>)">Save</button>
                
</div>