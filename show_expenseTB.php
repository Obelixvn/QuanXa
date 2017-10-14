<?php 
include "DB_functions_NN.php";
include "global.php";

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
            <th>From</th>
            <th>To</th>
            <th></th>
            <th></th>
            <th></th>
            <th>Amount</th>
        </tr>
    </thead>
    <tbody>
    <?php
    while($row = $result->fetch_assoc()) {
?>
    <tr>
        <td><?php echo $row["From"]; ?></td>
        <td><?php echo $row["To"]; ?></td>
        <td><?php echo $row["From"]; ?></td>
        <td><?php echo $row["From"]; ?></td>
        <td><?php echo $row["Amount"]; ?></td>
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
