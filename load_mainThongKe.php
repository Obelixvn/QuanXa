<?php 
include "global.php";
include "DB_functions_NN.php";

if (isset($_GET["str_date"])) {
    $str_date = $_GET["str_date"];
}
$year = substr($str_date,0,4);
$week = substr($str_date,-2);

if ($week <= 3){
    $week += 49;
    $year -=1;
}else{
    $week -=3;
}
$week = 6;
$year = 2018;

$date = new Datetime();
$date->setISODate($year,$week);

?>
<div class = "fl">
    <div>Week:</div>
    <div class = "mar_l_20">From</div>
    <div class = "mar_l_20">To</div>
    <div>Sale</div>
    <div class = "mar_l_20">Restuarant</div>
    <div class = "mar_l_20">Cash</div>
    <div class = "mar_l_20">Card</div>
    <div class = "mar_l_20">Delivery</div>
    <div class = "mar_l_20">Total Sale</div>
    <div>Cost of Sale(List Suppliers)</div>
    <div>Gross Profit</div>
    <div>Margin</div>
    <div>Operating Expenses</div>
    <div>Delivery Charge</div>
    <div>Salary(Boi/Bep)</div>
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
    <div>Water</div>
    <div>Other</div>
    <div>VAT</div>
</div>
<?php

for ($i=0; $i < 7; $i++) {
    

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
        $sale_re = $row["TKCash"] + $row["TKCard"];
        $sale_del = $row["TKRoo"] + $row["TKUber"] + $row["TKJEat"];
        $tong_sale = $sale_re + $sale_del;
        ?>
        <div></div>
        <div class = "txt_l"> <?php echo money_format('%#10n',$sale_re);?> </div>
        <div class = "txt_l"> <?php echo money_format('%#10n',$row["TKCash"]);?> </div>
        <div class = "txt_l"> <?php echo money_format('%#10n',$row["TKCard"]);?> </div>
        <div class = "txt_l"> <?php echo money_format('%#10n',$sale_del);?> </div>
        <div class = "txt_r"> <?php echo money_format('%#10n',$tong_sale);?> </div>
        
        
        <?php
    }else{
        ?>
        <div> Khong co du lieu Sale. Nen ko hien thi</div>
        </div>
        <?php
        if ($week == 52){
            $week = 1;
            
        }
        else{
            $week += 1;
        }
        
        $date->modify('+1 day');
        continue;
    }
//Load Tien Do
$tong_do = 0;
$sql = "SELECT * from view_tk_purchase
        WHERE   Week = ".$week." AND 
                Year = ".$year;

$result = DB_run_query($sql);
while ($row = $result->fetch_assoc()){

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
<div class = "txt_r"> <?php echo money_format('%#10n',$tong_do);?></div>

<?php
//Gross Profit
$Gross_Profit = $tong_sale - $tong_do;
$gross_P = $Gross_Profit/$tong_sale  * 100;
?>

<div class = "txt_r"> <?php echo money_format('%#10n',$Gross_Profit);?></div>
<div class = "txt_r"> <?php echo number_format($gross_P,2)."%";?></div>
<div></div>

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
<div class = "txt_l"> <?php echo money_format('%#10n',$del_charge);?></div>

<?php

$net_taking = $tong_sale - $tong_do - $del_charge;

?>
<div> <?php //echo money_format('%#10n',$net_taking);?></div>

<?php
//Load Luong Boi

$sql_expense = "
SELECT sum(amount) as luongBoi
FROM tb_expense
WHERE   tb_expense.`To` = '".$sunday."' and
        tb_expense.`FROM` = '".$monday."' and
        `Cat 1` = 'Luong' and 
        `Cat 2` = 'Boi'
";
$result_expense = DB_run_query($sql_expense);
$row_luongBoi = $result_expense->fetch_assoc();


$luongBoi = $row_luongBoi['luongBoi'];

?>
<div> <?php echo money_format('%#10n',$luongBoi);?></div>

<?php
$luongBep = 0;
// Load luong Bep
$sql_expense = "SELECT `tb_bep`.`d_o_w`, Rate
                    FROM `NN`.`tb_bep`inner JOIN tb_nhanVien on nv_ID = tb_nhanVien.ID
                    WHERE Week = ".$week."
";
$result_expense = DB_run_query($sql_expense);
while ($row_luongBep = $result_expense->fetch_assoc()){
    $hr = 0;
    $rate = $row_luongBep["Rate"];
    $wk_hr = str_split($row_luongBep['d_o_w']);
    foreach ($wk_hr as $e) {
        switch ($e) {
            case 0 :
                
                break;
            case 3 :
                $hr += 1;
                break;
            default:
                $hr += 0.5;
                break;
        }
    }
    $luongBep += $hr * $rate;
};
?>
<div> <?php echo money_format('%#10n',$luongBep);?></div>

<?php
//Fix Rate 
$tienve1 = $net_taking  - $luongBep - $luongBoi - 1998 - 184-$Weekly_expense_cat1["Bank Holiday"];
?>

<div> <?php echo money_format('%#10n',1998);?></div>
<div> <?php echo money_format('%#10n',$tienve1);?></div>
<div> <?php echo money_format('%#10n',184);?></div>
<?php

//Cash avaliable

$sql = "
SELECT sum(cost) as cashSupp from tb_purchase inner join tb_items on item_id = id_item
WHERE   date >= '".$monday."' 
        and date <= '".$sunday."'
        and supplier = 'Jacky'";



$result = DB_run_query($sql);
$row = $result->fetch_assoc();
$cashSupp = $row["cashSupp"];




$sql_expense = "
SELECT sum(amount) as luongCoVan
FROM tb_expense
WHERE   tb_expense.`To` = '".$sunday."' and
        tb_expense.`FROM` = '".$monday."' and
        `Cat 1` = 'Luong' and 
        `Cat 2` = 'Boi' and
        `Name` = 'Co Van'
";
$result_expense = DB_run_query($sql_expense);
$row_luongBoi = $result_expense->fetch_assoc();


$luongCoVan = $row_luongBoi['luongCoVan'];

//$cashAva = $cashTk - $cashSupp - $luongBep;
$cashAva = $cashTk - $cashSupp - $luongBep - (400 * $luongCoVan/540);

$cardTK = $tienve1 - $cashAva;
?>
<div> <?php echo money_format('%#10n',$cardTK);?></div>

<?php

?>
<div> <?php echo money_format('%#10n',$cashAva);?></div>
<div> <?php echo money_format('%#10n',$cashSupp);?></div>

<?php

$Vat_card = 0.9*0.2*($tong_sale - $cashTk);
$prefect_income = $tienve1 - $Vat_card;
?>
<div> <?php echo money_format('%#10n',$prefect_income);?></div>

<?php

$Vat_claim_tier1 = $Weekly_expense_cat1["Rent&Rate"] + $Weekly_expense_cat1["Dien"];


if ($week == 52){
    $week = 1;
    
}
else{
    $week += 1;
}

$date->modify('+1 day');
?>
</div>
<?php
exit;
}
?>