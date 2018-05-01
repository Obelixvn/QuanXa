

<form action="action_Paid_in_Full.php" method="post" id = "paid_in_full_form">
    <input type="hidden" name="Tong_Card" id = "tongCard_input" value = "0">
    <input type="hidden" name="date" value ="<?php echo $date_0; ?>">
    <input type="hidden" name="JEat" id = "Jeat_input" value = "0">
    <button type = "button" onclick = "action_Paid_in_Full()">Order(<?php echo $orderUpd; ?>)Items(<?php echo $itemUpd; ?>)</button>
</form>

<hr>
