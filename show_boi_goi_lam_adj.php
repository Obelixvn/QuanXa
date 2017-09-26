<?php

    include "functions_NN.php";
    
    
    $date = new Datetime ($_GET["Date"]);
    $thu = $_GET["thu"];
    if ($thu !=''){
        $ten_boi = $_GET["name"];
        $date= $date->modify('+'.$thu.' day');
        $sql_sel = 
                "
                Select * from `NN`.`tb_Boi_hour`
                Where   Date    =  '".$date->format('Y-m-d')."' and 
                        Name    =  '".$ten_boi."'
                
                ";
        $result = DB_run_query($sql_sel);
        
        if ($result->num_rows > 0){
            while($row = $result->fetch_assoc()) {
                $ten_boi = $row["Name"];
                $boi_shift = $row["Shift"];
                $boi_adj = $row["Adj"];
                $boi_note = $row["Note"];
                
            }
        }        
               

    }else{
    }
?>
<div class = "w50 h_20 mar_b_15">
    Ngay chon: <?php echo $date->format('d M Y'); ?>
</div>    

<div class = "w50  mar_b_15">
    <div class = "fl h_40 w25">
        
        [ Lam : <?php switch ($boi_shift) {
            case 1 :
                echo "Sang";
                break;
            case 2 :
                echo "Toi";
                break;
            case 3 :
                echo "Full";
                break;    
            default:
                echo "KO thay";
                break;
        }?>]
    </div>

    

    <div class = "fl h_20 w25">
         Adj: 
         <input type = "text" class = "w_30" name = "boi_adj" value = "<?php echo $boi_adj?>"/>
    </div> 

    <div class = "fl h_20 w25">
         Note :
         <button class ="fr" type = "button" onclick="update_boi_adj('<?php echo $date->format('Y-m-d'); ?>')">Update</button>               
         <textarea name = "boi_adj_note"rows = "4" cols = "50"><?php echo $boi_note?></textarea>
        
     </div> 
        
</div>

    
        
    
    
