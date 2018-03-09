<?php

//1. Doc du lieu tu tb_itemLine
include "global.php";
include "DB_functions_NN.php";


$sql_viewDate = "SELECT * FROM NN_itemLine.view_itemline_bydate";
//List cac ngay co trong tb_itemLine
$result = DB_run_query($sql_viewDate);
if ($result->num_rows > 0){
    while($row = $result->fetch_assoc()) {


        $date_str = $row["date"];   
        $newDate = new Datetime($date_str);
        $Log += "<br>Ngay ".$newDate->format('d M Y')." processing - Tong Item: ".$row["tongItem"];
        $sql_date_check = "Select status from NN_itemLine.tb_Date_updated where Date = '".$newDate->format('Y-m-d')."'";
        $result_date_check = DB_run_query($sql_date_check);
        //Kiem tra xem ngay nay dc dc update chua
        $row_date_check = $result_date_check->fetch_assoc();
        if ($row_date_check["status"] > 0){
            $tiep_tuc_update = false;
            // Da co update, check status, de update them ?
            $status = $result_date_check_2->fetch_assoc()["status"];
            if ($status == 1){
                //se Update them
                $tiep_tuc_update = true;
                $sql_insert = NULL;
                $Log += "<br> Ngay ".$newDate->format('d M Y')." se duoc update them";
            }
        }else{
            $sql_insert = "INSERT INTO `NN_itemLine`.`tb_Date_updated`
                                        (
                                        `Date`)
                                        VALUES
                                        (
                                         '".$newDate->format('Y-m-d')."'
                                         )
                                        ";

            $tiep_tuc_update = true;
        }

        if (!$tiep_tuc_update){
            $Log += "<br> Ngay ".$newDate->format('d M Y')." da duoc update tu truoc";
            break;
            
        }

        $week_date = $newDate->format("W");
        $year_date = $newDate->format("Y");
        $table_name = $year_date."W".$week_date;
        
        

        $tb_week_Name = $row["year"];
        $item_name = $row["Name"];
        $soLuong = $row["soLuong"];
        $soTien = $row["soTien"];
//2 Check Alias-Name        

        $sql_alias_name = "Select ID_item from tb_Alias_item where Name = '".$item_name."'";
        $result_alias = DB_run_query(£sql);
        if ($result_alias->num_rows > 0){
        // Da co ten
            $ID_mon = $result_alias->fetch_assoc()["ID_item"];
        
        }
        else{
        //Khong co ten
        // Tao du lieu    
        $sql_insert = "Insert into tb_Mon(Name) Value ('".$item_name."')";
        $new_ID_mon = Get_insertIDQuery($sql_insert);
        $sql_insert = "Insert into tb_Alias_item(Name,ID_item) Value ('".$item_name."',".$new_ID_mon.")";
        $result_insert = DB_run_query($sql_insert);

        }
    }
} 

?>