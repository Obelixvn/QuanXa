function show_adj_gioLam_boi(x) {
        x.parentElement.style.left = '-15px';
}
function save_adj_boi(id){
    var adj_numbers = document.getElementsByName('adj_number_'+id);
    var adj = '';
    adj_numbers.forEach(function(element) {
        if (element.value != '') {
            adj = element.value;
        }
    }, this);
    if (adj != ''){
        var note = prompt("Ly do");
        str_ajax = 'id='+id+'&adj='+adj+'&note='+note;
        phpFile = 'update_boi_adj_action.php';
        if (window.XMLHttpRequest) {
                // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
                // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 200) {
                

                var divs = document.getElementsByName('lich_boi_'+id);
                divs.forEach(function(div_id) {
                    div_id.innerHTML =    this.responseText; 
                }, this);
                            
                
                
            
            
            }
        };
            
        xmlhttp.open("Post",phpFile,true);

        xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");

        xmlhttp.send(str_ajax); 
                
    }
    
} 
function chon_kieu_luong_thongKe(element){
    var kieu = element.value;
    if (kieu =='tuan'){
        document.getElementById('luong_boi_theo_ngay').style.display = 'none';
        document.getElementById('luong_boi_theo_tuan').style.display = 'block';
    }
    if(kieu == 'ngay'){
        document.getElementById('luong_boi_theo_ngay').style.display = 'block';
        document.getElementById('luong_boi_theo_tuan').style.display = 'none';
    }

}
function luong_boi(){

    if (document.getElementById('luong_Choice2').checked){
        var date_0 = get_monday_from_inputWeek('luong_boi_tuan_0');
        var date_1 = get_monday_from_inputWeek('luong_boi_tuan_1');
        
        
    }
    if (document.getElementById('luong_Choice1').checked){
        var date_0 = document.getElementsByName('Date_selected')[0].value;
        var date_1 = '';
    }
    str_ajax = "luong_boi_boiPage.php?Date="+date_0+"&Date_1="+date_1;
    Java_ajax('luong_boi_boiPage',str_ajax);
    
}
function boiPage_onload(){
    var e = document.getElementsByName('Date_selected')[0].value;
    showLichBoi(e);
}
function payBoi(ten,ngay_0,ngay_1){
    str = ten + " lam tu "+ngay_0+" den "+ngay_1+" .So tien tra:";
    var tien_tra = prompt(str);
    var tien_luong = document.getElementById(ten+'_luong');
    alert(tien_tra-tien_luong);
    str_ajax = "ten="+ten+"&ngay_0="+ngay_0+"&ngay_1="+ngay_1;
    phpFile = 'payBoi_action.php';
    //Java_ajax_Post(str_ajax,ten+'_paid',phpFile);
}