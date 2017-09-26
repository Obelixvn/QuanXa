<?php
$supplier = $_GET["supplier"];
$Ngay_dat_do = $_GET["ngay_dat_do"];
?>

<p id = "list_doDat_<?php echo ($supplier)?>">
    <?php
    include "show_do_dat_trong_ngay.php";
    ?>
</p> 
<hr>
<p>
    <?php
    include "Dat_do_hang_ngay.php"; 
    ?>
</p>       