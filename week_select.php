       
        <?php
            include "global.php";
            date_default_timezone_set("Europe/London");
            $ten = $_GET["ten"];
            $function_on = $_GET["function_On"];
            echo "<select name =\"".$ten."\" onchange = \"".$function_on."\"> ";
            $startdate =  new Datetime($Ngay_bat_dau);
            $startWeek = $startdate->format("W"); 
                        
            $dateNow = new Datetime("Now");
            
            $weekNow = $dateNow->format("W");
                        
            $dateSel = $_GET["Date_selected"];
            if ($dateSel == null){
                $weekSel = $weekNow;
            }else{
                $weekSel = date_format(date_create($dateSel),"W");
            }
            
            
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
            echo "</select>";
        ?>
