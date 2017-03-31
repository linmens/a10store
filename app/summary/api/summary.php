<?php

$case = $_GET['hpm'];//品牌
$shop = $_GET['bottom'];//平台


switch ($case) {
    case "依布":
        require('get_yb_data.php');
        get_sale_data($shop);
        break;
    case "科尚":
        require('get_ks_data.php');
        get_sale_data($shop);
        break;
    default:
        require('get_ds_data.php');
        get_sale_data($shop);
}