<?php
    include "functions_NN.php";
    include "global.php";
    $date = new Datetime ($_GET["Date"]);
    $date_1 = new Datetime ($_GET["Date_1"]);
    

    
?>
<i><?php echo $date->format('d M Y'); ?> - <?php echo $date_1->modify('+6 day')->format('d M Y'); ?>  </i>
<br>
<?php 
    $name =  $_GET["Name"];
    echo $name;
?>
<br>
<?php
    do {
    echo "Tuan ".$date->format('W').":<br>";
    $tong_gio = 0;
?>


<?php

    
    
    $sql = "
        Select Name, Shift, tb_boi_hour.Date,Adj,Sang, Chieu , Note 
        From `NN`.`tb_boi_hour` 
        Left Join `NN`.`tb_gioLam` On tb_boi_hour.Date = tb_gioLam.Date
        Where   tb_boi_hour.Date >= '".$date->format('Y-m-d')."' and
                tb_boi_hour.Date <= '".$date->modify('+6 day')->format('Y-m-d')."' and
                Name = '".$name."'
        Order By  tb_boi_hour.Date ";
    
                
    $result = DB_run_query($sql);
    
    if ($result->num_rows > 0){
            

                ?>
                <table id = "giolam_detailt">
                <tbody>
                    <tr>
                        <th class = "w10 tieude">Ngay</th>
                        <th class = "w10">Ca lam</th>
                        <th class = "w10">Gio lam</th>
                        <th class = "w10">Adj</th>
                        <th>Note</th>
                    </tr>
                <?php 
                while($row = $result->fetch_assoc()) {
                echo "<tr>";
                $ngay = new Datetime($row["Date"]);
                $thu = $ngay->format('D');
                echo "<td class = \"tieude\">".$thu."</td>";
                $thu = $ngay->format('N');
                switch ($row["Shift"]) {
                    case 1:
                        $ca_lam = 'Sang';
                        if ($row["Sang"] == ''){
                            $giolam = $Gio_lam_cua_quan[$thu][0];
                        }else{
                            $giolam = $row["Sang"];
                        }
                        break;
                    
                    case 2:
                        $ca_lam = 'Chieu';
                        if ($row["Chieu"] == ''){
                            $giolam = $Gio_lam_cua_quan[$thu][1];
                        }else{
                            $giolam = $row["Chieu"];
                        }
                        break;

                    case 3:
                        $ca_lam = 'Full';
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
                $tong_gio += $giolam;
                
                //$giolam +=$row["Adj"];
                echo "<td>".$ca_lam."</td>";
                echo "<td>".$giolam."</td>";
                echo "<td>(<i>".$row["Adj"]."</i>)</td>";
                echo "<td class = \"w50 tieude\">".$row["Note"]."</td>";
                echo "</tr>";
            }
            echo "<tr>";
            echo "<td colspan=\"2\" >Tong Gio :</td>";
            echo "<td class = \"sum_tong\">".$tong_gio."</td>";
            echo "</tr>";    

    }
    else{
        echo "Khong tim thay<br>";
    }          
            
    
?>
</tbody>    
</table> 
<hr>
<?php
$date->modify('+1 day');
}
while ($date < $date_1);?>