<?php
require('tbapi_ein_class.php');
$ein = new ein_mysql();
$ein->e_mysql_connect();

$sales_tb_all = 0;
$sales_yhd_all = 0;

$result = '';

//生成本月销售额 数据

$date_time_int = date("Ym", time());

$start_time = $date_time_int.'00';
$start_end = $date_time_int.'32';


$qs_this_year = "SELECT * FROM `tbapi_yibu_sales_info` WHERE `date_time_int` > $start_time AND `date_time_int` < $start_end ORDER BY `date_time_int` ASC";
$data_arr_jn = $ein->e_mysql_search($qs_this_year);

foreach($data_arr_jn as $v1){

    $sales_tb = $v1['shop_yibu_tb'] + $v1['shop_ks_tb'];
    $sales_tb_all = $sales_tb_all + $sales_tb;


    $sales_yhd = $v1['shop_yibu_yhd'] + $v1['shop_ks_yhd'];
    $sales_yhd_all = $sales_yhd_all + $sales_yhd;


}

$qs = "SELECT * FROM `tbapi_yibu_customerservice_performance_month` ORDER BY `date_int_month` ASC";
$data = $ein->e_mysql_search($qs);

foreach($data as $v2){
    switch($v2['kf_name']){
        case "张芬":
            $sales_tm_zf = $v2['sales_yb_tm'] + $v2['sales_ks_tm'];
            $sales_tm_zf = round($sales_tm_zf,0);

            $tbk_sales = $v2['tbk_sales'];

            break;
        case "刘雨婷":
            $sales_tm_lyt = $v2['sales_yb_tm'] + $v2['sales_ks_tm'];
            $sales_tm_lyt = round($sales_tm_lyt,0);
            break;
        case "陆震":
            $sales_tm_lz = $v2['sales_yb_tm'] + $v2['sales_ks_tm'];
            $sales_tm_lz = round($sales_tm_lz,0);
            break;
        case "薛强":
            $sales_tm_xq = $v2['sales_yb_tm'] + $v2['sales_ks_tm'];
            $sales_tm_xq = round($sales_tm_xq,0);
            break;
        case "孙红":
            $sales_tm_sh = $v2['sales_yb_tm'] + $v2['sales_ks_tm'];
            $sales_tm_sh = round($sales_tm_sh,0);
            break;
        case "陈璐":
            $sales_tm_cl = $v2['sales_yb_tm'] + $v2['sales_ks_tm'];
            $sales_tm_cl = round($sales_tm_cl,0);
            break;
    }
}

$tbk_sales = $tbk_sales/6;

$sales_tb_all_all = $sales_tb_all;//淘宝总销售额
$sales_tb_all = round(($sales_tb_all/2),0);

$sales_yhd_all_all = $sales_yhd_all;
$sales_yhd_all = round(($sales_yhd_all/6),0);

$sales_all_zf = $sales_tb_all + $sales_yhd_all + $sales_tm_zf - $tbk_sales;//张芬 销售额
$sales_all_zf = round($sales_all_zf,0);

$sales_all_lyt = $sales_tb_all + $sales_yhd_all + $sales_tm_lyt - $tbk_sales;//刘雨婷 销售额
$sales_all_lyt = round($sales_all_lyt,0);

$sales_all_lz = $sales_yhd_all + $sales_tm_lz - $tbk_sales;//陆震 销售额
$sales_all_lz = round($sales_all_lz,0);

$sales_all_cl = $sales_yhd_all + $sales_tm_cl - $tbk_sales;//陈璐 销售额
$sales_all_cl = round($sales_all_cl,0);

$sales_all_xq = $sales_yhd_all + $sales_tm_xq - $tbk_sales;//薛强 销售额
$sales_all_xq = round($sales_all_xq,0);

$sales_all_sh = $sales_yhd_all + $sales_tm_sh - $tbk_sales;//孙红 销售额
$sales_all_sh = round($sales_all_sh,0);


$performance_zf = round(($sales_all_zf * 0.02),0);
$performance_lyt = round(($sales_all_lyt * 0.02),0);
$performance_lz = round(($sales_all_lz * 0.02),0);
$performance_cl = round(($sales_all_cl * 0.02),0);
$performance_xq = round(($sales_all_xq * 0.02),0);
$performance_sh = round(($sales_all_sh * 0.02),0);


$sales_tm_all = $sales_all_zf + $sales_all_lyt + $sales_all_lz + $sales_all_cl + $sales_all_xq + $sales_all_sh;

$sales_all_all = $sales_tm_all + $sales_tb_all_all + $sales_yhd_all_all;

$performance_all = $sales_all_all * 0.02;

$performance_all = round($performance_all,0);
$sales_tb_all_all = round($sales_tb_all_all,0);
$sales_yhd_all_all = round($sales_yhd_all_all,0);
$sales_all_all = round($sales_all_all,0);

$result .= '{"kf_name":"张芬","sales_tm":'. $sales_tm_zf .',"sales_tb":'. $sales_tb_all .',"sales_yhd":'. $sales_yhd_all .',"sales_all":'. $sales_all_zf .',"performance":'. $performance_zf .'},';
$result .= '{"kf_name":"刘雨婷","sales_tm":'. $sales_tm_lyt .',"sales_tb":'. $sales_tb_all .',"sales_yhd":'. $sales_yhd_all .',"sales_all":'. $sales_all_lyt .',"performance":'. $performance_lyt .'},';
$result .= '{"kf_name":"孙红","sales_tm":'. $sales_tm_sh .',"sales_tb":"0","sales_yhd":'. $sales_yhd_all .',"sales_all":'. $sales_all_sh .',"performance":'. $performance_sh .'},';
$result .= '{"kf_name":"薛强","sales_tm":'. $sales_tm_xq .',"sales_tb":"0","sales_yhd":'. $sales_yhd_all .',"sales_all":'. $sales_all_xq .',"performance":'. $performance_xq .'},';
$result .= '{"kf_name":"陈璐","sales_tm":'. $sales_tm_cl .',"sales_tb":"0","sales_yhd":'. $sales_yhd_all .',"sales_all":'. $sales_all_cl .',"performance":'. $performance_cl .'},';
$result .= '{"kf_name":"陆震","sales_tm":'. $sales_tm_lz .',"sales_tb":"0","sales_yhd":'. $sales_yhd_all .',"sales_all":'. $sales_all_lz .',"performance":'. $performance_lz .'},';
$result .= '{"kf_name":"总计","sales_tm":'. $sales_tm_all .',"sales_tb":'. $sales_tb_all_all .',"sales_yhd":'. $sales_yhd_all_all .',"sales_all":'. $sales_all_all .',"performance":'. $performance_all .'}';


echo '['. $result .']';




////设置 UID
//$qs = "SELECT * FROM `tbapi_yibu_customerservice_performance_month` ORDER BY `date_int_month` ASC";
//$data = $ein->e_mysql_search($qs);
//foreach ($data as $v1) {
//
//    $date_int_month = $v1['date_int_month'];
//    $kf_name = $v1['kf_name'];
//
//    $uid = $date_int_month . $kf_name;
//    $uid = md5($uid);
//    $up = "UPDATE `tbapi_yibu_customerservice_performance_month` SET `uid` = '$uid' WHERE `date_int_month` = '$date_int_month' AND `kf_name` = '$kf_name'";
//    mysql_query($up);
//    echo $uid;
//    echo "<br>";
//}

