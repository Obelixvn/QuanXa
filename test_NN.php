<?php
include "DB_functions_NN_itemLine.php";

$sql = "Select * from tb_mon where cat_1 = 2 ";

$i = 0;
    $alise_id =  array();
    $sql_alias = "Select ID_item from tb_alias_item";
    $r_alias = DB_run_query($sql_alias);
    while ($row_alias = $r_alias->fetch_assoc()){
        $alise_id[$i] = $row_alias["ID_item"];
        $i++;
    }

    $result = DB_run_query($sql);
            while ($row_mon = $result->fetch_assoc()){
                if( !in_array($row_mon["ID"],$alise_id)){
                    continue;
                }else{
                    echo "--  ".$row_mon["ID"]." :  ".$row_mon["Name"]."<br>";
                }
            }

?>


