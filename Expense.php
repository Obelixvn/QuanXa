<html>

<head>
    <link rel="stylesheet" href="Style.css">
    <link rel="stylesheet" href="Style_expensePage.css">
    
</head>

<body onload = "expensePage_onload()"> 
<?php
        include 'Mainbar.php';
        
?> 

<script src="java_functions_NN.js">
        
        
</script>
<script src="java_functions_Expsense.js">
        
        
</script>    
<fieldset id = "expense_field">
    <legend>Expenses </legend>
    <table id = "tb_expense" class = "tb_input_expense">
        <thead>
            <tr>
                <th>From</th>
                <th>To</th>
                <th>Name</th>
                <th>Cat 1</th>
                <th>Cat 2</th>
                <th>Cat 3</th>
                <th>Amount</th>
            </tr>
        </thead>
        <tbody id = "tbody_expense">
            
            <tr>
                <td><input type ="date" name = "bat_dau"></td>
                <td><input type ="date" name = "ket_thuc"></td>
                <td><input type = "text" name = "ten"></td>
                <td><input type = "text" name = "cat1"></td>
                <td><input type = "text" name = "cat2"></td>
                <td><input type = "text" name = "cat3"></td>
                <td><input type = "number" name = "tien"></td>
            </tr>
        </tbody>
    </table>    
    <button type = "button" onclick = "them_item_expense()">Them</button>
    <button type = "button" onclick = "update_expense()">Confirm</button>
</fieldset>

<fieldset >
    <legend>Expenses incured</legend>
    <div>
        <input onclick = "load_expenseTB('Week')" type = "radio" name = "orderBy" checked value = "Week">Week
        <input onclick = "load_expenseTB('Newest')"type = "radio" name = "orderBy" value = "Newest">Moi nhap
    </div>
    <div id ="expense_input"></div>
    <div id = "expense_table">
    </div>
</fieldset>    

</body>
</html>