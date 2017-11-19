<?php 
include "Global.php";
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
            FROM NN.tb_Sale 
            where   Date >= '".$monday."' 
                and Date <= '".$sunday."'
";

    $result = DB_run_query($sql);
    if ($result->num_rows > 0){
        $row = $result->fetch_assoc();
        ?>
        <div> <?php echo money_format('%#10n',$row["TongSale"]);?></div>
        
        <?php
    }else{

        ?>
        <div> 0</div>
        
        <?php
    }
    $tong_sale = $row["TongSale"];
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
if ($tong_do == 0) {
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

// Load luong Bep
$sql_expense = "SELECT `tb_Bep`.`d_o_w`
                    FROM `NN`.`tb_Bep`
                    WHERE Week = ".$week."
";
$result_expense = DB_run_query($sql_expense);
while ($row_luongBoi = $result_expense->fetch_assoc()){
    
};


$luongBoi = $row_luongBoi['luongBoi'];

$week += 1;
$date->modify('+1 day');
?>
</div>
<?php
}
?>