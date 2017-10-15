<?php
$date_0 = $_POST["date_0"];
$date_1 = $_POST["date_1"];
$cat_1 = $_POST["cat_1"];
$cat_2 = $_POST["cat_2"];
$cat_3 = $_POST["cat_3"];
$tien = $_POST["tien"];
$ten = $_POST["ten"];
include "DB_functions_NN.php";
include "global.php";

?>
<table class = "tb_input_expense">
    <thead>
            <tr>
                <th></th>
                <th>From</th>
                <th>To</th>
                <th>Name</th>
                <th>Cat 1</th>
                <th>Cat 2</th>
                <th>Cat 3</th>
                <th>Amount</th>
            </tr>
        
    </thead>
    <tbody>

<?php

for ($i=0; $i < count($ten); $i++) { 
    $date_from = $date_0[$i];
    $date_to = $date_1[$i];
    $name = $ten[$i];
    $amount = $tien[$i];
    $c1 = $cat_1[$i];
    $c2 = $cat_2[$i];
    $c3 = $cat_3[$i];
    if (!in_array('',array($date_from,$date_to,$name,$amount,$c1))){
        $sql = "
            INSERT INTO `NN`.`tb_Expense`
                (`Amount`,
                `From`,
                `To`,
                `Name`,
                `Cat 1`,
                `Cat 2`,
                `Cat 3`)
                VALUES
                (
                ".$amount.",
                '".$date_from."',
                '".$date_to."',
                '".$name."',
                '".$c1."',
                '".$c2."',
                '".$c3."'
                );

        ";
       
        $result = DB_run_query($sql);

?>
<tr>
                <td>
                    <i>Updated</i>
                </td>
                <td>
                    <?php 
                    $d = new Datetime($date_0[$i]);
                    echo $d->format('d M Y');
                    ?>
                </td>
                <td>
                    <?php 
                    $d = new Datetime($date_1[$i]);
                    echo $d->format('d M Y');
                    ?>
                </td>
                <td><?php echo $c1;?></td>
                <td><?php echo $c2;?></td>
                <td><?php echo $c3;?></td>
                <td><?php echo $name;?></td>
                <td><?php echo $amount;?></td>
                
</tr>
<?php
    }
}
?>
</tbody>
</table>
<button onclick = "done_updateExpense()">Done</button>