<?php 
function airlinesName($code){
    if($code == 'YT'){
        return 'Yeti Airlines';
    }else if($code == 'RMK'){
        return 'Simrik Airlines';
    }else if($code == 'TA'){
        return 'Tara Airlines';
    }else if($code == 'U4'){
        return 'Buddha Airlines';
    }else if($code == 'S1'){
        return 'Saurya Airlines';
    }else{
        return $code;
    }
}

function totalPrice($Adult, $Child, $AdultFare, $ChildFare, $ResFare, $FuelSurcharge, $Tax ){
    return ( $Adult * ($AdultFare + $ResFare + $FuelSurcharge + $Tax) ) + ( $Child * ($ChildFare + $ResFare + $FuelSurcharge + $Tax) );
}

function custom_number_format($money){
    $val = number_format($money, 2);
    $val2 = str_replace(".00", "", (string)$val);
    return $val2;
}

?>