<html>
<head>
    <link rel="stylesheet" href="Style.css">
</head>


<body>
    <h1>My site works</h1>
    <script>
        function change_date(){
            
            document.getElementById("week_sel_form").submit();

        }
            
    </script>
    <?php
        include 'Mainbar.php';
        
        
    ?>
    <div id = "Main_contain">
    
        <form id = "week_sel_form" action="/~Trang/" method ="GET"> 
        
        <select name ="Date_selected" onchange = "change_date()">        
        <?php
            date_default_timezone_set("Europe/London");
            $startdate =  new Datetime("2017-04-24");
            $startWeek = $startdate->format("W"); 
                        
            $dateNow = new Datetime("Now");
            
            $weekNow = $dateNow->format("W");
                        
            $dateSel = $_GET["Date_selected"];
            if ($dateSel == null){
                $weekSel = $weekNow;
            }else{
                $weekSel = date_format(date_create($dateSel),"W");
            }
            
            echo "alor";
            for ($i=$startWeek; $i <= $weekNow ; $i++) { 
                    
                echo "<option value = \"". $startdate->format('Y-m-d')."\"";
                if ($i == $weekSel ){
                    echo "selected ";
                }
                echo ">Week: ".$i." { ".$startdate->format('d/m/y');
                $startdate = $startdate->modify(' +6 day ');
                echo      " - ".$startdate->format('d/m/y')."}</option>";
                $startdate = $startdate->modify(' +1 day ');     
            }
            
        ?>
        </select>
              
        </form>
     <form action="/~Trang/sale_action_page.php" method ="POST">   
        <table  id = "sale_tb"style="width:100%">
            <?php
            $r = array("Mon","Tue","Wed","Thur","Fri","Sat","Sun","Tong tuan");
            
            $col = array("TM","TT","POS","Sum","Ratio","JE","Roo","Uber","Sum","Total","");
            $rNum = count($r);
            $colNum = count($col);
            $monday = new Datetime();

            $year = "2017";
            $monday->setISOdate($year,$weekSel);
            if (date_format($monday, 'l') != 'Monday'){
                $monday = $monday->modify('last monday');
            }
            
            
            $sunday = new Datetime($monday->format("Y-m-d"));
            $sunday = $sunday->modify('+6 day');
            $sunday = $sunday->format("Y-m-d");
            echo "<tr>";
            for ($j=0; $j <= $colNum; $j++) { 
                        echo "<th>".$col[$j-1]."</th>";
            }
            
            echo "</tr>";
            $date = $monday;
            for ($i = 1; $i <= $rNum;$i++){
                    
                    echo "<tr>";
                    
                    //echo "<input type=\"checkbox\" name=\"date_sel[] \" value=\"".$i."\"/></td>";
                    $sql = " SELECT * from tb_sale where Date = '".$date->format('Y-m-d')."' limit 1";
                    $result = DB_run_query($sql);
                    if ($result->num_rows > 0){
                        while($row = $result->fetch_assoc()) {
                            echo "<td><p title =\"".$date->format('Y-m-d')."\">".$r[$i-1]."</p></td>";
                            echo "<td>".$row['Cash']."</td>";
                            echo "<td>".$row['Card']."</td>";
                            echo "<td>".$row['POS']."</td>";
                            $sum1 = $row['Cash']+$row['Card'];
                            $ratio1 = $row['POS']/$row['Card'];
                            $ratio1 = number_format($ratio1,2);
                            echo "<td>".$sum1."</td>";
                            echo "<td>".$ratio1."%</td>";
                            echo "<td>".$row['JEat']."</td>";
                            echo "<td>".$row['Roo']."</td>";
                            echo "<td>".$row['Uber']."</td>";
                            $sum2 = $row['JE']+$row['Roo']+$row['Uber'];
                            echo "<td>".$sum2."</td>";
                            $sum = $sum1 + $sum2;
                            echo "<td>".$sum."</td>";
                            $TM = $TM + $row['Cash'];
                            $TT = $TT + $row['Card'];
                            $POS = $POS + $row['POS'];
                            $JE = $JE + $row['JE'];
                            $Roo = $Roo + $row['Roo'];
                            $Uber = $Uber + $row['Uber'];
                        }
                    }
                    else{
                        if ($i != $rNum){
                            echo "<td><input value = \"".$date->format('Y-m-d')."\"type =\"hidden\" name = \"date[]\"><p title =\"".$date->format('Y-m-d')."\">".$r[$i-1]."</p>";
                            echo "<td><input type = \"text\" name = \"TM[]\"></td>
                                  <td><input type = \"text\" name = \"TT[]\"></td>
                                  <td><input type = \"text\" name = \"POS[]\"></td>
                                  <td></td>
                                  <td></td>
                                  <td><input type = \"text\" name = \"JE[]\"></td>
                                  <td><input type = \"text\" name = \"Roo[]\"></td>
                                  <td><input type = \"text\" name = \"Uber[]\"></td>
                                  <td></td>
                                  <td></td>
                                ";
                                
                        }else{
                                $sum1 = $JE+$Roo+$Uber;
                                $sum2 = $TM+$TT;
                                $sum = $sum1 + $sum2;
                                echo "<td><p title =\"".$date->format('Y-m-d')."\">".$r[$i-1]."</p></td>";
                                echo "
                                
                                    <td>".$TM."</td>
                                    <td>".$TT."</td>
                                    <td>".$POS."</td>
                                    <td>".$sum2."</td>
                                    <td></td>
                                    <td>".$JE."</td>
                                    <td>".$Roo."</td>
                                    <td>".$Uber."</td>
                                    <td>".$sum1."</td>
                                    <td>".$sum."</td>
                                    ";
                                    
                                
                        } 
                        
                    }
                    echo "</tr>";
                    $date = $date->modify('+1 day');
            }
            ?>

        </table>
        <input type="submit" value="Submit">
        

    </form>
    </div>
</body>

</html>
