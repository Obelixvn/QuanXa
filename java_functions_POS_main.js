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
    strajax +="date_0="+dateInput[0].value+"&date_1="+dateInput[1].value;
    
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
    Java_ajax('tb_tienMat',strajax);
    strajax = "showSelect_tienMat_trongNgay.php?defferTime="+date;
    Java_ajax('Paid_in_Full',strajax);
    strajax = "showTM_tren_The.php?defferTime="+date;
    Java_ajax('TM_tren_the',strajax);
    
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
    var tbCheck = document.getElementsByName('tableCK');
    var tableID = document.getElementsByName('tableID');
    var tableTime = document.getElementsByName('tableTime');
    var count = tbCheck.length;
    
    strajax = "action_locTKTM.php?test=1";
    for (i = 0 ; i < count ; i++){
        if (!tbCheck[i].checked){
            strajax += "&tableID[]="+tableID[i].value;
            strajax += "&tableTime[]="+tableTime[i].value;
        }
    }
    Java_ajax('Paid_in_Full',strajax);
    
}
function action_Paid_in_Full(){
    var date = document.getElementById('TM_trongNgay').value;
    strajax = "action_Paid_in_Full.php?date="+date;
    Java_ajax('Paid_in_Full',strajax);
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
    strajax = 'Del_trongNgay_action.php?date='+date;
    if (confirm('Ket thuc ngay ?')){
        if (confirm('Xoa toan bo DEL trong ngay')){
        Java_ajax('result_Del',strajax);

        }
    }
}
function show_del_trongNgay(){
    var date = document.getElementById('del_trongNgay').value;
    strajax = 'Del_trongNgay_show.php?date='+date;
    Java_ajax('result_ALLDel',strajax);
    
}