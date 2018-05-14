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
<table class = "tb_input_expense ">
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

        $day_from = new Datetime($date_from);
        $day_to = new Datetime($date_to);

        $thu_0 = $day_from->format('N');
        $year_0 = $day_from->format('Y');
        $week_0 = $day_from->format('W');
        
        $thu_1 = $day_to->format('N');
        $year_1 = $day_to->format('Y');
        $week_1 = $day_to->format('W');

        if($thu_0 == 1){
            $monday = $date_from;
        }else{
            $monday = $day_from->modify('last monday')->format('Y-m-d');
        }
        if($thu_1 == 7){
            $sunday = $date_to;
        }else{
            $sunday = $day_to->modify('this sunday')->format('Y-m-d');
        }


        if ($year_1 < $year_0){
            echo "Nhap sai nam";
            exit;
        }else{
            $week_1 += 52*($year_1 - $year_0) ;
        }
        $week_diff = $week_1 - $week_0;
        
        if ($week_diff <0 ){
            echo "Nhap ngay ko dung";
            exit;
        }else{
            switch ($week_diff) {
                case 0:
                    $no_week = 1;
                    $total_days = $thu_1 - $thu_0 +1;
                    if ($total_days <= 0){
                        echo "Nhap sai ngay";
                        exit;
                    }
                    $sql = "
                    INSERT INTO `NN`.`tb_expense`
                        (`Amount`,
                        `From`,
                        `To`,
                        `Name`,
                        `Cat 1`,
                        `Cat 2`,
                        `Cat 3`, 
                        `per_week`)
                        VALUES
                        (
                        ".$amount.",
                        '".$monday."',
                        '".$sunday."',
                        '".$name."',
                        '".$c1."',
                        '".$c2."',
                        '".$c3."',
                        ".$amount."
                        );
        
                    ";
                    $result = DB_run_query($sql);
                    break;
                case 1:
                    $no_week = 2;
                    $total_days = 8 - $thu_0 + $thu_1;
                    $rate_day = $amount/$total_days;
                    $fist_week = $rate_day * (8-$thu_0);
                    $second_week = $rate_day * $thu_1;
                    $sql = "
                    INSERT INTO `NN`.`tb_expense`
                        (`Amount`,
                        `From`,
                        `To`,
                        `Name`,
                        `Cat 1`,
                        `Cat 2`,
                        `Cat 3`, 
                        `per_week`)
                        VALUES
                        (
                        ".$fist_week.",
                        '".$monday."',
                        '".$day_from->modify('this sunday')->format('Y-m-d')."',
                        '".$name."',
                        '".$c1."',
                        '".$c2."',
                        '".$c3."',
                        ".$fist_week."
                        );
        
                    ";
                    $result = DB_run_query($sql);
                    $sql = "
                    INSERT INTO `NN`.`tb_expense`
                        (`Amount`,
                        `From`,
                        `To`,
                        `Name`,
                        `Cat 1`,
                        `Cat 2`,
                        `Cat 3`, 
                        `per_week`)
                        VALUES
                        (
                        ".$second_week.",
                        '".$day_to->modify('last monday')->format('Y-m-d')."',
                        '".$sunday."',
                        '".$name."',
                        '".$c1."',
                        '".$c2."',
                        '".$c3."',
                        ".$second_week."
                        );
        
                    ";
                    $result = DB_run_query($sql);
                    # code...
                    break;
                    
                default:
                    $no_week = 3;
                    $total_days = $week_diff*7 - $thu_0 + $thu_1 +1;
                    $rate_day = $amount/$total_days;
                    $fist_week = $rate_day * (8-$thu_0);
                    $second_week = $rate_day * $thu_1;
                    $the_rest = $amount - $fist_week - $second_week;
                    $per_week = $rate_day * 7;
                    $sql = "
                    INSERT INTO `NN`.`tb_expense`
                        (`Amount`,
                        `From`,
                        `To`,
                        `Name`,
                        `Cat 1`,
                        `Cat 2`,
                        `Cat 3`, 
                        `per_week`)
                        VALUES
                        (
                        ".$fist_week.",
                        '".$monday."',
                        '".$day_from->modify('this sunday')->format('Y-m-d')."',
                        '".$name."',
                        '".$c1."',
                        '".$c2."',
                        '".$c3."',
                        ".$fist_week."
                        );
        
                    ";
                    $result = DB_run_query($sql);
                    $sql = "
                    INSERT INTO `NN`.`tb_expense`
                        (`Amount`,
                        `From`,
                        `To`,
                        `Name`,
                        `Cat 1`,
                        `Cat 2`,
                        `Cat 3`, 
                        `per_week`)
                        VALUES
                        (
                        ".$second_week.",
                        '".$day_to->modify('last monday')->format('Y-m-d')."',
                        '".$sunday."',
                        '".$name."',
                        '".$c1."',
                        '".$c2."',
                        '".$c3."',
                        ".$second_week."
                        );
        
                    ";
                    $result = DB_run_query($sql);
                    $sql = "
                    INSERT INTO `NN`.`tb_expense`
                        (`Amount`,
                        `From`,
                        `To`,
                        `Name`,
                        `Cat 1`,
                        `Cat 2`,
                        `Cat 3`,
                        `per_week`)
                        VALUES
                        (
                        ".$the_rest.",
                        '".$day_from->modify('+1 day')->format('Y-m-d')."',
                        '".$day_to->modify('-1 day')->format('Y-m-d')."',
                        '".$name."',
                        '".$c1."',
                        '".$c2."',
                        '".$c3."',
                        ".$per_week."
                        );
        
                    ";
                    $result = DB_run_query($sql);
                    break;
            }
        }
        
        
        
       
        
       
        

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