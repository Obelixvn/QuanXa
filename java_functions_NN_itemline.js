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