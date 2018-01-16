<html>

<head>
    <link rel="stylesheet" href="Style.css">
    <link rel="stylesheet" href="Style_boiPage.css">
</head>

<body onload = "boiPage_onload()"> 
<?php
        include 'Mainbar.php';
        include 'global.php';
?>
<script src="java_functions_NN.js"></script>
<script src="java_functions_boiPage.js"></script>
<div class ="headLine">        
    <div class = "left_contain"> 
                <hr>
    </div>        
        

    <div class = "mid_contain">
        [ Lich  Lam : ]
        <input type="week" id="week_boiPage" value="<?php echo($Ngay_hom_nay->format('Y-\WW')); ?>">
        <button onclick = "showLichBoi('week_boiPage')" >Load</button>
        
    </div>
    <div class = "right_contain" >
        <hr>
    </div>             
   
</div>
<div id = "Lich_Boi">

</div>
<div class = "headLine">
    <div class = "left_contain"> 
        <hr>
    </div>
    <div class = " fl mid_contain">
        [ Luong boi : ]
        
         
    </div>
    <div class = "right_contain" >
        <hr>
    </div>
</div>

    <div class = "mar_b_10">    
        <input type="radio" onclick = "chon_kieu_luong_thongKe(this)"id="luong_Choice1" name="thoi_gian_tinh_luong" value="tuan" checked>
            <label for="luong_Choice1">Week</label>
        <input type="radio" onclick = "chon_kieu_luong_thongKe(this)"id="luong_Choice2" name="thoi_gian_tinh_luong" value="ngay">
            <label for="luong_Choice1">Specific Time</label>
        <button onclick = "luong_boi()">Load</button>
    </div>
    

<div id = "luong_boi_theo_ngay" style = "display:none">
    Tu tuan: <input type = "week" id = "luong_boi_tuan_0">
    Den tuan: <input type = "week" id = "luong_boi_tuan_1">
</div>
<div id = "luong_boi_theo_tuan">
   
    
</div>
<table class = "w100">
    <td style ="vertical-align: top;width: 50%">
        <div id ="luong_boi_boiPage">
        </div>
    </td>
    <td style ="vertical-align: top;width: 50%">
        <div id = "Lich_lam_detail">
        </div>
    </td>
 </table>     





 

</body>

</html>