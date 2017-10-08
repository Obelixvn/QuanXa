<?php function money_format($style,$value){
        $value = number_format($value,2);
        $l = strlen($value);
        $str = "£".str_repeat('&nbsp;',(12-$l));
        
        return $str.$value;
    }

?>