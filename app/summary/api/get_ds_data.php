<?php

function get_sale_data($shop)
{

    require('../../config/config_mysql.php');
    $ein = new ein_mysql();
    $ein->e_mysql_connect();


    $result = '';
    $time_now = date("Ymd", time());

    $list_ds_tm_jn = '';//返回 list 天猫 今年销售数据;
    $list_ds_tm_qn = '';//返回 list 天猫 去年销售数据;


    $list_ds_tb_jn = '';//返回 list 淘宝 今年销售数据;
    $list_ds_tb_qn = '';//返回 list 淘宝 去年销售数据;


    $list_ds_yhd_jn = '';//返回 list 一号店 今年销售数据;
    $list_ds_yhd_qn = '';//返回 list 一号店 去年销售数据;

    $list_ds_jn = '';//返回 list 部门 今年销售数据;
    $list_ds_qn = '';//返回 list 部门 去年销售数据;


    $all_sales_ds_tm_jn = 0;//天猫 总 销售额 今年
    $all_sales_ds_tm_qn = 0;//天猫 总 销售额 去年

    $all_sales_ds_tb_jn = 0;//淘宝 总 销售额 今年
    $all_sales_ds_tb_qn = 0;//淘宝 总 销售额 去年

    $all_sales_ds_yhd_jn = 0;//一号店 总 销售额 今年
    $all_sales_ds_yhd_qn = 0;//一号店 总 销售额 去年

    $re_data_time = '';//返回时间

//获取今年数据
    $qs_this_year = "SELECT * FROM `tbapi_yibu_sales_info` WHERE `date_time_int` > 20170100 AND `date_time_int` < $time_now ORDER BY `date_time_int` ASC";
    $data_arr_jn = $ein->e_mysql_search($qs_this_year);

    $qs_last_year = "SELECT * FROM `tbapi_yibu_sales_info` WHERE `date_time_int` > 20160100 AND `date_time_int` < 20170100 ORDER BY `date_time_int` ASC";
    $data_arr_qn = $ein->e_mysql_search($qs_last_year);


    foreach ($data_arr_jn as $v1) {

        $date_time_int_jn2 = $v1['date_time_int'] - 10000;
        foreach ($data_arr_qn as $v2) {
            //去年的销售数据 时间段要与 本年度时间段一样才能 计入
            $date_time_int_qn = $v2['date_time_int'];
            if ($date_time_int_qn == $date_time_int_jn2) {

                //天猫 每日 总销售额 去年
                $tm_sales_qn_day = $v2['shop_ks_tm'] + $v2['shop_yibu_tm'];

                //淘宝 每日 总销售额 去年
                $tb_sales_qn_day = $v2['shop_ks_tb'] + $v2['shop_yibu_tb'];


                //一号店 每日 总销售额 去年
                $yhd_sales_qn_day = $v2['shop_ks_yhd'] + $v2['shop_yibu_yhd'];


                //总销售 每日 今年
                $ds_all_sales_qn = $tm_sales_qn_day + $tb_sales_qn_day + $yhd_sales_qn_day;

                //天猫 总销售额 去年
                $all_sales_ds_tm_qn = $all_sales_ds_tm_qn + $tm_sales_qn_day;
                $all_sales_ds_tm_qn = round($all_sales_ds_tm_qn, 0);


                //淘宝 总销售额 去年
                $all_sales_ds_tb_qn = $all_sales_ds_tb_qn + $tb_sales_qn_day;
                $all_sales_ds_tb_qn = round($all_sales_ds_tb_qn, 0);


                //淘宝 总销售额 去年
                $all_sales_ds_yhd_qn = $all_sales_ds_yhd_qn + $yhd_sales_qn_day;
                $all_sales_ds_yhd_qn = round($all_sales_ds_yhd_qn, 0);


                //组成json 返回 天猫店 去年销售数据
                if ($list_ds_tm_qn != '') {
                    $list_ds_tm_qn .= ',';
                }
                $list_ds_tm_qn .= $tm_sales_qn_day;

                //组成json 返回 淘宝店 去年销售数据
                if ($list_ds_tb_qn != '') {
                    $list_ds_tb_qn .= ',';
                }
                $list_ds_tb_qn .= $tb_sales_qn_day;

                //组成json 返回 一号店 去年销售数据
                if ($list_ds_yhd_qn != '') {
                    $list_ds_yhd_qn .= ',';
                }
                $list_ds_yhd_qn .= $yhd_sales_qn_day;


                //组成json 返回 电商 去年销售数据
                if ($list_ds_qn != '') {
                    $list_ds_qn .= ',';
                }
                $list_ds_qn .= $ds_all_sales_qn;


            }
        }


        //天猫 每日 总销售额 今年
        $tm_sales_jn_day = $v1['shop_ks_tm'] + $v1['shop_yibu_tm'];

        //淘宝 每日 总销售额 今年
        $tb_sales_jn_day = $v1['shop_ks_tb'] + $v1['shop_yibu_tb'];

        //一号店 每日 总销售额 今年
        $yhd_sales_jn_day = $v1['shop_ks_yhd'] + $v1['shop_yibu_yhd'];

        //总销售 每日 今年
        $ds_all_sales_jn = $tm_sales_jn_day + $tb_sales_jn_day + $yhd_sales_jn_day;

        //天猫 总销售额 今年
        $all_sales_ds_tm_jn = $all_sales_ds_tm_jn + $tm_sales_jn_day;
        $all_sales_ds_tm_jn = round($all_sales_ds_tm_jn, 0);

        //淘宝 总销售额 今年
        $all_sales_ds_tb_jn = $all_sales_ds_tb_jn + $tb_sales_jn_day;
        $all_sales_ds_tb_jn = round($all_sales_ds_tb_jn, 0);

        //一号店 总销售额 今年
        $all_sales_ds_yhd_jn = $all_sales_ds_yhd_jn + $yhd_sales_jn_day;
        $all_sales_ds_yhd_jn = round($all_sales_ds_yhd_jn, 0);

        //组成json 返回时间数据
        $date_time_int = $v1['date_time_int'];
        $date_time_int = strtotime($date_time_int);
        $date_time_int = date("Y/m/d", $date_time_int);
        if ($re_data_time != "") {
            $re_data_time .= ",";
        }
        $re_data_time .= '"' . $date_time_int . '"';


        //组成json 返回 天猫店 今年销售数据
        if ($list_ds_tm_jn != '') {
            $list_ds_tm_jn .= ',';
        }
        $list_ds_tm_jn .= $tm_sales_jn_day;


        //组成json 返回 淘宝店 今年销售数据
        if ($list_ds_tb_jn != '') {
            $list_ds_tb_jn .= ',';
        }
        $list_ds_tb_jn .= $tb_sales_jn_day;

        //组成json 返回 一号店 今年销售数据
        if ($list_ds_yhd_jn != '') {
            $list_ds_yhd_jn .= ',';
        }
        $list_ds_yhd_jn .= $yhd_sales_jn_day;


        //组成json 返回 电商 今年销售数据
        if ($list_ds_jn != '') {
            $list_ds_jn .= ',';
        }
        $list_ds_jn .= $ds_all_sales_jn;

    }

//电商今年总销售
    $all_sales_ds_jn = $all_sales_ds_tm_jn + $all_sales_ds_tb_jn + $all_sales_ds_yhd_jn;

//电商去年总销售
    $all_sales_ds_qn = $all_sales_ds_tm_qn + $all_sales_ds_tb_qn + $all_sales_ds_yhd_qn;


    switch ($shop) {
        case "天猫":
            $result .= '"data_title":["电商天猫","电商天猫去年"],';
            $result .= '"data_time":[' . $re_data_time . '],';
            $result .= '"list_sale_info_jn":{"all":' . $all_sales_ds_jn . ',"tm":' . $all_sales_ds_tm_jn . ',"tb":' . $all_sales_ds_tb_jn . ',"yhd":' . $all_sales_ds_yhd_jn . '},';
            $result .= '"list_sale_info_qn":{"all":' . $all_sales_ds_qn . ',"tm":' . $all_sales_ds_tm_qn . ',"tb":' . $all_sales_ds_tb_qn . ',"yhd":' . $all_sales_ds_yhd_qn . '},';
            $result .= '"list_sale_info_day_jn":{"all":' . $ds_all_sales_jn . ',"tm":' . $tm_sales_jn_day . ',"tb":' . $tb_sales_jn_day . ',"yhd":' . $yhd_sales_jn_day . '},';
            $result .= '"list_sale_info_day_qn":{"all":' . $ds_all_sales_qn . ',"tm":' . $tm_sales_qn_day . ',"tb":' . $tb_sales_qn_day . ',"yhd":' . $yhd_sales_qn_day . '},';
            $result .= '"list":[{"name":"电商天猫","data":[' . $list_ds_tm_jn . ']},{"name":"电商天猫去年","data":[' . $list_ds_tm_qn . ']}]';
            break;
        case "淘宝":
            $result .= '"data_title":["依布淘宝","依布淘宝去年"],';
            $result .= '"data_time":[' . $re_data_time . '],';
            $result .= '"list_sale_info_jn":{"all":' . $all_sales_ds_jn . ',"tm":' . $all_sales_ds_tm_jn . ',"tb":' . $all_sales_ds_tb_jn . ',"yhd":' . $all_sales_ds_yhd_jn . '},';
            $result .= '"list_sale_info_qn":{"all":' . $all_sales_ds_qn . ',"tm":' . $all_sales_ds_tm_qn . ',"tb":' . $all_sales_ds_tb_qn . ',"yhd":' . $all_sales_ds_yhd_qn . '},';
            $result .= '"list_sale_info_day_jn":{"all":' . $ds_all_sales_jn . ',"tm":' . $tm_sales_jn_day . ',"tb":' . $tb_sales_jn_day . ',"yhd":' . $yhd_sales_jn_day . '},';
            $result .= '"list_sale_info_day_qn":{"all":' . $ds_all_sales_qn . ',"tm":' . $tm_sales_qn_day . ',"tb":' . $tb_sales_qn_day . ',"yhd":' . $yhd_sales_qn_day . '},';
            $result .= '"list":[{"name":"依布淘宝","data":[' . $list_ds_tb_jn . ']},{"name":"依布淘宝去年","data":[' . $list_ds_tb_qn . ']}]';
            break;
        case "一号店":
            $result .= '"data_title":["依布一号店","依布一号店去年"],';
            $result .= '"data_time":[' . $re_data_time . '],';
            $result .= '"list_sale_info_jn":{"all":' . $all_sales_ds_jn . ',"tm":' . $all_sales_ds_tm_jn . ',"tb":' . $all_sales_ds_tb_jn . ',"yhd":' . $all_sales_ds_yhd_jn . '},';
            $result .= '"list_sale_info_qn":{"all":' . $all_sales_ds_qn . ',"tm":' . $all_sales_ds_tm_qn . ',"tb":' . $all_sales_ds_tb_qn . ',"yhd":' . $all_sales_ds_yhd_qn . '},';
            $result .= '"list_sale_info_day_jn":{"all":' . $ds_all_sales_jn . ',"tm":' . $tm_sales_jn_day . ',"tb":' . $tb_sales_jn_day . ',"yhd":' . $yhd_sales_jn_day . '},';
            $result .= '"list_sale_info_day_qn":{"all":' . $ds_all_sales_qn . ',"tm":' . $tm_sales_qn_day . ',"tb":' . $tb_sales_qn_day . ',"yhd":' . $yhd_sales_qn_day . '},';
            $result .= '"list":[{"name":"依布一号店","data":[' . $list_ds_yhd_jn . ']},{"name":"依布一号店去年","data":[' . $list_ds_yhd_qn . ']}]';
            break;
        default:
            //默认返回 依布 整个部门 全年销售额
            $result .= '"data_title":["部门今年","部门去年"],';
            $result .= '"data_time":[' . $re_data_time . '],';
            $result .= '"list_sale_info_jn":{"all":' . $all_sales_ds_jn . ',"tm":' . $all_sales_ds_tm_jn . ',"tb":' . $all_sales_ds_tb_jn . ',"yhd":' . $all_sales_ds_yhd_jn . '},';
            $result .= '"list_sale_info_qn":{"all":' . $all_sales_ds_qn . ',"tm":' . $all_sales_ds_tm_qn . ',"tb":' . $all_sales_ds_tb_qn . ',"yhd":' . $all_sales_ds_yhd_qn . '},';
            $result .= '"list_sale_info_day_jn":{"all":' . $ds_all_sales_jn . ',"tm":' . $tm_sales_jn_day . ',"tb":' . $tb_sales_jn_day . ',"yhd":' . $yhd_sales_jn_day . '},';
            $result .= '"list_sale_info_day_qn":{"all":' . $ds_all_sales_qn . ',"tm":' . $tm_sales_qn_day . ',"tb":' . $tb_sales_qn_day . ',"yhd":' . $yhd_sales_qn_day . '},';
            $result .= '"list":[{"name":"部门今年","data":[' . $list_ds_jn . ']},{"name":"部门去年","data":[' . $list_ds_qn . ']}]';
    }


    echo '{' . $result . '}';
}

