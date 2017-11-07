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
        <td>
            <?php echo $date->format('d M Y'); ?>
        </td>
        <td>
        <?php echo $row["tong"]; ?>
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
    </div>
    <?php

}else{
    echo "Khong co du lieu";
    exit;
}

?>