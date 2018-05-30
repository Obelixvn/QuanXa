<?php 
include "DB_functions_NN.php";
include "Global.php";
$date = new Datetime($_POST["ngay"]);

$net = $_POST["net"];

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
}
$expense = array ($row["JEat"] - $net[0] , $row["Uber"] - $net[1] , $row["Roo"] - $net[2] );
$money_style = '%.2n';

$tong_gross = $row["JEat"]+$row["Uber"]+$row["Roo"];
$tong_net =$net[0]+$net[1]+$net[2];

$date_0 = new Datetime($_POST["ngay"]);
$name = array ('Just Eat','Uber','Roo');
for ($i=0; $i < 3; $i++) { 
    $sql = "
        INSERT INTO `NN`.`tb_expense`
            (`Amount`,
            `From`,
            `To`,
            `Name`,
            `Cat 1`,
            `Cat 2`)
            VALUES
            (
            ".number_format($expense[$i],2).",
            '".$date_0->format('Y-m-d')."',
            '".$date->format('Y-m-d')."',
            '".$name[$i]."',
            'Delivery charge',
            '".$name[$i]."'
            )";
    $result = DB_run_query($sql);
    
}

?>
<tr>
    <td>Just Eat</td>
    <td ><?php echo money_format($money_style,number_format($row["JEat"],2)) ;?></td>
    <td><?php echo money_format($money_style,$net[0]) ;?></td>
    <td ><?php echo number_format($net[0]/$row["JEat"]*100,2) ;?>%</td>
    
</tr>
<tr>
    <td>Uber</td>
    <td id = "gross_2"><?php echo money_format($money_style,number_format($row["Uber"],2,'.',''));?></td>
    <td><?php echo money_format($money_style,$net[1]) ;?></td>
    <td id = "ratio_2"><?php echo number_format($net[1]/$row["Uber"]*100,2) ;?>%</td>
    
</tr>
<tr>
    <td>Roo</td>
    <td id = "gross_3"><?php echo money_format($money_style,number_format($row["Roo"],2,'.',''));?></td>
    <td><?php echo money_format($money_style,$net[2]) ;?></td>
    <td id = "ratio_3"><?php echo number_format($net[2]/$row["Roo"]*100,2) ;?>%</td>
    
</tr>
<tr>
    <td></td>
    <td id = "gross_tong"><?php echo money_format($money_style,$tong_gross);?></td>
    <td id = "net_tong"><?php echo money_format($money_style,$tong_net) ;?></td>
    <td id = "ratio_tong"><?php echo number_format($tong_net/$tong_gross*100,2) ?>%</td>
</tr>
