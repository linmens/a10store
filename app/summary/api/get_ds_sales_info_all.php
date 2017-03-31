<?php
require('../../config/config_mysql.php');
$ein = new ein_mysql();
$ein->e_mysql_connect();


//获取今年 系统当前时间
$time_now_jn = date("Ymd", time());

//获取去年 系统当前时间
$time_now_qn = $time_now_jn - 10000;


//获取 今年数据
$qs_jn = "SELECT * FROM `tbapi_yibu_sales_info` WHERE `date_time_int` > 20170100 AND `date_time_int` < $time_now_jn ORDER BY `date_time_int` ASC";
$re_data_arr_jn = $ein->e_mysql_search($qs_jn);

//获取 去年数据
$qs_qn = "SELECT * FROM `tbapi_yibu_sales_info` WHERE `date_time_int` > 20160100 AND `date_time_int` < $time_now_qn ORDER BY `date_time_int` ASC";
$re_data_arr_qn = $ein->e_mysql_search($qs_qn);

$all_sales_jn = 0;//总销售-今年
$all_sales_qn = 0;//总销售-去年


foreach ($re_data_arr_jn as $v1) {
    $shop_yibu_tm_this_year = $v1['shop_yibu_tm'];//依布-天猫数据(今年)
    $shop_yibu_tb_this_year = $v1['shop_yibu_tb'];//依布-淘宝数据(今年)
    $shop_yibu_yhd_this_year = $v1['shop_yibu_yhd'];//依布-一号店数据(今年)

    $shop_ks_tm_this_year = $v1['shop_ks_tm'];//科尚-天猫数据(今年)
    $shop_ks_tb_this_year = $v1['shop_ks_tb'];//科尚-淘宝数据(今年)
    $shop_ks_yhd_this_year = $v1['shop_ks_yhd'];//科尚-一号店数据(今年)

    //每日 所有店铺 总计销售额
    $all_sales_this_year = $shop_yibu_tm_this_year + $shop_yibu_tb_this_year + $shop_yibu_yhd_this_year + $shop_ks_tm_this_year + $shop_ks_tb_this_year + $shop_ks_yhd_this_year;

    //总销售-今年
    $all_sales_jn = $all_sales_jn + $all_sales_this_year;

    $date_time_int_jn = $v1['date_time_int'];

    $date_time_int_jn2 = $date_time_int_jn - 10000;

    foreach ($re_data_arr_qn as $v2) {
        $date_time_int_qn = $v2['date_time_int'];

        if ($date_time_int_qn == $date_time_int_jn2) {
            $shop_yibu_tm_last_year = $v2['shop_yibu_tm'];//依布-天猫数据
            $shop_yibu_tb_last_year = $v2['shop_yibu_tb'];//依布-淘宝数据
            $shop_yibu_yhd_last_year = $v2['shop_yibu_yhd'];//依布-一号店数据

            $shop_ks_tm_last_year = $v2['shop_ks_tm'];//科尚-天猫数据
            $shop_ks_tb_last_year = $v2['shop_ks_tb'];//科尚-淘宝数据
            $shop_ks_yhd_last_year = $v2['shop_ks_yhd'];//科尚-一号店数据

            //去年总销售额
            $all_sales_last_year = $shop_yibu_tm_last_year + $shop_yibu_tb_last_year + $shop_yibu_yhd_last_year + $shop_ks_tm_last_year + $shop_ks_tb_last_year + $shop_ks_yhd_last_year;

            $all_sales_qn = $all_sales_qn + $all_sales_last_year;

        }
    }

}

//总销售-今年
$all_sales_jn = ($all_sales_jn / 10000);
$all_sales_jn = round($all_sales_jn, 0);

//总销售-去年
$all_sales_qn = ($all_sales_qn / 10000);
$all_sales_qn = round($all_sales_qn, 0);

//总指标——今年
$zhibiao_jn = 1800;

//完成率-今年 = （总销售-今年 / 总指标——今年）*100
$wanchenglv_jn = (($all_sales_jn / $zhibiao_jn) * 100);
$wanchenglv_jn = round($wanchenglv_jn, 1);

//已用时间
$start_time = strtotime("2017-01-01");
$time_use = (time() - $start_time) / (365 * 24 * 60 * 60);
$time_use = round(($time_use * 100), 1);

//剩余指标 = 总指标——今年 - 总销售-今年
$shengyu_zhibiao = $zhibiao_jn - $all_sales_jn;

$result = '"all_sales_jn":"' . $all_sales_jn . '",';//总销售-今年
$result .= '"all_sales_qn":"' . $all_sales_qn . '",';//总销售-去年
$result .= '"zhibiao_jn":"' . $zhibiao_jn . '",';//总指标——今年
$result .= '"wanchenglv_jn":"' . $wanchenglv_jn . '%",';//完成率-今年
$result .= '"time_use":"' . $time_use . '%",';//已用时间
$result .= '"shengyu_zhibiao":"' . $shengyu_zhibiao . '"';//剩余指标
echo '{' . $result . '}';