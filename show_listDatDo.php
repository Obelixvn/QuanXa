<table class = "tb_datDoPage">
    <tbody >
        
    <tr>
        <th>Ten Item</th>
        <th class = "w25">Unit</th>
        <th class = "w10">Quality</th>
        <th class = "w10">Gia</th>
        <th class = "w10">Tien</th>
    </tr>
<?php
            $tongtien = 0;
            while($row = $result->fetch_assoc()) {
                $tongtien += $row["cost"]; 
                ?>
                </tr>
        
                    <td class = "datDo_ten"><?php echo ($row["name"])?></td>
                    <td class = "datDo_unit"><?php echo ("[".$row["unit"]."]") ;?></td>
                    <td class = "datDo_quality"><?php echo ($row["quality"]) ;?></td>
                    <td class = "datDo_gia"><?php echo ($row["price"]) ;?></td>
                    <td class = "datDo_tien"><?php echo ($row["cost"]) ;?></td>
                </tr>
                <?php
            }
    

?>
    <tr>
        <td class = "tong_tien" colspan ="4">Tong Tien:</td>
        <td class= "sum_tong"><?php echo $tongtien; ?></td>    
    <tr> 

    </tbody>
</table> 