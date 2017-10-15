<?php
    

    $Ngay_bat_dau = '2017-04-24';
    

function DBConn()
{
    
    
    $servername = "127.0.0.1";
    $username = "root";
    $password = "123456";
    $db = "NN";
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
?>