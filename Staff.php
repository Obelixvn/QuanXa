<html>
<head>
<?php
include "Mainbar.php";
?>

    <link rel="stylesheet" href="Style.css">
    <link rel="stylesheet" href="Style_Staff.css">

</head>
<body>
        <script src="java_functions_NN.js">
        
        
        </script>
        <script src="java_functions_Staff.js">
        
        
        </script>
</body>
<fieldset>
    <Legend>Staff</Legend>
    <div>
        Hien thi theo: <input type="radio" name="tb_staff_hienthi" value = "Boi" checked >Boi
        <input type="radio" name="tb_staff_hienthi" value = "Bep">Bep
        <input type="hidden" id="on_off_input" value = '1'>
        <div>
            <button class = "on_off_button on_button"onclick = "on_off_tb_staff(this)">On</button>
            <button onclick = "load_tb_staff()">Load</button>
        </div>
    </div>
    <div id = "tb_Staff"></div>
    <hr>
    <div id = "newStaff_info">
        <?php include "display_addNewStaff.php" ?>
    </div>
</fieldset>
</html>   

