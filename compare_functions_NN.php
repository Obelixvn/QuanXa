<?php

function hien_thi_phan_tram_tang_giam($base_number,$compare_number,$tang,$phan_tram){
    $diff = ($compare_number-$base_number);
    if ($diff > 0){
        $sign = "&#8593;";
    }else{
        $sign = "&#8595;";
    }
    if (!$tang){
        $diff = $diff*(-1);
    }
    if ($diff > 0){
        $style = "txt_green";
    }else{
        $style = "txt_red";
    }
    $diff = abs($diff);
    if ($phan_tram){
        $phan_tram = ($diff/$base_number * 100);
        $diff = number_format((float)$phan_tram, 2, '.', '')."%";
        
    }
    
    return "<span class = \"".$style."\">".$sign." ".$diff."</span>";
}

?>