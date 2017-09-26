<?php
    include "DB_functions_NN.php";
    include "Global.php";
    include "compare_functions_NN.php";
    $date = new Datetime($_GET["Date"]);
    
    $items = $_GET["items"];
    $suppliers = $_GET["suppliers"];
    $week_no = $date->format("W");
    
    $str_date = $date->format('Y-m-d');
    if ($suppliers != ''){
        $list_thong_ke= $suppliers;
        $kieu_thong_ke = 'Supplier' ;
    }
    if ($items != ''){
        $list_thong_ke = $items;
        $kieu_thong_ke = 'Item Name' ;
    }
    $sql_selected = " 
                    SELECT sum(cost) as tong_tuan from tb_purchase
                    WHERE   date = '".$str_date."'";
    
    $result = DB_run_query($sql_selected);
            
            
    while($row = $result->fetch_assoc()) {
        if ($row["tong_tuan"] !=null){
              $tong_tuan_baseNumber =    $row["tong_tuan"];       
        }else{
              $tong_tuan_baseNumber =    0;           
        }
                    
                    
    }
    $date = $date->modify('-21 day');
                                
?>

<table  class = "tb_datDoPage tb_thongKe" id = "thong_ke_theo_tuan">
    <tr>
        <th><?php echo $kieu_thong_ke; ?></th>
        <th>Tuan: <?php echo($week_no-3) ?></th>
        <th>Tuan: <?php echo($week_no-2) ?></th>
        <th>Tuan: <?php echo($week_no-1) ?></th>
        <th class = "head_frame">Tuan: <?php echo($week_no) ?></th>
        <th>Tuan: <?php echo($week_no +1) ?></th>
        <th>Tuan: <?php echo($week_no +2) ?></th>
        <th>Tuan: <?php echo($week_no +3) ?></th>
    </tr>

<?php 
    echo "<tr>";
        echo "<td></td>";
    for ($i=0; $i < 7; $i++) { 
            $monday = $date->format('Y-m-d');
            $sunday = $date->modify('+6 day')->format('Y-m-d');
            $sql_tongTuan = "
                        SELECT sum(cost) as tong_tuan from tb_purchase
                        WHERE   date >= '".$monday."' 
                                and date <= '".$sunday."'";
            
            

            $result = DB_run_query($sql_tongTuan);
            
            
            while($row = $result->fetch_assoc()) {
                echo "<td class = \"txt_red txt_c";
                if ($i == 3 ) {
                            echo " body_frame";
                }
                echo "\">[";
                if ($row["tong_tuan"] !=null){
                    
                        
                        
                        echo money_format('%#10n', $row["tong_tuan"]);
                }else{
                        echo '0';
                }
                echo " ]</td>";    
                    
            }    
               
            $date = $date->modify('+1 day');    
        }
        $date = new Datetime($_GET["Date"]);
        $date = $date->modify('-21 day');
    foreach ($list_thong_ke as $sup ) {
        switch ($kieu_thong_ke) {
                case 'Supplier':
                    $name = $sup;
                    $sql_thongKe = "
                            SELECT
                                sum(cost) as tong_tien
                            FROM `NN`.`tb_purchase`join tb_items on item_id = id_item 
                            WHERE        supplier = '".$sup."'
                            ";
                    $str_td =  "<td  class = \"pad_b10 pad_t10\"colspan = \"4\" id = \"detailt_thong_ke_".$sup."\"></td>
                                <td class = \"pad_b10 pad_t10\"colspan = \"3\" id = \"detailt_thong_ke_Item_".$sup."\" ></td>";       
                    break;
                
                case 'Item Name':
                    $sql = "Select name from tb_items where id_item = ".$sup;
                    $result = DB_run_query($sql);
                    $row = $result->fetch_assoc();
                    $name = $row["name"];
                    $sql_thongKe = "
                        SELECT
                            sum(cost) as tong_tien
                        FROM `NN`.`tb_purchase` 
                        WHERE  item_id = '".$sup."'
                        "; 
                    $str_td =  "<td  class = \"pad_b10 pad_t10\"colspan = \"4\" id = \"detailt_thong_ke_".$sup."\"></td>";
            }
        
        
               

        echo "<tr>";
        
        echo "<td class = \"sup_name_thongKe\">".$name."</td>";

        for ($i=0; $i < 7; $i++) { 
            $monday = $date->format('Y-m-d');
            $sunday = $date->modify('+6 day')->format('Y-m-d');
            $str_date = "and date >= '".$monday."' 
                         and date <= '".$sunday."'";
            

            $result = DB_run_query($sql_thongKe.$str_date);
            
            
            while($row = $result->fetch_assoc()) {
                echo "<td class = \"tien_thongKe";
                if ($i == 3 ) {
                            echo " body_frame";
                }
                echo "\">";
                if ($row["tong_tien"] !=null){
                    
                        
                        
                        echo money_format('%#10n', $row["tong_tien"])."<br><button onclick = \"get_detailt_thongKe('".$monday."','".$sup."','".$kieu_thong_ke."')\">Chi tiet</button></td>";
                }else{
                        echo '0';
                }
                echo " </td>";  
                
                    
                    
            }    
               
            $date = $date->modify('+1 day');    
        }
        $date = new Datetime($_GET["Date"]);
        $date = $date->modify('-21 day');
?>
</tr>
<tr class = "tr_detailt_thongKe" > 
    <?php echo $str_td; ?>
    <td> <span name = "close_button_detailt_thongKe" class = "closebtn" type = "button" onclick ="dong_thongKe_detailt(this.parentElement)">&times;</span></td>
</tr>

<?php } ?>
    <tr class = "w100 h20">
        <td colspan = "4" ></td>
        <td class = "foot_frame"></td>
        <td colspan = "2"><td>
    </tr>
</table>