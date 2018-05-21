<?php 
include "DB_POS.php";
include "global.php";
include "DB_itemLine.php";
?>


<?php

$date_0 = $_GET["date_0"];
$date_1 = $_GET["date_1"];
if ($date_0 == $date_1 and $date_1 == ''){
    $date = new Datetime();
    $date_0 = $date->format('Y-m-d');
    $date_1 = $date_0;
}else{
    $date = new DateTime($_GET["date_0"]);
}





$sql = "SELECT * FROM view_tkItem_v11 WHERE Ngay >= '".$date_0."' AND Ngay <= '".$date_1."' ORDER BY Ngay DESC";
$conn = DB_POS_connect();
$result= sqlsrv_query($conn, $sql);
$save = false;
if(isset($_GET["save"])){
    if($_GET["save"] == 1){
        $save = true;
    }
}
$pre_date = "";
$next = false;
$sql_insert_all ="";
while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
    ?>
    <tr>
        <td><?php echo $row["Ngay"]->format('Y-d-m') ?></td>
        <td><?php echo $row["Ten"] ?></td>
        <td><?php echo $row["Time"] ?></td>
        <td><?php echo $row["OrderType"] ?></td>
        <td><?php echo $row["tongTien"] ?></td>
        <td><?php echo $row["soLuong"] ?></td>
    </tr>
    <?php

    if($save){
        $cur_date = $row["Ngay"];
        if ($cur_date != $pre_date){
            $year = $cur_date->format('Y');
            $week = $cur_date->format('W');
            $table_name = "tb_".$year."W".$week; 
            $pre_date = $cur_date;
            $sql_itemLine = "SELECT count(*) as test from tb_date_updated Where date = '".$cur_date->format('Y-m-d')."'";
            $result_testDate = DB_itemLine_run_query($sql_itemLine);
            $row = $result_testDate->fetch_assoc();
            if($row["test"] > 0){
                
                $log .= "Ngay ".$cur_date->format('d M Y')." nay da duoc nhap tu truoc<br>";
                $next = true;
                continue;
                
                
            }else{
                $next = false;
                $sql_insert_all .= "INSERT INTO `nn_itemline`.`tb_date_updated`
                                    (
                                    `Date`,
                                    `Status`)
                                    VALUES
                                    (
                                    ".$cur_date->format('Y-m-d').",
                                    9);
                                    ";
                                        
                $sql_test_tbName = "SELECT count(*) as test
                                    FROM information_schema.TABLES
                                    WHERE (TABLE_SCHEMA = 'nn_itemline') AND (TABLE_NAME = '".$table_name."')";
                $result_testTable = DB_itemLine_run_query($sql_test_tbName);
                $row = $result_testTable->fetch_assoc();
                if($row["test"] == 0){
                    $sql_createTB .= " CREATE TABLE `".$table_name."` (
                        `ID` smallint(6) NOT NULL AUTO_INCREMENT,
                        `Date` datetime NOT NULL,
                        `ID_item` smallint(6) NOT NULL,
                        `Gio` varchar(2) NOT NULL,
                        `Type` varchar(6) NOT NULL
                        `soLuong` tinyint(4) NOT NULL,
                        `tongTien` float NOT NULL,
                        PRIMARY KEY (`ID`),
                        
                        ) ENGINE=InnoDB DEFAULT CHARSET=latin1;
                        ";
                    $result = DB_itemLine_run_query($sql_createTB);
                    if(!$result){
                        $log .= "Khong tao dc table tuan<br>";
                        echo $log;
                        exit;
                    }
                }
            }
        }
        if($next){
            continue;
        }
        //Tim item alise
        $sql_itemAlise = "Select ID_item FROM tb_alias_item Where Name = '".$row["Ten"] ."'";
        $result = DB_itemLine_run_query($sql_createTB);
        if(mysqli_num_rows($result) > 1){
            $row = $result_testTable->fetch_assoc();
            $itemID = $row["ID_item"];
        }else{
            //Insert tb_mon - Get ID
            $sql_insert_mon = "INSERT INTO `nn_itemline`.`tb_mon`";
            //Insert tb_alias - From ID
        }            

        $sql_insert_all .="INSERT INTO `nn_itemline`.`tb_2018w09`
                            (`Date`,
                            `ID_item`,
                            `Gio`,
                            `Type`,
                            `soLuong`,
                            `tongTien`)
                            VALUES
                            ('$cur_date->format('Y-m-d')',
                            ".$itemID.",
                            ".$row["Time"].",
                            ".$row["OrderType"].",
                            ".$row["soLuong"].",
                            ".$row["tongTien"].",
                            );
                            ";
    }
}

if(isset($_GET["save"])){
    if($_GET["save"] == 1){
    }
}




?>