<?php
require('../../config/config_mysql.php');

$ein = new ein_mysql();
$ein->e_mysql_connect();
$ein->e_html_set_header();

$id = $_GET['id'];

$up = "UPDATE `tbapi_yibu_orders_shuadan` SET `order_state` = '删除订单' WHERE `id` = $id";
if(mysql_query($up)){
    echo "删除成功";
}else{
    echo "删除失败";
}