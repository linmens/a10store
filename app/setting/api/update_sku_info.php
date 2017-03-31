<?php
require('../../config/config_mysql.php');

$ein = new ein_mysql();
$ein->e_mysql_connect();
$ein->e_html_set_header();


$params = json_decode(file_get_contents('php://input'), true);
$data_arr = $params['check'];

if ($data_arr == '') {

    $qs2 = "SELECT * FROM `tbapi_yibu_goods_info` ORDER BY `outer_id_gs` ASC";
    $data_arr = $ein->e_mysql_search($qs2);

    foreach ($data_arr as $v22) {
        $outer_id_ds = $v22['outer_id_ds'];//商品货号_电商
        $outer_id_gs = $v22['outer_id_gs'];//商品货号_公司
        $goods_color_no_gs = $v22['goods_color_no_gs'];//公司颜色编号
        $goods_color_gs = $v22['goods_color_gs'];//公司颜色
        $goods_year = $v22['goods_year'];//商品_年份
        $goods_season = $v22['goods_season'];//商品_季节
        $goods_class_gs = $v22['goods_class_gs'];//公司商品分类

        if ($re_data != '') {
            $re_data .= ',';
        }
        $re_data .= '{"outer_id_ds":"' . $outer_id_ds . '",';//商品货号_电商
        $re_data .= '"outer_id_gs":"' . $outer_id_gs . '",';//商品货号_公司
        $re_data .= '"goods_color_gs":"' . $goods_color_gs . '",';
        $re_data .= '"goods_year":"' . $goods_year . '",';
        $re_data .= '"goods_season":"' . $goods_season . '",';
        $re_data .= '"goods_class_gs":"' . $goods_class_gs . '",';
        $re_data .= '"goods_color_no_gs":"' . $goods_color_no_gs . '"}';
    }

    //输出json数据
    $res_data = '{"item_list":[' . $re_data . ']}';
    echo $res_data;
} else {
    $data = $params['data'];

    foreach ($data as $v) {

        $outer_id_ds = $v['outer_id_ds'];//商品货号_电商
        $outer_id_gs = $v['outer_id_gs'];//商品货号_公司

        $bar_code_ds_hf = $outer_id_ds . $v['goods_color_no_gs'];//条形码_电商

        $goods_year = $v['goods_year'];
        $goods_color_gs = $v['goods_color_gs'];
        $goods_color_no_gs = $v['goods_color_no_gs'];
        $goods_season = $v['goods_season'];
        $goods_class_gs = $v['goods_class_gs'];
        $goods_size_gs = '';


        //获取条形码(到颜色) 相同的 sku
        $qs = "SELECT * FROM `tbapi_yibu_goods_info_sku` WHERE `bar_code_ds` LIKE '%$bar_code_ds_hf%'";
        $data_sku = $ein->e_mysql_search($qs);

        //更新 每条sku 的 对应 信息
        foreach ($data_sku as $v_sku) {
            $bar_code_ds = $v_sku['bar_code_ds'];
            $sp_arr = str_split($bar_code_ds);

            switch ($goods_year) {
                case $goods_year >= 2016:

                    //获取尺码
                    $goods_size_no_gs = $sp_arr[10] . $sp_arr[11];
                    switch ($goods_size_no_gs) {
                        case "02":
                            $goods_size_gs = "M";
                            break;
                        case "03":
                            $goods_size_gs = "L";
                            break;
                        case "04":
                            $goods_size_gs = "XL";
                            break;
                        case "05":
                            $goods_size_gs = "2XL";
                            break;
                        case "06":
                            $goods_size_gs = "3XL";
                            break;
                        case "07":
                            $goods_size_gs = "4XL";
                            break;
                    }

                    break;
                case $goods_year <= 2015:

                    //获取尺码
                    $goods_size_no_gs = $sp_arr[10] . $sp_arr[11];
                    switch ($goods_size_no_gs) {
                        case "02":
                            $goods_size_gs = "M";
                            break;
                        case "03":
                            $goods_size_gs = "L";
                            break;
                        case "04":
                            $goods_size_gs = "XL";
                            break;
                        case "05":
                            $goods_size_gs = "2XL";
                            break;
                        case "06":
                            $goods_size_gs = "3XL";
                            break;
                        case "07":
                            $goods_size_gs = "4XL";
                            break;
                    }
                    break;
            }


            $update = "UPDATE `tbapi_yibu_goods_info_sku` SET ";
            $update .= "`outer_id_ds` = '$outer_id_ds',";
            $update .= "`outer_id_gs` = '$outer_id_gs',";
            $update .= "`goods_class_gs` = '$goods_class_gs',";
            $update .= "`goods_size_gs` = '$goods_size_gs',";
            $update .= "`goods_size_no_gs` = '$goods_size_no_gs',";
            $update .= "`goods_color_gs` = '$goods_color_gs',";
            $update .= "`goods_color_no_gs` = '$goods_color_no_gs',";
            $update .= "`goods_season` = '$goods_season',";
            $update .= "`goods_year` = '$goods_year'";
            $update .= "WHERE `bar_code_ds` = '$bar_code_ds'";

            mysql_query($update);

        }


    }
    echo '{"percent":' . $params['key'] . '}';

}


