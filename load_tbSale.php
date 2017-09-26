<?php
include "DB_functions_NN.php";
include "global.php";
$date = new Datetime($_GET["date"]);




?>
<div class = "tb_sale_colums">
        <div class = "tb_sale_items thu">
        </div> 
        <div class = "tb_sale_items card">
            <span class = " ">Card</span>
        </div> 
        <div class = "tb_sale_items cash">
            <span class = " ">Cash</span>
        </div> 
        <div class = "tb_sale_items tong_tien">
            <span class = "">Eat in</span>
        </div> 
        <div class = "tb_sale_items jeat">
            <span class = " ">JEat</span>
        </div> 
        <div class = "tb_sale_items uber">
            <span class = " ">Uber</span>
        </div>
        <div class = "tb_sale_items roo">
            <span class = "">Roo</span>
        </div>
        <div class = "tb_sale_items tong_tien">
            <span class = "">Eat out</span>
        </div>
        <div class = "tb_sale_items item_tong">
            <span class = "">Tong</span>
        </div>    
</div> 
<?php 
    $tong_cash = 0;
    $tong_card = 0;
    $tong_jeat = 0;
    $tong_roo =0;
    $tong_uber = 0;
    $tong_eatIn = 0;
    $tong_eatOut = 0;
    $tong_tuan =0;
    for ($i=1; $i < 8; $i++) { 
        $sql_sel = "

        SELECT * from tb_sale
        WHERE Date = '".$date->format('Y-m-d')."'
";

        $result = DB_run_query($sql_sel);
        $money_style = '%.2n';
        
?>
<div id = "sale_<?php echo $date->format('D'); ?>" class = "tb_sale_colums">
    <div class = "tb_sale_items thu">
        <input type = "hidden" id = "<?php echo $date->format('D'); ?>_thu" value = "<?php echo $date->format('Y-m-d'); ?>"/>
        <?php echo $date->format('D'); ?>
        
    </div>    
    <?php
        
        if ($result->num_rows >0){
            
            
            $row = $result->fetch_assoc();
            $tong_cash += $row["Cash"];
            $tong_card += $row["Card"];
            $tong_jeat += $row["JEat"];
            $tong_roo += $row["Roo"];
            $tong_uber += $row["Uber"];
            
            $eat_in = $row["Cash"] + $row["Card"];
            $eat_out = $row["Roo"] + $row["JEat"]+ $row["Uber"];
            $tong = $eat_in+$eat_out;
            $tong_eatIn +=$eat_in;
            $tong_eatOut += $eat_out;
            $tong_tuan += $tong;
    ?>
            <div class = "tb_sale_items item card">
                <span class = " "><?php echo( money_format($money_style,$row["Card"])); ?></span>
            </div> 
            <div class = "tb_sale_items item cash">
                <span class = " "><?php echo money_format($money_style,$row["Cash"]); ?></span>
            </div> 
            <div class = "tb_sale_items item tong_tien">
                <span class = "eat_in"><?php echo money_format($money_style,$eat_in); ?></span>
            </div>
            <div class = "tb_sale_items item jeat">
                <span class = " "><?php echo money_format($money_style,$row["JEat"]); ?></span>
            </div> 
            <div class = "tb_sale_items item uber">
                <span class = " "><?php echo money_format($money_style,$row["Uber"]); ?></span>
            </div>
            <div class = "tb_sale_items item roo">
                <span class = ""><?php echo money_format($money_style,$row["Roo"]); ?></span>
            </div> 
            <div class = "tb_sale_items item tong_tien">
                <span class = "eat_out"><?php echo money_format($money_style,$eat_out); ?></span>
            </div>
            <div class = "tb_sale_items item item_tong ">
                <span class = "tong_sale"><?php echo money_format($money_style,$tong); ?></span>
            </div>   
    <?php
        }else{
        
?>
            <div class = "tb_sale_items item card">
                <input oninput="add_tong(this)" name = "<?php echo $date->format('D'); ?>_sale" type = "number" min ="0" class = "card"/>
            </div> 
            <div class = "tb_sale_items item cash">
                <input oninput="add_tong(this)" name = "<?php echo $date->format('D'); ?>_sale" type = "number" min ="0" class = "cash"/>
            </div> 
            <div class = "tb_sale_items item tong_tien">
                <span name = "eat_in_<?php echo $date->format('D'); ?>"></span>
            </div>
            <div class = "tb_sale_items item jeat">
                <input  oninput="add_tong(this)" name = "<?php echo $date->format('D'); ?>_sale" type = "number" min ="0" class = "jeat"/>
            </div> 
            <div class = "tb_sale_items item uber">
                <input  oninput="add_tong(this)"name = "<?php echo $date->format('D'); ?>_sale" type = "number" min ="0" class = "uber"/>
            </div>
            <div class = "tb_sale_items item roo">
                <input  oninput="add_tong(this)"name = "<?php echo $date->format('D'); ?>_sale" type = "number" min ="0" class = "roo"/>
            </div>
            <div class = "tb_sale_items item tong_tien">
                <span name = "eat_out_<?php echo $date->format('D'); ?>"></span>
            </div>
            <div class = "tb_sale_items item item_tong">
                <span name = "tong_sale_<?php echo $date->format('D'); ?>"></span>
            </div> 
            <div class = "tb_sale_items item_button">
                <button onclick="save_daySale('<?php echo $date->format('D'); ?>')">Update</button>
            </div>
            
<?php
        }
?>
</div>
<?php
    $date->modify('+1 day');
    }
    $sql_expense = "
        SELECT sum(amount) as expense
        FROM tb_expense
        WHERE   tb_expense.`To` = '".$date->modify('-1 day')->format('Y-m-d')."' and
                tb_expense.`FROM` = '".$date->modify('-6 day')->format('Y-m-d')."' and
                `Cat 1` = 'Delivery charge'
    ";
    $result_expense = DB_run_query($sql_expense);

?>    
<div class = "tb_sale_colums">
        <div class = "tb_sale_items thu">
            
        </div> 
        <div class = "tb_sale_items item card">
            <span class = " "><?php echo money_format($money_style,$tong_card); ?></span>
        </div> 
        <div class = "tb_sale_items item cash">
            <span class = " "><?php echo money_format($money_style,$tong_cash);?></span>
        </div> 
        <div class = "tb_sale_items item tong_tien">
            <span class = ""><?php echo money_format($money_style,$tong_cash+$tong_card);?></span>
        </div> 
        <div class = "tb_sale_items item jeat">
            <span class = " "><?php echo money_format($money_style,$tong_jeat);?></span>
        </div> 
        <div class = "tb_sale_items item uber">
            <span class = " "><?php echo money_format($money_style,$tong_uber); ?></span>
        </div>
        <div class = "tb_sale_items item roo">
            <span class = ""><?php echo money_format($money_style,$tong_roo); ?></span>
        </div>
        <div class = "tb_sale_items item tong_tien">
            <span class = ""><?php echo money_format($money_style,$tong_eatOut);?></span>
        </div>
        <div class = "tb_sale_items item item_tong">
            <span class = ""><?php echo money_format($money_style,$tong_tuan);?></span>
        </div>
        <?php 
        if ($result_expense->num_rows > 0){
            $row_delCharge = $result_expense->fetch_assoc();
            $del_charge = $row_delCharge['expense'];

        
        ?>
        <div class = "tb_sale_items item item_tong">
            <i class = "">(<?php echo money_format($money_style,$del_charge);?>)</i>
        </div> 
        <div class = "tb_sale_items item item_tong">
            <span class = ""><?php echo money_format($money_style,($tong_tuan-$del_charge));?></span>
        </div> 
        <?php 
        }
        ?>    
</div>
