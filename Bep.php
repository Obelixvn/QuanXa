<html>

<head>
    <link rel="stylesheet" href="Style.css">
    <link rel="stylesheet" href="Style_bepPage.css">
    
</head>

<body> 
<?php
        include 'Mainbar.php';
        
?> 

<script src="java_functions_NN.js">
        
        
</script>
<script src="java_functions_Bep.js">
        
        
</script>    
<div class = "headLine">
    <div class = "left_contain"> 
        <hr>
    </div>
    <div class = " fl mid_contain">
        [ Lich Bep : ]
          
    </div>
    <div class = "right_contain" >
        <hr>
    </div>
</div> 
<div>
    <input type="week" id="week_bepPage" value="<?php echo($Ngay_hom_nay->format('Y-\WW')); ?>">
    <button onclick="loadLichBep()">Load</button>
</div>    
<div id = "lich_bep" >
    
</div>   
</body>
</html>