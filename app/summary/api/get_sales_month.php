<?php

$month = $_GET['month'];

$start_time_jn = "20170".$month."00";
$zhibiao_month = "20170".$month;


$end_time = $month + 1;
$end_time_jn = "20170".$end_time."00";


require('../../config/config_mysql.php');
$ein = new ein_mysql();
$ein->e_mysql_connect();
$ein->e_html_set_header();

$ks_sales_tm = 0;
$ks_sales_tb = 0;
$ks_sales_yhd = 0;

$yb_sales_tm = 0;
$yb_sales_tb = 0;
$yb_sales_yhd = 0;


$qs_this_year = "SELECT * FROM `tbapi_yibu_sales_info` WHERE `date_time_int` > $start_time_jn AND `date_time_int` < $end_time_jn ORDER BY `date_time_int` ASC";;
$data_arr_jn = $ein->e_mysql_search($qs_this_year);


$qs2 = "SELECT * FROM `tbapi_yibu_sales_zhibiao_month` WHERE `date_int` = $zhibiao_month ORDER BY `date_int` ASC";
$data_arr_zhibiao = $ein->e_mysql_search($qs2);


foreach($data_arr_jn as $v1){
    $shop_yibu_tm = $v1['shop_yibu_tm'];
    $shop_yibu_tb = $v1['shop_yibu_tb'];
    $shop_yibu_yhd = $v1['shop_yibu_yhd'];

    $shop_ks_tm = $v1['shop_ks_tm'];
    $shop_ks_tb = $v1['shop_ks_tb'];
    $shop_ks_yhd = $v1['shop_ks_yhd'];

    $ks_sales_tm = $ks_sales_tm + $v1['shop_ks_tm'];
    $ks_sales_tm = round($ks_sales_tm,0);
    $ks_sales_tb = $ks_sales_tb + $v1['shop_ks_tb'];
    $ks_sales_tb = round($ks_sales_tb,0);
    $ks_sales_yhd = $ks_sales_yhd + $v1['shop_ks_yhd'];
    $ks_sales_yhd = round($ks_sales_yhd,0);

    $yb_sales_tm = $yb_sales_tm + $v1['shop_yibu_tm'];
    $yb_sales_tm = round($yb_sales_tm,0);
    $yb_sales_tb = $yb_sales_tb + $v1['shop_yibu_tb'];
    $yb_sales_tb = round($yb_sales_tb,0);
    $yb_sales_yhd = $yb_sales_yhd + $v1['shop_yibu_yhd'];
    $yb_sales_yhd = round($yb_sales_yhd,0);

}

$zhibiao_yb_tm = $data_arr_zhibiao[0]['yb_tm'];
$zhibiao_yb_tb = $data_arr_zhibiao[0]['yb_tb'];
$zhibiao_yb_yhd = $data_arr_zhibiao[0]['yb_yhd'];

$zhibiao_ks_tm = $data_arr_zhibiao[0]['ks_tm'];
$zhibiao_ks_tb = $data_arr_zhibiao[0]['ks_tb'];
$zhibiao_ks_yhd = $data_arr_zhibiao[0]['ks_yhd'];


$wanchenglv_ks_tm = ($ks_sales_tm/$zhibiao_ks_tm)*100;
$wanchenglv_ks_tm = round($wanchenglv_ks_tm,1);

$wanchenglv_ks_tb = ($ks_sales_tb/$zhibiao_ks_tb)*100;
$wanchenglv_ks_tb = round($wanchenglv_ks_tb,1);

$wanchenglv_ks_yhd = ($ks_sales_yhd/$zhibiao_ks_yhd)*100;
$wanchenglv_ks_yhd = round($wanchenglv_ks_yhd,1);


$wanchenglv_yb_tm = ($yb_sales_tm/$zhibiao_yb_tm)*100;
$wanchenglv_yb_tm = round($wanchenglv_yb_tm,1);

$wanchenglv_yb_tb = ($yb_sales_tb/$zhibiao_yb_tb)*100;
$wanchenglv_yb_tb = round($wanchenglv_yb_tb,1);

$wanchenglv_yb_yhd = ($yb_sales_yhd/$zhibiao_yb_yhd)*100;
$wanchenglv_yb_yhd = round($wanchenglv_yb_yhd,1);



$result = '{"ks":[{"shop":"天猫","zhibiao":'. $zhibiao_ks_tm .',"sales":'. $ks_sales_tm .',"wanchenglv":"'. $wanchenglv_ks_tm .'%"},';
$result .= '{"shop":"淘宝","zhibiao":'. $zhibiao_ks_tb .',"sales":'. $ks_sales_tb .',"wanchenglv":"'. $wanchenglv_ks_tb .'%"},';
$result .= '{"shop":"一号店","zhibiao":'. $zhibiao_ks_yhd .',"sales":'. $ks_sales_yhd .',"wanchenglv":"'. $wanchenglv_ks_yhd .'%"}],';

$result .= '"yb":[{"shop":"天猫","zhibiao":'. $zhibiao_yb_tm .',"sales":'. $yb_sales_tm .',"wanchenglv":"'. $wanchenglv_yb_tm .'%"},';
$result .= '{"shop":"淘宝","zhibiao":'. $zhibiao_yb_tb .',"sales":'. $yb_sales_tb .',"wanchenglv":"'. $wanchenglv_yb_tb .'%"},';
$result .= '{"shop":"一号店","zhibiao":'. $zhibiao_yb_yhd .',"sales":'. $yb_sales_yhd .',"wanchenglv":"'. $wanchenglv_yb_yhd .'%"}]';
$result .= '}';

echo $result;