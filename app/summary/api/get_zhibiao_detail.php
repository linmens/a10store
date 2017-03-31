<?php
/**
 * Created by PhpStorm.
 * User: Ein
 * Date: 17/3/13
 * Time: 下午3:29
 */
$brand = $_GET['hpm'];

require('../../config/config_mysql.php');
$ein = new ein_mysql();
$ein->e_mysql_connect();

$result = '';
$re_data_tm = '';//天猫销售额 json list
$re_data_tb = '';//淘宝销售额 json list
$re_data_yhd = '';//一号店销售额 json list
$re_data_all = '';//部门总销售 json list

$zhibiao_tm_all = 0;//天猫全年总指标;
$zhibiao_tb_all = 0;//淘宝全年总指标;
$zhibiao_yhd_all = 0;//一号店全年总指标;
$zhibiao_all = 0;//部门全年总指标;

$all_sales_tm = 0;//天猫总销售
$all_sales_tb = 0;//淘宝总销售
$all_sales_yhd = 0;//一号店总销售
$all_sales_all = 0;//部门总销售

//获取总指标
$qs = "SELECT * FROM `tbapi_yibu_sales_zhibiao_month` ORDER BY `date_int` ASC";
$data_arr = $ein->e_mysql_search($qs);

$qs_this_year = "SELECT * FROM `tbapi_yibu_sales_info` WHERE `date_time_int` > 20170100 AND `date_time_int` < 20180100 ORDER BY `date_time_int` ASC";
$data_arr_jn = $ein->e_mysql_search($qs_this_year);


foreach ($data_arr as $v) {

    //取值
    switch($brand){
        case "依布":
            $tm = $v['yb_tm'];
            $tb = $v['yb_tb'];
            $yhd = $v['yb_yhd'];
            break;
        case "科尚":
            $tm = $v['ks_tm'];
            $tb = $v['ks_tb'];
            $yhd = $v['ks_yhd'];
            break;
        default:
            $tm = $v['yb_tm'] + $v['ks_tm'];
            $tb = $v['yb_tb'] + $v['ks_tb'];
            $yhd = $v['yb_yhd'] + $v['ks_yhd'];

    }

    //取整 指标
    $tm = round(($tm / 10000), 1);
    $tb = round(($tb / 10000), 1);
    $yhd = round(($yhd / 10000), 1);
    $re_all = round(($tm+$tb+$yhd), 0);


    $date_int = $v['date_int'];
    $date_int_start = $date_int . '00';
    $date_int_end = $date_int + 1;
    $date_int_end = $date_int_end . '00';

    //天猫 每月 总销售额
    $sales_tm_jn = 0;

    //淘宝 每月 总销售额
    $sales_tb_jn = 0;

    //一号店 每月 总销售额
    $sales_yhd_jn = 0;



    foreach ($data_arr_jn as $v2) {
        $date_time_int = $v2['date_time_int'];
        if ($date_time_int > $date_int_start && $date_time_int < $date_int_end) {

            //取值
            switch($brand){
                case "依布":
                    $shop_sales_tm = $v2['shop_yibu_tm'];
                    $shop_sales_tb = $v2['shop_yibu_tb'];
                    $shop_sales_yhd = $v2['shop_yibu_yhd'];
                    break;
                case "科尚":
                    $shop_sales_tm = $v2['shop_ks_tm'];
                    $shop_sales_tb = $v2['shop_ks_tb'];
                    $shop_sales_yhd = $v2['shop_ks_yhd'];
                    break;
                default:
                    $shop_sales_tm = $v2['shop_yibu_tm'] + $v2['shop_ks_tm'];
                    $shop_sales_tb = $v2['shop_yibu_tb'] + $v2['shop_ks_tb'];
                    $shop_sales_yhd = $v2['shop_yibu_yhd'] + $v2['shop_ks_yhd'];
            }

            //天猫 每月 总销售额
            $sales_tm_jn = $sales_tm_jn + $shop_sales_tm;

            //淘宝 每月 总销售额
            $sales_tb_jn = $sales_tb_jn + $shop_sales_tb;

            //淘宝 每月 总销售额
            $sales_yhd_jn = $sales_yhd_jn + $shop_sales_yhd;

        }
    }


    //取整
    //天猫 每月 总销售额
    $sales_tm_jn = round(($sales_tm_jn/10000),0);


    //淘宝 每月 总销售额
    $sales_tb_jn = round(($sales_tb_jn/10000),1);


    //一号店 每月 总销售额
    $sales_yhd_jn = round(($sales_yhd_jn/10000),1);

    //部门 总销售额
    $sales_all_jn = round(($sales_tm_jn+$sales_tb_jn+$sales_yhd_jn),0);


    //天猫销售额 json list
    if ($re_data_tm != '') {
        $re_data_tm .= ',';
    }
    $re_data_tm .= '{"m":'. $tm .',"success":'. $sales_tm_jn .',"percent":'. round(($sales_tm_jn/$tm)*100,0) .'}';


    //淘宝销售额 json list
    if ($re_data_tb != '') {
        $re_data_tb .= ',';
    }
    $re_data_tb .= '{"m":' . $tb . ',"success":'. $sales_tb_jn .',"percent":'. round(($sales_tb_jn/$tb)*100,0) .'}';


    //一号店销售额 json list
    if ($re_data_yhd != '') {
        $re_data_yhd .= ',';
    }
    $re_data_yhd .= '{"m":' . $yhd . ',"success":'. $sales_yhd_jn .',"percent":'. round(($sales_yhd_jn/$yhd)*100,0) .'}';


    //部门总销售 json list
    if ($re_data_all != '') {
        $re_data_all .= ',';
    }
    $re_data_all .= '{"m":' . $re_all . ',"success":'. $sales_all_jn .',"percent":'. round(($sales_all_jn/$re_all)*100,0) .'}';


    //天猫 总指标
    $zhibiao_tm_all = $zhibiao_tm_all + $tm;

    //淘宝 总指标
    $zhibiao_tb_all = $zhibiao_tb_all + $tb;

    //一号店 总指标
    $zhibiao_yhd_all = $zhibiao_yhd_all + $yhd;


    //天猫 总销售
    $all_sales_tm = $all_sales_tm + $sales_tm_jn;

    //淘宝 总销售
    $all_sales_tb = $all_sales_tb + $sales_tb_jn;

    //一号店 总销售
    $all_sales_yhd = $all_sales_yhd + $sales_yhd_jn;



}

$all_zhibiao_ds = $zhibiao_tm_all + $zhibiao_tb_all + $zhibiao_yhd_all;

//部门 总销售
$all_sales_all = $all_sales_tm + $all_sales_tb + $all_sales_yhd;

$result .= '{"all_zhibiao":'. $all_zhibiao_ds .',"shop":"天猫","ybzhibiao":[' . $re_data_tm . '],"all":'. $zhibiao_tm_all .',"all_sales":'. $all_sales_tm .',"percent":'. round(($all_sales_tm/$zhibiao_tm_all)*100,0) .'},';
$result .= '{"all_zhibiao":'. $all_zhibiao_ds .',"shop":"淘宝","ybzhibiao":[' . $re_data_tb . '],"all":'. $zhibiao_tb_all .',"all_sales":'. $all_sales_tb .',"percent":'. round(($all_sales_tb/$zhibiao_tb_all)*100,0) .'},';
$result .= '{"all_zhibiao":'. $all_zhibiao_ds .',"shop":"一号店","ybzhibiao":[' . $re_data_yhd . '],"all":'. $zhibiao_yhd_all .',"all_sales":'. $all_sales_yhd .',"percent":'. round(($all_sales_yhd/$zhibiao_yhd_all)*100,0) .'},';
$result .= '{"all_zhibiao":'. $all_zhibiao_ds .',"shop":"合计","ybzhibiao":[' . $re_data_all . '],"all":'. $all_zhibiao_ds .',"all_sales":'. $all_sales_all .',"percent":'. round(($all_sales_all/$all_zhibiao_ds)*100,0) .'}';


echo '[' . $result . ']';
