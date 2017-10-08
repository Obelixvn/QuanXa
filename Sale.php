<html>

<head>
    <link rel="stylesheet" href="Style.css">
    <link rel="stylesheet" href="Style_salePage.css">
    
</head>

<body onload = "salePage_onload()"> 
<?php
        include 'Mainbar.php';
        include 'global.php';
        
?> 

<script src="java_functions_NN.js">
        
        
</script>
<script src="java_functions_Sale.js">
        
        
</script>

<div class = "headLine">
    <div class = "left_contain"> 
        <hr>
    </div>
    <div class = " fl mid_contain">
        [ Sale : ]
          
    </div>
    <div class = "right_contain" >
        <hr>
    </div>
</div> 
<div>
    <input type="week" id="week_salePage" value="<?php echo($Ngay_hom_nay->format('Y-\WW')); ?>">
    <button onclick = "load_sale_tb()">Load</button>
</div>  
<div class = "sale_container">  
<div id = "sale_tb" >
    
</div>
</div>
<fieldset id = "income_field">
    <legend>Income recieved</legend>
    <input type = "week" id ="delivery_week_input"/>
    <button onclick = "load_delivery_taking()">Load</button>
    <table id = "tb_income">
        
    </table>    

</fieldset> 

</body>


</htnl>