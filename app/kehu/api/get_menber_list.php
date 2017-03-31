<?php
require('tbapi_ein_class.php');
$ein = new ein_mysql();
$ein->e_mysql_connect();

$params = json_decode(file_get_contents('php://input'), true);

$LIMIT_START = ($params['currentPage'] - 1) * $params['itemsPerPage'];//从第几行开始
$LIMIT_ROWS = $params['itemsPerPage'];//每页显示多少行
$LIMIT = "LIMIT " . $LIMIT_START . ', ' . $LIMIT_ROWS;


$filter_sheng = $params['filter'][0];
$filter_shi = $params['filter'][1];

if ($filter_sheng != '省份' && $filter_shi != '市县') {
    $where = "WHERE `adress_sheng` = '$filter_sheng' AND `adress_shi` = '$filter_shi'";
}

if ($where != '') {
    $qs = "SELECT * FROM `tbapi_yibu_menber_info` $where $LIMIT";
    $qs_get_goods_info_num = "SELECT count(`id`) FROM `tbapi_yibu_menber_info` $where";

} else {
    $qs = "SELECT * FROM `tbapi_yibu_menber_info` $LIMIT";
    $qs_get_goods_info_num = "SELECT count(`id`) FROM `tbapi_yibu_menber_info`";
}


$data = $ein->e_mysql_search($qs);
$result = '';

foreach ($data as $v1) {
    $buyer_nick = $v1['buyer_nick'];
    $buyer_phone = $v1['buyer_phone'];
    $adress_sheng = $v1['adress_sheng'];
    $adress_shi = $v1['adress_shi'];
    $state_shuashou = $v1['state_shuashou'];
    if($state_shuashou=="是"){
        $state_shuashou = '刷手';
    }else{
        $state_shuashou = '';
    }
    if ($result != '') {
        $result .= ',';
    }
    $result .= '{"buyer_nick":"' . $buyer_nick . '","buyer_phone":"' . $buyer_phone . '","adress_sheng":"' . $adress_sheng . '","adress_shi":"' . $adress_shi . '","state_shuashou":"' . $state_shuashou . '"}';
}

$qs_get_goods_info_num = $ein->e_mysql_search($qs_get_goods_info_num);
$qs_get_goods_info_num = $qs_get_goods_info_num[0]['count(`id`)'];

$totalPage = $qs_get_goods_info_num / $LIMIT_ROWS;
$totalPage = ceil($totalPage);


$data = '{"itemsPerPage":"' . $LIMIT_ROWS . '","total":"' . $qs_get_goods_info_num . '","totalPage":"' . $totalPage . '","list":[' . $result . ']}';


echo $data;
