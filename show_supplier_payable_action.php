<?php 
include "Global.php";
include "DB_functions_NN.php";


if(isset($_GET["sup"])){
    $sup = $_GET["sup"];
}

$sql = "

    Select sum(cost) as tong, Date
    From tb_purchase INNER JOIN tb_items On item_id = id_item
    Where status = 0 and supplier = '".$sup."'
    Group By Date
";
$first_date = "0";
$result = DB_run_query($sql);
if ($result->num_rows > 0){
    ?>
    <div id = "payable_tb_supplier">
    <table>
        <tbody>
            
        
    <?php
    while($row = $result->fetch_assoc()) {
        $date = new Datetime($row["Date"]);
        if ($first_date == "0"){
            $first_date = $date->format('d M');
        }
?>
    <tr>
        <td name = "invoce_date">
            <?php echo $date->format('d M Y'); ?>
        </td>
        <td name = "supplier_invoice_amount">
             <?php echo number_format($row["tong"],2); ?>
        </td>
    </tr>
<?php
    }
    ?>
    </tbody>
    </table>
    </div>
    <div class = "payable_control">
        <div id = "supplier_name"><?php echo $sup; ?></div>
        <span><?php echo $first_date; ?> </span>
        <span class = "fr"><?php echo $date->format('d M'); ?></span>
        <br>
        <input class = "w100" onchange = "invoice_select_payabale(this)"  type="range" id="invoice_select" min = "1" value = "1" max = "<?php echo $result->num_rows; ?>">
        <div id = "total_payable">
            <div >Tong : £<span id = "tong_tien">0</span> </div>
            <div ><button onclick = "pay_supplier('<?php echo $sup; ?>')">PAY</button></div>
            <div class = "clearFix"></div>
        </div>
    </div>
    <?php

}else{
    echo "Khong co du lieu";
    exit;
}

?>