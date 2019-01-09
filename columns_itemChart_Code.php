<?php
    $count = 0;
    $saleNumber = false;
    if(substr($Columns_title,0,4) == "SALE"){
        $saleNumber = true;
    }
    ?>
    <div class = "div_topChart_column">
    <div class = "div_topChart_items">
        <?php echo $Columns_title; ?>
    </div>
    <?php
    foreach ($ThongKE as $key => $value) {
        if(($count > $TOP_count) && ($TOP_count != 1)){
            break;
        }
        if($saleNumber){
            $Changing_value = round($first_week_value[$key]- ($value-$first_week_value[$key])/3,2);
        }else{
            $Changing_value = round($first_week_value[$key]- ($value-$first_week_value[$key])/3);
        }
        
        ?>
        <div class = "div_topChart_items">
            
            <div onmouseover = "highlight_itemName('<?php echo $ten_mon[$key]; ?>')" onmouseout = "highlight_itemName('<?php echo $ten_mon[$key]; ?>')"><span name = "item_name"><?php echo $ten_mon[$key]; ?></span></div>
            <div ><?php 
            if($saleNumber){
                echo  "£".number_format($value,2);
            }else{
                echo  $value;
            }
            
            
            ?></div>
            <div class = "<?php if($Changing_value >= 0){ echo "Better_value";}else {
                echo "Worst_value";}?>">
                <?php 
                    echo $Changing_value;
                ?>
            </div>
            <div class = "clearFix"></div>
        </div>
        <?php
        $count++;
        
    }
    ?>
    </div>