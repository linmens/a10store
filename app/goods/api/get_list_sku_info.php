<?php
/**
 * Created by PhpStorm.
 * User: Xiao_ai
 * Date: 2017/3/2
 * Time: 16:12
 */
header("Content-Type:text/html;charset=utf-8");
require('../../config/config_mysql.php');

$ein = new ein_mysql();
$ein->e_mysql_connect();

$outer_id_gs = $_GET['outer_id'];
$goods_color_gs = $_GET['color'];

$qs = "SELECT * FROM `tbapi_yibu_goods_info_sku` WHERE `outer_id_gs` = '$outer_id_gs' AND `goods_color_gs` = '$goods_color_gs'";
$data = $ein->e_mysql_search($qs);

foreach($data as $v){
    switch($v['goods_size_gs']){
        case "M":
            $m_num_gs_ck = $v['num_gs_ck'];
            $m_num_gs_shop = $v['num_gs_shop'];
            $m_num_ds_ck = $v['num_ds_ck'];
            break;
        case "L":
            $l_num_gs_ck = $v['num_gs_ck'];
            $l_num_gs_shop = $v['num_gs_shop'];
            $l_num_ds_ck = $v['num_ds_ck'];
            break;
        case "XL":
            $xl_num_gs_ck = $v['num_gs_ck'];
            $xl_num_gs_shop = $v['num_gs_shop'];
            $xl_num_ds_ck = $v['num_ds_ck'];
            break;
        case "2XL":
            $xxl_num_gs_ck = $v['num_gs_ck'];
            $xxl_num_gs_shop = $v['num_gs_shop'];
            $xxl_num_ds_ck = $v['num_ds_ck'];
            break;
        case "3XL":
            $xxxl_num_gs_ck = $v['num_gs_ck'];
            $xxxl_num_gs_shop = $v['num_gs_shop'];
            $xxxl_num_ds_ck = $v['num_ds_ck'];
            break;
        case "4XL":
            $xxxxl_num_gs_ck = $v['num_gs_ck'];
            $xxxxl_num_gs_shop = $v['num_gs_shop'];
            $xxxxl_num_ds_ck = $v['num_ds_ck'];
            break;
    }
}
$num_gs_ck_all = $m_num_gs_ck+$l_num_gs_ck+$xl_num_gs_ck+$xxl_num_gs_ck+$xxxl_num_gs_ck+$xxxxl_num_gs_ck;
$num_gs_shop_all = $m_num_gs_shop+$l_num_gs_shop+$xl_num_gs_shop+$xxl_num_gs_shop+$xxxl_num_gs_shop+$xxxxl_num_gs_shop;
$num_ds_ck_all = $m_num_ds_ck+$l_num_ds_ck+$xl_num_ds_ck+$xxl_num_ds_ck+$xxxl_num_ds_ck+$xxxxl_num_ds_ck;

$list = "";
$list .='{"num_gs_shop":[{"all":"'. $num_gs_shop_all .'","M":"'. $m_num_gs_shop .'","L":"'. $l_num_gs_shop .'","XL":"'. $xl_num_gs_shop .'","XXL":"'. $xxl_num_gs_shop .'","XXXL":"'. $xxxl_num_gs_shop .'","XXXXL":"'. $xxxxl_num_gs_shop .'"}],';
$list .='"num_gs_ck":[{"all":"'. $num_gs_ck_all .'","M":"'. $m_num_gs_ck .'","L":"'. $l_num_gs_ck .'","XL":"'. $xl_num_gs_ck .'","XXL":"'. $xxl_num_gs_ck .'","XXXL":"'. $xxxl_num_gs_ck .'","XXXXL":"'. $xxxxl_num_gs_ck .'"}],';
$list .='"num_ds_ck":[{"all":"'. $num_ds_ck_all .'","M":"'. $m_num_ds_ck .'","L":"'. $l_num_ds_ck .'","XL":"'. $xl_num_ds_ck .'","XXL":"'. $xxl_num_ds_ck .'","XXXL":"'. $xxxl_num_ds_ck .'","XXXXL":"'. $xxxxl_num_ds_ck .'"}]}';
echo $list;