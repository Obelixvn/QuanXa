<?php
include "DB_functions_NN.php";
if(isset($_GET["type"])){
    $type = $_GET["type"];
}
if(isset($_GET["status"])){
    $status = $_GET["status"];
}
?>
<table>
<thead>
    <th>Ten</th>
    
    <th>Rate</th>
    <th>Status</th>
    <th></th>
</thead>
<tbody>
<?php
    $sql = "Select * from tb_nhanVien where Role = '".$type."' and Status =".$status." Order By ID";
    
    $result_nv = DB_run_query($sql);
    if ($result_nv->num_rows >0){
        while ($row_nv = $result_nv->fetch_assoc()){
            $no_NV = $row_nv["ID"];
            $name = $row_nv["Name"];
            $rate = $row_nv["Rate"];
            $status = $row_nv["Status"];
            ?>
            <tr id = "tr_nV_<?php echo $no_NV; ?>">
                <?php
                    include "display_part_tr_tb_Staff.php";
                ?>
            </tr>

            <?php
        }
    }
?>
</tbody>
</table>