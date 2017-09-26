

<html>

<head>
    <link rel="stylesheet" href="Style.css">
</head>

<body onload = "datDoPage_onload()">
        <script src="java_functions_NN.js">
        
        
        </script>
        <?php
        include 'Mainbar.php';
        $_GET["ngay_dat_do"] = $Ngay_hom_nay->format('Y-m-d');
        ?>
<div class = "headLine">
    <div class = "left_contain"> 
        <hr>
    </div>
    <div class = " fl mid_contain">
        [ Dat do : ]
          
    </div>
    <div class = "right_contain" >
        <hr>
    </div>
</div> 
<div class = "h20">
     
        <input type="week" id="week_datDoPage" value="<?php echo($Ngay_hom_nay->format('Y-\WW')); ?>">
        <select name = "chon_thu_dat_do" onchange = "change_date_datDoPage()" >
        <option value ="0"/> Mon </option>
        <option value ="1"/>Tue </option>
        <option value ="2"/>Wed </option>
        <option value ="3"/>Thur </option>
        <option value ="4"/>Fri </option>
        <option value ="5"/>Sat </option>
        <option value ="6"/>Sun </option>
        
    </select>
    <button type = "button" onclick = "change_date_datDoPage()">Load</button>
     
</div>

<table class = "Maintb_datDoPage">
        <tbody>
                <tr>
                        <th colspan = '2'><input type = "hidden" id = "Ngay_dat_do" value = "<?php echo($Ngay_hom_nay->format('Y-m-d')); ?>"><span id = 'date_datDoPage'><?php echo($Ngay_hom_nay->format('d/M/Y')); ?></span></th>
                </tr>
                <tr>
                        <td id = "Thit_supplier">Thit
                        </td>
                        <td id = "Rau_supplier">Rau</td>    
                </tr>
               
                 <tr>
                        <td id = "Meat_dat_do"></td>
                        <td id = "Jacky_dat_do"></td>
                </tr>

                 <tr>
                        <td id = "Meat_do_them" class = "Do_them_datDoPage"></td>
                        <td id = "Jacky_do_them" class = "Do_them_datDoPage"></td>
                </tr>
                
                <tr>
                        <td id = "Meat_them_do"></td>
                        <td id = "Jacky_them_do"></td>
                </tr>
                <tr class = "h20">
                        </tr>
                <tr>
                        <td id = "Cook_Delight_supplier">Cook Delight</td>
                        <td id = "Hung_Nghia_supplier">Hung Nghia</td>
                </tr>
                <tr>
                        <td id = "Cook Delight_dat_do"> </td>
                        <td id = "Hung Nghia_dat_do"> </td>
                </tr>
                <tr>
                        <td id = "Cook Delight_do_them" class = "Do_them_datDoPage"> </td>
                        <td id = "Hung Nghia_do_them" class = "Do_them_datDoPage"> </td>
                </tr>
                <tr>
                        <td id = "Cook Delight_them_do"></td>
                        <td id = "Hung Nghia_them_do"></td>
                </tr>
                <tr>
                        <td colspan = "2" class = "pad_20 txt_c">Other Supplier: <select name ="supplier_sel_datdoPage">
                                        <option value = ''>--Select--</option>

                                <?php
                                        $sql = "select supplier from tb_items group by supplier";
                                        $result_supplier = DB_run_query($sql);
                                        if ($result_supplier->num_rows > 0){
                                            while($row = $result_supplier->fetch_assoc()) {
                                                    if (!in_array($row["supplier"],$Main_suppliers)){

                                                    
                                                    ?>
                                                    <option value = "<?php echo ($row["supplier"]); ?>"><?php echo ($row["supplier"]); ?></option>
                                                    <?php
                                                    }
                                            }    
                                        }
                                ?>

                                </select>
                                <button  onclick = "load_dat_do_other_supplier()">Oke</button>
                        </td>
                </tr>
                <tr>
                        <td id = "Other_supplier_name" class = "Other_supplier_dat_do"colspan = "2"></td>
                </tr>
                <tr>
                        <td id = "Other_dat_do"></td>
                
                
                        <td>
                        <div id = "Other_do_them" class = "Do_them_datDoPage"></div>
                
                        <div id = "Other_them_do"></div>
                        </td>
                </tr>
        </tbody>        
</table>

<div class = "headLine">
    <div class = "left_contain"> 
        <hr>
    </div>
    <div class = " fl mid_contain">
        [ New Item: ] <input type = "date" id = "newItem_date_dat_do" value = "<?php echo($Ngay_hom_nay->format('Y-m-d')); ?>">
          
    </div>
    <div class = "right_contain" >
        <hr>
    </div>
</div>
<table id = "tb_newItem_datDoPage" class = "tb_them_do">
        <thead>
                <tr>    
                        <th>Ten</th>
                        <th>Unit</th>
                        <th>So luong</th>
                        <th>Supplier</th>
                        <th>Tien</th>
                        </tr>

                </tr>
         </thead>
         <tbody id = "newItem_dat_do"> 
                 <tr>              
                        <td>
                                <input class = "them_do_ten" type = "text" name="ten_item[]">
                        
                        </td>
                        <td>
                                <input class = "them_do_unit" type = "text" name="unit_item[]">
                        </td>
                        <td>
                                <input class = "them_do_q" type = "number" value = "1"  min = "0" name ="q_item[]">
                        </td>
                        <td>
                                <input class = "them_do_supplier" type = "text" name="supplier_item[]">
                        </td>
                        <td>
                                <input class = "them_do_tien" type = "number"  min = "0" name ="cost_item[]">
                        </td>
                        
                </tr>
        </tbody>
        

</table>
<button type = "button" onclick = "newItem_tb_them_item()">Them</button>
<button type = "button" onclick = "newItem_tb_update_puchase()">Confirm</button>

<div class = "headLine">
    <div class = "left_contain"> 
        <hr>
    </div>
    <div class = " fl mid_contain">
        [ Thong ke : ]   <input type="week" id="week_thongKe" value="<?php echo($Ngay_hom_nay->format('Y-\WW')); ?>">
          
    </div>
    <div class = "right_contain" >
        <hr>
    </div>
</div> 
<div class = "h_20 mar_10">
        Theo:
        <select name = "kieu_thongKe" onchange ="load_kieu_thongKe()">
                
                <option value = "1">Supplier</option>
                <option value = "2">Item</option>
        </select>
</div>
<table id = "tb_thong_ke">
       <tr>
               <td class = "w25">
                       <div class = "w100 fl" id = "thong_ke_theo_suppliers" style = "display: block;">
                                <div class = "h20 w25 fl">
                                        <input id = "check_suppler_button" onclick = "thong_ke_sel_Allsupplier(1)" type="checkbox" name="All_supplier" value="1"> All
                                </div>
                                <div class = "fl">
                                        
                                <?php
                                        $result_supplier = DB_run_query($sql);
                                        while($row = $result_supplier->fetch_assoc()) {
                                        ?>
                                        <div class = "h20 w_100 fl mar_b_10">
                                        <input checked type = "checkbox" name = "thong_ke_supplier[]" value = "<?php echo ($row["supplier"]); ?>"> <?php echo ($row["supplier"]); ?>
                                        </div>
                                        <?php

                                        }
                                        
                                ?>
                                </div> 
                        </div> 
                        <div id = "thong_ke_theo_items" style = "display: none;">
                                Ten item: <input type = "text" id = "thong_ke_them_items_ten"/>
                                <button onclick = "thong_ke_them_items()">Them</button>
                                <div id = "list_items_thong_ke">
                                </div>        
                                       
                        </div> 
                        <button  onclick = "load_thongKe_tuan()">Load</button>
               </td>
               <td id = "thong_ke_tuan"></td>
       <tr>         
</table>        

                

<div >
</div>        


</body>

</html>
