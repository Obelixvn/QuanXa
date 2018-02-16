function on_off_tb_staff(x){
    if(x.classList.toggle('on_button')){
        x.innerHTML = 'On';
        document.getElementById('on_off_input').value = 1;
    }
    else{
        document.getElementById('on_off_input').value = 0;
        x.innerHTML = 'Off';
    }
}
function load_tb_staff(){
    var x = document.getElementsByName('tb_staff_hienthi');
    str_ajax = 'load_tbStaff.php?'
    x.forEach(function(e) {
        if (e.checked){
            str_ajax += "type="+ e.value;
        }
    }, this);
    str_ajax += "&status="+ document.getElementById('on_off_input').value;
    Java_ajax('tb_Staff',str_ajax);
}
function edit_active_staff(id){
    var staff = document.getElementsByName("nV_"+id);
    staff.forEach(function(e) {
        e.removeAttribute('disabled');
    }, this);
    document.getElementById('edit_button_'+id).style.display='none';
    document.getElementById('save_button_'+id).style.display='block';
}
function saveInfo_staff(id){
    var staff = document.getElementsByName("nV_"+id);
    ten = staff[0].value;
    rate = parseFloat(staff[1].value);
    
    if(staff[2].value == 1){
        status = 1;
    }else{
        status = 0;
    }
    str_ajax = "save_staffInfo.php?id="+id+"&ten="+ten+"&rate="+rate+"&status="+status;
    Java_ajax('tr_nV_'+id,str_ajax);

}
function add_staff(){
    var staffInfo = document.getElementsByName('newStaff_info');
    var ten = staffInfo[0].value;
    var rate = staffInfo[1].value;
    var role = staffInfo[2].value;
    str_ajax = 'newStaff_action.php?ten='+ten+"&rate="+rate+"&role="+role;
    
    Java_ajax('newStaff_info',str_ajax);
}