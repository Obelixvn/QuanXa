<?php

//1. Doc du lieu tu tb_itemLine
include "global.php";
include "DB_functions_NN.php";
$Log = "Item Line Vr1.0 run:";
set_time_limit(0);
$sql_viewDate = "SELECT * FROM NN_itemLine.view_itemline_bydate";
//List cac ngay co trong tb_itemLine
$result = DB_run_query($sql_viewDate);
if ($result->num_rows > 0){
    while($row = $result->fetch_assoc()) {
        
        
        $date_str = $row["date"];   
        $newDate = new Datetime($date_str);
        $Log .= "<br>Ngay ".$newDate->format('d M Y')." is processing - Tong Item: ".$row["tongItem"];
        echo "<ul>";
        $sql_date_check = "Select status from NN_itemLine.tb_Date_updated where Date = '".$newDate->format('Y-m-d')."'";
        $result_date_check = DB_run_query($sql_date_check);
        //Kiem tra xem ngay nay dc dc update chua
        $row_date_check = $result_date_check->fetch_assoc();
        if ($row_date_check["status"] > 0){
            $tiep_tuc_update = false;
            // Da co update, check status, de update them ?
            
            if ($row_date_check["status"] == 1){
                //se Update them
                $tiep_tuc_update = true;
                
                $sql_insert_dateUpdate = NULL;
                $Log .= "<li> Ngay ".$newDate->format('d M Y')." se duoc update them</li>";
            }
        }else{
            $sql_insert_dateUpdate = "INSERT INTO `NN_itemLine`.`tb_Date_updated`
                                        (
                                        `Date`)
                                        VALUES
                                        (
                                         '".$newDate->format('Y-m-d')."'
                                         )
                                        ";

            $tiep_tuc_update = true;
            $Log .= "<li> Ngay ".$newDate->format('d M Y')." update moi</li>";
        }
        
        if (!$tiep_tuc_update){
            $Log .= "<Li> Ngay ".$newDate->format('d M Y')." da duoc update tu truoc</li>";
            echo $Log."<hr>";
            $Log ="";
            echo "</ul>";
            continue;
            
        }
        // Ghi gia tri cua ngay dang update
        if ($sql_insert_dateUpdate != NULL){
            $r = DB_run_query($sql_insert_dateUpdate);
        }
        //Lay tien table thong Ke
        $week_date = $newDate->format("W");
        $year_date = $newDate->format("Y");
        $table_name = "tb_".$year_date."W".$week_date;
        
        // Check table exsist
        $sql_ck_table = "SELECT count(*) as ck
                            FROM information_schema.tables 
                            WHERE table_schema = 'nn_itemline'
                            AND table_name = '".$table_name."'
                        ";
        $re_table_exsist = DB_run_query($sql_ck_table);
        $ck = $re_table_exsist->fetch_assoc()["ck"];
        
        $Log .= "<li>Ck code table : ".$ck." </li>";

        if($ck == 0){
             // Creat table thong Ke
            $sql_cr_table = "CREATE TABLE `nn_itemline`.`".$table_name."` 
                            (   `ID` SMALLINT NOT NULL AUTO_INCREMENT ,
                                `ID_item` SMALLINT NOT NULL , 
                                `Gio` varchar(2) NOT NULL , 
                                `soLuong` TINYINT NOT NULL , 
                                `tongTien` FLOAT NOT NULL , 
                                PRIMARY KEY (`ID`), 
                                UNIQUE (`ID_item`,`Gio`)
                            ) ENGINE = InnoDB;";
            $r = DB_run_query($sql_cr_table);
            $Log .= "<li>Creat table : ".$table_name." </li>";
        }
        
        //Doc du lieu co duoc tu tb_view

        $sql_select_viewData = "SELECT Gio, soLuong,ID_item, tongTien ,view_item_thongke.Name as Name
                                FROM `nn_itemline`.`view_item_thongke` 
                                LEFT JOIN `nn_itemline`.`tb_alias_item`
                                ON `view_item_thongke`.`Name` = `tb_alias_item`.`Name` 
                                WHERE date = '".$date_str."'";
        
        $re_select_viewData = DB_run_query($sql_select_viewData);
        $count = 0;
        $notTOcount = 0;
        while($row_select_viewData = $re_select_viewData->fetch_assoc()) {
            
            
            $ID_item = $row_select_viewData["ID_item"];
            
            if($ID_item == NULL){
                $Log .= "<li> Mon moi - ".$row_select_viewData["Name"];
                $sql_insert_monMoi = "INSERT INTO `nn_itemline`.`tb_mon`
                                        (
                                         `Name`   
                                        )
                                        VALUE
                                        (
                                         '".$row_select_viewData["Name"]."'   
                                        )";
                $ID_item = Get_insertIDQuery($sql_insert_monMoi);

                $Log .= " - ID moi :".$ID_item."</li>";
                $sql_insert_aliasMon = "INSERT INTO `nn_itemline`.`tb_alias_item`
                                        (
                                            `Name`,
                                            `ID_item`
                                        )
                                        VALUE
                                        (
                                            '".$row_select_viewData["Name"]."',
                                            ".$ID_item."
                                        )
                                        ";
                $r = DB_run_query($sql_insert_aliasMon);                        
                $Log .= "<li>Alias Item created</li>";
            }
            if($ID_item == 114){
                // ID cua ky tu -----------
                $notTOcount += $row_select_viewData["soLuong"] ;
                
                continue;
            }
            // Tang tk_theoGio
            $sql_insert_itemTK = "INSERT INTO `nn_itemline`.`".$table_name."`
                                       (
                                        `ID_item`, 
                                        `Gio`, 
                                        `soLuong`, 
                                        `tongTien` 
                                       )
                                       VALUE
                                       (
                                           ".$ID_item.",
                                           '".$row_select_viewData["Gio"]."',
                                           ".$row_select_viewData["soLuong"].",
                                           ".$row_select_viewData["tongTien"]."
                                       )
                                       ON DUPLICATE KEY UPDATE
                                       `soLuong` = `soLuong` + ".$row_select_viewData["soLuong"].",
                                       `tongTien` = `tongTien` + ".$row_select_viewData["tongTien"]."
                                    ";

            $r = DB_run_query($sql_insert_itemTK);
            $count += $row_select_viewData["soLuong"];                     
        }
        $count += $notTOcount;
        $Log .= "<li>Tong so item update : ".$count."</li>";
        echo $Log."<br>";
        $Log = "";
        // Update tk theo gio tung tuan
        $sql_select_viewTk_theoGio = "  SELECT `Gio`, `revenue` From `nn_itemline`.`view_tktheogio`
                                        WHERE `date` = '".$date_str."';
                                    ";
        $re_viewTk_theoGio = DB_run_query($sql_select_viewTk_theoGio);
        while($row_viewTk_theoGio = $re_viewTk_theoGio->fetch_assoc()) {
            $sql_insertTK_theoGio = "INSERT INTO `nn_itemline`.`tb_tk_theogio`
                                    (
                                        `Week`,
                                        `Gio`,
                                        `soTien`
                                    )
                                    VALUE
                                    (
                                        '".$date_str."',
                                        ".$row_viewTk_theoGio["Gio"].",
                                        ".$row_viewTk_theoGio["revenue"]."
                                    )
                                    ON DUPLICATE KEY UPDATE `soTien` = `soTien` + ".$row_viewTk_theoGio["revenue"]."
                                    ";
            $r = DB_run_query($sql_insertTK_theoGio);

        }
        echo "<li>Thong ke theo gio da duoc update</li>";
        if (($count) == $row["tongItem"]){
            $sql_updateDate = "UPDATE  `nn_itemline`.`tb_Date_updated` SET `Status` = 9 WHERE `Date` = '".$newDate->format('Y-m-d')."'";
        }else{
            $sql_updateDate = "UPDATE  `nn_itemline`.`tb_Date_updated` SET `Status` = 8 WHERE `Date` = '".$newDate->format('Y-m-d')."'";
        }
        $r = DB_run_query($sql_updateDate);
        echo "<hr></ul>";
        
    }
} 

?>