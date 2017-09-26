<?php 
$date = $_GET["date"];
$sale = $_GET["day_sale"];

include "DB_functions_NN.php";
include "global.php";
$sql ="
    INSERT INTO `NN`.`tb_Sale`
    (`Date`,
    `Card`,
    `Cash`,
    `JEat`,
    `Uber`,
    `Roo`)
    VALUES
    (
    '".$date."',
    ".$sale[0].",
    ".$sale[1].",
    ".$sale[2].",
    ".$sale[3].",
    ".$sale[4]."
    );
";

$result = DB_run_query($sql);
$date = new Datetime($date);
$money_style = '%.2n';
$eat_in = $sale[0]+$sale[1];
$eat_out = $sale[2] +$sale[3] +$sale[4];
$tong = $eat_in +$eat_out;
?>

<div id = "sale_<?php echo $date->format('D'); ?>" class = "tb_sale_colums">

    <div class = "tb_sale_items thu">
        <input type = "hidden" id = "<?php echo $date->format('D'); ?>_thu" value = "<?php echo $date->format('Y-m-d'); ?>"/>
        <?php echo $date->format('D'); ?>
        
    </div>    
    
            <div class = "tb_sale_items item card">
                <span class = " "><?php echo money_format($money_style,$sale[0]); ?></span>
            </div> 
            <div class = "tb_sale_items item cash">
                <span class = " "><?php echo money_format($money_style,$sale[1]); ?></span>
            </div> 
            <div class = "tb_sale_items item tong_tien">
                <span class = "eat_in"><?php echo money_format($money_style,$eat_in); ?></span>
            </div>
            <div class = "tb_sale_items item jeat">
                <span class = " "><?php echo money_format($money_style,$sale[2]); ?></span>
            </div> 
            <div class = "tb_sale_items item uber">
                <span class = " "><?php echo money_format($money_style,$sale[3]); ?></span>
            </div>
            <div class = "tb_sale_items item roo">
                <span class = ""><?php echo money_format($money_style,$sale[4]); ?></span>
            </div>
            <div class = "tb_sale_items item tong_tien">
                <span class = "eat_out"><?php echo money_format($money_style,$eat_out); ?></span>
            </div>
            <div class = "tb_sale_items item item_tong ">
                <span class = "tong_sale"><?php echo money_format($money_style,$tong); ?></span>
            </div>    
    
</div>