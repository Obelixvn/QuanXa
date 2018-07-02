
<?php 
include "DB_functions_NN_itemLine.php";
$fullInfo= false;
$ten_mon = "";
if(isset($_GET["ten"])){
    $ten_mon = $_GET["ten"];
}
if(isset($_GET['fullInfo'])){
    $fullInfo= true;
    $sql = "Select * From";
}else{
    $sql = "Select ID, Name From";
}
$sql.=" tb_mon Where Name like '%".$ten_mon."%'";

$result = "";
$result = DB_run_query($sql);
if($result != ""){


    if($fullInfo){
        $mon_cat = array();
        $cat_parent_name =  array();
        
        
        $sql_cat = "Select * from tb_mon_cat";
        $r_mon_cat = DB_run_query($sql_cat);
        while ($row_mon_cat = $r_mon_cat->fetch_assoc()){
            
            
            if($row_mon_cat["ID"] >= 1000){
                $cat_parent_name[$row_mon_cat["ID"]] = $row_mon_cat["Cat_name"]; 
            }else{
                $mon_cat[$row_mon_cat["ID"]] = $row_mon_cat["Cat_name"];
            }
        }
    }
    $i = 0;
    $alise_id =  array();
    $sql_alias = "Select ID_item from tb_alias_item";
    $r_alias = DB_run_query($sql_alias);
    while ($row_alias = $r_alias->fetch_assoc()){
        $alise_id[$i] = $row_alias["ID_item"];
        $i++;
    }
    if($fullInfo){

   
    ?>
    <div id= "table_frame" style = "width: 800px;">
            
    <table id= "result_search_mon">    



    <thead>
        
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

    <?php }
    else{ 
    ?>
    <div id= "table_frame">
            
    <table id= "result_search_mon">   

    <?php }?>
    <tbody>
        <?php 
            $i = 0;
            while ($row_mon = $result->fetch_assoc()){
                if( !in_array($row_mon["ID"],$alise_id)){
                    continue;
                }

                ?>
                 <tr>
                     <td >
                        
                        <div id = "item_monID_<?php echo $row_mon["ID"] ?>" onclick = "select_itemMon(this)" >
                            <?php  echo $row_mon["Name"];   ?>
                        </div>
                     </td>
                     <?php 
                     if(!$fullInfo){
                         echo "</tr>";
                         continue;
                     }
                     ?>
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
                $i++;
            }
        
        ?>
        
       
        <?php
         ?>
    </tbody>
    <?php
    
}

?>
</table>
</div>
