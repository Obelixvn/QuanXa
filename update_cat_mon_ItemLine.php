<?php

include "DB_functions_NN_itemline.php";


$sql_cat = "Select * from tb_mon_cat where ID > 1000 ";
$result_main_cat = DB_run_query($sql_cat);
$i = 0;
$j = 0;
$main_cat_name = array();
$sub_cat_value = array();

while($row_main_cat = $result_main_cat->fetch_assoc()){
    $main_cat_name[$i] = $row_main_cat["Name"];
    $id_main_cat = $row_main_cat["ID"];
    $sql_sub_cat = "Select * from tb_mon_cat where cat_parent = ".$id_main_cat;
    $result_sub_cat = DB_run_query($sql_sub_cat);
    $temp_a = array();
    while($row_sub_cat = $result_sub_cat->fetch_assoc()){
        $temp_a[$row_sub_cat["ID"]] = $row_sub_cat["Name"];
    }
    $sub_cat_value[$i] = $temp_a;
    $i++;
}


$sql = "Select * from tb_mon where status = 0 limit 10";
$result_mon = DB_run_query($sql);


?>
<form action="action_update_cat_mon.php" method="post">
<table>
<thead>
    <th>
        Ten
    </th>
    <?php
    for ($j=0; $j < $i; $j++) { 
        ?>
        <th>
        <?php 
            echo $main_cat_name[$j];
        ?>
        </th>
        <?php
    }
    ?>
</thead>
<tbody>
<?php
    while($row_mon = $result_mon->fetch_assoc()){
        $id = $row_mon["ID"];
        ?>
        <tr id = "<?php echo $id; ?>">
            <td>
                <input type="hidden" name="id_mon[]" value = "<?php echo $id; ?>">
                <?php echo $row_mon["Name"]; ?>
            </td>
            <?php
            for ($t=0; $t < $i; $t++) { 
                ?>
                <td>
                    <select name="<?php echo $main_cat_name[$t]; ?>[]" id="">
                        <option value="0">None</option>
                        <?php
                        foreach ($sub_cat_value[$t] as $key => $value) {
                            ?>
                            <option value="<?php echo $key ?>"><?php echo $value; ?></option>
                            <?php
                        }
                        ?>
                    </select>
                </td>
                <?php
            }
            ?>
        </tr>   
        <?php
    }
?>
</tbody>
</table>
<button>Oke</button>
</form>