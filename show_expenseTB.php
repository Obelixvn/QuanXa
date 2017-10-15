<?php 
include "DB_functions_NN.php";
include "global.php";
setlocale(LC_MONETARY, 'en_GB.UTF-8');
if (isset($_GET["orderBy"])){

    $orderby = $_GET["orderBy"];
}
$sql = "
    SELECT *
    FROM tb_expense
    
";
if ($orderby == "Week"){
    $sql .= " WHERE '".$Ngay_hom_nay->format('Y-m-d')."' >= tb_expense.From
                AND '".$Ngay_hom_nay->format('Y-m-d')."' <= tb_expense.To";
}
$sql .= " ORDER BY ID DESC
        Limit 10";
$result = DB_run_query($sql);
if ($result->num_rows > 0){

    ?>
    <table>
    <thead>
        <tr>
            <th colspan = "2">Ten</th>
            
            <th>Amount</th>
            
            <th>From</th>
            <th>To</th>
            
        </tr>
    </thead>
    <tbody>
    <?php
    while($row = $result->fetch_assoc()) {
?>
    <tr>
        <td><?php echo $row["Name"]; ?></td>
        <td><?php echo $row["Cat 1"]; ?></td>
        <td><?php echo money_format('%#10.2n',$row["Amount"]);  ?></td>
        <td><?php $date = new Datetime ($row["From"]); echo $date->format("d M Y"); ?></td>
        <td><?php $date = new Datetime ($row["To"]); echo $date->format("d M Y");?></td>
        
        
    </tr>

<?php
    }
    ?>
    
        
        </tbody>
    </table>
    <?php
}
else{
    echo "No Data found";
    exit;
}   

?>
