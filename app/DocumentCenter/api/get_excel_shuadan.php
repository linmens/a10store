<?php
/*简单实用Exec*/
require('../../config/class/PHPExcel_1.8.0_doc/Classes/PHPExcel/IOFactory.php');
require('../../config/class/PHPExcel_1.8.0_doc/Classes/PHPExcel.php');
require('../../config/config_mysql.php');



$ein = new ein_mysql();
$ein->e_mysql_connect();
$qs = "SELECT * FROM `tbapi_yibu_orders_shuadan`";
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
$obpe->getActiveSheet()->getColumnDimension('A')->setWidth(5);//设置列宽度
$obpe->getActiveSheet()->getColumnDimension('B')->setWidth(20);//设置列宽度
$obpe->getActiveSheet()->getColumnDimension('C')->setWidth(18);//设置列宽度
$obpe->getActiveSheet()->getColumnDimension('D')->setWidth(10);//设置列宽度
$obpe->getActiveSheet()->getColumnDimension('E')->setWidth(10);//设置列宽度
$obpe->getActiveSheet()->getColumnDimension('F')->setWidth(20);//设置列宽度
$obpe->getActiveSheet()->getColumnDimension('G')->setWidth(10);//设置列宽度
$obpe->getActiveSheet()->getColumnDimension('H')->setWidth(20);//设置列宽度
$obpe->getActiveSheet()->getColumnDimension('I')->setWidth(10);//设置列宽度


//设置C列为文本格式
//$obpe->getActiveSheet()->getStyle('C')->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_TEXT);


//设置SHEET，设置当前sheet索引,用于后续的内容操作，一般用在对个Sheet的时候才需要显示调用，缺省情况下,PHPExcel会自动创建第一个SHEET被设置SheetIndex=0
$obpe->setactivesheetindex(0);

$obpe->getActiveSheet()->setTitle('一号店价格表'); //设置工作表名称
// 设置默认字体和大小
$obpe->getDefaultStyle()->getFont()->setName('宋体');
//$obpe->getDefaultStyle()->getFont()->setName(iconv('gbk', 'utf-8', '宋体'));
$obpe->getDefaultStyle()->getFont()->setSize(10);

//设置标题
$obpe->getactivesheet()->setcellvalue('A1', "店铺");
$obpe->getactivesheet()->setcellvalue('B1', "买家ID");
$obpe->getactivesheet()->setcellvalue('C1', "订单号");
$obpe->getactivesheet()->setcellvalue('D1', "订单金额");
$obpe->getactivesheet()->setcellvalue('E1', "佣金金额");
$obpe->getactivesheet()->setcellvalue('F1', "购买时间");
$obpe->getactivesheet()->setcellvalue('G1', "订单状态");
$obpe->getactivesheet()->setcellvalue('H1', "运单号");
$obpe->getactivesheet()->setcellvalue('I1', "快递公司");


//写入多行数据
foreach ($data as $k => $v) {
    $k = $k + 2;
    /* @func 设置列 */
    $obpe->getactivesheet()->setcellvalue('A' . $k, $v['shop']);
    $obpe->getactivesheet()->setcellvalue('B' . $k, $v['buyer_nick']);
    $obpe->getactivesheet()->setCellValueExplicit('C'.$k, $v['order_id'], PHPExcel_Cell_DataType::TYPE_STRING);//设置输出为文本格式
    $obpe->getactivesheet()->setcellvalue('D' . $k, $v['order_money']);
    $obpe->getactivesheet()->setcellvalue('E' . $k, $v['order_yongjin']);
    $obpe->getactivesheet()->setcellvalue('F' . $k, $v['pay_time']);
    $obpe->getactivesheet()->setcellvalue('G' . $k, $v['state']);
    $obpe->getactivesheet()->setcellvalue('H' . $k, $v['wl_no']);
    $obpe->getactivesheet()->setCellValueExplicit('I'.$k, $v['wl_gs'], PHPExcel_Cell_DataType::TYPE_STRING);//设置输出为文本格式
}


$obwrite = PHPExcel_IOFactory::createWriter($obpe, 'Excel5');
header("Content-Disposition:attachment;filename=sd2.xls"); //attachment新窗口打印inline本窗口打印
$obwrite->save('php://output');
exit;
