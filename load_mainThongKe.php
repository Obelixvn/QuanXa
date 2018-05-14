<?php 
include "global.php";
include "DB_functions_NN.php";

if (isset($_GET["str_date"])) {
    $str_date = $_GET["str_date"];
}
$year = substr($str_date,0,4);
$week = substr($str_date,-2);

if ($week <= 2){
    $week += 50;
    $year -=1;
}else{
    $week -=2;
}


$date = new Datetime();
$date->setISODate($year,$week);

?>
<div class = "fl">
    <div>Week:</div>
    <div class = "mar_l_20">From</div>
    <div class = "mar_l_20">To</div>
    <div>Sale</div>
    
    <div class = "mar_l_20">Cash</div>
    <div class = "mar_l_20">Card</div>
    <div class = "mar_l_20">&nbsp</div>
    <div class = "mar_l_20">Delivery</div>
    <div class = "mar_l_20 tongItem_1">Total Sale</div>
    <div>Cost of Sale</div>
    <div class = "mar_l_20">Total cost:</div>
    <div class = "tongItem_1">Gross Profit</div>
    <div class = "mar_l_20">Margin</div>
    <div>Delivery Charge</div>
    <div class = "tongItem_1">Operating Profit</div>
    <div>Salary</div>
    <div class = "mar_l_20">Boi</div>
    <div class = "mar_l_20">&nbsp</div>
    <div class = "mar_l_20">Bep</div>
    <div class = "mar_l_20 tongItem_1">Total:</div>
    <div>Fixed Overhead Cost</div>
    <div>Card provider</div>
    <div>Electric</div>
    <div>Gas</div>
    <div>Waste</div>
    <div>Internet/Phone</div>
    <div>Quandoo</div>
    <div>POS</div>
    <div>Bank charge</div>
    <div>License(Premise/Music)</div>
    <div>Issurance</div>
    <div>Rent&Rate</div>
    <div>Water</div>
    <div>Other</div>
    <div class = "tongItem_2">Tax</div>
    <div >Operating Expense</div>
    <div class = "tongItem_1">Net Profit</div>
    <div>Cash AVA</div>
    <div></div>
</div>
<?php

for ($i=0; $i < 5; $i++) {
    

    ?>
    <div class = "fl tB_ThongKe_items">
        <div> Tuan: <?php echo $week;?></div>
    
    <?php
    
    $monday = $date->format('Y-m-d');

    ?>
    
    <div> <?php echo $date->format('d M Y')?></div>
    
    <?php
    $sunday = $date->modify('+ 6 day')->format('Y-m-d'); 

    ?>
    
    <div> <?php echo $date->format('d M Y')?></div>
    
    <?php

//Load Sale
    $sql = "SELECT * FROM view_tk_sale 
            WHERE WeekTK = ".$week." AND
                  YearTK = ".$year; 

    $result = DB_run_query($sql);
    if ($result->num_rows > 0){
        $row = $result->fetch_assoc();
        $cash_sale = $row["TKCash"];
        $sale_re = $row["TKCash"] + $row["TKCard"];
        $sale_del = $row["TKRoo"] + $row["TKUber"] + $row["TKJEat"];
        $tong_sale = $sale_re + $sale_del;
        ?>
        <div></div>
        
        <div class = "txt_l"> <?php echo money_format('%#10n',$row["TKCash"]);?> </div>
        <div class = "txt_l"> <?php echo money_format('%#10n',$row["TKCard"]);?> </div>
        <div class = "txt_r"> <?php echo money_format('%#10n',$sale_re);?> </div>
        <div class = "txt_r"> <?php echo money_format('%#10n',$sale_del);?> </div>
        <div class = "txt_r tongItem_1"><span><?php echo money_format('%#10n',$tong_sale);?></span>  </div>
        
        
        <?php
    }else{
        ?>
        <div> Khong co du lieu Sale. Nen ko hien thi</div>
        </div>
        <?php
        if ($week == 52){
            $week = 1;
            $year+= 1;
        }
        else{
            $week += 1;
        }
        
        $date->modify('+1 day');
        continue;
    }
//Load Tien Do
$tong_do = 0;
$cash_expense = 0;
$sql = "SELECT * from view_tk_purchase
        WHERE   Week = ".$week." AND 
                Year = ".$year;

$result = DB_run_query($sql);
while ($row = $result->fetch_assoc()){
    if ($row["supplier"] == 'Jacky'){
        $cash_expense += $row["Cost"];
    }
    ?>
    <div class = "hide_true txt_r" name = "purchase_W"> 
        <?php 
            echo $row["supplier"]." : ".money_format('%#10n',$row["Cost"]);
            $tong_do += $row["Cost"];
        ?>
    </div>
    
    <?php

}
?>
<div></div>
<div class = "txt_r"> (<?php echo money_format('%#10n',$tong_do);?>)</div>

<?php
//Gross Profit
$Gross_Profit = $tong_sale - $tong_do;
$gross_P = $Gross_Profit/$tong_sale  * 100;
?>

<div class = "txt_r tongItem_1"><span><?php echo money_format('%#10n',$Gross_Profit);?></span> </div>
<div class = "txt_r"> <?php echo number_format($gross_P,2)."%";?></div>


<?php

//Delivery charge

$sql_expense = "
SELECT sum(amount) as expense
FROM tb_expense
WHERE   tb_expense.`To` = '".$sunday."' and
        tb_expense.`FROM` = '".$monday."' and
        `Cat 1` = 'Delivery charge'
";
$result_expense = DB_run_query($sql_expense);
$row_delCharge = $result_expense->fetch_assoc();


$del_charge = $row_delCharge['expense'];
?>
<div class = "txt_r">( <?php echo money_format('%#10n',$del_charge);?>)</div>

<?php

$net_taking = $Gross_Profit  - $del_charge;
?>
<div class = "txt_r tongItem_1"><span><?php echo money_format('%#10n',$net_taking);?></span> </div>
<div></div>
<?php

//Load Luong Boi
$tipBoi = 0;
$sql_expense = "
SELECT sum(amount) as luongBoi , `Cat 3`
FROM tb_expense
WHERE   tb_expense.`To` = '".$sunday."' and
        tb_expense.`FROM` = '".$monday."' and
        `Cat 1` = 'Luong' and 
        `Cat 2` = 'Boi'
GROUP BY `Cat 3`        
";
$result_expense = DB_run_query($sql_expense);
while($row_luongBoi = $result_expense->fetch_assoc()){
    if($row_luongBoi["Cat 3"] == "Basic"){
        $luongBoi = $row_luongBoi['luongBoi'];
    } else{
        $tipBoi = $row_luongBoi['luongBoi'];
    }
}



if($luongBoi < 1000 ){
    $sql_luongBoi = "SELECT sum(tienLuong) as luongBoi
                    FROM NN.view_luongboi
                    WHERE `year` = ".$year." AND
                    `week` = ".$week;
    $result_expense = DB_run_query($sql_luongBoi);
    $row_luongBoi = $result_expense->fetch_assoc();  
    $luongBoi = $row_luongBoi['luongBoi'];              
}

?>
<div  class = "txt_l"> <?php echo money_format('%#10n',$luongBoi);?></div>
<div  class = "txt_l"> <?php echo money_format('%#10n',$tipBoi);?></div>


<?php
$luongBoi += $tipBoi;
$luongBep = 0;
// Load luong Bep
$weekBep = $year*100 + $week;
$sql_luongBep = "SELECT sum(Luong) as luongBep
                FROM NN.view_luongbep
                WHERE `Week` = ".$weekBep;
$result_expense = DB_run_query($sql_luongBep);
$row_luongBep = $result_expense->fetch_assoc();
$luongBep = $row_luongBep['luongBep'];

$cash_expense += $luongBep;

$tonng_luong = $luongBep + $luongBoi;
?>
<div  class = "txt_l"> <?php echo money_format('%#10n',$luongBep);?></div>
<div  class = "txt_l tongItem_1"><span><?php echo money_format('%#10n',$tonng_luong);?></span> </div>
<div class = "">&nbsp</div>
<?php
//Card Provider
$tong_expense_cat1 = 0;
$sql_expense = "
SELECT sum(per_week) as expense
FROM tb_expense
WHERE   tb_expense.`To` >= '".$sunday."' and
        tb_expense.`FROM` <= '".$monday."' and
        `Cat 1` = 'Card Provider'
";
$result_expense = DB_run_query($sql_expense);
$row_cardProvider = $result_expense->fetch_assoc();

$expense_cardProvider = $row_cardProvider["expense"];

if (!$expense_cardProvider > 0 ){
    $expense_cardProvider = $Weekly_expense_cat1["Card Provider"];
}
$tong_expense_cat1 += $expense_cardProvider;

?>

<div  class = "txt_l"> <?php echo money_format('%#10n',$expense_cardProvider);?></div>

<?php
//Electric
$sql_expense = "
SELECT sum(per_week) as expense
FROM tb_expense
WHERE   tb_expense.`To` >= '".$sunday."' and
        tb_expense.`FROM` <= '".$monday."' and
        `Cat 1` = 'Electric'
";
$result_expense = DB_run_query($sql_expense);
$row_expense = $result_expense->fetch_assoc();

$expense_cat1 = $row_expense["expense"];

if (!$expense_cat1 > 0 ){
    $expense_cat1 = $Weekly_expense_cat1["Dien"];
}
$tong_expense_cat1 += $expense_cat1;
?>

<div  class = "txt_l"> <?php echo money_format('%#10n',$expense_cat1);?></div>

<?php
//Gas
$sql_expense = "
SELECT sum(per_week) as expense
FROM tb_expense
WHERE   tb_expense.`To` >= '".$sunday."' and
        tb_expense.`FROM` <= '".$monday."' and
        `Cat 1` = 'Gas'
";
$result_expense = DB_run_query($sql_expense);
$row_expense = $result_expense->fetch_assoc();


    $expense_cat1 = $row_expense["expense"];



if (!$expense_cat1 > 0 ){
    $expense_cat1 = $Weekly_expense_cat1["Gas"];
}
$tong_expense_cat1 += $expense_cat1;
?>
<div  class = "txt_l"> <?php echo money_format('%#10n',$expense_cat1);?></div>
<?php
//Waste
$sql_expense = "
SELECT sum(per_week) as expense
FROM tb_expense
WHERE   tb_expense.`To` >= '".$sunday."' and
        tb_expense.`FROM` <= '".$monday."' and
        `Cat 1` = 'Waste'
";
$result_expense = DB_run_query($sql_expense);
$row_expense = $result_expense->fetch_assoc();

$expense_cat1 = $row_expense["expense"];

if (!$expense_cat1 > 0 ){
    $expense_cat1 = $Weekly_expense_cat1["Rac"];
}
$tong_expense_cat1 += $expense_cat1;
?>
<div class = "txt_l"> <?php echo money_format('%#10n',$expense_cat1);?></div>
<?php
//Internet
$sql_expense = "
SELECT sum(per_week) as expense
FROM tb_expense
WHERE   tb_expense.`To` >= '".$sunday."' and
        tb_expense.`FROM` <= '".$monday."' and
        `Cat 1` = 'Internet'
";
$result_expense = DB_run_query($sql_expense);
$row_expense = $result_expense->fetch_assoc();

$expense_cat1 = $row_expense["expense"];

if (!$expense_cat1 > 0 ){
    $expense_cat1 = $Weekly_expense_cat1["Internet"];
}
$tong_expense_cat1 += $expense_cat1;
?>
<div class = "txt_l"> <?php echo money_format('%#10n',$expense_cat1);?></div>
<?php
//Quandoo
$sql_expense = "
SELECT sum(per_week) as expense
FROM tb_expense
WHERE   tb_expense.`To` >= '".$sunday."' and
        tb_expense.`FROM` <= '".$monday."' and
        `Cat 1` = 'Quandoo'
";
$result_expense = DB_run_query($sql_expense);
$row_expense = $result_expense->fetch_assoc();

$expense_cat1 = $row_expense["expense"];

if (!$expense_cat1 > 0 ){
    $expense_cat1 = $Weekly_expense_cat1["Quandoo"];
}
$tong_expense_cat1 += $expense_cat1;
?>
<div class = "txt_l"> <?php echo money_format('%#10n',$expense_cat1);?></div>
<?php
//POS
$sql_expense = "
SELECT sum(per_week) as expense
FROM tb_expense
WHERE   tb_expense.`To` >= '".$sunday."' and
        tb_expense.`FROM` <= '".$monday."' and
        `Cat 1` = 'Clover'
";
$result_expense = DB_run_query($sql_expense);
$row_expense = $result_expense->fetch_assoc();

$expense_cat1 = $row_expense["expense"];

if (!$expense_cat1 > 0 ){
    $expense_cat1 = $Weekly_expense_cat1["Clover"];
}
$tong_expense_cat1 += $expense_cat1;
?>
<div class = "txt_l"> <?php echo money_format('%#10n',$expense_cat1);?></div>
<?php
//Bank Charge
$sql_expense = "
SELECT sum(per_week) as expense
FROM tb_expense
WHERE   tb_expense.`To` >= '".$sunday."' and
        tb_expense.`FROM` <= '".$monday."' and
        `Cat 1` = 'Bank chager'
";
$result_expense = DB_run_query($sql_expense);
$row_expense = $result_expense->fetch_assoc();

$expense_cat1 = $row_expense["expense"];

if (!$expense_cat1 > 0 ){
    $expense_cat1 = $Weekly_expense_cat1["Bank chager"];
}
$tong_expense_cat1 += $expense_cat1;
?>
<div class = "txt_l"> <?php echo money_format('%#10n',$expense_cat1);?></div>
<?php
//Licenses
$sql_expense = "
SELECT sum(per_week) as expense
FROM tb_expense
WHERE   tb_expense.`To` >= '".$sunday."' and
        tb_expense.`FROM` <= '".$monday."' and
        `Cat 1` = 'Premise Lience'
";
$result_expense = DB_run_query($sql_expense);
$row_expense = $result_expense->fetch_assoc();

$expense_cat1 = $row_expense["expense"];

if (!$expense_cat1 > 0 ){
    $expense_cat1 = $Weekly_expense_cat1["Premise Lience"];
}
$tong_expense_cat1 += $expense_cat1;
?>
<div class = "txt_l"> <?php echo money_format('%#10n',$expense_cat1);?></div>
<?php
//Issurance
$sql_expense = "
SELECT sum(per_week) as expense
FROM tb_expense
WHERE   tb_expense.`To` >= '".$sunday."' and
        tb_expense.`FROM` <= '".$monday."' and
        `Cat 1` = 'Inssuare'
";
$result_expense = DB_run_query($sql_expense);
$row_expense = $result_expense->fetch_assoc();

$expense_cat1 = $row_expense["expense"];

if (!$expense_cat1 > 0 ){
    $expense_cat1 = $Weekly_expense_cat1["Building Inssuare"];
}
$tong_expense_cat1 += $expense_cat1;
?>
<div class = "txt_l"> <?php echo money_format('%#10n',$expense_cat1);?></div>
<?php
//Rent&Rate
$sql_expense = "
SELECT sum(per_week) as expense
FROM tb_expense
WHERE   tb_expense.`To` >= '".$sunday."' and
        tb_expense.`FROM` <= '".$monday."' and
        `Cat 1` = 'Rent_Rate'
";
$result_expense = DB_run_query($sql_expense);
$row_expense = $result_expense->fetch_assoc();

$expense_cat1 = $row_expense["expense"];

if (!$expense_cat1 > 0 ){
    $expense_cat1 = $Weekly_expense_cat1["Rent&Rate"];
}
$tong_expense_cat1 += $expense_cat1;
?>
<div class = "txt_l"> <?php echo money_format('%#10n',$expense_cat1);?></div>
<?php
//Water

?>
<div class = "txt_l"> <?php echo money_format('%#10n',$Weekly_expense_cat1["Nuoc"]);?></div>
<?php
$tong_expense_cat1 += $Weekly_expense_cat1["Nuoc"];
//Other
$sql_expense = "
SELECT sum(per_week) as expense
FROM tb_expense
WHERE   tb_expense.`To` >= '".$sunday."' and
        tb_expense.`FROM` <= '".$monday."' and
        `Cat 1` = 'Other'
";
$result_expense = DB_run_query($sql_expense);
$row_expense = $result_expense->fetch_assoc();

$expense_cat1 = $row_expense["expense"];

if (!$expense_cat1 > 0 ){
    $expense_cat1 = $Weekly_expense_cat1["Other"];
}
$tong_expense_cat1 += $expense_cat1;
?>
<div class = "txt_l"> <?php echo money_format('%#10n',$expense_cat1);?></div>
<?php

//Tax
$sql_expense = "
SELECT sum(per_week) as expense
FROM tb_expense
WHERE   tb_expense.`To` >= '".$sunday."' and
        tb_expense.`FROM` <= '".$monday."' and
        `Cat 1` = 'Tax' 
";
$result_expense = DB_run_query($sql_expense);
$row_expense = $result_expense->fetch_assoc();

$expense_cat1 = $row_expense["expense"];
$Vat_card = $row_expense["expense"];

$tong_expense_cat1 += $expense_cat1;
?>
<div class = "txt_l tongItem_2"> <span><?php echo money_format('%#10n',$expense_cat1);?></span></div>
<?php
$tong_expense = $tonng_luong + $tong_expense_cat1;
?>
<div class = "txt_r"> (<?php echo money_format('%#10n',$tong_expense);?>)</div>
<?php
$net_profit = $net_taking - $tong_expense ;
?>
<div class = "txt_r tongItem_1"> <span><?php echo money_format('%#10n',$net_profit);?></span></div>
<?php
//Cash avaliable

$sql_luongBoi = "SELECT sum(tienLuong) as luongBoi
FROM NN.view_luongboi
WHERE `Ten` = 'Co Van' AND `year` = ".$year." AND
`week` = ".$week;
$result_expense = DB_run_query($sql_luongBoi);
$row_luongBoi = $result_expense->fetch_assoc();

$cash_expense += $row_luongBoi['luongBoi'] - 140;


//$cashAva = $cashTk - $cashSupp - $luongBep;
$cashAva = $cash_sale - $cash_expense;


?>
<div class = "txt_r"> <?php echo money_format('%#10n',$cashAva);?></div>

<?php


$Vat_card = $net_taking*0.2 - $Vat_card;
$prefect_income = $net_profit - $Vat_card;
?>
<div class = "txt_r"> <?php echo money_format('%#10n',$prefect_income);?></div>

<?php




if ($week == 52){
    $week = 1;
    $year += 1;
    
}
else{
    $week += 1;
}

$date->modify('+1 day');
?>
</div>
<?php

}
?>
<div class = "clearfix"></div>