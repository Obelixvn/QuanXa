function salePage_onload(){
    load_sale_tb();
}
function load_sale_tb(){
    var monday = get_monday_from_inputWeek('week_salePage');
    str_ajax = 'load_tbSale.php?date='+monday;
    div_id = 'sale_tb';
    Java_ajax(div_id,str_ajax);
}
function save_daySale(day){
    var date = document.getElementById(day+'_thu').value;
    var day_sale = document.getElementsByName(day+'_sale');
    //phpFile = 'save_daySale.php';
    str_ajax = 'save_daySale.php?date='+date;
    div_id = 'sale_'+day;
    $data = true;
    day_sale.forEach(function(sale) {
        if (sale.value != '') {
            str_ajax +="&day_sale[]="+sale.value;
        }
        else{
            
            $data = false;
            return;
        }
    }, this);
    if($data){
        
        //Java_ajax_Post(str_ajax,div_id,phpFile);
        Java_ajax(div_id,str_ajax);
    }else{
        alert('Nhap thieu du lieu !');
    }
    
}
function add_tong(x){
   var ten =  x.getAttribute("name");
   var main_ten = ten.substring(0,3);
   var day_sales = document.getElementsByName(main_ten+'_sale');
   card = cash = jeat = uber = roo = 0;
   if (day_sales[0].value != ''){
       card = parseFloat(day_sales[0].value);
   }
   if (day_sales[1].value != ''){
       cash = parseFloat(day_sales[1].value);
   }
   if (day_sales[2].value != ''){
       jeat = parseFloat(day_sales[2].value);
   }
   if (day_sales[3].value != ''){
       uber = parseFloat(day_sales[3].value);
   }
   if (day_sales[4].value != ''){
       roo = parseFloat(day_sales[4].value);
   }
   
   document.getElementsByName('eat_in_'+main_ten)[0].innerHTML = card + cash;
   document.getElementsByName('eat_out_'+main_ten)[0].innerHTML = jeat + uber+ roo;
    document.getElementsByName('tong_sale_'+main_ten)[0].innerHTML = card + cash+jeat + uber+ roo;
}
function load_delivery_taking(){
    var monday = get_monday_from_inputWeek('delivery_week_input');
    str_ajax = 'load_delivery_action.php?date='+monday;
    
    Java_ajax('tb_income',str_ajax);
}
function get_ratio_delivery(x,i){
    var net = parseFloat(x.value);
    var gross = document.getElementById('gross_'+i).innerHTML.replace("\,","");
    var r = parseFloat((net/gross)*100).toFixed(2);
    document.getElementById('ratio_'+i).innerHTML = r +"%";

    var input = document.getElementsByName('net_input');
    var tong_net = 0;
    
    input.forEach(function(e) {
        if (e.value != ''){
            var num = parseFloat(e.value)*100;
            tong_net += num;
        }
        
    }, this);
    document.getElementById('net_tong').innerHTML = tong_net/100;

    var tong_gross = document.getElementById('gross_tong').innerHTML.replace("\,","");
    
    r  = parseFloat(tong_net/tong_gross).toFixed(2);
    
    document.getElementById('ratio_tong').innerHTML = r + "%";
}
function update_delivery_net(){
    var input = document.getElementsByName('net_input');
    var date = get_monday_from_inputWeek('delivery_week_input');
    str_ajax = "ngay="+date;
    input.forEach(function(e) {
        str_ajax += "&net[]="+e.value;
    }, this);
    phpFile = "update_net_delivery_action.php";
    alert(str_ajax);
    Java_ajax_Post(str_ajax,'delivery_taking',phpFile);
}