<?php

    include "DB_functions_NN.php";
    $date = new Datetime($_GET["date"]);

    $supplier = $_GET["supplier"];
    $monday = $date->format('Y-m-d');
    $sunday = $date->modify('+6 day')->format('Y-m-d');
    $sql = "
        SELECT
                tb_items.name,
                sum(tb_purchase.quality) as soluong,
                sum(tb_purchase.cost) as tien,
                item_id,
                unit
                FROM `NN`.`tb_purchase`join tb_items on item_id = id_item 
                WHERE       date >= '".$monday."' 
                        and date <= '".$sunday."'
                        and supplier = '".$supplier."'

                GROUP BY item_id        
        ";
        
?>

<table class = "tb_datDoPage ">
    <tr>
        <th>Ten</th>
        <th>So luong</th>
        <th>Tien</th>
        <th></th>
    </tr>    
    
<?php
        $result = DB_run_query($sql);
            if ($result->num_rows > 0){
                $tongtien = 0;
                while($row = $result->fetch_assoc()) {
                    $tongtien += $row["tien"];
?>
                <tr>
                    <td class = "datDo_ten"><?php echo ($row["name"]) ; ?></td>
                    <td class = "datDo_quality"><?php echo ($row["soluong"]." x ".$row["unit"]) ; ?></td>
                    <td class = "datDo_tien"><?php echo money_format('%#10n',$row["tien"]) ; ?></td>
                    <td><button onclick = "get_detail_thong_keItem(<?php echo ("'".$monday."',".$row["item_id"].",'".$supplier."'"); ?>)">Xem</button></td>
                </tr>    
            <?php } ?>
            <tr>
                <td  class = "tong_tien" colspan = "2">Tong tien tuan <?php echo $date->format('W');?>:</td>
                <td class = "sum_tong"><?php echo money_format('%#10n',$tongtien); ?></td>
                <td></td>
            </tr>

<?php

                
            }
    


?>
</table>
