<?php 
include "Global.php";
include "DB_functions_NN.php";


$ten_boi = array_fill(0,20.,"0");
    $luong_boi = array_fill(0,20.,0);
    
    $rate = array_fill(0,20.,0);
    $ngay_chieu = array_fill(0,20.,0);
    $ngay_sang = array_fill(0,20.,0);
    $ngay_full = array_fill(0,20.,0);
    $sql = "
        Select Name, Shift, tb_boi_hour.Date,Adj,Sang, Chieu 
        From `NN`.`tb_boi_hour` 
        Left Join `NN`.`tb_gioLam` On tb_boi_hour.Date = tb_gioLam.Date
        Where   Paid = 0
                
        Order By Name       
            ";
    
    $index = 0;   
    $tong_tienLuong = 0;    
    $result = DB_run_query($sql);
    
    $tong_gio = 0;
    if ($result->num_rows > 0){
            while($row = $result->fetch_assoc()) {
                if ($ten_boi[$index] != $row["Name"]){
                    $index = $index + 1;
                    
                    $ten_boi[$index] = $row["Name"];
                    
                    
                    $luong_boi[$index] = 0;
                    $sql_rate = "
                        SELECT
                        `tb_nhanVien`.`Rate`
                        FROM `NN`.`tb_nhanVien`
                        WHERE 
                            `tb_nhanVien`.`Name` ='".$ten_boi[$index]."'

                    ";
                    $result_rate = DB_run_query($sql_rate);
                    if($result_rate->num_rows > 0){
                        $row_rate = $result_rate->fetch_assoc();
                        $rate[$index] = $row_rate["Rate"];
                    }else{
                        $rate[$index] = 6.7;
                    }
                    
                }
                $date = new Datetime($row["Date"]);
                
                $thu = $date->format('N');
                
                
                if ($row["Sang"] == ''){
                    $giolam_sang = $Gio_lam_cua_quan[$thu][0];
                }else{
                    $giolam_sang = $row["Sang"];
                }
                
                if ($row["Chieu"] == ''){
                    $giolam_chieu = $Gio_lam_cua_quan[$thu][1];
                }else{
                    $giolam_chieu = $row["Chieu"];
                }
                
                switch ($row["Shift"]) {
                    case 1 :
                        $luong_boi[$index] += $giolam_sang;
                        $ngay_sang[$index] +=1 ;
                        break;
                    
                    case 2 :
                        $luong_boi[$index] += $giolam_chieu;
                        $ngay_chieu[$index] += 1;
                        break;

                    case 3 :
                        $luong_boi[$index] += $giolam_sang;
                        $luong_boi[$index] += $giolam_chieu;
                        $luong_boi[$index] += 1;
                        $ngay_full[$index] += 1;
                        break;    
                }
                $luong_boi[$index] = $luong_boi[$index] + $row["Adj"];
                
            }
            
    }
?>
<table class = "tb_payable">
    <tbody>

<?php    

for ($i=1; $i <= $index; $i++) {
?> 
    <tr>
        <td><?php echo ucwords(strtolower($ten_boi[$i])); ?></td>
        <td><?php echo $luong_boi[$i]; ?></td>
        <td title = "<?php echo $rate[$i]; ?>"><?php echo money_format('%#10.2n',($luong_boi[$i]* $rate[$i])); ?></td>
        <td><button onclick = "pay_individual_weekly('<?php echo $ten_boi[$i];?>')">PAY</button></td>
    </tr>

<?php    
}    

?>    

    </tbody>
</table>

   
    


