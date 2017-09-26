 <?php
include "DB_functions_NN.php";
$ten= $_GET["name"];

$sql = "Select id_item,name,supplier,unit 
        From tb_items
        WHERE name like '%".$ten."%'
        ";

$result = DB_run_query($sql);
if ($result->num_rows > 0){
            
    while($row = $result->fetch_assoc()) {
?>
        <input type = "checkbox" name = "thong_ke_items[]" value = "<?php echo $row["id_item"]; ?>"/><?php echo $row["name"]; ?>[<?php echo $row["unit"]; ?>]<?php echo $row["supplier"]; ?>
        <br>
<?php
    }
}       
 ?>
