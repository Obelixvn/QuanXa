<?php
    $date_id = $_GET["dateID"];
    echo "Sang<br>";
    echo "<input class= \"nhap_ten\"  type = \"text\" name =\"Boi_sang[".$date_id."][]\"><br>";
    echo "<input class= \"nhap_ten\" type = \"text\" name =\"Boi_sang[".$date_id."][]\"><br>";
    echo "<input class= \"nhap_ten\" type = \"text\" name =\"Boi_sang[".$date_id."][]\">";
    
    echo "<hr>";
    echo "Chieu<br>";
    echo "<input class= \"nhap_ten\" type = \"text\" name =\"Boi_toi[".$date_id."][]\"><br>";
    echo "<input class= \"nhap_ten\" type = \"text\" name =\"Boi_toi[".$date_id."][]\"><br>";
    echo "<input class= \"nhap_ten\" type = \"text\" name =\"Boi_toi[".$date_id."][]\">";
    echo "<div class = \"button\"id = bt_updateStaff".$date_id."\">
            <button type=\"button\" onclick = \"updateStaff(".$date_id.")\">Update</button>
            </div>
            ";
   
    
?>