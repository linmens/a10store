<?php
require('../../config/config_mysql.php');

$ein = new ein_mysql();//实例化类
$ein->e_html_set_header();//设置header-utf_8
$ein->e_mysql_connect();//链接数据库

$params = json_decode(file_get_contents('php://input'), true);
$filter = $params['filter'][0];

$LIMIT_START = ($params['currentPage'] - 1) * $params['itemsPerPage'];//从第几行开始
$LIMIT_ROWS = $params['itemsPerPage'];//每页显示多少行

$LIMIT = "LIMIT ".$LIMIT_START.', '.$LIMIT_ROWS;

$filter_year = $filter['year'];//筛选年份
$filter_status = $filter['status'];//商品状态
$filter_season = $filter['season'];//商品季节
$filter_color = $filter['color'];//商品是否多色
$filter_paishe = $filter['paishe'];//商品拍摄状态
$sortName = $filter['sortName'];//排序项目
$sort = $filter['sort'];//排序方式



$search = $params['search'];//搜索关键词


//决定搜索条件 筛选条件
$where = '';

if ($filter_year != '') {
    if($where!=''){
        $where.=' AND ';
    }
    $where .= "`goods_year` = '$filter_year'";
}


if($filter_status != ''){
    if($where!=''){
        $where.=' AND ';
    }
    if($filter_status=="正常"){
        $where .= "`num_ds_state` = ''";
    }
    if($filter_status=="缺货"){
        $where .= "`num_ds_state` = '缺货'";
    }
    if($filter_status=="售空"){
        $where .= "`num_ds_ck` = 0";
    }
}

if($filter_paishe != ''){
    if($where!=''){
        $where.=' AND ';
    }
    if($filter_paishe=="未拍摄"){
        $where .= "`paishe_state` = '未拍摄'";
    }
    if($filter_paishe=="已拍摄"){
        $where .= "`paishe_state` = '已拍摄'";
    }
}

if($filter_season != ''){
    if($where!=''){
        $where.=' AND ';
    }
    $where .= "`goods_season` = '$filter_season'";
}

if($filter_color != ''){
    if($where!=''){
        $where.=' AND ';
    }
    $where .= "`goods_state_color_num` > 1";
}

$f_search = " `outer_id_gs` LIKE '%$search%' OR `outer_id_ds` LIKE '%$search%' OR `goods_class_gs` LIKE '%$search%' OR `goods_color_gs` LIKE '%$search%'";

if($search!=''){
    if($where!=''){
        $where.=' AND ';
    }
    $where .=$f_search;
}
if($where!=''){
    $where = ' WHERE '.$where;
}


//决定排序方式
if ($sortName != '' || $sort != '') {
    $order_by = "ORDER BY ";
    switch($sortName){
        case "总销量":
            $sort_what = 'sales_volume_all';
            break;
        case "30天销量":
            $sort_what = 'sales_volume_30d';
            break;
        case "7天销量":
            $sort_what = 'sales_volume_7d';
            break;
        case "库存":
            $sort_what = 'num_ds_ck';
            break;
        case "促销价":
            $sort_what = 'goods_price_ump_tm';
            break;
        case "吊牌价":
            $sort_what = 'price_gs';
            break;
        case "上架时间":
            $sort_what = 'time_goods_onlist';
            break;
        case "商品分类":
            $sort_what = 'goods_class_gs';
            break;
    }
    switch($sort){
        case "down":
            $sort = 'DESC';
            break;
        case "up":
            $sort = 'ASC';
            break;
    }
    $order_by .= "`$sort_what` ";
    $order_by .= "$sort";

} else {
    $order_by = "ORDER BY `sales_volume_7d` DESC";
}

//搜索语句
if ($where != '' || $sortName != '') {
    $qs_get_goods_info = "SELECT * FROM `tbapi_yibu_goods_info` $where $order_by $LIMIT";
    $qs_get_goods_info_num = "SELECT count(`id`) FROM `tbapi_yibu_goods_info` $where $order_by";
} else {
    $qs_get_goods_info = "SELECT * FROM `tbapi_yibu_goods_info` ORDER BY `sales_volume_7d` DESC $LIMIT";
    $qs_get_goods_info_num = "SELECT count(`id`) FROM `tbapi_yibu_goods_info`";
}
//echo $qs_get_goods_info;

$goods_data = $ein->e_mysql_search($qs_get_goods_info);

$all_goods = "";
foreach ($goods_data as $v) {
    if ($all_goods != '') {
        $all_goods .= ",";
    }
    $outer_id_gs = $v['outer_id_gs'];
    $outer_id_ds = $v['outer_id_ds'];
    $goods_class_gs = $v['goods_class_gs'];
    $goods_color_gs = $v['goods_color_gs'];
    $price_gs = $v['price_gs'];
    $num_gs_shop = $v['num_gs_shop'];
    $num_gs_ck = $v['num_gs_ck'];
    $num_ds_ck = $v['num_ds_ck'];
    $goods_year = $v['goods_year'];
    $goods_season = $v['goods_season'];
    $pic_url = $v['pic_url'];
    $num_iid_tm = $v['num_iid_tm'];
    $num_iid_tb = $v['num_iid_tb'];
    $num_ds_state = $v['num_ds_state'];
    $num_iid_yhd = $v['num_iid_yhd'];
    $sales_7d_tm = $v['sales_7d_tm'];
    $sales_30d_tm = $v['sales_30d_tm'];
    $sales_volume_7d_tm = $v['sales_volume_7d_tm'];
    $sales_volume_7d = $v['sales_volume_7d'];//电商7天总销量
    $sales_volume_30d = $v['sales_volume_30d'];//电商30天总销量
    $sales_volume_all = $v['sales_volume_all'];//电商总销量
    $goods_price_ump_tm = $v['goods_price_ump_tm'];
    $goods_price_ump_tb = $v['goods_price_ump_tb'];
    $goods_price_ump_yhd = $v['goods_price_ump_yhd'];
    $goods_state_color_num = $v['goods_state_color_num'];
    $state_onsale_tb = $v['state_onsale_tb'];
    $state_onsale_tm = $v['state_onsale_tm'];
    switch($state_onsale_tb){
        case "Y":
            $state_onsale_tb = "出售中";
            break;
        case "N":
            $state_onsale_tb = "仓库中";
            break;
    }
    switch($state_onsale_tm){
        case "Y":
            $state_onsale_tm = "出售中";
            break;
        case "N":
            $state_onsale_tm = "仓库中";
            break;
    }
    $time_goods_onlist = $v['time_goods_onlist'];

    //动销率 = 总销量 / (总销量+剩余库存)
    $dongxiaolv = ($sales_volume_all / ($sales_volume_all + $num_ds_ck)) * 100;
    $dongxiaolv = round($dongxiaolv,2);

    //库存周转时间 = 剩余库存 /（7天 销售量 / 7天销售时间）
    $zhouzhuan_time = $num_ds_ck / ($sales_volume_7d / 7);
    $zhouzhuan_time = round($zhouzhuan_time,1);



    if ($goods_state_color_num < 1) {
        $goods_state_color_num = "单色";
    } else {
        $goods_state_color_num = "多色";
    }


    $all_goods .= '{"outer_id_gs":"' . $outer_id_gs . '",';
    $all_goods .= '"outer_id_ds":"' . $outer_id_ds . '",';
    $all_goods .= '"goods_class_gs":"' . $goods_class_gs . '",';
    $all_goods .= '"goods_color_gs":"' . $goods_color_gs . '",';
    $all_goods .= '"price_gs":"' . $price_gs . '",';
    $all_goods .= '"num_gs_shop":"' . $num_gs_shop . '",';
    $all_goods .= '"num_gs_ck":"' . $num_gs_ck . '",';
    $all_goods .= '"num_ds_ck":"' . $num_ds_ck . '",';
    $all_goods .= '"goods_year":"' . $goods_year . '",';
    $all_goods .= '"goods_season":"' . $goods_season . '",';
    $all_goods .= '"pic_url":"' . $pic_url . '",';
    $all_goods .= '"num_iid_tm":"' . $num_iid_tm . '",';
    $all_goods .= '"num_iid_tb":"' . $num_iid_tb . '",';
    $all_goods .= '"num_iid_yhd":"' . $num_iid_yhd . '",';
    $all_goods .= '"sales_7d_tm":"' . $sales_7d_tm . '",';
    $all_goods .= '"sales_30d_tm":"' . $sales_30d_tm . '",';
    $all_goods .= '"sales_volume_7d_tm":"' . $sales_volume_7d_tm . '",';
    $all_goods .= '"sales_volume_7d":"' . $sales_volume_7d . '",';
    $all_goods .= '"sales_volume_30d":"' . $sales_volume_30d . '",';
    $all_goods .= '"sales_volume_all":"' . $sales_volume_all . '",';
    $all_goods .= '"state_quehuo":"' . $num_ds_state . '",';
    $all_goods .= '"goods_price_ump_tm":"' . $goods_price_ump_tm . '",';
    $all_goods .= '"goods_price_ump_tb":"' . $goods_price_ump_tb . '",';
    $all_goods .= '"goods_price_ump_yhd":"' . $goods_price_ump_yhd . '",';
    $all_goods .= '"goods_state_color_num":"' . $goods_state_color_num . '",';
    $all_goods .= '"state_onsale_tb":"' . $state_onsale_tb . '",';
    $all_goods .= '"state_onsale_tm":"' . $state_onsale_tm . '",';
    $all_goods .= '"dongxiaolv":"' . $dongxiaolv . '%",';
    $all_goods .= '"zhouzhuan_time":"' . $zhouzhuan_time . '天",';
    $all_goods .= '"time_goods_onlist":"' . $time_goods_onlist . '"}';

    $num_ds_state = '';//还原缺货状态
}

$qs_get_goods_info_num = $ein->e_mysql_search($qs_get_goods_info_num);
$qs_get_goods_info_num = $qs_get_goods_info_num[0]['count(`id`)'];

$totalPage = $qs_get_goods_info_num / $LIMIT_ROWS;
$totalPage = ceil($totalPage);

$data = '{"itemsPerPage":"'. $LIMIT_ROWS .'","total":"'. $qs_get_goods_info_num .'","totalPage":"'. $totalPage .'","list":[' . $all_goods . ']}';
echo $data;