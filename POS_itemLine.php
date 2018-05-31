<?php 
include "DB_POS.php";
include "global.php";
include "DB_itemLine.php";


$date_0 = $_GET["date_0"];
$date_1 = $_GET["date_1"];
if ($date_0 == $date_1 and $date_1 == ''){
    $date = new Datetime();
    $date_0 = $date->format('Y-m-d');
    $date_1 = $date_0;
}else{
    $date = new DateTime($_GET["date_0"]);
}





$sql = "SELECT  * FROM view_tkItem_v11 WHERE Ngay >= '".$date_0."' AND Ngay <= '".$date_1."' ORDER BY Ngay DESC";
$conn = DB_POS_connect();
$result= sqlsrv_query($conn, $sql);

$total_row = 0;
$log ='';

$list_rows = 0;
$save = false;
$sql_insert_row = "";
if(isset($_GET["save"])){
    if($_GET["save"] == 1){
        $save = true;
        $pre_date = "";
        $next = false;
        
        
    }
}

while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
    $list_rows += 1;
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
            $sql_itemLine = "SELECT sum(Status) as test from tb_date_updated Where date = '".$cur_date->format('Y-m-d')."'";
            $result_testDate = DB_itemLine_run_query($sql_itemLine);
            $row_ck_date= $result_testDate->fetch_assoc();
            if($row_ck_date["test"] > 0){
                
                $log .= "Ngay ".$cur_date->format('d M Y')." nay da duoc nhap tu truoc<br>";
                $next = true;
                continue;
                
                
            }else{
                $next = false;
                $log .= "Update ngay ".$cur_date->format('d M Y')."<br>";
                $sql_insert_dateUpdate = "INSERT INTO `nn_itemline`.`tb_date_updated`
                                    (
                                    `Date`,
                                    `Status`)
                                    VALUES
                                    (
                                    '".$cur_date->format('Y-m-d')."',
                                    9);
                                    ";
                $r =  DB_itemLine_run_query($sql_insert_dateUpdate);                    
                $sql_test_tbName = "SELECT count(*) as test
                                    FROM information_schema.TABLES
                                    WHERE (TABLE_SCHEMA = 'nn_itemline') AND (TABLE_NAME = '".$table_name."')";
                $result_testTable = DB_itemLine_run_query($sql_test_tbName);
                $row_ck_tb = $result_testTable->fetch_assoc();
                if($row_ck_tb["test"] == 0){
                    $sql_createTB = " CREATE TABLE `".$table_name."` (
                        `ID` smallint(6) NOT NULL AUTO_INCREMENT,
                        `Date` datetime NOT NULL,
                        `ID_item` smallint(6) NOT NULL,
                        `Gio` varchar(2) NOT NULL,
                        `Type` varchar(6) NOT NULL,
                        `soLuong` tinyint(4) NOT NULL,
                        `tongTien` float NOT NULL,
                        PRIMARY KEY (`ID`)
                        
                        ) ENGINE=InnoDB DEFAULT CHARSET=latin1;
                        ";
                    $result_cr_tb = DB_itemLine_run_query($sql_createTB);
                    if(!$result_cr_tb){
                        $log .= "Khong tao dc table tuan<br>";
                        echo $log;
                        exit;
                    }else{
                        $log.= "Table created : ".$table_name." <br>";
                    }
                }else{
                    $log.= "Da co table tuan <br>";
                }
            }
        }
        if($next){
            continue;
        }
        //Tim item alise
        $sql_itemAlise = "Select ID_item FROM tb_alias_item Where Name = '".$row["Ten"] ."'";
        $result_ck_Alise = DB_itemLine_run_query($sql_itemAlise);
        if(mysqli_num_rows($result_ck_Alise) > 0){
            $row_alise = $result_ck_Alise->fetch_assoc();
            $itemID = $row_alise["ID_item"];
        }else{
            //Insert tb_mon - Get ID
            $log .="New item ID :";
            $sql_insert_mon = "INSERT INTO `nn_itemline`.`tb_mon`(`Name`) VALUES ('".$row["Ten"]."')";
            $itemID = Get_insertIDQuery($sql_insert_mon);
            //Insert tb_alias - From ID
            $log .= $itemID."<br>";
            $sql_insert_ali = "INSERT INTO `tb_alias_item`(`Name`, `ID_item`) VALUES ('".$row['Ten']."',".$itemID.")";
            $r = DB_itemLine_run_query($sql_insert_ali);
            $log.= "Alise formed<br>";
        }            

        $sql_insert_row = "INSERT INTO `nn_itemline`.`".$table_name."`
                            (`Date`,
                            `ID_item`,
                            `Gio`,
                            `Type`,
                            `soLuong`,
                            `tongTien`)
                            VALUES
                            ('".$cur_date->format('Y-m-d')."',
                            ".$itemID.",
                            '".$row["Time"]."',
                            '".$row["OrderType"]."',
                            ".$row["soLuong"].",
                            ".$row["tongTien"]."
                            );
                            ";
        $r =  DB_itemLine_run_query($sql_insert_row);
        $total_row += 1;     
                      
    }
}


    ?>
    <tr class= "save_itemLine_report">
        <td colspan = "6">
        <span>
            Chu y:
        </span>
        <span>
            Da save dc <b> <?php echo $total_row."/".$list_rows; ?> </b> ban ghi.
        </span>
        </td>
    </tr>
    <tr class= "save_itemLine_report">
        <td colspan = "6">
            <?php echo $log; ?>
        </td>
    </tr>
    <?php


//Tk theo gio
$date_tk = new DateTime($date_1);
$date_1 = $date_tk->modify('+1 day')->format('Y-m-d');
$sql = "Select Convert(date, OpenDateTime) as Ngay, DATEPART( hh,OpenDateTime) as Time, sum(Total) as Tien From OrderList Where OpenDateTime >= '".$date_0."' AND OpenDateTime <= '".$date_1."' GROUP BY DATEPART( hh,OpenDateTime) , Convert(date, OpenDateTime) ";

$result= sqlsrv_query($conn, $sql);
while ($row = sqlsrv_fetch_array($result, SQLSRV_FETCH_ASSOC)) {
    
    $sql_insert_tk_theoGio = "INSERT INTO `nn_itemline`.`tb_tk_theogio`
                                (
                                `Ngay`,
                                `Gio`,
                                `soTien`)
                                VALUES
                                (
                                '".$row["Ngay"]->format('Y-m-d')."',
                                ".$row["Time"].",
                                ".$row["Tien"]."
                                )ON DUPLICATE KEY UPDATE Id=Id
                                ";
    $r =  DB_itemLine_run_query($sql_insert_tk_theoGio);
                                    
}

?>