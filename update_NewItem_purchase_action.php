<?php 
    include "DB_functions_NN.php";
    $date = $_POST["Date"];
    $itemName = $_POST["name"];
    $itemUnit = $_POST["unit"];
    $itemQuatity = $_POST["quality"];
    $itemSupplier = $_POST["supplier"];
    $itemCost = $_POST["cost"];
    for ($i=0; $i < count($itemName) ; $i++) { 
        $item_price[$i] = $itemCost[$i]/$itemQuatity[$i];
        $item_price[$i] = number_format((float)$item_price[$i], 2, '.', '');
        $sql = "
            INSERT INTO `NN`.`tb_items`
                    (
                    `name`,
                    `unit`,
                    `supplier`)
                    VALUES
                    (
                    '".$itemName[$i]."',
                    '".$itemUnit[$i]."',
                    '".$itemSupplier[$i]."'
                    )";
        $insert_ID = Get_insertIDQuery($sql);
        
        $sql = "
            INSERT INTO `NN`.`tb_purchase`
                (`item_id`,
                `date`,
                `quality`,
                
                `cost`,
                `price`
                )
                VALUES
                (
                ".$insert_ID.",
                '".$date."',
                ".$itemQuatity[$i].",
                ".$itemCost[$i].",
                ".$item_price[$i]."
                )";
        $result = DB_run_query($sql);
        if ($result){
            ?>
                <tr>
                        <td>
                                <i>Updated</i> <?php echo ($itemName[$i]);  ?>
                        
                        </td>
                        <td>
                                <?php echo ($itemUnit[$i]);  ?>
                        </td>
                        <td>
                                <?php echo ($itemQuatity[$i]);  ?>
                        </td>
                        <td>
                                <?php echo ($itemSupplier[$i]);  ?>
                        </td>
                        <td>
                                <?php echo ($itemCost[$i]);  ?>
                        </td>
                </tr>        
            <?
        }                  
    }
?>