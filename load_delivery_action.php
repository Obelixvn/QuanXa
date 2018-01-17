<?php 
include "DB_functions_NN.php";
include 'global.php';
$date = new datetime($_GET["date"]);
$money_style = '%.2n';
$tong_net = 0;

$sql = "
        SELECT
            
            
            sum(`tb_sale`.`Roo`) as Roo,
            sum(`tb_sale`.`Uber`) as Uber,
            sum(`tb_sale`.`JEat`) as JEat
        FROM `NN`.`tb_sale`
        WHERE   DATE >= '".$date->format('Y-m-d')."' and
                DATE <= '".$date->modify('+6 day')->format('Y-m-d')."'

    ";
$result = DB_run_query($sql);

if ($result->num_rows > 0){
    $row = $result->fetch_assoc();
    $tong_gross = $row["Roo"]+$row["JEat"]+$row["Uber"];

$sql = "
         SELECT
            `tb_expense`.`Amount` as expense
            
        FROM `NN`.`tb_expense`
        WHERE   `tb_expense`.`To` = '".$date->format('Y-m-d')."' and
                `tb_expense`.`From` = '".$date->modify('-6 day')->format('Y-m-d')."'
        and Name = '";
?>
<thead>
<tr>
    <th></th>
    <th>Gross</th>
    <th>Net</th>
    <th>Ratio</th>
    
</tr>
</thead>
<tbody id = "delivery_taking">
            
        
<tr>
    <td>Just Eat</td>
    <td id = "gross_1"><?php echo number_format($row["JEat"],2) ;?></td>
    
<?php 
            $sql_tmp = $sql."Just Eat'";
            
            $result = DB_run_query($sql_tmp);
            if ($result->num_rows > 0){
                $expense_rows = $result->fetch_assoc();
                $net_row = $row["JEat"] - $expense_rows["expense"];
                $tong_net += $net_row;
?>
            <td><?php  echo money_format($money_style,$net_row); ?></td>
            <td><?php echo number_format($net_row/$row["JEat"]*100,2) ;?>%</td>
<?php
               
            }else{
?>          
            <td>        
                <input name = "net_input" oninput="get_ratio_delivery(this,1)"type = "number"/>
            </td>
            <td id = "ratio_1"></td>
<?php
            }
?>
     
</tr>
<tr>
    <td>Uber</td>
    <td id = "gross_2"><?php echo number_format( $row["Uber"],2);?></td>
    
        <?php 
            $sql_tmp = $sql."Uber'";
            $result = DB_run_query($sql_tmp);
            if ($result->num_rows > 0){
                $expense_rows = $result->fetch_assoc();
                $net_row = $row["Uber"] - $expense_rows["expense"];
                $tong_net += $net_row;
?>
            <td><?php  echo money_format($money_style,$net_row); ?></td>
            <td><?php echo number_format($net_row/$row["Uber"]*100,2) ;?>%</td>
<?php
               
            }else{
?>          
            <td>        
                <input name = "net_input" oninput="get_ratio_delivery(this,2)"type = "number"/>
            </td>
            <td id = "ratio_2"></td>
<?php
            }
?>
        
    
        
    
    
</tr>
<tr>
    <td>Roo</td>
    <td id = "gross_3"><?php echo number_format( $row["Roo"],2);?></td>
<?php 
            $sql_tmp = $sql."Roo'";
            $result = DB_run_query($sql_tmp);
            if ($result->num_rows > 0){
                $expense_rows = $result->fetch_assoc();
                $net_row = $row["Roo"] - $expense_rows["expense"];
                $tong_net += $net_row;
?>
            <td><?php  echo money_format($money_style,$net_row); ?></td>
            <td><?php echo number_format($net_row/$row["Roo"]*100,2) ;?>%</td>
<?php
               
            }else{
?>          
            <td>        
                <input name = "net_input" oninput="get_ratio_delivery(this,3)"type = "number"/>
            </td>
            <td id = "ratio_3"></td>
<?php
            }
?>   
</tr>
<tr>
    <td></td>
    <td id = "gross_tong"><?php echo number_format( $tong_gross,2);?></td>
    <td id = "net_tong"><?php echo number_format($tong_net,2);?></td>
    <td id = "ratio_tong"><?php if ($tong_net != 0){ echo number_format($tong_net/$tong_gross*100,2)."%";} ?></td>
</tr>
<?php if ($tong_net== 0){

?>
<tr>
    <td colspan = "3"></td>
    <td><button onclick = "update_delivery_net()">Update</button></td>
</tr>
<?php }?>
</tbody>
<?php 
}
else{
   echo "Ko co du lieu";
}
?>