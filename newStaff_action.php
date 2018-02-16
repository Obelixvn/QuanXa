<?php
include "DB_functions_NN.php";

if(isset($_GET["ten"])){
    $name = $_GET["ten"];
}
if(isset($_GET["rate"])){
    $rate = $_GET["rate"];
}
if(isset($_GET["role"])){
    $role = $_GET["role"];
}
$sql = "Insert into tb_nhanVien
        (
        Name,
        Rate,    
        Role,    
        Status    
        )    
        Value
        (
         '".$name."',
         ".$rate.",
         '".$role."',
         1       
        )        
    ";
if($result = DB_run_query($sql)){
    echo "<i>Them thanh cong ".$name." vao vi tri ".$role."</i><br><br>";
    include "display_addNewStaff.php";
}
;

?>