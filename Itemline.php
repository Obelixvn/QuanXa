<html>
<head>
    <link rel="stylesheet" href="Style.css">
    <link rel="stylesheet" href="Style_itemLine.css">
</head>

<body onload = "load_TOP_item()">
<script src="java_functions_NN.js"></script>    
<script src="java_functions_NN_itemline.js"></script>
<fieldset >
    <legend>
    Thong Ke Item Line
    </legend>
    <div id = "control_panel" class = "fl">
        <div id = "title_top">
            TOP: <select name="TOP_count" id="TOP_count">
                    <Option value = "10">10</Option>
                    <Option value = "20">20</Option>
                    <Option value = "1">ALL</Option>
                    <Option value = "-10">(-10)</Option>
                    <Option value = "-20">(-20)</Option>
                    <Option value = "-1">(-ALL)</Option>
                </select>
        </div> 
        <div id = "time_span">
            <div>
                <input type="radio" checked = "checked" onclick = "select_time(0)"name="time_option"  value = "0" id=""> ALL
            </div>
            <div>
            <input type="radio" onclick = "select_time(1)" name="time_option" value = "1" id="">
            From: <input type="week" id = "input_week_0" disabled = "disabled" >
            To: <input type="week" id = "input_week_1" disabled = "disabled">
            </div>
        </div>
        <hr>
        <div id = "sang_chieu_toi">
            <span name = "sang_chieu_toi_select">Sang</span>
            <span name = "sang_chieu_toi_select">Chieu</span>
            <span  name = "sang_chieu_toi_select"class = "selected">Ca ngay</span>
        </div>
        <input type="range" name="" onchange ="sang_chieu_toi_select(this)" id="input_range_sang_chieu_toi" min = "1" max = "3" value = "3" >
        <button onclick = "load_TK_top()">Load Top</button>
        <br>
        <input type="radio"  checked = "checked"name="type_option" value = "1" id="">Theo so Luong
        <input type="radio"  name="type_option" value = "2" id="">Theo Sale
        
        <hr>

    </div>
    <div id = "TOP_Order" class = "Top_tb fr">
        TOP ORDER
        <hr>
        <table>
            
            <tbody id= "tb_TOP_Order">
                
            </tbody>
        </table>
    </div>
    <div id = "TOP_Sale" class = "Top_tb fr">
        TOP SALE
        <hr>
        <table>
            
            <tbody id= "tb_TOP_Sale">
                
            </tbody>
        </table>
    </div>
    <div id = "TK_top" class ="fl" >
        <div id = "title_TK_top"></div>
        <hr>
        <table>
            <tbody id = "tb_TK_top">
                
            </tbody>
        </table>
    </div>
    <div class = "clearFix"></div>
</fieldset> 
<div id = "cat_select">
        <div>
            <input onclick = "text_input_click(this)" type="text" id="ten_mon" value = "Ten mon an"> 
            <button>Xem tat ca</button>
            <hr>
        </div>
        <div class = "fl">
            <div class = "button_cat cat_1">
                <button onclick = "cat_select(1)"><span>Do Nuoc</span> </button>
                <button onclick = "cat_select(2)"><span>Do xao</span> </button>
                <button onclick = "cat_select(3)"><span>Goi&Nom</span></button>
                
            </div>
            <hr style = "margin-right: 10px;">
            <div class = "button_cat cat_2">
                <button onclick = "cat_select(11)"><span>Com</span> </button>
                <button onclick = "cat_select(12)"><span>My</span> </button>
                <button onclick = "cat_select(13)"><span>Bun</span></button>
                <button onclick = "cat_select(14)"><span>Pho</span></button>
                
                
            </div>
            <hr style = "margin-right: 10px;">
            <div class = "button_cat cat_3">
                
                <button onclick = "cat_select(21)"><span>Sofl Drink</span></button>
                <button onclick = "cat_select(22)"><span>Wine</span></button>
                <button onclick = "cat_select(23)"><span>Juice</span></button>
                <button onclick = "cat_select(24)"><span>Dessert</span></button>
                
            </div>
            <hr style = "margin-right: 10px;">
            <div class = "button_cat cat_4">
                
                <button onclick = "cat_select(31)"><span>Thit Bo</span></button>
                <button onclick = "cat_select(32)"><span>Thit Ga</span></button>
                <button onclick = "cat_select(33)"><span>Tom</span></button>
                <button onclick = "cat_select(34)"><span>Muc</span></button>
                <button onclick = "cat_select(35)"><span>Ca</span></button>
                <button onclick = "cat_select(36)"><span>Diep</span></button>
                <button onclick = "cat_select(36)"><span>Tofu</span></button>
                
            </div>
            
        </div>
        <div id = "cat_selected">
                <div name = "cat_name" >Do nuoc</div>
                <div name = "cat_name">Do xao</div>
                <div name = "cat_name">Goi&nom</div>

                <div class = "group_1"name = "cat_name_1">Com</div>
                <div class = "group_1"name = "cat_name_1">My</div>
                <div class = "group_1"name = "cat_name_1">Bun</div>
                <div class = "group_1"name = "cat_name_1">Pho</div>

                <div class = "group_2"name = "cat_name_2">Soft Drink</div>
                <div class = "group_2"name = "cat_name_2">Wine</div>
                <div class = "group_2"name = "cat_name_2">Juice</div>
                <div class = "group_2"name = "cat_name_2">Dessert</div>

                <div class = "group_3"name = "cat_name_3">Thit Bo</div>
                <div class = "group_3"name = "cat_name_3">Thit Ga</div>
                <div class = "group_3"name = "cat_name_3">Tom</div>
                <div class = "group_3"name = "cat_name_3">Muc</div>
                <div class = "group_3"name = "cat_name_3">Ca</div>
                <div class = "group_3"name = "cat_name_3">Tofu</div>

        </div>
        
</div>
<div id = "tb_result"></div> 
</body> 

</html>