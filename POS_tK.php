<html>
<head>


    <link rel="stylesheet" href="Style.css">
    <link rel="stylesheet" href="Style_POS_main.css">

</head>
<body>
        <script src="java_functions_NN.js">
        
        
        </script>
        <script src="java_functions_POS_main.js">
        
        
        </script>
</body>
<fieldset>
    <Legend>Thong Ke</Legend>
    <div class = "fl">
    <div id = "option_penal">
        <div>
            <button onclick = "POS_TKLoad(0)" class = "fl">Theo so Luong</button>
            <button onclick = "POS_TKLoad(1)" class = "fl">Theo so Tien</button>
        </div>
        <div class = "clearFix"></div>
        <hr>
        <div>
        <div id = "sang_chieu_toi">
            <span name = "sang_chieu_toi_select">Sang</span>
            <span name = "sang_chieu_toi_select">Chieu</span>
            <span  name = "sang_chieu_toi_select"class = "selected">Ca ngay</span>
        </div>
        <input type="range" name="" onchange ="sang_chieu_toi_select(this)" id="input_range_sang_chieu_toi" min = "1" max = "3" value = "3" >
        </div>
        <div>
            <input type="checkbox" checked name="orderType" id="">Eat In
            <input type="checkbox" checked name="orderType" id="">Take Away
            <input type="checkbox" checked name="orderType" id="">Delivery
        </div>
    </div>
    <table id = "tb_TKitems">
    </table>
    <div>
        
    </div>
    
    </div>
    <div class = "fl pad_t10" >
        TM
        <input type="date" name="" id="TM_trongNgay">
        <button onclick= "loadTienMat()">Load</button>
        <hr>
        <div id = "Paid_in_Full" >
            
        </div>
        <div id = "TM_tren_the" >
            
        </div>
        <table id = "tb_tienMat">

        </table>
        <button onclick= "Xapxep()">Xap xep</button>
        <button onclick= "loc_thongKe_TM()">Xoa Others</button>
    </div>
    <div class = "fl pad_t10" >
        Refund
        <hr>
        <input type="date" name="" id="refund_trongNgay">
        <input type="text" name="" id="refund_ten">
        <input type="number" name="" id="refund_amount">
        <button onclick = "search_order()">Tim</button>
        <div id = "result_refund">

        </div>
    </div>
    <div class = "fl pad_t10" >
        Delivery
        
        <input type="date" name="" id="del_trongNgay">
        <hr>
        <button onclick = "show_del_trongNgay()">Show</button>
        <span id = "result_ALLDel">

        </span>
        <hr>
        <button onclick = "del_trongNgay()">Xoa</button>
        
        <span id = "result_Del">

        </span>
        
    </div>
    <div class= "clearFix" id = "test"></div>
</fieldset>
<fieldset >
    <legend>Item Line</legend>
    <input type="date" name="date_itemLine" id="">
    <input type="date" name="date_itemLine" id="">
    <button onclick = "loadItemLine()">Load</button>
    <table id = "tb_itemLine">

    </table>
</fieldset>
</html>   




