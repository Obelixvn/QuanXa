<?php
    $date_id = $_GET["dateID"];
?>    
     Sang
     <br>
     <div class = "w100 h_20"> 
      <div class = "fl tieude w33" >Xoa</div>  
    <input class= "fl w50" type = "text" name ="ten_Boisang_xoa" >
    </div>
    <br> 
    <div class = "w100 h_20">
        <div class ="fl tieude w33">Them</div>
    <input class = "fl w50" type = "text" name ="ten_Boisang_them" >
    </div>
    <hr>
    Chieu
    <br>
    <div class = "w100 h_20"> 
      <div class = "fl tieude w33" >Xoa</div>  
    <input class= "fl w50" type = "text" name ="ten_Boitoi_xoa" >
    </div>
    <br> 
    <div class = "w100 h_20">
        <div class ="fl tieude w33">Them</div>
    <input class = "fl w50" type = "text" name ="ten_Boitoi_them" >
    </div>
    

    <?php
    echo "<div class = \"button\"id = bt_updateStaff".$date_id."\">
            <button type=\"button\" onclick = \"changeStaff(".$date_id.")\">Doi</button>
            </div>
            ";
   
    ?>
