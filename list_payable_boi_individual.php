<?php
include "Global.php";
include "DB_functions_NN.php";

if (isset($_GET["ten"])){
    $name = $_GET["ten"];
}
else{
    echo "No Name !";
    exit;
}
$payByDay = false;
$sql_rate = "
    SELECT
    `tb_nhanVien`.`Rate`
    FROM `NN`.`tb_nhanVien`
    WHERE 
        `tb_nhanVien`.`Name` ='".$name."' and
        `tb_nhanVien`.`Role` = 'Boi'

";
$result_rate = DB_run_query($sql_rate);
if($result_rate->num_rows > 0){
    $row_rate = $result_rate->fetch_assoc();
    $rate= $row_rate["Rate"];
    if ($rate > 20){
        $payByDay = true;
    } 
}else{
    $rate = 6.7;
}

if($payByDay){

    $sql = "
    Select Name, Shift, tb_boi_hour.Date,Adj 
    From `NN`.`tb_boi_hour` 

    Where   Paid = 0 and
            Name = '".$name."'
    Order By  tb_boi_hour.Date ";

}else{
    $sql = "
    Select Name, Shift, tb_boi_hour.Date,Adj,Sang, Chieu , Note 
    From `NN`.`tb_boi_hour` 
    Left Join `NN`.`tb_gioLam` On tb_boi_hour.Date = tb_gioLam.Date
    Where   Paid = 0 and
            Name = '".$name."'
    Order By  tb_boi_hour.Date ";
}


    
$tuan = 0; 
$tong_tuan = 0; 
$first_week = 0;
$index = 0;

$date = new DateTime();            
    $result = DB_run_query($sql);
    
    if ($result->num_rows > 0){
        
?>
    <div>
    <div class = "week_select_overlay" id = "week_select_overlay_boi">
        <table id = "payable_boi_individual" >
            <tbody id = "tb_weekly_hour">
            <?php 
            while($row = $result->fetch_assoc()) {
                $ngay = new Datetime($row["Date"]);
                
                $week_no = $ngay->format('W');
                if ($first_week == 0) {
                    $first_week = $week_no;
                }
                if ($tuan != $week_no){
                    if ($tong_tuan != 0){

                        $index++;
                        
                        $date->setISODate($year,$tuan);
                        
                        ?>
                        <tr>
                            <td>Tuan: <?php echo $tuan; ?></td>
                            <td name = "monday_date"><?php echo $date->format('d M Y'); ?></td>
                            <td><?php echo $date->modify('+6 day')->format('d M Y'); ?></td>
                            <td name = "payable_hour" id = "tong_gion_week_<?php echo $tuan; ?>"><?php echo $tong_tuan; ?></td>
                            
                            
                        </tr>
                        <?php
                    }
                    $tuan = $ngay->format('W');
                    $tong_tuan=0;
                }
                
                    $thu = $ngay->format('N');

                    if ($payByDay){
                        switch ($row["Shift"]) {                               
                            case 3:                               
                                $giolam = 1;
                                break;
                            default:
                                $giolam = 0.5;
                                break;    
                        }
                    }else{
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
                               
                                $giolam = 0;
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
                    }
                    
                    $giolam += $row["Adj"];
                    $tong_tuan += $giolam;
                    $year = $ngay->format('Y');
                
            }
            
            $date->setISODate($year,$tuan);
            ?><tr>
                <td>Tuan: <?php echo $tuan; ?></td>
                <td name = "monday_date"><?php echo $date->format('d M Y'); ?></td>
                <td><?php echo $date->modify('+6 day')->format('d M Y'); ?></td>
                <td name = "payable_hour" id = "tong_gion_week_<?php echo $tuan; ?>"><?php echo $tong_tuan; ?></td>
                
            </tr>
            </tbody>
            
        </table>
        </div>
        <div class = "pay_control_panel">
            <div class = "pay_range_control">
                <div class = "pay_range_control_P1">
                    <span class = "fr">Week</span><br>
                    <b><?php echo $name; ?></b>
                </div>
                <div class = "pay_range_control_P2">
                    <span><?php echo $first_week; ?></span>
                    <span class = "fr"><?php echo $tuan; ?></span>
                    <br>
                    <input onchange = "week_pay_change(this)" type="range" id="week_select" min = "1" value = "1" max = "<?php echo $index+1; ?>">
                </div>
                <button class = "fl" onclick ="pay_action_boi('<?php echo $name; ?>')">PAY</button> 
            </div>
            <div class = "pay_display_control">
                <div class= "hour display">Hr<br><span id = "hour_pay">0</span></div>
                <div class= "w_40"><br>x</div>
                <div class= "rate w_40">Rate<br> <span id = "rate_pay"><?php echo $rate; ?></span></div>
                <div class= "w_40"><br>=</div>
                <div class= "luong display"><br><span id = "luong_pay">0</span></div>
                <div class= "w_40"><br>+</div>
                <div class= "tip display">Tip<br> <input type = "number" id = "tip_pay" value = "0" onchange = "add_tip_payable()"/></div>
                <div class= "w_40"><br>=</div>
                <div class= "total display">£<br><span id = "total_pay">0</span></div>
                
            </div>
        </div>
        
    </div>    
        
<?php
        

    }else{
        echo "Khong co du lieu";
    }

?>

