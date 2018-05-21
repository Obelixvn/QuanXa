function POS_mainLoad(){
    load_tbOrderList();
}

function load_tbOrderList(){
    strajax = "load_tbOrderList.php";
    Java_ajax('tb_orderList',strajax);
}
function POS_TKLoad(type){
    strajax = "load_tb_TKitems.php?type="+type;

    time = document.getElementById('input_range_sang_chieu_toi').value;
    strajax +="&time="+time;
    var checkBox = document.getElementsByName('orderType');
    if (checkBox[0].checked){
        strajax += "&orderType[]=EatIn";
    }
    if (checkBox[1].checked){
        strajax += "&orderType[]=TW";
    }
    if (checkBox[2].checked){
        strajax += "&orderType[]=DEL";
    }
    
    Java_ajax('tb_TKitems',strajax);
}
function loadItemLine(){
    strajax = "POS_itemLine.php?"
    var dateInput = document.getElementsByName('date_itemLine');
    var save = document.getElementById('check_save_andLoad').checked;
    strajax +="date_0="+dateInput[0].value+"&date_1="+dateInput[1].value;
    if(save){
        if(confirm('Co chac chan khong')){
            strajax +="&save=1"
        }
    }
    
    
    Java_ajax('tb_itemLine',strajax);
}
function reload_DELstatus(){
    strajax = "action_DELstatus.php?";
    Java_ajax('tb_Del_order',strajax);
}
function release_DELstatus(){
    if(confirm("Release DELIVERY table ?")){
        
        strajax = "action_DELstatus.php?release=1";
        Java_ajax('tb_Del_order',strajax);
    }
    
}
function loadTienMat(){
    var date = document.getElementById('TM_trongNgay').value;
    strajax = "load_tienMat_trongNgay.php?defferTime="+date;
    Java_ajax('div_test',strajax);
    //strajax = "showSelect_tienMat_trongNgay.php?defferTime="+date;
    //Java_ajax('Paid_in_Full',strajax);
    //strajax = "showTM_tren_The.php?defferTime="+date;
    //Java_ajax('TM_tren_the',strajax);
    
}
function Xapxep(){
    var tbCheck = document.getElementsByName('tableCK');
    tbCheck.forEach(element => {
        
        if (!element.checked){
            
            
            element.parentElement.parentElement.style.display = 'none';
        }
    });
}
function show_chiTiet(x){
    var tableID = document.getElementsByName('tableID')[x].value;
    var tableTime = document.getElementsByName('tableTime')[x].value;
    strajax = "show_detail_order.php?tableID="+tableID+"&tableTime="+tableTime;
    Java_ajax('order_detail_'+x,strajax)
}
function loc_thongKe_TM(){
    var date = document.getElementById('TM_trongNgay').value;
    var tbCheck = document.getElementsByName('tableCK');
    var tableID = document.getElementsByName('tableID');
    var tableTime = document.getElementsByName('tableTime');
    var count = tbCheck.length;
    
    strajax = "action_locTKTM.php?defferTime="+date;
    for (i = 0 ; i < count ; i++){
        if (!tbCheck[i].checked){
            strajax += "&tableID[]="+tableID[i].value;
            strajax += "&tableTime[]="+tableTime[i].value;
        }
    }
    Java_ajax('Paid_in_Full',strajax);
    
}
function action_Paid_in_Full(){

    if (confirm('Da loc tien mat chua?')){
        if(confirm('Save ItemLine chua ???')){
            var JEat = prompt('Just Eat ?');
            if (isNaN(JEat)){
            
                alert('Phai nhap so');
                return false;
            }else{
                document.getElementById('Jeat_input').value = JEat;
                var tong_card = prompt('Tong the tren Card machine ?');
                if (isNaN(tong_card)){
            
                    alert('Phai nhap so');
                    return false;
                }else{
                    document.getElementById('tongCard_input').value = tong_card;
                    var pass = prompt('Pass code?');
                    if(pass == 123098){
                        document.getElementById('paid_in_full_form').submit();
                    }else{
                        alert("Wrong !");
                        return false;
                    }
                }
            }
        }
        else{
            return false;
        }
    }else{
        return false;
    }
    
}
function addUp_tongTien(){
    var tableCK = document.getElementsByName('tableCK');

    var TM = document.getElementsByName('TM_addUp');
    var tong = 0;
    var count = tableCK.length;
    
    
    for (i = 0 ; i < count ; i++){
        if (tableCK[i].checked){
           tong += parseFloat(TM[i].innerHTML) * 100;
        }
    }
    tong = tong/100;
    var card = parseFloat(document.getElementById('fix_card').innerHTML);
    
    var per = tong /card *100;


    
    document.getElementById('adj_TM').innerHTML = tong.toString();
    document.getElementById('adj_percent').innerHTML = per.toFixed(2);
}
function search_order(){
    var date = document.getElementById('refund_trongNgay').value;
    var ten = document.getElementById('refund_ten').value;
    var tien = document.getElementById('refund_amount').value;

    if(ten != '' & tien != ''){
        strajax = "search_actionOrder.php?date="+date+"&ten="+ten+"&tien="+tien;
        Java_ajax('result_refund',strajax);
    }else{
        alert('Nhap thieu')
    }
}
function refund_action(x){
    var tien = document.getElementById('refund_amount').value;
    var ten = document.getElementById('refund_ten').value;
    var time = document.getElementsByName('Time_ban')[x].value;
    var id = document.getElementsByName('ID_ban')[x].value;
    var card = parseFloat(document.getElementsByName('card_ban')[x].value);
    var cash = parseFloat(document.getElementsByName('cash_ban')[x].value);
    check_tong = card + cash;
    if (tien != check_tong){
        alert('Tong nhap khong dung');
    }else{
        if (confirm("Thay doi ban :"+ten+" thanh Card: "+card+" ; Cash: "+cash)){
            strajax = "refund_order_action.php?time="+time+"&tableid="+id+"&card="+card+"&cash="+cash;
            Java_ajax('orderToReFund_'+x,strajax);
        }
        
    }
    

}
function del_trongNgay(){
    var date = document.getElementById('del_trongNgay').value;
    if(date != ''){
        strajax = "Del_trongNgay_action.php?date="+date;
    }else{
        strajax = "Del_trongNgay_action.php";
    }
    
    if (confirm('Ket thuc ngay ?')){
        if (confirm('Xoa toan bo DEL trong ngay')){
        Java_ajax('result_Del',strajax);

        }
    }
}
function show_del_trongNgay(){
    var date = document.getElementById('date_suaDon').value;
    if (date != ''){
        strajax = "Del_trongNgay_show.php?date="+date;
    }else{
        strajax = "Del_trongNgay_show.php?1=1";
    }
    var ten = document.getElementById('ten_suaDon').value;
    var tien = document.getElementById('tien_suaDon').value;
    if (ten != '' & tien != ''){
        strajax += "&ten="+ten+"&tien="+tien;
    }else{
       alert('Nhap thieu du lieu');
    }
    Java_ajax('result_ALLDel',strajax);
    
    
}
function cal_totaleOrder(x){
    var select = document.getElementsByName('items_select');
    var price = document.getElementsByName('items_price');
    var lenght = select.length;
    var tong = 0;
    var i = 0;
    for (let index = 0; index < select.length; index++) {
        if (select[index].checked){
            i = parseFloat(price[index].innerHTML);
            tong += i;
        }
        
    }
    document.getElementById('order_suaDon_'+x).innerHTML = tong.toFixed(2);
}
function Update_don(x){
    
    var tID = document.getElementsByName('tableID_don')[x].value;
    var time = document.getElementsByName('openDateTime')[x].value;
    var price = document.getElementsByName('items_price');
    var select = document.getElementsByName('items_select');
    var itemsID = document.getElementsByName('item_ID');
    var tong = 0;
    var strID = ("(");
    var i = 0;
    for (let index = 0; index < select.length; index++) {
        if (select[index].checked){
            i = parseFloat(price[index].innerHTML);
            tong += i;
            
        }else{
            strID += itemsID[index].value+",";
        }
        
    }
    
    strID = strID.substring(0,(strID.length -1));
    strID += ")";
    strajax = "update_don_action.php?tableID="+tID+"&time="+time+"&tong="+tong+"&strID="+strID;
    alert(strajax);
    
    if (strID != ")"){
        Java_ajax('result_action_ALLDel',strajax);
    }
    
    
}
function lock_don(){
    var ten_goc = document.getElementById("Ex_ten_goc").value;
    var tien_goc = document.getElementById("Ex_tien_goc").value;
    var date = document.getElementById("Ex_date_suaDon").value;
    strajax = "lock_don_ex_step_1.php?date="+date+"&ten_goc="+ten_goc+"&tien_goc="+tien_goc;
    
    Java_ajax('lock_result',strajax);
}
function click_openTime_Ex_don(x){
    document.getElementById('gio_den_Ex').value = x.value;
}
function chuyen_don(){
    var ten_goc = document.getElementById("ten_den_Ex").value;
    var tien_goc = document.getElementById("tien_den_Ex").value;
    var date = document.getElementById("date_chuyen_Ex").value;
    var time = document.getElementById('gio_den_Ex').value;
    var tableID_goc = document.getElementById('table_goc_ID_Ex').value;
    var time_moi_ex = document.getElementById('gio_tra_Ex').value;
    strajax = "exchange_don_ex_step_1.php?date="+date+"&ten_den="+ten_goc+"&tien_den="+tien_goc+"&tableID_goc="+tableID_goc+"&time="+time+"&time_moi_ex="+time_moi_ex;
    Java_ajax('test',strajax);
    
}