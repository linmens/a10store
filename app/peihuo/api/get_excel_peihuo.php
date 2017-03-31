<?php

require_once("./class/PHPExcel_1.8.0_doc/Classes/PHPExcel.php");
require_once('./class/PHPExcel_1.8.0_doc/Classes/PHPExcel/IOFactory.php');
require('tbapi_ein_class.php');

$params = json_decode(file_get_contents('php://input'), true);
$where = '';

$ein = new ein_mysql();
$ein->e_mysql_connect();
$ein->e_html_set_header();


$filter_year = $params[0]['year'];
if ($filter_year != '') {
    if ($where != '') {
        $where .= ' AND ';
    }
    $where .= "`goods_year` = $filter_year";
}

$filter_season = $params[0]['season'];
if ($filter_season != '') {
    if ($where != '') {
        $where .= ' AND ';
    }
    $where .= "`goods_season` = '$filter_season'";
}


if ($where != '') {
    $where = ' WHERE ' . $where;
}


$sort_name = $params[0]['sortname'];//排序名
$sort = $params[0]['sort'];//排序方式


switch ($sort_name) {
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

$order_by = '';

if ($sort_name != '' && $sort != '') {
    $order_by = ' ORDER BY ';

    $order_by .= $sort_name;

    $order_by .= ' ' . $sort;
}


if ($order_by != '' || $where != '') {
    $qs = "SELECT * FROM `tbapi_yibu_goods_info_sku` $where $order_by";
    $qs_get_goods_info_num = "SELECT count(`id`) FROM `tbapi_yibu_goods_info_sku` $where";

} else {
    $qs = "SELECT * FROM `tbapi_yibu_goods_info_sku` ORDER BY `num_ds_ck`";
    $qs_get_goods_info_num = "SELECT count(`id`) FROM `tbapi_yibu_goods_info_sku` $where";
}


$data = $ein->e_mysql_search($qs);


//实例化
$obpe = new PHPExcel();

/* @func 设置文档基本属性 */
$obpe_pro = $obpe->getProperties();
$obpe_pro->setCreator('Ein')//设置创建者
->setLastModifiedBy('2017/1/20 15:00')//设置时间
->setTitle('data')//设置标题
->setSubject('beizhu')//设置备注
->setDescription('miaoshu')//设置描述
->setKeywords('keyword')//设置关键字 | 标记
->setCategory('catagory');//设置类别

/* 设置宽度 */
//$obpe->getActiveSheet()->getColumnDimension()->setAutoSize(true);
$obpe->getActiveSheet()->getColumnDimension('A')->setWidth(15);//设置列宽度
$obpe->getActiveSheet()->getColumnDimension('B')->setWidth(15);//设置列宽度
$obpe->getActiveSheet()->getColumnDimension('C')->setWidth(10);//设置列宽度
$obpe->getActiveSheet()->getColumnDimension('D')->setWidth(15);//设置列宽度
$obpe->getActiveSheet()->getColumnDimension('E')->setWidth(15);//设置列宽度


//$obpe->getActiveSheet()->getStyle('A')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);


//设置SHEET，设置当前sheet索引,用于后续的内容操作，一般用在对个Sheet的时候才需要显示调用，缺省情况下,PHPExcel会自动创建第一个SHEET被设置SheetIndex=0
$obpe->setactivesheetindex(0);

$obpe->getActiveSheet()->setTitle('Sheet1'); //设置工作表名称
// 设置默认字体和大小
$obpe->getDefaultStyle()->getFont()->setName('宋体');
//$obpe->getDefaultStyle()->getFont()->setName(iconv('gbk', 'utf-8', '宋体'));
$obpe->getDefaultStyle()->getFont()->setSize(10);

//设置标题
$obpe->getactivesheet()->setcellvalue('A1', "货号");
$obpe->getactivesheet()->setcellvalue('B1', "颜色编号");
$obpe->getactivesheet()->setcellvalue('C1', "内长");
$obpe->getactivesheet()->setcellvalue('D1', "尺码");
$obpe->getactivesheet()->setcellvalue('E1', "数量");

$k = 1;
//写入多行数据
foreach ($data as $v) {

    $num_gs_ck = $v['num_gs_ck'];//公司仓库库存数
    $num_ds_ck = $v['num_ds_ck'];//电商仓库库存数
    $sales_volume_7d = $v['sales_volume_7d'];//电商7日销量

    $sales_volume_7d = $sales_volume_7d * 2;

    
    if($sales_volume_7d<=3){
        //如果 销量小于库存保底数3件， 调货基数为3（补齐到3件）  。其他情况下，调货基数为  售卖件数(7天) * 2
        $sales_volume_7d = 3;
    }

    $num = $sales_volume_7d - $num_ds_ck;//所需库存 = 调货基数 - 剩余库存数(补齐到多少件)
    if($num>0 && $num_gs_ck>0){
        //所需库存 大于0 才输出到配货单

        if($num_gs_ck <=  $num){
            $peihuo_num = $num_gs_ck;
        }else{
            $peihuo_num = $num;
        }
        $k = $k + 1;
        /* @func 设置列 */
        $obpe->getactivesheet()->setcellvalue('A' . $k, $v['outer_id_gs']);
        $obpe->getActiveSheet()->setCellValueExplicit('B' . $k, $v['goods_color_no_gs'], PHPExcel_Cell_DataType::TYPE_STRING);
        $obpe->getactivesheet()->setcellvalue('C' . $k, "0");
        $obpe->getactivesheet()->setcellvalue('D' . $k, $v['goods_size_gs']);
        $obpe->getactivesheet()->setcellvalue('E' . $k, $peihuo_num);
    }
}


$obwrite = PHPExcel_IOFactory::createWriter($obpe, 'Excel5');
//header("Content-Disposition:attachment;filename=peihuo.xls"); //attachment新窗口打印inline本窗口打印
//$obwrite->save('php://output');//输出在客户端下载

$file_name = "peihuo.xls";

$save_path = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'down' . DIRECTORY_SEPARATOR . $file_name;//文件保存路径
$obwrite->save($save_path);//保存在后台服务器
$save_path = "http://www.a10store.com/TB_API/app/peihuo/api/down/" . $file_name;
echo '{"down_path":"' . $save_path . '"}';

exit;
