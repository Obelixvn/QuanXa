<?php
include "Global.php";
include "DB_functions_NN.php";

if (isset($_GET["ten"])){
    $name = $_GET["ten"];
}

?>
<script src="java_functions_Expsense.js">
        
        
</script> 
<b><?php echo $name; ?></b>
<?php 

$sql_rate = "
    SELECT
    `tb_nhanVien`.`Rate`
    FROM `NN`.`tb_nhanVien`
    WHERE 
        `tb_nhanVien`.`Name` ='".$name."'

";
$result_rate = DB_run_query($sql_rate);
if($result_rate->num_rows > 0){
    $row_rate = $result_rate->fetch_assoc();
    $rate= $row_rate["Rate"];
}else{
    $rate = 6.7;
}
 $sql = "
        Select Name, Shift, tb_boi_hour.Date,Adj,Sang, Chieu , Note 
        From `NN`.`tb_boi_hour` 
        Left Join `NN`.`tb_gioLam` On tb_boi_hour.Date = tb_gioLam.Date
        Where   Paid = 0 and
                Name = '".$name."'
        Order By  tb_boi_hour.Date ";
    
$tuan = 0; 
$tong_tuan = 0; 
$date = new DateTime();            
    $result = DB_run_query($sql);
    
    if ($result->num_rows > 0){
?>
        <table>
            <tbody>
            <?php 
            while($row = $result->fetch_assoc()) {
                $ngay = new Datetime($row["Date"]);
                
                $week_no = $ngay->format('W');
                if ($tuan != $week_no){
                    if ($tong_tuan != 0){

                        
                        
                        $date->setISODate($year,$tuan);
                        
                        ?>
                        <tr>
                            <td>Tuan: <?php echo $tuan; ?></td>
                            <td><?php echo $date->format('d M Y'); ?></td>
                            <td><?php echo $date->modify('+6 day')->format('d M Y'); ?></td>
                            <td id = "tong_gion_week_<?php echo $tuan; ?>"><?php echo $tong_tuan; ?></td>
                            
                            <td><input onclick = "add_week_to_pay(this)" type="checkbox" name="pay_week[]" value="<?php echo $tuan;?>"></td>
                            <td></td>
                        </tr>
                        <?php
                    }
                    $tuan = $ngay->format('W');
                    $tong_tuan=0;
                }
                
                    $thu = $ngay->format('N');
                    switch ($row["Shift"]) {
                        case 1:
                            
                            if ($row["Sang"] == ''){
                                $giolam = $Gio_lam_cua_quan[$thu][0];
                            }else{
                                $giolam = $row["Sang"];
                            }
                            break;
                        
                        case 2:
                            
                            if ($row["Chieu"] == ''){
                                $giolam = $Gio_lam_cua_quan[$thu][1];
                            }else{
                                $giolam = $row["Chieu"];
                            }
                            break;

                        case 3:
                           
                            $giolam = 1;
                            if ($row["Sang"] == ''){
                                $giolam += $Gio_lam_cua_quan[$thu][0];
                            }else{
                                $giolam += $row["Sang"];
                            }
                            if ($row["Chieu"] == ''){
                                $giolam += $Gio_lam_cua_quan[$thu][1];
                            }else{
                                $giolam += $row["Chieu"];
                            }
                            
                            break;
                    }
                    $giolam += $row["Adj"];
                    $tong_tuan += $giolam;
                    $year = $ngay->format('Y');
                
            }
            
            $date->setISODate($year,$tuan);
            ?><tr>
                <td>Tuan: <?php echo $tuan; ?></td>
                <td><?php echo $date->format('d M Y'); ?></td>
                <td><?php echo $date->modify('+6 day')->format('d M Y'); ?></td>
                <td id = "tong_gion_week_<?php echo $tuan; ?>"><?php echo $tong_tuan; ?></td>
                <td><input onclick = "add_week_to_pay(this)" type="checkbox" name="pay_week[]" value="<?php echo $tuan;?>"></td>
                
                <td></td>
            </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan= "4">PAY</td>
                    <td>Rate</td>
                </tr>
                <tr>
                    <td colspan = "3">Tong Gio:</td>
                    <td id = "tong_gio_pay">0</td>
                    <td id = "rate_pay"><?php echo $rate; ?></td>
                    
                </tr>
                <tr>
                    <td colspan = "3">Thanh tien:</td>
                    <td id = "luong_pay">0</td>
                    
                </tr>
                
                <tr>
                    <td colspan = "3">Tip</td>
                    <td ><input onkeyup = "add_tip_payable()" type = "number" id ="tip_pay" value = "0"/></td>

                </tr>
                <tr>
                    <td colspan = "3">Tong Pay:</td>
                    <td id = "tong_pay">0</td>
                </tr>
            </tfoot>
        </table> 
        
        
<?php
        

    }else{
        echo "Khong co du lieu";
    }

?>

