<?php
/**
 * Created by PhpStorm.
 * User: Ein
 * Date: 17/2/10
 * Time: 下午4:17
 */
require('../../config/config_mysql.php');
$ein = new ein_mysql();
$ein->e_mysql_connect();


$status = $_GET['status'];
$id = $_GET['id'];


if ($status != "" && $id != "") {

    switch ($status) {
        case "未确认";
            $state = "已确认";
            break;
        case "已确认";
            $state = "已结算";
            break;
        case "已结算";
            $state = "已完成";
            break;
    }

    $up_qs = "UPDATE `tbapi_yibu_orders_shuadan` SET `state` = '$state' WHERE `id` = $id AND `state` = '$status'";

    if (mysql_query($up_qs)) {
        $mes = "修改成功";
    } else {
        $mes = "修改失败";
    }
}

echo $mes;