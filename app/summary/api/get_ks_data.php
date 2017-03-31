<?php

function get_sale_data($shop)
{

    require('../../config/config_mysql.php');
    $ein = new ein_mysql();
    $ein->e_mysql_connect();

    $result = '';

    $re_data_time = "";//返回时间数据
    $list_yb_tm_jn = '';//返回 list 依布 天猫 今年销售数据;
    $list_yb_tm_qn = '';//返回 list 依布 天猫 去年销售数据;

    $list_yb_tb_jn = '';//返回 list 依布 淘宝 今年销售数据;
    $list_yb_tb_qn = '';//返回 list 依布 淘宝 去年销售数据;

    $list_yb_yhd_jn = '';//返回 list 依布 一号店 今年销售数据;
    $list_yb_yhd_qn = '';//返回 list 依布 一号店 去年销售数据;

    $list_yb_jn = '';//返回 list 依布 今年销售数据;
    $list_yb_qn = '';//返回 list 依布 去年销售数据;

    $all_sales_yb_tm_jn = 0;//返回 总销售而 依布 天猫
    $all_sales_yb_tb_jn = 0;//返回 总销售而 依布 淘宝
    $all_sales_yb_yhd_jn = 0;//返回 总销售而 依布 一号店
    $all_sales_yb_jn = 0;//返回 总销售额 依布 今年


    $all_sales_yb_tm_qn = 0;//返回 总销售而 依布 天猫
    $all_sales_yb_tb_qn = 0;//返回 总销售而 淘宝 天猫
    $all_sales_yb_yhd_qn = 0;//返回 总销售而 一号店 天猫
    $all_sales_yb_qn = 0;//返回 总销售额 依布 去年


    $time_now = date("Ymd", time());

//获取今年数据
    $qs_this_year = "SELECT `date_time_int`,`shop_ks_tm`,`shop_ks_tb`,`shop_ks_yhd` FROM `tbapi_yibu_sales_info` WHERE `date_time_int` > 20170100 AND `date_time_int` < $time_now ORDER BY `date_time_int` ASC";
    $data_arr_jn = $ein->e_mysql_search($qs_this_year);

    $qs_last_year = "SELECT `date_time_int`,`shop_ks_tm`,`shop_ks_tb`,`shop_ks_yhd` FROM `tbapi_yibu_sales_info` WHERE `date_time_int` > 20160100 AND `date_time_int` < 20170100 ORDER BY `date_time_int` ASC";
    $data_arr_qn = $ein->e_mysql_search($qs_last_year);

    foreach ($data_arr_jn as $v1) {
        $date_time_int_jn2 = $v1['date_time_int'] - 10000;
        foreach ($data_arr_qn as $v2) {
            //去年的销售数据 时间段要与 本年度时间段一样才能 计入
            $date_time_int_qn = $v2['date_time_int'];
            if ($date_time_int_qn == $date_time_int_jn2) {
                $shop_ks_tm_last_year = $v2['shop_ks_tm'];//科尚-天猫数据
                $shop_ks_tb_last_year = $v2['shop_ks_tb'];//科尚-淘宝数据
                $shop_ks_yhd_last_year = $v2['shop_ks_yhd'];//科尚-一号店数据
                $shop_ks_last_year = $shop_ks_tm_last_year + $shop_ks_tb_last_year + $shop_ks_yhd_last_year;//科尚今年-数据


                //返回 总销售额 依布 天猫 去年
                $all_sales_yb_tm_qn = $all_sales_yb_tm_qn + $shop_ks_tm_last_year;
                $all_sales_yb_tm_qn = round($all_sales_yb_tm_qn, 0);

                //返回 总销售额 依布 淘宝 去年
                $all_sales_yb_tb_qn = $all_sales_yb_tb_qn + $shop_ks_tb_last_year;
                $all_sales_yb_tb_qn = round($all_sales_yb_tb_qn, 0);

                //返回 总销售额 依布 一号店 去年
                $all_sales_yb_yhd_qn = $all_sales_yb_yhd_qn + $shop_ks_yhd_last_year;
                $all_sales_yb_yhd_qn = round($all_sales_yb_yhd_qn, 0);


                //组成json 返回天猫店 去年销售数据
                if ($list_yb_tm_qn != '') {
                    $list_yb_tm_qn .= ',';
                }
                $list_yb_tm_qn .= $shop_ks_tm_last_year;


                //组成json 返回淘宝店 去年销售数据
                if ($list_yb_tb_qn != '') {
                    $list_yb_tb_qn .= ',';
                }
                $list_yb_tb_qn .= $shop_ks_tb_last_year;


                //组成json 返回一号店店 去年销售数据
                if ($list_yb_yhd_qn != '') {
                    $list_yb_yhd_qn .= ',';
                }
                $list_yb_yhd_qn .= $shop_ks_yhd_last_year;


                //组成json 返回一号店店 去年销售数据
                if ($list_yb_qn != '') {
                    $list_yb_qn .= ',';
                }
                $list_yb_qn .= $shop_ks_last_year;

            }
        }

        $shop_yibu_tm_this_year = $v1['shop_ks_tm'];//科尚-今年天猫数据
        $shop_yibu_tb_this_year = $v1['shop_ks_tb'];//科尚-今年-淘宝数据
        $shop_yibu_yhd_this_year = $v1['shop_ks_yhd'];//科尚-今年-一号店数据
        $shop_yibu_this_year = $shop_yibu_tm_this_year + $shop_yibu_tb_this_year + $shop_yibu_yhd_this_year;//科尚-今年-数据

        //返回 总销售额 科尚 天猫 今年
        $all_sales_yb_tm_jn = $all_sales_yb_tm_jn + $shop_yibu_tm_this_year;
        $all_sales_yb_tm_jn = round($all_sales_yb_tm_jn, 0);

        //返回 总销售额 科尚 淘宝 今年
        $all_sales_yb_tb_jn = $all_sales_yb_tb_jn + $shop_yibu_tb_this_year;
        $all_sales_yb_tb_jn = round($all_sales_yb_tb_jn, 0);

        //返回 总销售额 科尚 一号店 今年
        $all_sales_yb_yhd_jn = $all_sales_yb_yhd_jn + $shop_yibu_yhd_this_year;
        $all_sales_yb_yhd_jn = round($all_sales_yb_yhd_jn, 0);


        //组成json 返回时间数据
        $date_time_int = $v1['date_time_int'];
        $date_time_int = strtotime($date_time_int);
        $date_time_int = date("Y/m/d", $date_time_int);
        if ($re_data_time != "") {
            $re_data_time .= ",";
        }
        $re_data_time .= '"' . $date_time_int . '"';

        //组成json 返回 依布 天猫店 今年销售数据
        if ($list_yb_tm_jn != '') {
            $list_yb_tm_jn .= ',';
        }
        $list_yb_tm_jn .= $shop_yibu_tm_this_year;


        //组成json 返回 依布 淘宝店 今年销售数据
        if ($list_yb_tb_jn != '') {
            $list_yb_tb_jn .= ',';
        }
        $list_yb_tb_jn .= $shop_yibu_tb_this_year;

        //组成json 返回 依布 一号店店 今年销售数据
        if ($list_yb_yhd_jn != '') {
            $list_yb_yhd_jn .= ',';
        }
        $list_yb_yhd_jn .= $shop_yibu_yhd_this_year;


        //组成json 返回 依布 今年销售数据
        if ($list_yb_jn != '') {
            $list_yb_jn .= ',';
        }
        $list_yb_jn .= $shop_yibu_this_year;
    }

//返回 总销售额 依布 今年
    $all_sales_yb_jn = $all_sales_yb_tm_jn + $all_sales_yb_tb_jn + $all_sales_yb_yhd_jn;

//返回 总销售额 依布 去年
    $all_sales_yb_qn = $all_sales_yb_tm_qn + $all_sales_yb_tb_qn + $all_sales_yb_yhd_qn;


    switch ($shop) {
        case "天猫":
            $result .= '"data_title":["科尚天猫","科尚天猫去年"],';
            $result .= '"data_time":[' . $re_data_time . '],';
            $result .= '"list_sale_info_jn":{"all":' . $all_sales_yb_jn . ',"tm":' . $all_sales_yb_tm_jn . ',"tb":' . $all_sales_yb_tb_jn . ',"yhd":' . $all_sales_yb_yhd_jn . '},';
            $result .= '"list_sale_info_qn":{"all":' . $all_sales_yb_qn . ',"tm":' . $all_sales_yb_tm_qn . ',"tb":' . $all_sales_yb_tb_qn . ',"yhd":' . $all_sales_yb_yhd_qn . '},';
            $result .= '"list_sale_info_day_jn":{"all":' . $shop_yibu_this_year . ',"tm":' . $shop_yibu_tm_this_year . ',"tb":' . $shop_yibu_tb_this_year . ',"yhd":' . $shop_yibu_yhd_this_year . '},';
            $result .= '"list_sale_info_day_qn":{"all":' . $shop_ks_last_year . ',"tm":' . $shop_ks_tm_last_year . ',"tb":' . $shop_ks_tb_last_year . ',"yhd":' . $shop_ks_yhd_last_year . '},';
            $result .= '"list":[{"name":"科尚天猫","data":[' . $list_yb_tm_jn . ']},{"name":"科尚天猫去年","data":[' . $list_yb_tm_qn . ']}]';
            break;
        case "淘宝":
            $result .= '"data_title":["科尚淘宝","科尚淘宝去年"],';
            $result .= '"data_time":[' . $re_data_time . '],';
            $result .= '"list_sale_info_jn":{"all":' . $all_sales_yb_jn . ',"tm":' . $all_sales_yb_tm_jn . ',"tb":' . $all_sales_yb_tb_jn . ',"yhd":' . $all_sales_yb_yhd_jn . '},';
            $result .= '"list_sale_info_qn":{"all":' . $all_sales_yb_qn . ',"tm":' . $all_sales_yb_tm_qn . ',"tb":' . $all_sales_yb_tb_qn . ',"yhd":' . $all_sales_yb_yhd_qn . '},';
            $result .= '"list_sale_info_day_jn":{"all":' . $shop_yibu_this_year . ',"tm":' . $shop_yibu_tm_this_year . ',"tb":' . $shop_yibu_tb_this_year . ',"yhd":' . $shop_yibu_yhd_this_year . '},';
            $result .= '"list_sale_info_day_qn":{"all":' . $shop_ks_last_year . ',"tm":' . $shop_ks_tm_last_year . ',"tb":' . $shop_ks_tb_last_year . ',"yhd":' . $shop_ks_yhd_last_year . '},';
            $result .= '"list":[{"name":"科尚淘宝","data":[' . $list_yb_tb_jn . ']},{"name":"科尚淘宝去年","data":[' . $list_yb_tb_qn . ']}]';
            break;
        case "一号店":
            $result .= '"data_title":["科尚一号店","科尚一号店去年"],';
            $result .= '"data_time":[' . $re_data_time . '],';
            $result .= '"list_sale_info_jn":{"all":' . $all_sales_yb_jn . ',"tm":' . $all_sales_yb_tm_jn . ',"tb":' . $all_sales_yb_tb_jn . ',"yhd":' . $all_sales_yb_yhd_jn . '},';
            $result .= '"list_sale_info_qn":{"all":' . $all_sales_yb_qn . ',"tm":' . $all_sales_yb_tm_qn . ',"tb":' . $all_sales_yb_tb_qn . ',"yhd":' . $all_sales_yb_yhd_qn . '},';
            $result .= '"list_sale_info_day_jn":{"all":' . $shop_yibu_this_year . ',"tm":' . $shop_yibu_tm_this_year . ',"tb":' . $shop_yibu_tb_this_year . ',"yhd":' . $shop_yibu_yhd_this_year . '},';
            $result .= '"list_sale_info_day_qn":{"all":' . $shop_ks_last_year . ',"tm":' . $shop_ks_tm_last_year . ',"tb":' . $shop_ks_tb_last_year . ',"yhd":' . $shop_ks_yhd_last_year . '},';
            $result .= '"list":[{"name":"科尚一号店","data":[' . $list_yb_yhd_jn . ']},{"name":"科尚一号店去年","data":[' . $list_yb_yhd_qn . ']}]';
            break;
        default:
            //默认返回 依布 整个部门 全年销售额
            $result .= '"data_title":["科尚今年","科尚去年"],';
            $result .= '"data_time":[' . $re_data_time . '],';
            $result .= '"list_sale_info_jn":{"all":' . $all_sales_yb_jn . ',"tm":' . $all_sales_yb_tm_jn . ',"tb":' . $all_sales_yb_tb_jn . ',"yhd":' . $all_sales_yb_yhd_jn . '},';
            $result .= '"list_sale_info_qn":{"all":' . $all_sales_yb_qn . ',"tm":' . $all_sales_yb_tm_qn . ',"tb":' . $all_sales_yb_tb_qn . ',"yhd":' . $all_sales_yb_yhd_qn . '},';
            $result .= '"list_sale_info_day_jn":{"all":' . $shop_yibu_this_year . ',"tm":' . $shop_yibu_tm_this_year . ',"tb":' . $shop_yibu_tb_this_year . ',"yhd":' . $shop_yibu_yhd_this_year . '},';
            $result .= '"list_sale_info_day_qn":{"all":' . $shop_ks_last_year . ',"tm":' . $shop_ks_tm_last_year . ',"tb":' . $shop_ks_tb_last_year . ',"yhd":' . $shop_ks_yhd_last_year . '},';
            $result .= '"list":[{"name":"科尚今年","data":[' . $list_yb_jn . ']},{"name":"科尚去年","data":[' . $list_yb_qn . ']}]';
    }

    echo '{' . $result . '}';
}