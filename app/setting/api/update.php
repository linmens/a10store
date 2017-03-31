<?php
header("Content-Type:text/html;charset=utf-8");


$case = $_GET['check'];//判断导入的表格

if($case==''){
    $params = json_decode(file_get_contents('php://input'), true);
    $case = $params['check'];
}

switch ($case) {
    case "同步库存":
        require_once("./update_ds_ck_num.php");
        break;

    case "更新会员数据":
        require_once("./update_menber_info.php");
        break;
    case "更新sku信息":
        require_once("./update_sku_info.php");
        break;
}