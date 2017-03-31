<?php
header("Content-type: text/html; charset=utf-8");
$params = json_decode(file_get_contents('php://input'), true);

$states = $params['status'];//选择 报销状态

$menu = $params['menu'];//选择 支出项目

$shop = $params['shop'];//选择 申请店铺

$username_level = $_COOKIE['username_level'];//用户权限


if ($username_level >= 3) {

    require('../../config/config_mysql.php');

    $ein = new ein_mysql();
    $ein->e_mysql_connect();//链接数据库

    $where = '';//筛选条件

    if ($menu != '') {
        switch ($menu) {
            case "所有":
                $class = "`class` != ''";
                break;
            case "刷单":
                $class = "`class` = '刷单'";
                break;
            case "闪购费":
                $class = "`class` = '闪购费'";
                break;
            case "拍照费":
                $class = "`class` = '拍照费'";
                break;
            case "直通车费用":
                $class = "`class` = '直通车费用'";
                break;
            case "软件费":
                $class = "`class` = '软件费'";
                break;
            case "短信费":
                $class = "`class` = '短信费'";
                break;
        }
        if ($where != '') {
            $where .= ' AND ';
        }
        $where .= $class;

    }

    if ($states != '') {
        switch ($states) {
            case "不限":
                $states = "`state` != ''";
                break;
            case "未打款":
                $states = "`state` = '未打款'";
                break;
            case "已打款":
                $states = "`state` = '已打款'";
                break;
            case "已报销":
                $states = "`state` = '已报销'";
                break;
        }
        if ($where != '') {
            $where .= ' AND ';
        }
        $where .= $states;
    }


    if ($shop != '') {
        switch ($shop) {
            case "天猫":
                $shop = "`shop` = '天猫'";
                break;
            case "淘宝":
                $shop = "`shop` = '淘宝'";
                break;
            case "一号店":
                $shop = "`shop` = '一号店'";
                break;
        }
        if ($where != '') {
            $where .= ' AND ';
        }
        $where .= $shop;
    }


    $where = "WHERE " . $where;


    $qs = "SELECT * FROM `tbapi_yibu_expense_list` $where ORDER BY `up_time` DESC";


    $data = $ein->e_mysql_search($qs);
    foreach ($data as $val) {
        $shop = $val['brand'] . $val['shop'];
        if ($return_data != "") {
            $return_data .= ",";
        }
        $return_data .= '{"id":"' . $val['id'] . '",';//编号
        $return_data .= '"shop":"' . $shop . '",';//店铺
        $return_data .= '"class":"' . $val['class'] . '",';//项目
        $return_data .= '"class_detail":"' . $val['class_detail'] . '",';//项目明细
        $return_data .= '"all_price":"' . $val['all_price'] . '",';//总金额
        $return_data .= '"state":"' . $val['state'] . '",';//报销状态
        $return_data .= '"user":"' . $val['user_ins'] . '",';//报销人
        $return_data .= '"up_time":"' . $val['up_time'] . '",';//申请时间
        $return_data .= '"img_src":"' . $val['img_src'] . '"}';//留底图片
    }
    echo '[' . $return_data . ']';
}