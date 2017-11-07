
<div id = "do_payable_list">

<?php 
include "Global.php";
include "DB_functions_NN.php";

$sql = "SELECT SUM(cost) as tong, supplier 
        From tb_purchase INNER JOIN tb_items ON item_id = id_item
        WHERE status = 0
        GROUP BY supplier";
$result = DB_run_query($sql);
if ($result->num_rows > 0 ){
    while($row = $result->fetch_assoc()) {
?>
    <div class = "supplier_payable">
        <span><?php echo $row["supplier"]; ?></span>
        <span><?php echo money_format('%#10.2n',$row["tong"]); ?></span>
        <span> <button onclick = "show_supplier_payable('<?php echo $row["supplier"]; ?>')">PAY</button> </span>
        <div class = "clearfix"></div>
    </div>

<?php
    }
}else{
    echo "Khong no nan gi ai";
    exit;
}        

?>
</div>
<div id = "supplier_payable_tb" ></div>
