<?php 
 $serverName = "192.168.0.107\VDIT, 49277";
 $connectionOptions = array(
     "Database" => "NgonNgon",
     "Uid" => "sahara",
     "PWD" => "Tony0186"
 );
 
 //Establishes the connection
 $conn = sqlsrv_connect($serverName, $connectionOptions);
 if( $conn === false ) {
    die( print_r( sqlsrv_errors(), true));
 }
//Select Query
//$tsql1= "SELECT * From OrderItems INNER JOIN Config_table ON OrderItems.TableID = Config_table.ID Where OpenDateTime >= '2018-04-12 19:00:00' AND OpenDateTime <= '2018-04-12 19:30:00'"; 
$tsql1= "SELECT * From OrderList INNER JOIN Config_table ON OrderList.TableID = Config_table.ID Where OpenDateTime >= '2018-04-14 13:00:00' AND OpenDateTime <= '2018-04-14 14:00:00' AND Config_table.TableName= '10A'"; 

$tsql1 = "Select sum(Prices*Quantity) From OrderItems INNER JOIN Config_table ON OrderItems.TableID = Config_table.ID  Where OpenDateTime >= '2018-04-15' AND OpenDateTime <= '2018-04-16' and Config_table.TableName = '10A'";

$tsql1 = "select Ten,sum(soLuong) as sl, sum(tongTien) as tien from view_tkItem_v11 WHERE Ngay = '2018-04-15'Group by Ten ";


$tsql1 = "SELECT  *
FROM OrderItems  WHERE OpenDateTime = '2018-04-22 19:29:28' ";
$tsql1 = "SELECT  *
FROM OrderItems WHERE OpenDateTime = '2018-04-18 17:34:31' and OrderItems.TableID =212  Order BY OpenDateTime Desc ";

$tsql1 = " OrderList SET Cash = 0, Card = 27.2
WHERE OpenDateTime = '2018-04-17 18:50:21' and OrderList.TableID =213 ";

$tsql1 = "Select * From OrderItems Where Note = 'Paid_in_Full'";

$tsql1 = "SELECT TABLE_NAME
FROM INFORMATION_SCHEMA.COLUMNS";

$tsql1 = "SELECT ID,TableName FROM Config_Table WHERE ID IN (236,238,239,240,245)";
$tsql1 = "SELECT ID,TableName FROM Config_Table WHERE ID IN (237,241,242,243,244)";


$tsql1 = "UPDATE OrderList  SET VAT = Round(Total * 0.155,2), SaleNoneVAT = Round(Total * 0.07,2),NetTotal = Round(Total * 0.93,2)   WHERE  OpenDateTime <= '2018-04-23 23:59:59' ";

$tsql= "SELECT Top 10 * From OrderItems WHERE OpenDateTime = '2018-05-17 12:50:34'";

$tsql1 = "SELECT TableName, OpenDateTime, Card, CloseDateTime FROM OrderList INNER JOIN Config_table On OrderList.TableID = Config_table.ID WHERE OpenDateTime = '2018-06-16 12:19:37' ";

$tsql1 = "UPDATE OrderList SET CloseOrder = 2  WHERE TableID = 210 AND OpenDateTime = '2018-05-16 12:37:19'";

//$tsql = "DELETE FROM OrderItems WHERE ID IN (33928,33929,33930,33934,33936,33937,33938)";
//
$tsql1= "SELECT * From OrderList WHERE OpenDateTime ='2018-05-16 19:48:12' ORDER BY OpenDateTime DESC";

$tsql1 = "INSERT INTO MenuCfg (Code, Menu,TAPrice,Price,Food,DinnerHasTax,LunchHasTax) VALUES ('','Crab Summer Roll',6.5,6.5,1,1,1);
            INSERT INTO MenuCfg (Code, Menu,TAPrice,Price,Food,DinnerHasTax,LunchHasTax) VALUES ('','Vegatable Summer Roll',4.5,4.5,1,1,1);
            INSERT INTO MenuCfg (Code, Menu,TAPrice,Price,Food,DinnerHasTax,LunchHasTax) VALUES ('','Mango Chicken Salad',6.8,6.8,1,1,1);
            INSERT INTO MenuCfg (Code, Menu,TAPrice,Price,Food,DinnerHasTax,LunchHasTax) VALUES ('','Papaya Chicken Salad',6.8,6.8,1,1,1);
            INSERT INTO MenuCfg (Code, Menu,TAPrice,Price,Food,DinnerHasTax,LunchHasTax) VALUES ('','Mango Beef Salad',6.8,6.8,1,1,1);
            INSERT INTO MenuCfg (Code, Menu,TAPrice,Price,Food,DinnerHasTax,LunchHasTax) VALUES ('','Papaya Beef Salad',6.8,6.8,1,1,1);
            INSERT INTO MenuCfg (Code, Menu,TAPrice,Price,Food,DinnerHasTax,LunchHasTax) VALUES ('','Mango Carb Salad',8,8,1,1,1);
            INSERT INTO MenuCfg (Code, Menu,TAPrice,Price,Food,DinnerHasTax,LunchHasTax) VALUES ('','Papaya Crab Salad',8,8,1,1,1);
            INSERT INTO MenuCfg (Code, Menu,TAPrice,Price,Food,DinnerHasTax,LunchHasTax) VALUES ('','Mango Duck Salad',7.5,7.5,1,1,1);
            INSERT INTO MenuCfg (Code, Menu,TAPrice,Price,Food,DinnerHasTax,LunchHasTax) VALUES ('','Papaya Duck Salad',7.5,7.5,1,1,1);
            INSERT INTO MenuCfg (Code, Menu,TAPrice,Price,Food,DinnerHasTax,LunchHasTax) VALUES ('','Cold Bun With Chicken',9,9,1,1,1);
            INSERT INTO MenuCfg (Code, Menu,TAPrice,Price,Food,DinnerHasTax,LunchHasTax) VALUES ('','Cold Bun With Beef',9.5,9.5,1,1,1);
            INSERT INTO MenuCfg (Code, Menu,TAPrice,Price,Food,DinnerHasTax,LunchHasTax) VALUES ('','Cold Bun With Duck',9.5,9.5,1,1,1);
            INSERT INTO MenuCfg (Code, Menu,TAPrice,Price,Food,DinnerHasTax,LunchHasTax) VALUES ('','Cold Bun With Crab',9.5,9.5,1,1,1);
            INSERT INTO MenuCfg (Code, Menu,TAPrice,Price,Food,DinnerHasTax,LunchHasTax) VALUES ('','Cold Bun With Pork',8.5,8.5,1,1,1);
            INSERT INTO MenuCfg (Code, Menu,TAPrice,Price,Food,DinnerHasTax,LunchHasTax) VALUES ('','Cold Bun With Mix Meat',10.5,10.5,1,1,1);             



         ";

$tsql998 = "CREATE VIEW view_tkDel_v11 AS
        SELECT
                OpenDateTime as Ngay,
                CASE 
                    WHEN TableID IN (236,238,239,240,245)
                    THEN 'Roo'
                 
                    WHEN TableID IN  (237,241,242,243,244)
                    THEN  'Uber'
                END AS Del  ,
                Total as Tien  

        FROM OrderList 
        WHERE 
            TableID >=236 AND TableID <=245";

$tsql99= "CREATE VIEW view_tkItem_v11 AS
SELECT
MenuCfg.Menu as Ten, 
Convert(date, OpenDateTime) as Ngay,
CASE 
    WHEN DATEPART(hh,OpenDateTime) < 17 
    THEN 'S' 
    ELSE 'C' 
END AS [Time],
CASE 
    WHEN TableID <=200
    THEN 'TW'
    WHEN TableID >=236 AND TableID <=245
    THEN 'DEL' 
    ELSE 'EatIn' 
END AS [OrderType],
Sum(Prices*Quantity) as tongTien,
Sum(Quantity) as soLuong
  
FROM OrderItems Inner Join  MenuCfg On OrderItems.MenuID = MenuCfg.ID
GROUP BY MenuCfg.Menu,Convert(date, OpenDateTime) ,CASE 
    WHEN DATEPART(hh,OpenDateTime) < 17 
    THEN 'S' 
    ELSE 'C' 
END,CASE 
    WHEN TableID <=200
    THEN 'TW'
    WHEN TableID >=236 AND TableID <=245
    THEN 'DEL' 
    ELSE 'EatIn' 
END;
";

//Executes the query
$getResults= sqlsrv_query($conn, $tsql);

//Error handling
if ($getResults == FALSE){
    die( print_r( sqlsrv_errors(), true));
}
    
?>

<h1> Results : </h1>

<?php
while ($row = sqlsrv_fetch_array($getResults, SQLSRV_FETCH_ASSOC)) {
    //var_dump ($row["COLUMN_NAME"]);
    var_dump ($row);
    echo sqlsrv_rows_affected($getResults);
    //echo $row["ID"]."  -  ";
    //echo $row["TableName"];
    echo ("<br/>");
}

sqlsrv_free_stmt($getResults);


?>