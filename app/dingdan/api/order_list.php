<?php
require('tbapi_ein_class.php');
$ein = new ein_mysql();
$ein->e_mysql_connect();

$params = json_decode(file_get_contents('php://input'), true);


$LIMIT_START = ($params['currentPage'] - 1) * $params['itemsPerPage'];//从第几行开始
$LIMIT_ROWS = $params['itemsPerPage'];//每页显示多少行
$LIMIT = "LIMIT ".$LIMIT_START.', '.$LIMIT_ROWS;

$endTime = $params['endTime'];
if($endTime!=''){
    $endTime = "`time_xiadan` < '$endTime'";
}
$startTime = $params['startTime'];
if($startTime!=''){
    $startTime = "`time_xiadan` > '$startTime'";
}

if($endTime!='' && $startTime!=''){
    $where = "WHERE $startTime AND $endTime";
}

$params = json_decode(file_get_contents('php://input'), true);


//决定搜索条件 筛选条件
$filter_shop_name = $params['filter'][1];//店铺筛选

switch($filter_shop_name){
    case "所有订单":
        $filter_shop_name = '';
        break;
    case "天猫":
        $filter_shop_name = 'yb_tm';
        break;
    case "淘宝":
        $filter_shop_name = 'yb_tb';
        break;
    case "一号店":
        $filter_shop_name = 'yb_yhd';
        break;
}

if ($filter_shop_name != '') {
    if($where!=''){
        $where.=' AND ';
    }
    $where .= "`shop_name` = '$filter_shop_name'";
}

$filter_state_order_pingtai = $params['filter'][0];//订单状态筛选

switch($filter_state_order_pingtai){
    case "未付款":
    case "已付款":
    case "已发货":
    case "交易关闭":
    case "待退款全部退款":
        break;
    default:
        $filter_state_order_pingtai = '';
}

if ($filter_state_order_pingtai != '') {
    if($where!=''){
        $where.=' AND ';
    }
    $where .= "`state_order_pingtai` = '$filter_state_order_pingtai'";
}


$qs = "SELECT * FROM `tbapi_yibu_orders_info` $where ORDER BY `time_xiadan` DESC $LIMIT";
$data = $ein->e_mysql_search($qs);


$qs_get_goods_info_num = "SELECT count(`id`) FROM `tbapi_yibu_orders_info` $where ORDER BY `time_xiadan` DESC";

$result = '';


foreach($data as $v1){
    $order_id = $v1['order_id'];
    $shop_name = $v1['shop_name'];
    $buyer_zfb = $v1['buyer_zfb'];
    $buyer_phone = $v1['buyer_phone'];
    $buyer_nick = $v1['buyer_nick'];
    $time_xiadan = $v1['time_xiadan'];
//    $time_pay = $v1['time_pay'];
    $wl_gs = $v1['wl_gs'];
    $wl_no = $v1['wl_no'];
    $adress_name = $v1['adress_name'];
//    $adress_detail = $v1['adress_detail'];
    $state_order_pingtai = $v1['state_order_pingtai'];

    if($result != ''){
        $result .= ',';
    }
    $result .= '{"shop_name":"'. $shop_name .'",';
    $result .= '"buyer_zfb":"'. $buyer_zfb .'",';
    $result .= '"buyer_phone":"'. $buyer_phone .'",';
    $result .= '"buyer_nick":"'. $buyer_nick .'",';
    $result .= '"time_xiadan":"'. $time_xiadan .'",';
//    $result .= '"time_pay":"'. $time_pay .'",';
    $result .= '"wl_gs":"'. $wl_gs .'",';
    $result .= '"wl_no":"'. $wl_no .'",';
    $result .= '"adress_name":"'. $adress_name .'",';
//    $result .= '"adress_detail":"'. $adress_detail .'",';
    $result .= '"state_order_pingtai":"'. $state_order_pingtai .'",';
    $result .= '"order_id":"'. $order_id .'"}';
}


$qs_get_goods_info_num = $ein->e_mysql_search($qs_get_goods_info_num);
$qs_get_goods_info_num = $qs_get_goods_info_num[0]['count(`id`)'];

$totalPage = $qs_get_goods_info_num / $LIMIT_ROWS;
$totalPage = ceil($totalPage);


$data = '{"itemsPerPage":"'. $LIMIT_ROWS .'","total":"'. $qs_get_goods_info_num .'","totalPage":"'. $totalPage .'","list":[' . $result . ']}';

echo $data;
