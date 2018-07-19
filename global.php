<?php
    include 'windowns_php_functions.php';
    date_default_timezone_set("Europe/London");
    setlocale(LC_MONETARY, 'en_GB.UTF-8');
    $Ngay_bat_dau = "2017-04-24";
    
    $Gio_lam_cua_quan  = array(

        array(),
        array(5,5.5), //Monday
        array(5,5.5), //Tuesday
        array(5,5.5), //Wednesday
        array(5,6), //Thurday
        array(5,6), //Friday
        array(4.5,6), //Saturday
        array(4.5,6), //Sunday
        
    );
    $Ngay_hom_nay = new Datetime();
    $Main_suppliers = array(

        "Meat",
        "Jacky",
        "Cook Delight",
        "Hung Nghia"
    );
    $Weekly_expense_cat1 = array(
        "Supplier"=>"0",
        "Rent&Rate"=>"1350",
        "Luong" => "0",
        "Rac"=>"80",
        "Dien"=>"160",
        "Gas"=>"160",
        "Nuoc"=>"50",
        "Building Inssuare"=>"27",
        "Card Provider"=>"90",
        "Premise Lience"=>"21",
        "Bank chager"=>"20",
        "Internet"=>"12",
        "Clover"=>"27",
        "Quandoo"=>"55",
       
        "Other"=>"200",//Dung ten
        "Bank Holiday" => "172",//10+42+26+35+31+28
        "Tax" => "0"
        );

    $Credit_supplier = array(
        "Meat",
        "Cook Delight",
        "Hung Nghia",
        "Wine",
        "4 Season"
    );
?>