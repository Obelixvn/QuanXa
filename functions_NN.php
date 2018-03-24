<?php

include 'global.php';

$Ngay_bat_dau = '2017-04-24';

function DBConn()
{
    //include "local_BD.php";
    include "OnlineDB.php";
    $conn = mysqli_connect($servername, $username, $password,$db);


    if (!$conn) {
        die("Connection failed: " . $conn->connect_error);
    } 
    return $conn;

}
function Get_insertIDQuery($sql){
    $conn = DBConn();
    $result =  $conn->query($sql);
    if ($result) {
    // output data of each row
        
        
        return $conn->insert_id;
        
        
    }    
    else {
        die ("Failed: ".$sql."<br>".$conn->error);
        
    }
    $conn->close();    
}
function DB_run_query($sql){
    $conn = DBConn();
    $result =  $conn->query($sql);
    if ($result) {
    // output data of each row
       
        
        return $result;
    }    
    else {
        die ("Failed: ".$sql."<br>".$conn->error);
        
    }
    $conn->close();
}

function Option_BoiTen($l){
    $str_ten = '';
    foreach ($l as $name ) {
        $list_ten = $str_ten."".$l.",";
        
    }
    $str_ten = substr($str_ten,0,-1);
    
}
function show_BoiData_BoiPage($date){
    
    $date_id = date("N",strtotime($date));

    //echo "<div class = \"BoiData\"id = \"".$date."\">";
    //echo "<p>".date("l",strtotime($date))."</p>";
    
    $sql_sel = 
        "
        Select * from `NN`.`tb_boi_hour`
        Where Date =' 
        ".$date."'and (Shift =1 or Shift = 3)";
       
    $result = DB_run_query($sql_sel);
    echo "<div class= \"tb_Boi_Page\">";
    echo "<input value =\"".$date."\" type = \"hidden\" name =\"Date[".$date_id."]\">";
    if ($result->num_rows > 0){
        
        while($row = $result->fetch_assoc()) {
        
        
?>
        <div class="container" name = "lich_boi_<?php echo $row["id"]; ?>">
            <div class = "layer_1_tenBoi">
                    <div class = "ten_boi">
                    <?php
                        if ($row["Adj"] != 0){
                            echo "<i title = \"".$row["Note"]."\">";
                            echo ucwords(strtolower($row["Name"]));
                            echo "(".$row["Adj"].")</i>";    
                        }else{
                            echo ucwords(strtolower($row["Name"]));
                        } 
                        //echo "<br>";
                    ?> 
                     
                     </div>
            </div>    

            <div class="overlay">
                
                    <input  onclick = "show_adj_gioLam_boi(this)" type = "checkbox"/> Adj
                
                    <input name = "adj_number_<?php echo $row["id"]; ?>"style = "width:40px" type = "number" >
                    <button onclick = "save_adj_boi(<?php echo $row["id"]; ?>)">Save</button>
                
            </div>
        </div>
<?php
        
        }
        
    }
    else{

    for ($i=0; $i < 7; $i++) { 
        
        echo "<input list = \"datalist_boi\" class = \"nhap_ten\" type = \"text\" name =\"Boi_sang[".$date_id."][]\">";
    }    
    
    
    }
    echo "</div>";
    
    echo "<hr>";
    $sql_sel = 
        "
        Select * from `NN`.`tb_boi_hour`
        Where Date =' 
        ".$date."'and (Shift =2 or Shift = 3)";
       
    $result = DB_run_query($sql_sel);
    echo "<div class= \"tb_Boi_Page_chieu\">";
    if ($result->num_rows > 0){
    
        while($row = $result->fetch_assoc()) {
?>            
        <div class="container" name = "lich_boi_<?php echo $row["id"]; ?>">
            <div class = "layer_1_tenBoi">
                    <div class = "ten_boi">
                    <?php
                        if ($row["Adj"] != 0){
                            echo "<i title = \"".$row["Note"]."\">";
                            echo ucwords(strtolower($row["Name"]));
                            echo "(".$row["Adj"].")</i>";    
                        }else{
                            echo ucwords(strtolower($row["Name"]));
                        } 
                        //echo "<br>";
                    ?> 
                     
                     </div>
            </div>    

            <div class="overlay">
                
                    <input  onclick = "show_adj_gioLam_boi(this)" type = "checkbox"/> Adj
                
                    <input name = "adj_number_<?php echo $row["id"]; ?>"style = "width:40px" type = "number" >
                    <button onclick = "save_adj_boi(<?php echo $row["id"]; ?>)">Save</button>
                
            </div>
        </div>
            
<?php        
        }
        echo "
            </div>
            
            <div class = \"button\" id = \"bt_themStaff".$date_id."\">
            <button type=\"button\" onClick = \"themStaff(".$date_id.")\">Them Staff</button>
            
            ";
        echo "
            
            <button type=\"button\" onClick = \"xoaStaff(".$date_id.")\">Thay doi</button>
            </div>
            ";    
    }
    else{

    for ($i=0; $i < 3; $i++) { 
        
        echo "<input list = \"datalist_boi\" class = \"nhap_ten\"  type = \"text\" name =\"Boi_toi[".$date_id."][]\">";
    }    
    
    
    echo "</div><div class = \"button\"id = bt_updateStaff".$date_id."\">
            <button type=\"button\" onclick = \"updateStaff(".$date_id.")\">Update</button>
            </div>
            ";
    }
    //echo "</div>";
}
function show_week_select($ten,$function_on){
            global $Ngay_bat_dau;
            echo "<select name =\"".$ten."\" onchange = \"".$function_on."\"> ";
            $startdate =  new Datetime($Ngay_bat_dau);
            
            
            $startWeek = $startdate->format("W"); 
                        
            $dateNow = new Datetime("Now");
            
            $weekNow = $dateNow->format("W");
                        
            
            
            
            for ($i=$startWeek; $i <= $weekNow ; $i++) { 
                    
                echo "<option value = \"". $startdate->format('Y-m-d')."\"";

                if ($i == $weekNow){
                    echo "selected";
                }
                echo ">Week: ".$i." { ".$startdate->format('d/m/y');
                $startdate = $startdate->modify(' +6 day ');
                echo      " - ".$startdate->format('d/m/y')."}</option>";
                $startdate = $startdate->modify(' +1 day ');     
            }
            echo "</select>";    
};
?>