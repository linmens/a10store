<?php

require('../../config/class/PHPExcel_1.8.0_doc/Classes/PHPExcel/IOFactory.php');
require('../../config/class/PHPExcel_1.8.0_doc/Classes/PHPExcel.php');
require('../../config/config_mysql.php');



$ein = new ein_mysql();
$ein->e_mysql_connect();
$qs = "SELECT * FROM `tbapi_yibu_goods_info` WHERE `num_iid_yhd` != '' AND `num_ds_ck` > 7 AND `goods_year` <= 2015";
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
$obpe->getActiveSheet()->getColumnDimension('F')->setWidth(15);//设置列宽度
$obpe->getActiveSheet()->getColumnDimension('G')->setWidth(65);//设置列宽度
$obpe->getActiveSheet()->getColumnDimension('H')->setWidth(15);//设置列宽度
$obpe->getActiveSheet()->getColumnDimension('I')->setWidth(15);//设置列宽度
$obpe->getActiveSheet()->getColumnDimension('I')->setWidth(5);//设置列宽度
$obpe->getActiveSheet()->getColumnDimension('K')->setWidth(6);//设置列宽度
$obpe->getActiveSheet()->getColumnDimension('L')->setWidth(37);//设置列宽度


//$obpe->getActiveSheet()->getStyle('A')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);


//设置SHEET，设置当前sheet索引,用于后续的内容操作，一般用在对个Sheet的时候才需要显示调用，缺省情况下,PHPExcel会自动创建第一个SHEET被设置SheetIndex=0
$obpe->setactivesheetindex(0);

$obpe->getActiveSheet()->setTitle('一号店价格表'); //设置工作表名称
// 设置默认字体和大小
$obpe->getDefaultStyle()->getFont()->setName('宋体');
//$obpe->getDefaultStyle()->getFont()->setName(iconv('gbk', 'utf-8', '宋体'));
$obpe->getDefaultStyle()->getFont()->setSize(10);

//设置标题
$obpe->getactivesheet()->setcellvalue('A1', "商品编码");
$obpe->getactivesheet()->setcellvalue('B1', "子品编码");
$obpe->getactivesheet()->setcellvalue('C1', "闪购报名价");
$obpe->getactivesheet()->setcellvalue('D1', "报名库存");
$obpe->getactivesheet()->setcellvalue('E1', "顾客最多购买");
$obpe->getactivesheet()->setcellvalue('F1', "顾客最小购买");
$obpe->getactivesheet()->setcellvalue('G1', "特卖标题");
$obpe->getactivesheet()->setcellvalue('H1', "主图URL");
$obpe->getactivesheet()->setcellvalue('I1', "副图URL");
$obpe->getactivesheet()->setcellvalue('J1', "顺位");
$obpe->getactivesheet()->setcellvalue('K1', "备注");
$obpe->getactivesheet()->setcellvalue('L1', "1号店商品链接");
$obpe->getactivesheet()->setcellvalue('M1', "天猫店商品链接");
$obpe->getactivesheet()->setcellvalue('N1', "是否秒杀");


//写入多行数据
foreach ($data as $k => $v) {
    $k = $k + 2;
    /* @func 设置列 */
    $obpe->getActiveSheet()->setCellValueExplicit('A' . $k, $v['num_iid_yhd'], PHPExcel_Cell_DataType::TYPE_STRING);
    $obpe->getactivesheet()->setcellvalue('B' . $k, "");
    switch ($v['goods_year']) {
        case 2015:
            if ($v['goods_season'] == "春装") {
                $goods_price_ump_yhd = "49";
            }else{
                $goods_price_ump_yhd = ($v['price_gs'] * 0.13)/10;
                $goods_price_ump_yhd = round($goods_price_ump_yhd,0);
                $goods_price_ump_yhd = ($goods_price_ump_yhd * 10) - 2;
            }
            break;
        case 2014:
            $goods_price_ump_yhd = "39";
            break;
        case 2013:
        case 2012:
        case 2011:
            $goods_price_ump_yhd = "29";
            break;

    }
    $obpe->getactivesheet()->setcellvalue('C' . $k, $goods_price_ump_yhd);
    $obpe->getactivesheet()->setcellvalue('D' . $k, $v['num_ds_ck']);
    $obpe->getactivesheet()->setcellvalue('E' . $k, "");
    $obpe->getactivesheet()->setcellvalue('F' . $k, "");
    $obpe->getactivesheet()->setcellvalue('G' . $k, $v['goods_title_yhd']);
    $obpe->getactivesheet()->setcellvalue('H' . $k, "");
    $obpe->getactivesheet()->setcellvalue('I' . $k, "");
    $obpe->getactivesheet()->setcellvalue('J' . $k, $k - 1);
    $obpe->getactivesheet()->setcellvalue('K' . $k, "免邮");
    $obpe->getactivesheet()->setcellvalue('L' . $k, $v['goods_url_yhd']);
    $obpe->getactivesheet()->setcellvalue('M' . $k, "");
    $obpe->getactivesheet()->setcellvalue('N' . $k, "");
    $obpe->getactivesheet()->setcellvalue('O' . $k, "");
}


$obwrite = PHPExcel_IOFactory::createWriter($obpe, 'Excel5');
header("Content-Disposition:attachment;filename=sg.xls"); //attachment新窗口打印inline本窗口打印
$obwrite->save('php://output');
exit;
