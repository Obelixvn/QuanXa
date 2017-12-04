
<?php
    include 'functions_NN.php';
    $date= $_GET["Date"];
    $item_q = $_GET["quality"];
    $item_name = $_GET["name"];
    $item_cost = $_GET["cost"];
    $supplier = $_GET["supplier"];
    if (isset($_GET["unit"])){
        $unit = $_GET["unit"];
    }
    
    $newItem = 0;
    $item_unit = array();
    $item_id = array();
    $purchase_id = array(); 
    $item_price = array();  
    if (in_array($supplier,$Credit_supplier)){
        $status = 0;
    }
    else{
        $status = 1;
    } 
    for ($i=0; $i < count($item_name) ; $i++) { 
        $sql_item ="
                Select id_item,unit from tb_items
                Where   name = '".$item_name[$i]."' and
                        supplier = '".$supplier."'
                Order by id_item        
        ";
        $item_price[$i] = $item_cost[$i]/$item_q[$i];
        $item_price[$i] = number_format((float)$item_price[$i], 2, '.', '');
        
        

        $result = DB_run_query($sql_item);
        if ($result->num_rows > 0){
            $num_item_exist = 0;
            while($row = $result->fetch_assoc()) {
                
                $item_id[$i][$num_item_exist] = $row["id_item"];
                
                $item_unit[$i][$num_item_exist] = $row["unit"];
                $num_item_exist +=1;
                
            }
            
            
        }
        else{
            
            $sql_item ="
                INSERT INTO `NN`.`tb_items`
                        (
                        `name`,
                        `supplier`,
                        `unit`
                        )
                        VALUES
                        (
                        '".$item_name[$i]."',
                        '".$supplier."',
                        '".$unit[$newItem]."'
                        );
           
            ";
            $item_id[$i][0] = Get_insertIDQuery($sql_item);
            
            $newItem++;
            
        }
        
        $sql_purchase = "
            INSERT INTO `NN`.`tb_purchase`
                    (`item_id`,
                    `date`,
                    `quality`,
                    `status`,
                    `cost`,
                    `price`
                    )
                    VALUES
                    (
                    ".$item_id[$i][0].",
                    '".$date."',
                    ".$item_q[$i].",
                    ".$status.",
                    ".$item_cost[$i].",
                    ".$item_price[$i]."
                    )";
        $purchase_id[$i] = Get_insertIDQuery($sql_purchase);
        
    }
 
if (count($purchase_id) == 0){
    echo "Khong nhap duoc vao database";
}else{
   
    $Ngay_dat_do = $date;
    $sql = "
    SELECT name,price,quality,cost,unit From tb_purchase join tb_items on tb_purchase.item_id = tb_items.id_item
    Where supplier = '".$supplier."'
    and date = '".$Ngay_dat_do."'
    

    ";

    $result = DB_run_query($sql);
    if ($result->num_rows > 0){
        include "show_listDatDo.php";
    } 
}
