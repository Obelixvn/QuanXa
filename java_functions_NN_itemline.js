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
function check_cat_input(){
    var str_ajax = "";
    var div_cat = document.getElementById('cat_selected').childNodes;
    var TOP_count = document.getElementById('TOP_count').value;
    var sang_chieu = document.getElementById('input_range_sang_chieu_toi').value;
    str_ajax = "loadTK_itemline.php?top_count="+TOP_count+"&sang_chieu="+sang_chieu;
    var type_option = document.getElementsByName('type_option');
    if (type_option[1].checked){
        str_ajax += "&type=2";
    }
    var time_option = document.getElementsByName('time_option');
    if (time_option[0].checked){
        
        str_ajax += "&time=0";
       
    }else{
        week_0 = document.getElementById('input_week_0').value;
        week_1 = document.getElementById('input_week_1').value;
        str_ajax += "&time=1&week_0="+week_0+"&week_1="+week_1;
        
    }
    
   
    var i;
    var j = 0;
    for (let i = 0; i < div_cat.length; i++) {
        const element = div_cat[i];
        if(element.nodeName === 'DIV'){
            
            if(element.classList.contains('show')){
               
               str_ajax += "&cat_id[]="+element.id;
            }
        }
    }
    
    Java_ajax('tb_result',str_ajax);
    
}
function search_mon(){
    var ten_mon = document.getElementById('ten_mon').value;
    var fullInfo = document.getElementById('itemMon_fullInfo')
    str_ajax = "get_ten_mon_itemLine.php?ten="+ten_mon;
    
    if(fullInfo.checked){
        str_ajax += "&fullInfo=1";
        document.getElementById('list_item_select').style.width = "350px";
        document.getElementById('list_item_select').style.overflow = "scroll";
    }else{
        document.getElementById('list_item_select').removeAttribute("style");
    }
    Java_ajax('list_item_select',str_ajax);
}
function plot_a_chart_item(){
    
    
    var type = 1;
    var sang_chieu = document.getElementById('input_range_sang_chieu_toi').value;
    
    str_ajax = "loadTK_itemline.php?sang_chieu="+sang_chieu;
    var type_option = document.getElementsByName('type_option');
    if (type_option[1].checked){
        type = 2;
    }
    var time_option = document.getElementsByName('time_option');
    if (time_option[0].checked){
        
        week_0 = 0;
        week_1 = 0;
        time = 0;
    }else{
        week_0 = document.getElementById('input_week_0').value;
        week_1 = document.getElementById('input_week_1').value;
        time = 1;
       
    }
    var groupByDay = 0;
    if(document.getElementsByName('group_by_time_item')[0].checked){
        groupByDay = 1;
    }

    var id_array = document.getElementsByName('itemID_selected_chartInput');
    if(id_array != null){
       
        
        submit_post_via_hidden_form("test_sample.php",{
            sang_chieu: sang_chieu,
            week_0:week_0,
            week_1:week_1,
            type : type,
            groupByDay:groupByDay,
            id_array : "item",
            time:time
        })
    }else{
        alert("Chua nhap item");
    }
    
}
function submit_post_via_hidden_form(url, params) {
    var form = document.createElement("form");
    form.setAttribute("method", "post");
    form.setAttribute("action", url);
    form.setAttribute("target", "_blank");
    for (const key in params) {
        if (params.hasOwnProperty(key)) {
            
            const element = params[key];
            if(key == "id_array"){
                if(element == "item"){
                    var id_array = document.getElementsByName('itemID_selected_chartInput');
                    id_array.forEach(e => {
                        var hiddenField = document.createElement("input");      
                        hiddenField.setAttribute("name", "item_ID[]");
                        hiddenField.setAttribute("value", e.value);
                        form.appendChild(hiddenField);
                         
                    });
                }else{
                    var div_cat = document.getElementById('cat_selected').childNodes;
                    var i;
                    
                    for (let i = 0; i < div_cat.length; i++) {
                        const e = div_cat[i];
                        if(e.nodeName === 'DIV'){
                            
                            if(e.classList.contains('show')){
                                var hiddenField = document.createElement("input");      
                                hiddenField.setAttribute("name", "cat_id[]");
                                hiddenField.setAttribute("value", e.id);
                                form.appendChild(hiddenField);
                            
                            }
                        }
                    }
                }
            }
            else{
                var hiddenField = document.createElement("input");      
                hiddenField.setAttribute("name", key);
                hiddenField.setAttribute("value", element);
                form.appendChild(hiddenField);
                
            }
            
        }
        document.body.appendChild(form); 
    }

    
               
    form.submit();
    

    form.remove();
}
function select_itemMon(x){
    var item_ID = x.id.substring(11);
    var check_input = document.getElementById('itemSELECTED_'+item_ID);
    if(check_input == null){
        var num_selected_item  = document.getElementsByName('itemID_selected_chartInput');
        if (num_selected_item.length >= 3){
            alert('Toi da la 3 item');
        }else{
            var itemName = x.innerHTML;
            var div_item = document.createElement("div")
            var input_hidden = document.createElement("input");
            input_hidden.setAttribute("name", "itemID_selected_chartInput");
            input_hidden.setAttribute("value", item_ID);
            input_hidden.setAttribute("id", "itemSELECTED_"+item_ID);
            input_hidden.setAttribute("type","hidden");
            var spanTen = document.createElement("span");
            div_item.setAttribute("onclick", "remove_selected_itemID(this)");
            spanTen.innerHTML = itemName;
            div_item.appendChild(input_hidden);
            div_item.appendChild(spanTen);
            document.getElementById('itemMon_selected_list').appendChild(div_item);
        } 
        
    }else{
        alert('Da co chon item nay roi');
    }
    document.getElementById('itemMon_rightPart').style.display = "block";
    
}
function remove_selected_itemID(element){
    element.parentNode.removeChild(element);
}
function plot_a_chart_cat(){
    var type = 1;
    var sang_chieu = document.getElementById('input_range_sang_chieu_toi').value;
    
    str_ajax = "loadTK_itemline.php?sang_chieu="+sang_chieu;
    var type_option = document.getElementsByName('type_option');
    if (type_option[1].checked){
        type = 2;
    }
    var time_option = document.getElementsByName('time_option');
    if (time_option[0].checked){
        
        week_0 = 0;
        week_1 = 0;
        time = 0;
    }else{
        week_0 = document.getElementById('input_week_0').value;
        week_1 = document.getElementById('input_week_1').value;
        time = 1;
       
    }
    var groupByDay = 0;
    if(document.getElementsByName('group_by_time_cat')[0].checked){
        groupByDay = 1;
    }

    var div_cat = document.getElementById('cat_selected').childNodes;
    var i;
    var index = 0;
    for (let i = 0; i < div_cat.length; i++) {
        const element = div_cat[i];
        if(element.nodeName === 'DIV'){
            
            if(element.classList.contains('show')){
               
              index++
            }
        }
    }
    if(index > 0 & index <=3){
        submit_post_via_hidden_form("test_sample.php",{
            sang_chieu: sang_chieu,
            week_0:week_0,
            week_1:week_1,
            type : type,
            groupByDay:groupByDay,
            id_array : "cat",
            time:time
        })
    }else{
        if(index == 0){
            alert("Chua nhap category");
        }else{
            alert("Chi duoc toi da 3 loai");
        }
        
    }
    
    
    
       
        
        
    
}
