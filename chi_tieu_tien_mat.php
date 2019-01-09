<?php
include "DB_functions_NN.php";

if(isset($_GET['thang'])){
    $thang = $_GET['thang'];
    if ($thang >=1 && $thang <=12){
        $date_0 = "2018-".$thang."-01";
        $thang += 1;
        $date_1 = "2018-".$thang."-01";
        $sql_expense = "SELECT `From`, `To`, SUBSTRING(Name, -2) as Ngay, substring(Name, 1 , length(Name) -3)  as Ten, Amount 
                        From tb_expense 
                        WHERE tb_expense.`Cat 3` = 'Cash' 
                        AND tb_expense.from >= '".$date_0."'
                        AND tb_expense.from < '".$date_1."' 
                        Order by `From`, Ngay ASC" ;
        $sql_veg = "SELECT Date_format(date , '%e %b %Y') as date, sum(tb_purchase.cost) as tongtien
                    from tb_purchase INNER JOIN tb_items ON item_id = id_item 
                    WHERE supplier = 'Jacky' AND 
                    date >= '".$date_0."' AND date < '".$date_1."'
                    Group by date";
        $result = DB_run_query($sql_veg);
        $tong_veg = 0;
        ?>
         <h1>Vegetable</h1>
            <hr>
            <table id = 'chi_tieu_tien_mat_rau'>
            
        <?php
        while($row = $result->fetch_assoc()) { 
            $tong_veg += $row['tongtien'];
        ?>
            <tr>
                <td>
                    <?php echo $row['date']; ?>
                </td>
                <td>
                    <?php echo $row['tongtien']; ?>
                </td>
           </tr>
        <?php
        }
        ?>
        <tr>
            <td> <b>  Tong Tien Rau:</b> </td>
            <td> <b> <?php echo $tong_veg; ?> </b> </td>
        </tr> 
            </table>
        <?php
            $result_expense = DB_run_query($sql_expense);
        ?>
         <h1>Chi Phi Khac</h1>
            <hr>
            <table id = 'chi_tieu_tien_mat_cac_loai'>
            
        <?php
        $from = "";
        $tong_exp = 0;
        while($row_epx = $result_expense->fetch_assoc()) { 
            $tong_exp += $row_epx['Amount'];
            if($from != $row_epx['From']){
                $date_from = new DateTime($row_epx['From']);
                $date_to = new DateTime($row_epx['To']);
                $from = $row_epx['From'];
                ?>
                <tr>
                    <td colspan = "3">
                   <b> <?php echo $date_from->format('d M Y')." - ".$date_to->format('d M Y') ; ?></b>
                   </td>
                </tr>
        <?php
            }
        ?>
            <tr>
                <td>
                    <?php echo $row_epx['Ngay']; ?>
                </td>
                <td>
                    <?php echo $row_epx['Ten']; ?>
                </td>
                <td>
                    <?php echo $row_epx['Amount']; ?>
                </td>
            </tr>
        <?php
        }
        ?>
        <tr>
            <td colspan = "2">
                <b> Tong tien khac:</b>
            </td>
            <td>
                <b> <?php echo $tong_exp; ?></b>
            </td>
            
        </tr>
            </table>
<?php
    }
}else{
    Echo "Error 1019";
    exit;
}

?>