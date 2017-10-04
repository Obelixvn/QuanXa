<?
    include "functions_NN.php";
    include "global.php";
    global $Gio_lam_cua_quan;
    $date = new Datetime($_GET["Date"]);
    if ($_GET["Date_1"] == null){
        $date_1 = $date;
    }else{
        $date_1 = new Datetime($_GET["Date_1"]);
    }
    
    $ten_boi = array();
    $luong_boi = array();
    $ngay_sang = array();
    $ngay_chieu = array();
    $ngay_full = array();
    $rate = array();
    $sql = "
        Select Name, Shift, tb_boi_hour.Date,Adj,Sang, Chieu 
        From `NN`.`tb_boi_hour` 
        Left Join `NN`.`tb_gioLam` On tb_boi_hour.Date = tb_gioLam.Date
        Where   tb_boi_hour.Date >= '".$date->format('Y-m-d')."' and
                tb_boi_hour.Date <= '".$date_1->modify('+6 day')->format('Y-m-d')."'
                
        Order By Name       
            ";
    
    $index = 0;       
    $result = DB_run_query($sql);
    
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

?><style>

</style>
<table>
    <tbody>
        <tr>
            <th class = "ten_boi">Ten</th>
            <th style ="width:60px">Gio lam</th>
            <th>Luong</th>
            <th></th>
        </tr>
        <?php
            setlocale(LC_MONETARY, 'en_GB.UTF-8');
            $date = new Datetime($_GET["Date"]);
            $date_1 = new Datetime($_GET["Date_1"]);
            for ($i=1; $i <= count($ten_boi); $i++) {
                $str = '';
                if ($ngay_full[$i] != ''){
                    $str = $ngay_full[$i]." full,";
                }
                if ($ngay_sang[$i] != ''){
                    $str = $str." ".$ngay_sang[$i]." sang,";
                }
                if ($ngay_chieu[$i] != ''){
                    $str = $str." ".$ngay_chieu[$i]." toi";
                }
                echo "<tr>"; 
                echo "<td class =\"ten_boi\">".ucwords(strtolower($ten_boi[$i]))."</td>";
                echo "<td title =\"".$str."\">".$luong_boi[$i]."</td>";
                $tien_luong = $luong_boi[$i]* $rate[$i];
                $tong_tienLuong += $tien_luong;
                echo "<td>".money_format('%#10.2n',$tien_luong)."</td>";
                echo "<td><button type =\"button\" onclick = \"show_lichLam_detailt('".$ten_boi[$i]."','".$date->format('Y-m-d')."','".$date_1->format('Y-m-d')."')\">Chi tiet</button></td>";
                echo "</tr>";
                $tong_gio = $tong_gio + $luong_boi[$i];
            }
        ?>
        <tr>
            <td>Tong Gio:</td>
            <td class = "sum_tong"><?php echo $tong_gio; ?></td>
            <td class = "sum_tong"><?php echo money_format('%(#10.2n',$tong_tienLuong); ?></td>
        </tr>
    </tbody>
</table>
