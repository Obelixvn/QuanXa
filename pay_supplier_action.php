<?php 
include "Global.php";
include "DB_functions_NN.php";
if(isset($_GET["date1"])){
    $date1 = new Datetime( $_GET["date1"]);
}else{
    echo "ko du data";
    exit;
}
if(isset($_GET["date2"])){
    $date_2 = new Datetime ( $_GET["date2"]);
}else{
    echo "ko du data";
    exit;
}
if(isset($_GET["supplier"])){
    $supplier =  $_GET["supplier"];
}else{
    echo "ko du data";
    exit;
}

$sql = "UPDATE `tb_purchase` INNER JOIN tb_items ON item_id = id_item 
        SET status = 1 
        WHERE tb_items.supplier = '".$supplier."' 
        AND tb_purchase.date >= '".$date1->format('Y-m-d')."'
        AND tb_purchase.date <= '".$date_2->format('Y-m-d')."'
        ";

$result = DB_run_query($sql);
if ($result){
    ?>
    <i>Done !__</i>Tra supplier: <u><?php echo $supplier; ?></u> tu ngay <u><?php echo $date1->format('d M Y'); ?></u> den ngay <u><?php echo $date_2->format('d M Y'); ?></u>

    <?php
}
?>