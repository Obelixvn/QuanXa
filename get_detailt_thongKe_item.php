<?php 
include "DB_functions_NN.php";
include "global.php";
$date = new Datetime ($_GET["date"]);
$id = $_GET["item"];
$monday = $date->format('Y-m-d');
$sunday = $date->modify('+6 day')->format('Y-m-d');

$sql = "

    Select name,unit from tb_items where id_item = ".$id;

$result = DB_run_query($sql);
    if ($result->num_rows > 0){
        while($row = $result->fetch_assoc()) {
            $item_name = $row["name"];
            $unit = $row["unit"];
        }
    } 
       
?>

<i><u><?php echo strtoupper($item_name)."  -  Tuan:".$date->format('W'); ?></u></i>
<table class = "w100 ">
    <tr>
        <th class = "w25">Ngay</th>
        <th class = "w25">So luong</th>
        <th class = "w25">Gia</th>
        <th class = "w25">Tien</th>
    </tr>
 <?php

    $sql = "
        SELECT  cost,
                price,
                quality,
                date
        FROM `NN`.`tb_purchase`
        WHERE       date >= '".$monday."' 
                and date <= '".$sunday."'
                and item_id = '".$id."'

        ORDER BY date       
        ";
    $result = DB_run_query($sql);
    if ($result->num_rows > 0){
        $tongtien = 0;
        $tongsll = 0;
        while($row = $result->fetch_assoc()) { 
            $date = new Datetime($row["date"]);
            $tongtien += $row["cost"];
            $tongsll += $row["quality"];
?>
            <tr>
            <td><i><?php echo $date->format('l');?></i></td>
            <td class = "datDo_quality"><?php echo $row["quality"]." x ".$unit; ?></td>
            <td class = "datDo_gia"><?php echo money_format('%#10n',$row["price"]); ?></td>
            <td class = "datDo_tien"><?php echo money_format('%#10n',$row["cost"]); ?></td>
            </tr>
            
<?php        }
?>
            <tr>
                <td class = "tieude">Tong tuan:</td>
                <td class = "bor_t1 txt_c"><?php echo $tongsll." x ".$unit; ?></td>
                <td></td>
                <td class = "sum_tong"> <?php echo money_format('%#10n',$tongtien); ?></td>
                <td> </td>
            </tr>
<?php
    }   

 ?>   

</table>    