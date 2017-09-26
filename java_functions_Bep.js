function lich_bep_S_C(x,y,z) {
    var d = parseInt(document.getElementById(y).value);
    z = parseInt(z);
    if (x.classList.toggle("btn_nghi")){
        
        document.getElementById(y).value = d-z ;
    }else{
        
        document.getElementById(y).value = d+z;
    }
}
function show_change_BepPage(e,div_id){
    e.parentElement.style.display='none';
    document.getElementById(div_id).style.display = 'block';
}
function onloadBepPage(){
    
}
function loadLichBep(){
    var date = get_monday_from_inputWeek('week_bepPage');
    str_ajax = 'loadLichBep.php?Date='+date;
    Java_ajax('lich_bep',str_ajax);
}
function save_lichBep(){
    str_tuan = document.getElementById('week_bepPage').value;
    str_tuan = str_tuan.split("-");
    tuan = str_tuan[1].substr(1);
    str_ajax = "update_lichBep_action.php?week="+tuan;
    
    var nv_id = document.getElementsByName('nv_Bep_ID');
    nv_id.forEach(function(id) {
        str_ajax += "&nv_id[]="+id.value;
        var shift = document.getElementsByName('Shift_bep_'+id.value);
        str_ajax += "&ca_lam[]=";
        shift.forEach(function(ca_lam) {
            str_ajax += ca_lam.value;
        }, this);
    }, this);
    
    Java_ajax('lich_bep',str_ajax);
}
function update_lichBep(id,x){
    var ca_lam = document.getElementById('select_ca_lam_'+id+'_'+x).value;
    str_ajax = 'id='+id+'&x='+x+'&ca_lam='+ca_lam;
    
    Java_ajax_Post(str_ajax,'lich_bep_'+id+'_'+x,'update_lichBep_canhan.php')
}