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
        <div id = "div_test">
        </div>
        
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
        
        <input type="date" name="" id="date_suaDon">
        <input type="text" name="" id="ten_suaDon">
        <input type="number" name="" id="tien_suaDon">
        <hr>
        <button  onclick = "show_del_trongNgay()">Show</button>
        <div id = "result_ALLDel">

        </div>
        <div id = "result_action_ALLDel">

        </div>
        
        
        
    </div>
    <div class= "clearFix" id = "test"></div>
    <div class = "fl pad_t10" >
        Money exchange
        
        <br>
        <input type="checkbox" name="" id="auto_tinh">
        <table>
            <tbody>
                <tr>
                    <td>
                    <input type="date" name="" id="Ex_date_suaDon">
                    </td>
                    <td>
                        <input type="text" name="" id="Ex_ten_goc">
                    </td>
                    <td>
                        <input type="number" name="" id="Ex_tien_goc">
                    </td>
                    
                    <td>
                    <button onclick = "lock_don()" >Lock</button>
                    </td>
                    <td id = "lock_result">
                    </td> 
                    
                    
                </tr>
                <tr>
                    <td><input type="date" name="" id="date_chuyen_Ex"></td>
                    <td>
                    <input type="text" name="" id="ten_den_Ex">
                    </td>
                    <td>
                    <input type="number" name="" id="tien_den_Ex">
                    </td>
                    <td>
                
                    <input disabled type="text" name="" id="gio_den_Ex">
                    <input  type="text" name="" id="gio_tra_Ex">
                    </td>
                    <td>
                    <button onclick = "chuyen_don()" >TXD</button>
                    </td>
                </tr>
            </tbody>
        </table>
        
        
       
        
        
        
    </div>
    <div class= "clearFix" id = "test"></div>
</fieldset>
<fieldset >
    <legend>Item Line</legend>
    <input type="date" name="date_itemLine" id="">
    <input type="date" name="date_itemLine" id="">
    <button onclick = "loadItemLine()">Load</button>
    <input type="checkbox" name="" id="check_save_andLoad">Save&Load
    <table >
        <tbody id = "tb_itemLine" >
        </tbody>

    </table>
</fieldset>
</html>   




