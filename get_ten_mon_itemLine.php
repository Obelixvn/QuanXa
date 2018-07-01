<?php 
include "DB_functions_NN_itemLine.php";

$ten_mon = "";
if(isset($_GET["ten"])){
    $ten_mon = $_GET["ten"];
}
$sql = "Select * From tb_mon Where Name like '%".$ten_mon."%'";

$result = "";
$result = DB_run_query($sql);
if($result != ""){
    $mon_cat = array();
    $cat_parent_name =  array();
    $alise_id =  array();
    $i = 0;
    $sql_cat = "Select * from tb_mon_cat";
    $r_mon_cat = DB_run_query($sql_cat);
    while ($row_mon_cat = $r_mon_cat->fetch_assoc()){
        
        
        if($row_mon_cat["ID"] >= 1000){
            $cat_parent_name[$row_mon_cat["ID"]] = $row_mon_cat["Cat_name"]; 
        }else{
            $mon_cat[$row_mon_cat["ID"]] = $row_mon_cat["Cat_name"];
        }
    }

    $sql_alias = "Select ID_item from tb_alias_item";
    $r_alias = DB_run_query($sql_alias);
    while ($row_alias = $r_alias->fetch_assoc()){
        $alise_id[$i] = $row_alias["ID_item"];
        $i++;
    }
    ?>
    <thead>
        <tr>
            <th style ="text-align:left;">
            <button class = "explanning">Expand</button>
            </th>
        </tr>
        <tr>
            <th>Ten</th>
        <?php
            foreach ($cat_parent_name as $element) {
                ?>
                <th>
                    <?php echo $element ?>
                </th>
                <?php
            }
        ?>
    </tr>    
    </thead>
    <tbody>
        <?php 
            while ($row_mon = $result->fetch_assoc()){
                if( !in_array($row_mon["ID"],$alise_id)){
                    continue;
                }
                ?>
                 <tr>
                     <td >
                        <input type="radio" name="mon_id" value = "<?php echo $row_mon["ID"] ?>">
                        <?php  echo $row_mon["Name"];   ?>
                     </td>
                     <td >
                        <?php  
                            $index = $row_mon["Cat_1"];
                            if($index > 0){
                                echo $mon_cat[$index];
                            }
                        ?>
                     </td>
                     <td>
                        <?php  
                            $index = $row_mon["Cat_2"];
                            if($index > 0){
                                echo $mon_cat[$index];
                            }
                        ?>
                     </td>
                     <td>
                        <?php  
                            $index = $row_mon["Cat_3"];
                            if($index > 0){
                                echo $mon_cat[$index];
                            }
                        ?>
                     </td>
                     <td>
                        <?php  
                            $index = $row_mon["Cat_4"];
                            if($index > 0){
                                echo $mon_cat[$index];
                            }
                        ?>
                     </td>
                     <td>
                        <?php  
                            $index = $row_mon["Cat_5"];
                            if($index > 0){
                                echo $mon_cat[$index];
                            }
                        ?>
                     </td>
                     <td>
                        <?php  
                            $index = $row_mon["Cat_6"];
                            if($index > 0){
                                echo $mon_cat[$index];
                            }
                        ?>
                     </td>
                     <td>
                        <?php  
                            $index = $row_mon["Cat_7"];
                            if($index > 0){
                                echo $mon_cat[$index];
                            }
                        ?>
                     </td>
                     <td>
                        <?php  
                            $index = $row_mon["Cat_8"];
                            if($index > 0){
                                echo $mon_cat[$index];
                            }
                        ?>
                     </td>
                     <?php
                        
                     ?>
                 </tr>
                <?php
            }
        ?>
        
       
        <?php
         ?>
    </tbody>
    <?php
    
}

?>