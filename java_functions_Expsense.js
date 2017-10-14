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
    Java_ajax_Post(str_ajax,'tbody_expense',phpFile);
}
function load_expenseTB(orderBy){
    str_ajax ="show_expenseTB.php?orderBy=";
    if(orderBy = 'Newest'){
        str_ajax += orderBy;
    }
    else{
        str_ajax += 'week';
    }
    Java_ajax('expense_table',str_ajax);
}