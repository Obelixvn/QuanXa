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


$date = new Datetime();
$date->setISODate($year,$week);



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
    $sql = "SELECT sum(cash) + sum(Card) + sum(Roo) + sum(JEat) + sum(Uber) as TongSale 
            FROM NN.tb_sale 
            where   Date >= '".$monday."' 
                and Date <= '".$sunday."'
";

    $result = DB_run_query($sql);
    $row = $result->fetch_assoc();
    
    if ($row["TongSale"] != NULL){
        
        ?>
        <div> <?php echo money_format('%#10n',$row["TongSale"]);?></div>
        
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
    $tong_sale = $row["TongSale"];

//Tien mat

$sql = "SELECT sum(cash)  as cashTK
FROM NN.tb_sale 
where   Date >= '".$monday."' 
    and Date <= '".$sunday."'
";

$result = DB_run_query($sql);
$row = $result->fetch_assoc();
$cashTk = $row["cashTK"];

?>
<div> <?php echo money_format('%#10n',$cashTk);?></div>

<?php
//Load Tien Do

$sql = "
SELECT sum(cost) as tong_tuan from tb_purchase
WHERE   date >= '".$monday."' 
        and date <= '".$sunday."'";



$result = DB_run_query($sql);
$row = $result->fetch_assoc();

?>
<div> <?php echo money_format('%#10n',$row["tong_tuan"]);?></div>

<?php

$tong_do = $row["tong_tuan"];
if ($tong_sale == 0) {
    $gross_P = 0;
}else{
    $gross_P = ($tong_sale - $tong_do)/$tong_sale * 100;
}


//Gross Profit

?>
<div> <?php echo number_format($gross_P,2);?>%</div>

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
<div> (<?php echo money_format('%#10n',$del_charge);?>)</div>

<?php

$net_taking = $tong_sale - $tong_do - $del_charge;

?>
<div> <?php echo money_format('%#10n',$net_taking);?></div>

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
}
?>