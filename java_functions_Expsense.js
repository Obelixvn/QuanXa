function expensePage_onload(){
    load_expenseTB('Week');
    
}


function them_item_expense(){
    var table = document.getElementById('tb_expense');
    var row = table.insertRow(-1);
    var cell1 = row.insertCell(0);
    var cell2 = row.insertCell(1);
    var cell3 = row.insertCell(2);
    var cell4 = row.insertCell(3);
    var cell5 = row.insertCell(4);
    var cell6 = row.insertCell(5);
    var cell7 = row.insertCell(6);
    cell1.innerHTML = '<input type ="date" name = "bat_dau">';
    cell2.innerHTML = '<input type ="date" name = "ket_thuc">';
    cell3.innerHTML = '<input type = "text" name = "ten">';
    cell4.innerHTML = '<input type = "text" name = "cat1">';

    cell5.innerHTML = '<input type = "text" name = "cat2">';
    cell6.innerHTML = '<input type = "text" name = "cat3">';
    cell7.innerHTML = '<input type = "number" name = "tien">';
}
function update_expense(){
    str_ajax = "Test=1";
    var date_0 = document.getElementsByName('bat_dau');
    date_0.forEach(function(ngay) {
        str_ajax += "&date_0[]="+ngay.value;
    }, this);
    var date_1 = document.getElementsByName('ket_thuc');
    date_1.forEach(function(ngay) {
        str_ajax += "&date_1[]="+ngay.value;
    }, this);
    var name = document.getElementsByName('ten');
    name.forEach(function(ten) {
        str_ajax += "&ten[]="+ten.value;
    }, this);
    var cat_1 = document.getElementsByName('cat1');
    cat_1.forEach(function(e) {
        str_ajax += "&cat_1[]="+e.value;
    }, this);
    var cat_2 = document.getElementsByName('cat2');
    cat_2.forEach(function(e) {
        str_ajax += "&cat_2[]="+e.value;
    }, this);
    var cat_3 = document.getElementsByName('cat3');
    cat_3.forEach(function(e) {
        str_ajax += "&cat_3[]="+e.value;
    }, this);
    var amounts = document.getElementsByName('tien');
    amounts.forEach(function(e) {
        str_ajax += "&tien[]="+e.value;
    }, this);
    phpFile = "update_expense.php";
    Java_ajax_Post(str_ajax,'expense_input',phpFile);
    
    ;
    document.getElementById('tbody_expense').innerHTML = '';
}
function load_expenseTB(orderBy){
    str_ajax ="show_expenseTB.php?orderBy=";
    if(orderBy == 'Newest'){
        str_ajax += orderBy;
    }
    else{
        str_ajax += 'Week';
        
    }
    Java_ajax('expense_table',str_ajax);
}
function done_updateExpense(){
    document.getElementsByName('orderBy')[1].checked = true
    document.getElementById('expense_input').innerHTML = '';
    load_expenseTB('Newest');
}
function pay_individual_weekly(ten){
    Java_ajax('Boi_paying_tb','list_payable_boi_individual.php?ten='+ten)
}
function add_week_to_pay(x){
    var week = x.value;
    var gio = parseFloat(document.getElementById('tong_gion_week_'+week).innerHTML);
    var tong_gio = parseFloat(document.getElementById('tong_gio_pay').innerHTML);
    var tip = parseFloat(document.getElementById('tip_pay').value);
    var rate = parseFloat(document.getElementById('rate_pay').innerHTML);

    if (!x.checked){
        document.getElementById('tong_gio_pay').innerHTML = (tong_gio*100 - gio*100)/100;
       
        
    }else{
        document.getElementById('tong_gio_pay').innerHTML = tong_gio + gio;
        
        

    }
    var tong_gio = parseFloat(document.getElementById('tong_gio_pay').innerHTML);
    var luong_pay = parseFloat(rate*tong_gio).toFixed(2);
    document.getElementById('luong_pay').innerHTML = luong_pay;
    var luong_pay = parseFloat(document.getElementById('luong_pay').innerHTML);
    document.getElementById('tong_pay').innerHTML = luong_pay + tip;
    
    
}
function add_tip_payable(){
    
    var tong_gio = parseFloat(document.getElementById('luong_pay').innerHTML);
    var tip = parseFloat(document.getElementById('tip_pay').value);
    var tong_pay = parseFloat(tong_gio + tip);
    
    document.getElementById('total_pay').innerHTML = tong_pay.toFixed(2);
}
function pay_action_boi(ten){
    var week_pay = document.getElementsByName('monday_date');
    str_ajax = 'pay_boi_action.php?ten='+ten;
    var num_weeks = document.getElementById('week_select').value;
    for (var index = 0; index < num_weeks; index++) {
        str_ajax += '&monday_date[]='+week_pay[index].innerHTML;
        
    }
    str_ajax += '&tip='+document.getElementById('tip_pay').value;
    str_ajax += '&hour_pay='+ document.getElementById('hour_pay').innerHTML;
    Java_ajax('test',str_ajax);
}

function week_pay_change(x){
    var h = x.value;
    var total_hour = 0 ;
    var hour = 0;
    h = h *27;
    document.getElementById('week_select_overlay_boi').style.height = h+"px";
    var num_week = x.value;
    weekly_hours = document.getElementsByName('payable_hour');
    for (var i = 0; i < num_week; i++) {
            hour = parseFloat(weekly_hours[i].innerHTML);
            total_hour = parseFloat(total_hour + hour);

    }
    document.getElementById('hour_pay').innerHTML = total_hour.toFixed(2);
    var rate = parseFloat (document.getElementById('rate_pay').innerHTML);
    var luong_pay = total_hour *rate;
    document.getElementById('luong_pay').innerHTML = luong_pay.toFixed(2) ;
    var tip = parseFloat(document.getElementById('tip_pay').value);
    var total_pay = luong_pay + tip;
    document.getElementById('total_pay').innerHTML = total_pay.toFixed(2);
}
function paying_section_select(x,ten){
    
    var items = document.getElementsByName('menu_items');
        items.forEach(function(e) {
            if (e.classList.contains(ten)){
                e.classList.toggle('selected');
                
            }else{
                e.classList.remove('selected');
            }
        }, this);
    if (x.classList.contains('selected')){
        switch (ten) {
            case 'boi_section':
                Java_ajax('select_contain','list_boi_payable.php');
                break;
            case 'do_section':
                Java_ajax('select_contain','list_do_payable.php');
                break;
            
        }
        
    }else{
        document.getElementById('select_contain').innerHTML = '';
    }
}
    

    