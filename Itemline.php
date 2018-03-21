<html>
<head>
    <link rel="stylesheet" href="Style.css">
    <link rel="stylesheet" href="Style_itemLine.css">
</head>

<body>
<script src="java_functions_NN.js"></script>    
<script src="java_functions_NN_itemline.js"></script>
<fieldset >
    <legend>
    Thong Ke Item Line
    </legend>
    <div id = "control_panel">
        <div id = "time_span">
            <div>
                <input type="radio" checked = "checked" onclick = "select_time(0)"name="time_option" id=""> ALL
            </div>
            <div>
            <input type="radio" onclick = "select_time(1)" name="time_option" id="">
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
        <div id= "options_ratio">

        
        </div>
    </div>
    
    
</fieldset> 
<div id = "cat_select">
        <div>
            <input onclick = "text_input_click(this)" type="text" id="ten_mon" value = "Ten mon an"> 
            <button>Xem tat ca</button>
            <hr>
        </div>
        <div>
            <div id = "button_cat_1">
                <button onclick = "cat_select(1)"><span>Do Nuoc</span> </button>
                <button onclick = "cat_select(2)"><span>Do xao</span> </button>
                <button onclick = "cat_select(3)"><span>Goi&Nom</span></button>
                
            </div>
            <div id = "cat_selected">
                <div name = "cat_name" >Do nuoc</div>
                <div name = "cat_name">Do xao</div>
                <div name = "cat_name">Goi&nom</div>
            </div>
        </div>
        
</div>
<div id = "tb_result"></div> 
</body> 

</html>