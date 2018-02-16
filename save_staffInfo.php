<?php
include "DB_functions_NN.php";
if(isset($_GET["id"])){
    $no_NV= $_GET["id"];
}
if(isset($_GET["ten"])){
    $name = $_GET["ten"];
}
if(isset($_GET["rate"])){
    $rate = $_GET["rate"];
}
if(isset($_GET["status"])){
    $status = $_GET["status"];
}

$sql = "
    Update tb_nhanVien
    Set 
        Name = '".$name."',
        
        Rate = ".$rate.",
        
        Status = ".$status."
        
    
    Where ID = ".$no_NV;        
if ($result = DB_run_query($sql)){
    include "display_part_tr_tb_Staff.php";
}else{
    echo "Co loi";
}

?>