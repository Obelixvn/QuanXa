function load_mainTK(){
    var t = document.getElementById('week_thongKe').value;
    Java_ajax('tb_thongKe','load_mainThongKe.php?str_date='+t);
}