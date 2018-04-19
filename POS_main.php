<html>
<head>


    <link rel="stylesheet" href="Style.css">
    <link rel="stylesheet" href="Style_POS_main.css">

</head>
<body onload = "POS_mainLoad()">
        <script src="java_functions_NN.js">
        
        
        </script>
        <script src="java_functions_POS_main.js">
        
        
        </script>
</body>
<fieldset>
    <Legend>Order</Legend>
    <table id = "tb_orderList">
    </table>
    <div id  = "Delivery_status">
       DELIVERY: 
       <button onclick = "reload_DELstatus()">Reload</button>
       <button onclick = "release_DELstatus()" >Release</button>
       <hr>
        <div id = "tb_Del_order"></div>

        
    </div>
</fieldset>
</html>   




