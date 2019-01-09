function change_date(){
            
            document.getElementById("week_sel_form").submit();

        }
        
function showLichBoi() {
    date = get_monday_from_inputWeek('week_boiPage');
    str_ajax ="getLichboi.php?date="+date;
    Java_ajax('Lich_Boi',str_ajax);
    luong_boi();
}

function themStaff(date_id){
    
    if (window.XMLHttpRequest) {
                    // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else {
                    // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById('bt_themStaff'+date_id).innerHTML = this.responseText;
                document.getElementById('bt_themStaff'+date_id).style.height = '200px';
            }
            };
                
        xmlhttp.open("GET","themBoi.php?dateID="+date_id,true);
        xmlhttp.send();

}
function xoaStaff(date_id){
    if (window.XMLHttpRequest) {
                    // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else {
                    // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById('bt_themStaff'+date_id).innerHTML = this.responseText;
                document.getElementById('bt_themStaff'+date_id).style.height = '200px';
            }
            };
                
        xmlhttp.open("GET","xoaBoi.php?dateID="+date_id,true);
        xmlhttp.send();    
}
function changeStaff(date_id){
    var date = document.getElementsByName('Date['+date_id+']')[0].value;
    var boi_sang_thay = document.getElementsByName('ten_Boisang_xoa')[0].value;
    var boi_sang_duoc_doi = document.getElementsByName('ten_Boisang_them')[0].value;

    

    var boi_toi_thay = document.getElementsByName('ten_Boitoi_xoa')[0].value;
    var boi_toi_duoc_doi = document.getElementsByName('ten_Boitoi_them')[0].value;

    str_ajax =  date
                +'&Boi_sang_Bixoa='+boi_sang_thay
                +'&Boi_sang_Dcthem='+boi_sang_duoc_doi
                +'&Boi_toi_Bixoa='+boi_toi_thay
                +'&Boi_toi_Dcthem='+boi_toi_duoc_doi ;
    if (window.XMLHttpRequest) {
                    // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else {
                    // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById(date).innerHTML = this.responseText;
            }
            };
                
        xmlhttp.open("GET","xoaBoi_action.php?Date="+str_ajax,true);
        xmlhttp.send();    
}
function updateStaff(date_id){
    var boi_sang = document.getElementsByName('Boi_sang['+date_id+'][]');
    var boi_toi = document.getElementsByName('Boi_toi['+date_id+'][]');
    var date = document.getElementsByName('Date['+date_id+']')[0].value;
    str_boiSang_name = '';
    str_boiToi_name = '';
    var i;
    for (i = 0; i < boi_sang.length; i++) {
        if (boi_sang[i].value != '') {
            str_boiSang_name = str_boiSang_name + boi_sang[i].value+',';
        }
    }
    for ( i = 0; i < boi_toi.length; i++) {
       
        if (boi_toi[i].value != '') {
            str_boiToi_name = str_boiToi_name + boi_toi[i].value+',';
        }
    }
    str_ajax = date+'&Boi_sang='+str_boiSang_name+'&Boi_toi='+str_boiToi_name;
    
    
    if (window.XMLHttpRequest) {
                    // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else {
                    // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById(date).innerHTML = this.responseText;
            }
            };
                
        xmlhttp.open("GET","update_initial_BoiTb.php?Date="+str_ajax,true);
        xmlhttp.send();

   
}function Java_ajax(div_id,str_ajax){

    if (window.XMLHttpRequest) {
                    // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else {
                    // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById(div_id).innerHTML = this.responseText;
            }
            };
                
        xmlhttp.open("GET",str_ajax,true);
        xmlhttp.send();
}
function show_gioLam(){
    var thu = document.getElementsByName('chon_thu')[0].value;
    var tuan = document.getElementsByName('giolam')[0].value;
    str_ajax = 'show_gioLam.php?Date='+tuan+'&Thu='+thu;
    
    Java_ajax('div_gioLam',str_ajax);
    
}
function update_giolam(date){
    var closing_time = document.getElementById('input_closing_time_'+date).value;
    var r = confirm("Dong cua luc : "+closing_time);
    if (r == true) {
        
        str_ajax = 'Date='+date+'&closing_time='+closing_time;
        phpFile = 'show_gioLam.php';
        
        Java_ajax_Post(str_ajax,'closing_time_'+date,phpFile);
    } 
}
function boi_Adj_made(state){
    
    switch (state) {
        case 1:
            document.getElementsByName('ten_boi_Adj_gioLam')[0].setAttribute('disabled',true);
            document.getElementById('boi_adj_button_2').style.display = "block";
            document.getElementById('boi_adj_button_1').style.display = "none";
            document.getElementById('boi_adj_div_1').style.display = "block";
            break;
    
        case 2:
            ten_boi = document.getElementsByName('ten_boi_Adj_gioLam')[0].value;
            thu = document.getElementsByName('chon_thu_boi_Adj')[0].value;
            tuan = document.getElementsByName('week_boi_gio_lam_adj')[0].value;
            str_ajax = 'show_boi_goi_lam_adj.php?Date='+tuan+'&name='+ten_boi+'&thu='+thu;
            //document.getElementById('boi_adj_button_2').style.display = "none";
            document.getElementsByName('ten_boi_Adj_gioLam')[0].removeAttribute('disabled');
            document.getElementById('boi_gioLam_adj').style.height = "130px";
            Java_ajax('boi_gioLam_adj',str_ajax);
            break;
    }
}
function update_boi_adj(date){
    var ten_boi = document.getElementsByName('ten_boi_Adj_gioLam')[0].value;
    var boi_adj= document.getElementsByName('boi_adj')[0].value;
    var boi_adj_note = document.getElementsByName('boi_adj_note')[0].value;
    str_ajax = 'update_boi_adj_action.php?Date='+date+'&ten_boi='+ten_boi+'&adj='+boi_adj+'&note='+boi_adj_note;
    alert(str_ajax);
    Java_ajax('boi_gioLam_adj',str_ajax);
}
function show_lichLam_detailt(name,date,date_1){
    
        str_ajax= 'show_lichLam_detailt.php?Name='+name+'&Date='+date+'&Date_1='+date_1;
    
        Java_ajax('Lich_lam_detail',str_ajax);
    
    
}
function item_selected_datDoPage(x){
    var td_elements =  x.parentElement.parentElement.children;
    
    var sup = x.name.substr(12);
    var item = x.value;

    if (window.XMLHttpRequest) {
        // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
        } else {
                // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
        if (this.readyState == 4 && this.status == 200) {
            var str_return = this.responseText;
            var e = str_return.split(',');
            if (e[0] != "NULL"){
                td_elements[1].innerHTML = e[0];
                if (e[1] != "NULL"){
                    td_elements[3].innerHTML = e[1];
                }
                else{
                    td_elements[3].innerHTML = "New";
                }

            }else{
                td_elements[1].innerHTML = "<input class = \"them_do_unit\" type=\"text\" name=\"unit_item_"+sup+"\" >";
                td_elements[3].innerHTML = "New";
            }
        }
        };
            
        xmlhttp.open("GET","getItemPrice.php?name="+item+"&sup="+sup ,true);
        xmlhttp.send();


    
}

function item_quality_selected_datDoPage(x){
    var td_elements =  x.parentElement.parentElement.children;
    if (td_elements[3].innerHTML != "New"){
        var price = parseFloat(td_elements[3].innerHTML);
        var q_item = x.value;
        td_elements[4].children[0].value = (price * q_item).toFixed(2);
    }
    

}

function item_cost_input_datDoPage(x){
    
    var sup = x.name.substr(10);
    var cost = document.getElementsByName('cost_item_'+sup);
    var i = 0;
    cost.forEach(function(e) {
        if (e.value != ''){
            i += parseFloat(e.value);
        }
        
    }, this);
    document.getElementById('tongTien_'+sup).innerHTML = i.toFixed(2);
    
    var td_elements =  x.parentElement.parentElement.children;
    var oldPrice = parseFloat(td_elements[3].innerHTML);
    var q_item = td_elements[2].children[0].value;

    var newPrice = (x.value / q_item).toFixed(2);
    
    if (newPrice != oldPrice){
        if (newPrice > oldPrice){
            td_elements[3].style.color = 'red';
                             
        }else{
            td_elements[3].style.color = 'green';    
        }
        td_elements[3].innerHTML = newPrice;
    }

}

function datDoPage_onload(){
    change_date_datDoPage();
    Java_ajax('Cook Delight_them_do','Dat_do_hang_ngay.php?supplier=Cook Delight');
    Java_ajax('Hung Nghia_them_do','Dat_do_hang_ngay.php?supplier=Hung Nghia');
    Java_ajax('Jacky_them_do','Dat_do_hang_ngay.php?supplier=Jacky');
    Java_ajax('Meat_them_do','Dat_do_hang_ngay.php?supplier=Meat');
    //Java_ajax('thong_ke_theo_items','list_items_datDoPage.php');
    //load_thongKe_tuan();

}
function them_item_datDo(index) {
    var table = document.getElementById("tb_datDo_"+index);
    var row = table.insertRow(-1);
    var cell1 = row.insertCell(0);
    var cell2 = row.insertCell(1);
    var cell3 = row.insertCell(2);
    var cell4 = row.insertCell(3);
    var cell5 = row.insertCell(4);
    cell1.innerHTML = "<input onblur = \"item_selected_datDoPage(this)\" class = \"them_do_ten\" list=\"items_list_"+index+"\" name=\"item_dat_do_"+index+"\">";
    cell3.innerHTML = "<input onblur = \"item_quality_selected_datDoPage(this)\" class = \"them_do_q\"value = \"1\" type = \"number\" name = \"q_item_"+index+"\">";
    cell5.innerHTML = "<input onblur = \"item_cost_input_datDoPage(this)\" class = \"them_do_tien\" type = \"number\" name = \"cost_item_"+index+"\">";
}
function newItem_tb_them_item(){
    var table = document.getElementById("tb_newItem_datDoPage");
    var row = table.insertRow(-1);
    var cell1 = row.insertCell(0);
    var cell2 = row.insertCell(1);
    var cell3 = row.insertCell(2);
    var cell4 = row.insertCell(3);
    var cell5 = row.insertCell(4);
    
    cell1.innerHTML = "<input class = \"them_do_ten\" type = \"text\" name=\"ten_item[]\">";
    cell2.innerHTML =   "<input class = \"them_do_unit\" type = \"text\" name=\"unit_item[]\">";
    cell3.innerHTML =  "<input class = \"them_do_q\" type = \"number\"  min = \"0\" name =\"q_item[]\">";
    cell4.innerHTML =   "<input class = \"them_do_supplier\" type = \"text\" name=\"supplier_item[]\">";
    cell5.innerHTML =   "<input class = \"them_do_tien\" type = \"number\"  min = \"0\" name =\"cost_item[]\">";
    
}
function update_puchase(sup){
    date = document.getElementById('Ngay_dat_do').value;
    var name = document.getElementsByName('item_dat_do_'+sup);
    var quality = document.getElementsByName('q_item_'+sup);
    var cost = document.getElementsByName('cost_item_'+sup);
    var unit = document.getElementsByName('unit_item_'+sup);
    str_itemName ='';
    str_itemQuality ='';
    str_itemCost ='';
    str_itemUnit = '';
    for (i = 0; i < name.length; i++) {
        if      (name[i].value != '' 
            && quality[i].value !=''
            && cost[i].value !='')
        {
            str_itemName += '&name[]='+name[i].value;
            str_itemQuality +='&quality[]='+quality[i].value;
            str_itemCost += '&cost[]='+cost[i].value;
        }
    }
    for (var i = 0; i < unit.length; i++) {
        if(unit[i] != ''){
            str_itemUnit += '&unit[]='+unit[i].value;
        }
        
    }
    str_ajax = 'update_purchase_action.php?Date='+date+'&supplier='+sup+str_itemName+str_itemQuality+str_itemCost+str_itemUnit;
    Java_ajax(sup+'_dat_do',str_ajax);
    //document.getElementById(sup+'_them_do').style.display = 'none';
    document.getElementById('tb_datDo_'+sup).innerHTML = '';
}
function newItem_tb_update_puchase(){
    date = document.getElementById('newItem_date_dat_do').value;
    var name = document.getElementsByName('ten_item[]');
    var unit = document.getElementsByName('unit_item[]');
    var quality = document.getElementsByName('q_item[]');
    
    var supplier = document.getElementsByName('supplier_item[]');
    var cost = document.getElementsByName('cost_item[]');
    str_itemName ='';
    str_itemQuality ='';
    str_itemUnit ='';
    str_itemCost ='';
    str_itemSupplier ='';
    for (i = 0; i < name.length; i++) {
        if      (name[i].value != '' 
            && quality[i].value !=''
            && cost[i].value !=''
            && unit[i].value !=''
            && supplier[i].value !='')
        {
            str_itemName += '&name[]='+name[i].value;
            str_itemQuality +='&quality[]='+quality[i].value;
            str_itemCost += '&cost[]='+cost[i].value;
            str_itemUnit += '&unit[]='+unit[i].value;
            str_itemSupplier += '&supplier[]='+supplier[i].value;
        }
    }
    phpFile = 'update_NewItem_purchase_action.php';
    str_ajax = 'Date='+date+str_itemName+str_itemQuality+str_itemCost+str_itemSupplier+str_itemUnit;
    
    Java_ajax_Post(str_ajax,'newItem_dat_do',phpFile);
}
function save_itemUnit_datDoPage(id){
    var tag = document.getElementsByName('purchaseID_'+id)[0].tagName;
    unit = '';
    if (tag == 'INPUT'){
        unit = document.getElementsByName('purchaseID_'+id)[0].value;
        if (unit == ''){
            return;
        }
        item_id = document.getElementsByName('itemID_'+id)[0].value;
        
    }else{
        item_id = document.getElementsByName('purchaseID_'+id)[0].value;
    }

    
    if (window.XMLHttpRequest) {
                    // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else {
                    // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById('span_purchanseId_'+id).innerHTML = this.responseText;
                document.getElementsByName('purchaseID_'+id)[0].setAttribute("disabled","disabled");
                document.getElementsByName('save_button_'+id)[0].style.display = 'none';
            }
            };
                
        xmlhttp.open("Post",'save_itemUnit_datDoPage.php',true);
        
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    str_ajax = 'purchase_id='+id+'&unit='+unit+'&item_id='+item_id;
    xmlhttp.send(str_ajax);
}
function hoan_thanh_them_do(sup){
    document.getElementById(sup+'_them_do').style.display = 'block';
    document.getElementById(sup+'_do_them').innerHTML = '';
    ngay_dat_do = document.getElementById('Ngay_dat_do').value;
    str_ajax = 'show_do_dat_trong_ngay.php?ngay_dat_do='+ngay_dat_do+'&supplier='+sup;
    Java_ajax(sup+'_dat_do',str_ajax);


}
function Java_ajax_Post(str_ajax,div_id,phpFile){
    if (window.XMLHttpRequest) {
                    // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else {
                    // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById(div_id).innerHTML = this.responseText;
                
            }
            };
                
        xmlhttp.open("Post",phpFile,true);
        
    xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
    
    xmlhttp.send(str_ajax);
}
function get_monday_from_inputWeek(input){
    str_tuan = document.getElementById(input).value;
    str_tuan = str_tuan.split("-");
    var year = str_tuan[0];
    var first_day = new Date(year,0,0);
    t_day = first_day.getDay();
    if (t_day >= 4){
        t_day =  t_day - 7;
    }
    var tuan = parseInt(str_tuan[1].substr(1));
    var day = parseInt(tuan*7  - 6 - t_day);
    var d = new Date(year,0,day);
    dd = d.getDate();
    mm = d.getMonth()+1;
    yy = d.getFullYear();
    MM = d.toDateString().substr(4,3);
    ngay_dat_do = yy+'-'+mm+'-'+dd;
   return ngay_dat_do;
}
function change_date_datDoPage(){
    var thu = document.getElementsByName('chon_thu_dat_do')[0].value;
    str_tuan = document.getElementById('week_datDoPage').value;
    str_tuan = str_tuan.split("-");
    var year = str_tuan[0];
    thu = parseInt(thu);
    tuan = parseInt(str_tuan[1].substr(1));

    var firstdayofYear = new Date (year,0,1);
    var dayofWeek_firstdayofYear = firstdayofYear.getDay()+6;
    
    if(dayofWeek_firstdayofYear > 7){
        dayofWeek_firstdayofYear = dayofWeek_firstdayofYear -7;
    }
    if(dayofWeek_firstdayofYear >= 4){
        var mondayofFirstWeek = 7 - dayofWeek_firstdayofYear;
    }else{
        var mondayofFirstWeek = 0 - dayofWeek_firstdayofYear;
    }
    var day = parseInt(tuan*7 + thu - 6 + mondayofFirstWeek);
    var d = new Date(year,0,day);
    dd = d.getDate();
    mm = d.getMonth()+1;
    yy = d.getFullYear();
    MM = d.toDateString().substr(4,3);
    ngay_dat_do = yy+'-'+mm+'-'+dd;
    document.getElementById('date_datDoPage').innerHTML= dd+'/'+MM+'/'+yy;
    document.getElementById('Ngay_dat_do').value = ngay_dat_do;
    str_ajax = 'show_do_dat_trong_ngay.php?ngay_dat_do='+ngay_dat_do+'&supplier=';
    Java_ajax('Meat_dat_do',str_ajax+'Meat');
    Java_ajax('Jacky_dat_do',str_ajax+'Jacky');
    Java_ajax('Cook Delight_dat_do',str_ajax+'Cook Delight');
    Java_ajax('Hung Nghia_dat_do',str_ajax+'Hung Nghia');
    
}
function load_dat_do_other_supplier(){
    var sup = document.getElementsByName('supplier_sel_datdoPage')[0].value;
    if (sup != ''){

        old_sup = document.getElementById('Other_supplier_name').innerHTML;

        if (old_sup == ''){
            old_sup = 'Other';
        }
        document.getElementById('Other_supplier_name').innerHTML = sup;
        ngay_dat_do = document.getElementById('Ngay_dat_do').value;
        document.getElementById(old_sup+'_dat_do').setAttribute('id',sup+'_dat_do');
        document.getElementById(old_sup+'_them_do').setAttribute('id',sup+'_them_do');
        document.getElementById(old_sup+'_do_them').setAttribute('id',sup+'_do_them');
        Java_ajax(sup+'_them_do','Dat_do_hang_ngay.php?supplier='+sup);
        str_ajax = 'show_do_dat_trong_ngay.php?ngay_dat_do='+ngay_dat_do+'&supplier='+sup;
        Java_ajax(sup+'_dat_do',str_ajax);
        
        
        

    }
}
function thong_ke_sel_Allsupplier(index){
   
   var sup = document.getElementsByName('thong_ke_supplier[]');
   sup.forEach(function(element) {
       element.checked = true;
   }, this);
}
function load_thongKe_tuan(){
    var kieu = document.getElementsByName('kieu_thongKe')[0].value;
    
    date = get_monday_from_inputWeek('week_thongKe');
    if (kieu == 1){
            var suppliers = document.getElementsByName('thong_ke_supplier[]');
            str_suppler = '';
            suppliers.forEach(function(sup) {
                if (sup.checked){
                    str_suppler += '&suppliers[]='+sup.value;
                }
            
        }, this);
        str_ajax = 'show_thong_ke_action.php?Date='+date+str_suppler;
        Java_ajax('thong_ke_tuan',str_ajax);


    }else if(kieu == 2){
            var items = document.getElementsByName('thong_ke_items[]');
            str_items = '';
            items.forEach(function (item){
                 if(item.checked){
                     str_items += '&items[]='+item.value;
                 }   
            },this)
            str_ajax = 'show_thong_ke_action.php?Date='+date+str_items;
            
            Java_ajax('thong_ke_tuan',str_ajax);
            
    }

    
    
    

}
function get_detailt_thongKe(date,sup,kieu){
    if (kieu =='Supplier'){
        str_ajax = 'get_detailt_thongKe.php?date='+date+'&supplier='+sup;
        document.getElementById('detailt_thong_ke_Item_'+sup).innerHTML ='';
    }else if (kieu == 'Item Name'){
        str_ajax = 'get_detailt_thongKe_item.php?date='+date+'&item='+sup;
        
    }
    
    Java_ajax('detailt_thong_ke_'+sup,str_ajax);
    document.getElementById('detailt_thong_ke_'+sup).parentElement.style.display = 'table-row';
}
function get_detail_thong_keItem(date,id,sup){
    
    str_ajax ='get_detailt_thongKe_item.php?date='+date+'&item='+id;
    
    Java_ajax('detailt_thong_ke_Item_'+sup,str_ajax);
}
function load_kieu_thongKe(){
    var kieu = document.getElementsByName('kieu_thongKe')[0].value;
    if (kieu == 1){
            document.getElementById('thong_ke_theo_suppliers').style.display = 'block';
            document.getElementById('thong_ke_theo_items').style.display = 'none';

    }else if(kieu == 2){
            document.getElementById('thong_ke_theo_suppliers').style.display = 'none';
            document.getElementById('thong_ke_theo_items').style.display = 'block';
    }
}
function thong_ke_them_items(){
    ten = document.getElementById('thong_ke_them_items_ten').value;

    str_ajax = "list_items_datDoPage.php?name="+ten;

    if (window.XMLHttpRequest) {
                    // code for IE7+, Firefox, Chrome, Opera, Safari
        xmlhttp = new XMLHttpRequest();
    } else {
                    // code for IE6, IE5
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById('list_items_thong_ke').innerHTML += this.responseText+'<br>';
            }
            };
                
        xmlhttp.open("GET",str_ajax,true);
        xmlhttp.send();
    
    
}
function dong_thongKe_detailt(div_id){
    div_id.parentNode.style.display= 'none';
}

