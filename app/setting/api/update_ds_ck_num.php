<?php
//从sku表中提取商品库存，更新至商品库
require('../../config/config_mysql.php');
$ein = new ein_mysql();
$ein->e_mysql_connect();
$ein->e_html_set_header();
$params = json_decode(file_get_contents('php://input'), true);
$data_arr = $params['data'];
if ($data_arr == '') {
    //如果post数据为空，就执行 返回商品总list
    $select = "SELECT `outer_id_gs`,`goods_color_gs` FROM `tbapi_yibu_goods_info` ORDER BY `goods_year` DESC";
    $data_arr = $ein->e_mysql_search($select);
    foreach ($data_arr as $v1) {
        $outer_id_gs = $v1['outer_id_gs'];
        $goods_color_gs = $v1['goods_color_gs'];
        if ($re_data != '') {
            $re_data .= ',';
        }
        $re_data .= '{"outer_id_gs":"' . $outer_id_gs . '","goods_color_gs":"' . $goods_color_gs . '"}';
    }
    //输出json数据
    $res_data = '{"item_list":[' . $re_data . ']}';
    echo $res_data;
} else {
    //如果post数据不为空，开始更新sku库存合计 到商品表
    $data_arr = $params['data'];
    foreach ($data_arr as $vvv) {
        $outer_id_gs = $vvv['outer_id_gs'];
        $goods_color_gs = $vvv['goods_color_gs'];
        $sales_volume_all_all = 0;//商品总销量,返回数据
        $sales_volume_30d_all = 0;//返回商品30天总销量,返回数据
        $sales_volume_7d_all = 0;//返回商品7天总销量,返回数据
        $num_ds_ck_all = 0;//返回 电商仓库 总库存,返回数据
        $num_gs_ck_all = 0;//返回 公司仓库 总库存,返回数据
        $num_gs_shop_all = 0;//返回 公司商场 总库存,返回数据
        $qs = "SELECT * FROM `tbapi_yibu_goods_info_sku` WHERE `outer_id_gs` = '$outer_id_gs' AND `goods_color_gs` = '$goods_color_gs'";
        $data = $ein->e_mysql_search($qs);
        foreach ($data as $v) {
            $sales_volume_all_all = $sales_volume_all_all + $v['sales_volume_all'];//商品总销量，累加
            $sales_volume_30d_all = $sales_volume_30d_all + $v['sales_volume_30d'];//商品30天总销量，累加
            $sales_volume_7d_all = $sales_volume_7d_all + $v['sales_volume_7d'];//商品7天总销量，累加
            $num_ds_ck_all = $num_ds_ck_all + $v['num_ds_ck'];//电商仓库库存，累加
            $num_gs_ck_all = $num_gs_ck_all + $v['num_gs_ck'];//公司仓库库存，累加
            $num_gs_shop_all = $num_gs_shop_all + $v['num_gs_shop'];//公司商场库存，累加
        }
        $up = "UPDATE `tbapi_yibu_goods_info` SET `sales_volume_7d` = '$sales_volume_7d_all', `sales_volume_30d` = '$sales_volume_30d_all', `sales_volume_all` = '$sales_volume_all_all', `num_ds_ck` = '$num_ds_ck_all', `num_gs_ck` = '$num_gs_ck_all', `num_gs_shop` = '$num_gs_shop_all' WHERE `outer_id_gs` = '$outer_id_gs' AND `goods_color_gs` = '$goods_color_gs'";
        mysql_query($up);
    }
    echo '{"percent":'.$params['key'].'}';
}