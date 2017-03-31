<?php
header("Content-Type:text/html;charset=utf-8");


$case = $_GET['upload'];//判断导入的表格

switch ($case) {
    case "导入大仓库存":
    case "导入商场库存":
        require_once("./upload_lijin.php");
        break;
    case "导入新品信息":
        require_once("./upload_new_goods.php");
        break;
    case "导入每日销售":
        require_once("./upload_sales_day.php");
        break;
    case "导入库存销量":
        require_once("./upload_num_ds_ck_sales7.php");
        break;
    case "导入总销量":
        require_once("./upload_salse_volume_all.php");
        break;
    case "导入订单信息-E店宝":
        require_once("./upload_order_edb.php");
        break;
    case "导入订单_天猫":
        require_once("./upload_order_tm.php");
        break;
    case "导入订单商品_天猫":
        require_once("./upload_order_tm_goods.php");
        break;
    case "导入促销价_淘宝":
        require_once("./upload_price_ump_tb.php");
        break;
    case "导入促销价_天猫":
        require_once("./upload_price_ump_tm.php");
        break;
}