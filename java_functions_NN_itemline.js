function select_time(t){
    if(t == 1){
        document.getElementById('input_week_0').removeAttribute('disabled');
        document.getElementById('input_week_1').removeAttribute('disabled');
    }else{
        document.getElementById('input_week_0').setAttribute("disabled","disabled");
        document.getElementById('input_week_1').setAttribute("disabled","disabled");
    }
}
function sang_chieu_toi_select(x){
    var v = document.getElementById('input_range_sang_chieu_toi').value;
    var span = document.getElementsByName('sang_chieu_toi_select');
    var i = 1;
    span.forEach(e => {
        if (i == v){
            e.classList.add("selected");
        }else{
            e.classList.remove("selected");
        }
        i++;
    });
}
function text_input_click(x){
    document.getElementById('ten_mon').style.textAlign= "left";
    document.getElementById('ten_mon').style.color = "black";
    document.getElementById('ten_mon').value = "";
}
function cat_select(x){
    var i = 0;
    var group = ["cat_name","cat_name_1","cat_name_2","cat_name_3"]
    var t = Math.floor(x/10);
    var z = x%10;
    
    group.forEach(e => {
        var j = 1;
        div_cat_names = document.getElementsByName(e);
        div_cat_names.forEach(element => {
            
            if(i!= t){
                element.classList.remove('show');
            }else{
                
                if(j == z){
                    element.classList.toggle('show');
                }
                
            }
            j++
        });
    i++;
    });
}
function load_TOP_item(){
    str_ajax = "loadTK_itemline.php";
    Java_ajax('tb_TOP_Order',str_ajax);
    str_ajax +="?type=2";
    Java_ajax('tb_TOP_Sale',str_ajax);
}
function load_TK_top(){
    var title_tk = "TOP ";
    var TOP_count = document.getElementById('TOP_count').value;
    
    var sang_chieu = document.getElementById('input_range_sang_chieu_toi').value;
    switch (sang_chieu) {
        case '1':
            title_tk += "SANG -";
            break;
        case '2':
            title_tk += "CHIEU TOI -";
            break;
        default:
            break;
    }
    str_ajax = "loadTK_itemline.php?top_count="+TOP_count+"&sang_chieu="+sang_chieu;
    var type_option = document.getElementsByName('type_option');
    if (type_option[1].checked){
        str_ajax += "&type=2";
    }
    var time_option = document.getElementsByName('time_option');
    if (time_option[0].checked){
        
        str_ajax += "&time=0";
        title_tk += "ALL TIME";
    }else{
        week_0 = document.getElementById('input_week_0').value;
        week_1 = document.getElementById('input_week_1').value;
        str_ajax += "&time=1&week_0="+week_0+"&week_1="+week_1;
        title_tk += "TUAN : "+ week_0 + " - " +week_1;
    }

    
    document.getElementById('title_TK_top').innerHTML = title_tk;
    Java_ajax('tb_TK_top',str_ajax);
    
}