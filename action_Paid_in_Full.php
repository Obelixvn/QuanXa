<?php



if(isset($_POST["date"])){
    
    $date = new DateTime($_POST["date"]);
    $date_0 = $date->format('Y-m-d');
    $date_1 = $date->modify(' +1 day ')->format('Y-m-d'); 
}else{
    echo "Error: 119";
    exit;
}
if(!isset($_POST["Tong_Card"])){
    echo "Error :120";
    exit;
}else{
    $tong_card = $_POST["Tong_Card"];
    if (!is_numeric($tong_card)){
        echo "Error: 121";
        exit;
    }
}


//Connect POS
 $serverNamePOS = "192.168.0.107\VDIT, 49277";
 $connectionOptions = array(
     "Database" => "NgonNgon",
     "Uid" => "sahara",
     "PWD" => "Tony0186"
 );
 
//Establishes the connection
$connPOS = sqlsrv_connect($serverNamePOS, $connectionOptions);
if( $connPOS === false ) {
    die( print_r( sqlsrv_errors(), true));
}
$log = "Connect sucessfull POS<br>";
// Connect DB
$servernameDB = "35.197.197.7";
$username = "root";
$password = "ngon123456";
$db = "NN";

$connDB = mysqli_connect($servernameDB, $username, $password,$db);

if (!$connDB) {
        echo $log;
        die("Connection failed: " . $connDB->connect_error);
} 

$log .= "Connect sucessfull DB<br>";

//Function cho sale_avg

function DB_run_query($sql_tmp){
    $servernameDB_tmp = "35.197.197.7";
    $username_tmp = "root";
    $password_tmp = "ngon123456";
    $db_tmp = "NN";

    $connDB_tmp = mysqli_connect($servernameDB_tmp, $username_tmp, $password_tmp,$db_tmp);
    
    $result =  $connDB_tmp->query($sql_tmp);
    if ($result) {
    // output data of each row
       
        
        return $result;
    }    
    else {
        die ("Failed: ".$sql."<br>".$conn->error);
        
    }
    
}
include "Sale_functions_NN.php";

$log .="Log Ngay: - ".$date_0."<br>";
// Lay thong tin;

$TM = 0;
$Card = 0;
$Roo = 0;
$JEat = 0;
$Uber = 0;
$POS = 0;
$tips_onCard = 0;

if(isset($_POST["JEat"])){
    $JEat = $_POST["JEat"];
}else{
    echo "Error : 119";
    exit;
}

$sql = "SELECT sum(Cash-Change) as TongTM, sum(Card) as TongThe
        FROM OrderList 
        WHERE OpenDateTime >= '".$date_0."' 
        AND OpenDateTime <= '".$date_1."' 
        AND (TableID <236 OR TableID >245)";


$resultPOS= sqlsrv_query($connPOS, $sql);

if ($resultPOS === FALSE){
    $log.= "Khong lay dc tien the<br>";
    echo $log;
    die( print_r( sqlsrv_errors(), true));
}
$row = sqlsrv_fetch_array($resultPOS, SQLSRV_FETCH_ASSOC);
$Card = $row["TongThe"];
$TM = $row["TongTM"];
$log .= "Lay xong tien the<br>";
sqlsrv_free_stmt($resultPOS);

$sql = "SELECT sum(Cash-Change+Card) as TongPOS
        FROM OrderList 
        WHERE OpenDateTime >= '".$date_0."' 
        AND OpenDateTime <= '".$date_1."' 
        AND Note <> 'Paid_in_Full'
        AND (TableID <=236 OR TableID >=245)";


$resultPOS= sqlsrv_query($connPOS, $sql);

if ($resultPOS === FALSE){
    $log.= "Khong lay dc tien the<br>";
    echo $log;
    die( print_r( sqlsrv_errors(), true));
}
$row = sqlsrv_fetch_array($resultPOS, SQLSRV_FETCH_ASSOC);
$POS = $row["TongPOS"];
$log .= "Lay xong POS TK<br>";
sqlsrv_free_stmt($resultPOS);


$sql = "SELECT DEl, sum(Tien) as tongTien 
        FROM view_tkDel_v11
        WHERE Ngay >= '".$date_0."' 
        AND Ngay <= '".$date_1."'
        GROUP BY DEL ";
$resultPOS= sqlsrv_query($connPOS, $sql);

if ($resultPOS === FALSE){
    $log.= "Khong lay dc tien DEL<br>";
    echo $log;
    die( print_r( sqlsrv_errors(), true));
}
while($row = sqlsrv_fetch_array($resultPOS, SQLSRV_FETCH_ASSOC)){
    if($row["DEl"] == 'Roo'){
        $Roo = $row["tongTien"];
    }else{
        $Uber = $row["tongTien"];
    }
};
$log .="Xong del<br>";
sqlsrv_free_stmt($resultPOS);
$tips_onCard = $tong_card - $Card;
$Card = $tong_card;
//Luu thong tin

$sql ="
    INSERT INTO `NN`.`tb_sale`
    (`Date`,
    `Card`,
    `Cash`,
    `POS`,
    `JEat`,
    `Uber`,
    `Roo`,
    `Tips_onCard`)
    VALUES
    (
    '".$date_0."',
    ".$Card.",
    ".$TM.",
    ".$POS.",
    ".$JEat.",
    ".$Uber.",
    ".$Roo.",
    ".$tips_onCard."
    )
    ON DUPLICATE KEY UPDATE Date=Date;
";


$result =  $connDB->query($sql);
    if (!$result) {
        echo $log;
        die ("Failed: ".$sql."<br>".$connDB->error);
    }
$log .= "Save data xong<br>";
Insert_Avg_diff($Card,$TM,$Roo,$Uber,$JEat,$date_0);

//Pain_inFull

$sql = "DELETE FROM OrderList 
        WHERE TableID >=236 AND TableID <=245 
        AND OpenDateTime >= '".$date_0."' AND OpenDateTime <= '".$date_1."'";

$resultPOS= sqlsrv_query($connPOS, $sql);
if ($resultPOS == FALSE){
    $log.= "Khong update Orderlist - Del<br>";
    echo $log;
    die( print_r( sqlsrv_errors(), true));
}
sqlsrv_free_stmt($resultPOS);
$sql = "DELETE FROM OrderItems
            WHERE TableID >=236 AND TableID <=245 
            AND OpenDateTime >= '".$date_0."' AND OpenDateTime <= '".$date_1."'";

$resultPOS= sqlsrv_query($connPOS, $sql);
if ($resultPOS == FALSE){
    $log.= "Khong update Orderitem - Del<br>";
    echo $log;
    die( print_r( sqlsrv_errors(), true));
}          
$log.= "Update xong DEL <br>";
sqlsrv_free_stmt($resultPOS);


$orderUpd = 0;
$ItemsUpd = 0;
$sql = "DELETE OrderList
        WHERE OpenDateTime >= '".$date_0."' 
        AND OpenDateTime <= '".$date_1."' 
        AND Note = 'Paid_in_Full'";



$resultPOS= sqlsrv_query($connPOS, $sql);
if ($resultPOS == FALSE){
    $log.= "Order List - Update faile";
    echo $log;
    die( print_r( sqlsrv_errors(), true));
}else{
    $orderUpd += sqlsrv_rows_affected($resultPOS);
}

sqlsrv_free_stmt($resultPOS);
$sql = "DELETE OrderItems
        WHERE OpenDateTime >= '".$date_0."' 
        AND OpenDateTime <= '".$date_1."' 
        AND Note = 'Paid_in_Full'";



$resultPOS= sqlsrv_query($connPOS, $sql);

if ($resultPOS == FALSE){
    $log.= "Order Item - Update faile";
    echo $log;
    die( print_r( sqlsrv_errors(), true));
}else{
    $ItemsUpd += sqlsrv_rows_affected($resultPOS);
}

$log.= "Update xong !! - ".$orderUpd." - ".$ItemsUpd;
sqlsrv_free_stmt($resultPOS);
$connDB->close();
sqlsrv_close($connPOS);

echo $log;
?>
