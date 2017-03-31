<?php
require('tbapi_ein_class.php');
$ein = new ein_mysql();
$ein->e_mysql_connect();
$result = '';


$where = '';

$params = json_decode(file_get_contents('php://input'), true);

$LIMIT_START = ($params['postData']['currentPage'] - 1) * $params['postData']['itemsPerPage'];//从第几行开始
$LIMIT_ROWS = $params['postData']['itemsPerPage'];//每页显示多少行
$LIMIT = "LIMIT " . $LIMIT_START . ', ' . $LIMIT_ROWS;

$filter = $params['postData']['filter'][0];

$filter_season = $filter['season'];

if ($filter_season != '') {
    if ($where != '') {
        $where .= ' AND ';
    }
    $where .= "`goods_season` = '$filter_season'";
}

$filter_year = $filter['year'];
if ($filter_year != '') {
    if ($where != '') {
        $where .= ' AND ';
    }
    $where .= "`goods_year` = $filter_year";
}

if ($where != '') {
    $where = ' WHERE ' . $where;
}

$order_by = '';
$sort_name = $filter['sortname'];//排序名
$sort = $filter['sort'];//排序方式

switch($sort_name){
    case "货号":
        $sort_name = '`outer_id_gs`';
        break;
    case "电商仓库存":
        $sort_name = '`num_ds_ck`';
        break;
    case "大仓库存":
        $sort_name = '`num_gs_ck`';
        break;
    case "周销量":
        $sort_name = '`sales_volume_7d`';
        break;
    case "月销量":
        $sort_name = '`sales_volume_30d`';
        break;
}

switch ($sort) {
    case "down":
        $sort = "DESC";
        break;
    case "up":
        $sort = "ASC";
        break;
}



if ($sort_name != '' && $sort != '') {
    $order_by = ' ORDER BY ';

    $order_by .= $sort_name;

    $order_by .= ' ' . $sort;
}

if ($order_by != '' || $where != '') {
    $qs = "SELECT * FROM `tbapi_yibu_goods_info_sku` $where $order_by $LIMIT";
    $qs_get_goods_info_num = "SELECT count(`id`) FROM `tbapi_yibu_goods_info_sku` $where";

} else {
    $qs = "SELECT * FROM `tbapi_yibu_goods_info_sku` ORDER BY `num_ds_ck` $LIMIT";
    $qs_get_goods_info_num = "SELECT count(`id`) FROM `tbapi_yibu_goods_info_sku` $where";
}


//echo $qs;

$data = $ein->e_mysql_search($qs);


foreach ($data as $v1) {
    $outer_id_gs = $v1['outer_id_gs'];
    $goods_color_gs = $v1['goods_color_gs'];
    $goods_size_gs = $v1['goods_size_gs'];
    $num_ds_ck = $v1['num_ds_ck'];
    $num_gs_ck = $v1['num_gs_ck'];
    $sales_volume_7d = $v1['sales_volume_7d'];
    $sales_volume_30d = $v1['sales_volume_30d'];

    if ($result != '') {
        $result .= ',';
    }

    $result .= '{"outer_id_gs":"' . $outer_id_gs . '",';
    $result .= '"goods_color_gs":"' . $goods_color_gs . '",';
    $result .= '"goods_size_gs":"' . $goods_size_gs . '",';
    $result .= '"num_ds_ck":"' . $num_ds_ck . '",';
    $result .= '"num_gs_ck":"' . $num_gs_ck . '",';
    $result .= '"sales_volume_7d":"' . $sales_volume_7d . '",';
    $result .= '"sales_volume_30d":"' . $sales_volume_30d . '"}';
}

$qs_get_goods_info_num = $ein->e_mysql_search($qs_get_goods_info_num);
$qs_get_goods_info_num = $qs_get_goods_info_num[0]['count(`id`)'];

$totalPage = $qs_get_goods_info_num / $LIMIT_ROWS;
$totalPage = ceil($totalPage);


$data = '{"itemsPerPage":"' . $LIMIT_ROWS . '","total":"' . $qs_get_goods_info_num . '","totalPage":"' . $totalPage . '","list":[' . $result . ']}';
echo $data;