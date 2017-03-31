<?php

/**
 * Created by PhpStorm.
 * User: Ein
 * Date: 16/11/25
 * Time: 下午3:54
 */
/*定义数据库各数据表通用变量开始*/
define("EIN_SQL_SERVER_IP","mysql.sql134.eznowdata.com");//数据库 IP地址
define("EIN_SQL_SERVER_USERNAME","sq_a10store");//数据库用户名
define("EIN_SQL_SERVER_PASSWORD","lcxlcx299");//数据库密码

define("EIN_SQL_SHEET_GOODS","tbapi_yibu_goods");//数据库商品表 表名
/*定义数据库各数据表通用变量结束*/


class ein_mysql
{
    /*通用方法  开始*************/
    function e_mysql_connect()
    {
        /*连接数据库方法*/
        //已优化
        $con = mysql_connect(EIN_SQL_SERVER_IP, EIN_SQL_SERVER_USERNAME, EIN_SQL_SERVER_PASSWORD);
        mysql_select_db("sq_a10store", $con);
        mysql_query('set names utf8');
    }


    function e_html_set_header()
    {
        header("Content-type: text/html; charset=utf-8");
    }

    function e_mysql_search($serch_qs)
    {
        /*搜索数据库方法,返回搜索结果数组*/
        $result = mysql_query($serch_qs);//执行语句
        $result_arr = array();
        while ($row = mysql_fetch_assoc($result)) {
            $result_arr[] = $row;
        }
        return $result_arr;//返回数组
    }

    function tbapi_get_token()
    {
        /*更新授权*/
        $serch_qs = "SELECT * FROM `tbapi_yibu_info` WHERE `item` = 'access_token' LIMIT 1";
        $result_arr = $this->e_mysql_search($serch_qs);//执行 搜索用户是否存在 语句
        $sessionKey = $result_arr[0]['content'];
        return $sessionKey;
    }

    function tbapi_trades_sold_get($sessionKey, $Created_time_start,$setStatus)
    {
        /*获取已售出订单方法*/


        $return_time = "";
        //获取商品数据
        $c = new TopClient;
        $c->appkey = '23498274';  //填写你自己的APPKEY
        $c->secretKey = 'a27e9bc72b81457399e0afb615573ce7';  //填写你自己的secretKey
        $req = new TradesSoldGetRequest;
        $req->setFields("seller_nick,buyer_nick,title,type,created,sid,tid,seller_rate,buyer_rate,status,payment,discount_fee,adjust_fee,post_fee,total_fee,pay_time,end_time,modified,consign_time,buyer_obtain_point_fee,point_fee,real_point_fee,received_payment,commission_fee,pic_path,num_iid,num_iid,num,price,cod_fee,cod_status,shipping_type,receiver_name,receiver_state,receiver_city,receiver_district,receiver_address,receiver_zip,receiver_mobile,receiver_phone,orders.title,orders.pic_path,orders.price,orders.num,orders.iid,orders.num_iid,orders.sku_id,orders.refund_status,orders.status,orders.oid,orders.total_fee,orders.payment,orders.discount_fee,orders.adjust_fee,orders.sku_properties_name,orders.item_meal_name,orders.buyer_rate,orders.seller_rate,orders.outer_iid,orders.outer_sku_id,orders.refund_id,orders.seller_type");
        $req->setStatus("$setStatus");
        $req->setEndCreated("$Created_time_start");
        $req->setType("fixed");
        $req->setPageSize("100");
        $resp = $c->execute($req, $sessionKey);
        $resp_arr = json_encode($resp);
        $resp_arr = json_decode($resp_arr, true);
        $trades = $resp_arr['trades']['trade'];
        foreach ($trades as $val) {
            $tid = $val['tid'];
            $buyer_nick = $val['buyer_nick'];//用户昵称
            $received_payment = $val['received_payment'];
            $created = $val['created'];
            $return_time = $created;
            $pay_time = $val['pay_time'];
            $consign_time = $val['consign_time'];
            $end_time = $val['end_time'];
            $sonid = $tid;

            //查询数据库中是否有该订单
            $serch_is = "SELECT * FROM `tbapi_yibu_orders` WHERE `tid` = '$tid' LIMIT 1";
            $result_is = mysql_query($serch_is);//执行 搜索商品是否存在 语句
            $result_arr_is = array();
            while ($row_is = mysql_fetch_assoc($result_is)) {
                $result_arr_is[] = $row_is;
            }
            $tid_is = $result_arr_is[0]['tid'];

            //更新成交买家到 会员列表
            $serch_user = "SELECT * FROM `tbapi_yibu_users` WHERE `buyer_nick` = '$buyer_nick' LIMIT 1";
            $user_result = mysql_query($serch_user);
            $result_arr_user = array();
            while ($row_user = mysql_fetch_assoc($user_result)) {
                $result_arr_user[] = $row_user;
            }
            $user_is = $result_arr_user[0]['buyer_nick'];
            if ($user_is == "") {
                //如果用户不存在就 插入新的用户
                $ins_user = "INSERT INTO `tbapi_yibu_users` (`buyer_nick`) VALUES ('$buyer_nick')";
                mysql_query($ins_user);
            }
            //判断父订单是否存在，并选择 插入 或者 更新订单数据
            if ($tid_is == "") {
                //如果 订单不存在 就 插入新订单
                $ins = "INSERT INTO `tbapi_yibu_orders` (`tid`, `sonid`, `buyer_nick`, `received_payment`, `created`, `pay_time`, `consign_time`, `end_time`,`status`) VALUES ('$tid', '$sonid', '$buyer_nick', '$received_payment', '$created', '$pay_time', '$consign_time', '$end_time', '$setStatus')";
                mysql_query($ins);
            } else {
                //如果 订单存在， 就开始执行更新数据 程序
                $upd = "UPDATE `tbapi_yibu_orders` SET `received_payment` = '$received_payment', `created` = '$created', `pay_time` = '$pay_time', `consign_time` = '$consign_time', `end_time` = '$end_time' , `status` = '$setStatus' WHERE `sonid` = $tid";
                mysql_query($upd);
            }
            $num_all = 0;//父订单 购买商品总件数
            $order = $val['orders']['order'];

            //判断 订单中商品的数量 选择不同程序处理
            if ($order[0] == "") {
                //若订单中商品为单件，进入本程序
                $sonid = $tid . $order['sku_id'];//子订单id
                $received_payment = $order['payment'];//商品实际支付金额
                $num = $order['num'];
                $num_all = $num + $num_all;
                $num_iid = $order['num_iid'];
                $sku_id = $order['sku_id'];

                //更新商品库中对应商品的促销价格

                $ump_price = $order['total_fee'];//商品促销价格
                $update_ump_price = "UPDATE `tbapi_yibu_goods` SET `ump_price` = '$ump_price' WHERE `tmall_shop_num_iid` = '$num_iid'";
                mysql_query($update_ump_price);

                $sku_properties_name = $order['sku_properties_name'];
                $sku_inf = explode(";", $sku_properties_name);
                $sku_inf_color = explode(":", $sku_inf[0]);
                $sku_color = $sku_inf_color[1];
                $sku_inf_size = explode(":", $sku_inf[1]);
                $sku_size = $sku_inf_size[1];
                $sku_sql = "UPDATE `tbapi_yibu_goods` SET  `sku_color` =  '$sku_color', `sku_size` = '$sku_size', `ump_price` = '$ump_price' WHERE `sku_id` = '$sku_id'";
                mysql_query($sku_sql);
                //查询数据库中是否有该订单
                $serch_sonid = "SELECT * FROM `tbapi_yibu_orders` WHERE `sonid` = '$sonid' LIMIT 1";
                $result_sonid = mysql_query($serch_sonid);//执行 搜索商品是否存在 语句
                $result_arr_sonid = array();
                while ($row_sonid = mysql_fetch_assoc($result_sonid)) {
                    $result_arr_sonid[] = $row_sonid;
                }
                $sonid_sql = $result_arr_sonid[0]['sonid'];
                if ($sonid_sql == "") {
                    $ins_goods = "INSERT INTO `tbapi_yibu_orders` (`tid`, `sonid`, `buyer_nick`, `num`, `num_iid`, `sku_id`,`status`) VALUES ('$tid', '$sonid', '$buyer_nick', '$num', '$num_iid', '$sku_id','$setStatus')";
                    mysql_query($ins_goods);

                } else {
                    $upd_sonid = "UPDATE `tbapi_yibu_orders` SET `statsu` = '$setStatus', `received_payment` = '$received_payment', `num` = '$num', `num_iid` = '$num_iid', `sku_id` = '$sku_id', `created` = '$created', `pay_time` = '$pay_time', `consign_time` = '$consign_time', `end_time` = '$end_time' WHERE `sonid` = $sonid";
                    mysql_query($upd_sonid);
                }
            } else {
                //若订单中商品为多件，进入本程序
                foreach ($order as $mororder) {
                    $sonid = $tid . $mororder['sku_id'];//子订单id
                    $payment = $mororder['payment'];//商品实际支付金额
                    $num = $mororder['num'];
                    $num_all = $num + $num_all;
                    $num_iid = $mororder['num_iid'];


                    //更新商品库中对应商品的促销价格
                    $ump_price = $mororder['total_fee'];//商品促销价格
                    $update_ump_price = "UPDATE `tbapi_yibu_goods` SET `ump_price` = '$ump_price' WHERE `tmall_shop_num_iid` = '$num_iid'";
                    mysql_query($update_ump_price);

                    $sku_id = $mororder['sku_id'];
                    $sku_properties_name = $mororder['sku_properties_name'];
                    $sku_inf = explode(";", $sku_properties_name);
                    $sku_inf_color = explode(":", $sku_inf[0]);
                    $sku_color = $sku_inf_color[1];
                    $sku_inf_size = explode(":", $sku_inf[1]);
                    $sku_size = $sku_inf_size[1];
                    $sku_sql = "UPDATE `tbapi_yibu_goods` SET  `sku_color` =  '$sku_color', `sku_size` = '$sku_size' WHERE `sku_id` = '$sku_id'";
                    mysql_query($sku_sql);
                    //查询数据库中是否有该订单
                    $serch_sonid = "SELECT * FROM `tbapi_yibu_orders` WHERE `sonid` = '$sonid' LIMIT 1";
                    $result_sonid = mysql_query($serch_sonid);//执行 搜索商品是否存在 语句
                    $result_arr_sonid = array();
                    while ($row_sonid = mysql_fetch_assoc($result_sonid)) {
                        $result_arr_sonid[] = $row_sonid;
                    }
                    $sonid_sql = $result_arr_sonid[0]['sonid'];
                    if ($sonid_sql == "") {
                        $ins_goods = "INSERT INTO `tbapi_yibu_orders` (`tid`, `sonid`, `buyer_nick`, `num`, `num_iid`, `sku_id`, `status`) VALUES ('$tid', '$sonid', '$buyer_nick', '$num', '$num_iid', '$sku_id', '$setStatus')";
                        mysql_query($ins_goods);
                    } else {
                        $upd_sonid = "UPDATE `tbapi_yibu_orders` SET `status` = '$setStatus', `received_payment` = '$payment', `num` = '$num', `num_iid` = '$num_iid', `sku_id` = '$sku_id', `created` = '$created', `pay_time` = '$pay_time', `consign_time` = '$consign_time', `end_time` = '$end_time' WHERE `sonid` = '$sonid'";
                        mysql_query($upd_sonid);
                    }
                }
            }
            //更新父订单商品总件数;
            $upd_all_num = "UPDATE `tbapi_yibu_orders` SET `num` = '$num_all' WHERE `sonid` = $tid";
            mysql_query($upd_all_num);
        }
        return $return_time;
    }

    function tbapi_build_goods_json($serch_qs)
    {
        /*生成商品数据*/

        //获取商品总数
        $serch_goods_qs = "SELECT id FROM `tbapi_yibu_goods` WHERE `tmall_shop_num_iid` = `sku_id` ORDER BY `age` DESC";
        $serch_goods_num = mysql_query($serch_goods_qs);
        $goods_num = mysql_num_rows($serch_goods_num);//商品总数

        //获取缺货商品总数
        $serch_quehuo_qs = "SELECT id FROM `tbapi_yibu_goods` WHERE `sis_status` = '缺货' AND `tmall_shop_num_iid` = `sku_id` ORDER BY `age` DESC";
        $serch_quehuo_num = mysql_query($serch_quehuo_qs);
        $quehuo_num = mysql_num_rows($serch_quehuo_num);//商品总数


        $result = mysql_query($serch_qs);
        $result_arr = array();
        while ($row = mysql_fetch_assoc($result)) {
            $result_arr[] = $row;
        }
        $all_goods = "";
        $num = 0;//商品总库存
        $sku_num = 0;//sku总数


        foreach ($result_arr as $val_1) {
            $sku_num = $sku_num + 1;


            if ($val_1['tmall_shop_num_iid'] === $val_1['sku_id']) {//子id 和 商品 id 相等才是主商品
                if ($val_1['num'] != 0) {
                    $sku_num = $sku_num - 1;
                    $seller_cids = $val_1['seller_cids'];
                    $searr = explode(",", $seller_cids);
                    $seller_cids_cn = array();//商品分类id
                    foreach ($searr as $value_kind) {
                        if ($value_kind != "") {//如果分类id不为空
                            //查询商品分类数据库中是否已有该商品分类
                            $serch_seller_cids = "SELECT * FROM `tbapi_yibu_kinds` WHERE `seller_cids` = '$value_kind' LIMIT 1";
                            $result1 = mysql_query($serch_seller_cids);//执行 搜索商品是否存在 语句
                            $result_arr1 = array();

                            while ($row1 = mysql_fetch_assoc($result1)) {
                                $result_arr1[] = $row1;
                            }
                            if ($result_arr1[0]['seller_cids'] == "") {//若分类中无 就新建
                                $inss = "INSERT INTO `tbapi_yibu_kinds` (`seller_cids` ,`seller_cids_cn`)VALUES ('$value_kind',  '空')";
                                mysql_query($inss);
                            } else {
                                $seller_cids_cn[] = $result_arr1[0]['seller_cids_cn'];
                            }
                        }
                    }
                    if ($all_goods != "") {
                        $all_goods .= ",";
                    }
                    $all_goods .= '{"pic_url":"' . $val_1['pic_url'] . '",';
                    $all_goods .= '"outer_id":"' . $val_1['outer_id'] . '",';
                    $all_goods .= '"tmall_shop_num_iid":"' . $val_1['tmall_shop_num_iid'] . '",';
                    $seller_cids_new = "";
                    foreach ($seller_cids_cn as $val_2) {
                        if ($seller_cids_new != "") {
                            $seller_cids_new .= ",";
                        }
                        $seller_cids_new .= '{"cids":"' . $val_2 . '"}';
                    }
                    $all_goods .= '"seller_cids_cn":[' . $seller_cids_new . '],';
                    $all_goods .= '"title":"' . $val_1['title'] . '",';


                    //匹配sku信息
                    $sku_num_iid = $val_1['tmall_shop_num_iid'];
                    $qss = "SELECT * FROM  `tbapi_yibu_goods` WHERE `tmall_shop_num_iid` = '$sku_num_iid' AND `tmall_shop_num_iid` != `sku_id` ORDER BY  `age` DESC LIMIT 0 , 30";
                    $sku_arr_re = mysql_query($qss);
                    $sku_arr = array();
                    while ($row_su = mysql_fetch_assoc($sku_arr_re)) {
                        $sku_arr[] = $row_su;
                    }

//                    echo $qss;

                    $sku_info = "";
                    foreach ($sku_arr as $val_sku) {

                        $sku_info_color = $val_sku['sku_color'];
                        $sku_info_size = $val_sku['sku_size'];
                        $sku_info_num = $val_sku['num'];

                        if ($sku_info != "") {
                            $sku_info .= ",";
                        }

                        $sku_info .= '{"sku_info_color":"' . $sku_info_color . '",';
                        $sku_info .= '"sku_info_size":"' . $sku_info_size . '",';
                        $sku_info .= '"sku_info_num":"' . $sku_info_num . '"}';

                        $sku_info_color = "";
                        $sku_info_size = "";
                        $sku_info_num = "";

                    }


                    $goods_class = $val_1['season'] . "_goods_class";

                    $all_goods .= '"sku_info":[' . $sku_info . '],';
                    $all_goods .= '"price":"' . $val_1['price'] . '",';
                    $all_goods .= '"num":"' . $val_1['num'] . '",';
                    $all_goods .= '"list_time":"' . $val_1['list_time'] . '",';
                    $all_goods .= '"delist_time":"' . $val_1['delist_time'] . '",';
                    $all_goods .= '"created":"' . $val_1['created'] . '",';
                    $all_goods .= '"tm_ump_price":"' . $val_1['tm_ump_price'] . '",';
                    $all_goods .= '"tb_ump_price":"' . $val_1['tb_ump_price'] . '",';
                    $all_goods .= '"first_cost":"' . $val_1['first_cost'] . '",';
                    $all_goods .= '"age":"' . $val_1['age'] . '",';
                    $all_goods .= '"' . $goods_class . '":"' . $val_1['goods_class'] . '",';
                    $all_goods .= '"sis_status":"' . $val_1['sis_status'] . '",';
                    $all_goods .= '"tm_as":"' . $val_1['tm_as'] . '",';
                    $all_goods .= '"tb_as":"' . $val_1['tb_as'] . '",';
                    $all_goods .= '"yhd_as":"' . $val_1['yhd_as'] . '",';
                    $all_goods .= '"jd_as":"' . $val_1['jd_as'] . '",';
                    $all_goods .= '"sales_30d_ds":"' . $val_1['sales_30d_ds'] . '",';
                    $all_goods .= '"tb_shop_num_iid":"' . $val_1['tb_shop_num_iid'] . '",';
                    $all_goods .= '"tmall_shop_num_iid":"' . $val_1['tmall_shop_num_iid'] . '",';
                    $all_goods .= '"yhd_num_iid":"' . $val_1['yhd_num_iid'] . '",';
                    $all_goods .= '"yhd_sg":"' . $val_1['yhd_sg'] . '",';
                    $all_goods .= '"yhd_goods_url":"' . $val_1['yhd_goods_url'] . '"}';
                    $num = $num + $val_1['num'];
                }
            }

        }
        $data_info = "";
        $data_info .= '{"num":"' . $num . '",';
        $data_info .= '"sku_num":"' . $sku_num . '",';
        $data_info .= '"goods_num":"' . $goods_num . '",';
        $data_info .= '"quehuo_num":"' . $quehuo_num . '"}';
        $data = '{"data_info":[' . $data_info . '],"all_goods":[' . $all_goods . ']}';
        file_put_contents('mk_get_all_goods.json', $data);
        return $data;
    }

    function tbapi_update_sku_info($item)
    {
        /*更新所有商品sku信息、库存信息
        传入参数 item 为商品sku数据
        */

        $tm_as = $item['approve_status'];//天猫商品状态
        $num = $item['num'];//宝贝库存总数
        $NumIid = $item['num_iid'];//宝贝id
        $title = $item['title'];//宝贝标题

        $return_data = "";


        foreach ($item['skus']['sku'] as $key => $value) {

            $outer_id = $value['outer_id'];//商品sku货号
            $price = $value['price'];//商品sku价格
            $quantity = $value['quantity'];//商品sku库存
            $created = $value['created'];//商品创建时间


            //更新商品信息
            if ($quantity == 0) {
                $sis_status = "缺货";
            } else {
                $sis_status = "正常";
            }
            $upd_num_iid = "UPDATE `tbapi_yibu_goods` SET `num` = '$num', `sis_status` = '$sis_status', `created` = '$created', `tm_as` = '$tm_as' WHERE `tmall_shop_num_iid` = '$NumIid' AND `tmall_shop_num_iid` = `sku_id`";
            mysql_query($upd_num_iid);


            //更新商品sku信息
            $sku_id = $value['sku_id'];//商品skuid
            $properties_name = $value['properties_name'];

            $sku_inf = explode(";", $properties_name);
            $sku_inf_color = $sku_inf[0];
            $sku_inf_size = $sku_inf[1];


            $sku_inf_color_arr = explode("颜色分类:", $sku_inf_color);
            $sku_inf_color = $sku_inf_color_arr[1];

            $sku_inf_size_arr = explode("尺码:", $sku_inf_size);
            $sku_inf_size = $sku_inf_size_arr[1];


            //查询数据库中是否有该商品
            $serch_is = "SELECT sku_id FROM `tbapi_yibu_goods` WHERE `sku_id` = '$sku_id' LIMIT 1";
            $serch_num = mysql_num_rows(mysql_query($serch_is));


            if ($serch_num == 1) {
                //sku信息存在 开始更新信息
                $upd = "UPDATE `tbapi_yibu_goods` SET `num` = '$quantity', `sku_color` = '$sku_inf_color', `sku_size` = '$sku_inf_size', `sis_status` = '$sis_status', `tm_as` = '$tm_as', `created` = '$created', `outer_id` = '$outer_id' WHERE `sku_id` = $sku_id";
                if(mysql_query($upd)){
                    $mes = "更新成功";
                }else{
                    $mes = "更新失败";
                }
            } else if ($serch_num == 0) {
                //sku信息不存在 开始插入新行
                $ins_new = "INSERT INTO `tbapi_yibu_goods` (`outer_id`, `tmall_shop_num_iid`, `title`, `sku_id`, `price`, `num`, `sis_status`, `tm_as`, `created`) VALUES ('$outer_id', '$NumIid', '$title', '$sku_id', '$price', '$quantity', '$sis_status','$tm_as', '$created')";
                if(mysql_query($ins_new)){
                    $mes = "插入成功";
                }else{
                    $mes = "插入失败";
                }
            }
            if($return_data != ''){
                $return_data .= ",";
            }
            $return_data .= '{id:"'. $key .'",outer_id:"'.$outer_id.'",quantity":"'.$quantity.'","$mes":"'.$mes.'"}';
        }
        echo "[".$return_data."]";
    }

    function update_json_profit_statement($arr)
    {
        $day_month = date('Y-m', time());

        //回款金额
        $return_amount = $arr['return_amount'];
        $return_amount = round($return_amount, 0);

        //本月销售金额
        $sales_month = $arr['sales_month'];
        $sales_month = round($sales_month, 0);


        //若是本月 平台扣点= 回款金额 * 平台平均扣点，若是次月平台扣点  = 开票金额 - 回款金额
        //若是本月 税 = 回款金额 * 平台税点，若是次月 税 = 开票额 * 平台扣点
        if ($arr['time'] == $day_month) {
            switch ($arr['shop']) {
                case "天猫";
                    $koudian_platform = $return_amount * 0.065;
                    $operation_cost_taxes = $return_amount * 0.015;
                    break;
                case "C宝";
                    $koudian_platform = $return_amount * 0.015;
                    $operation_cost_taxes = $return_amount * 0.015;
                    break;
                case "京东";
                    $koudian_platform = $return_amount * 0.195;
                    $operation_cost_taxes = $return_amount * 0.125;
                    break;
                case "一号店";
                    $koudian_platform = $return_amount * 0.125;
                    $operation_cost_taxes = $return_amount * 0.125;
                    break;
            }
        } else {
            $operation_cost_taxes = $arr['operation_cost_taxes'];
//            $koudian_platform = $invoice_amount - $return_amount;
        }
        $koudian_platform = round($koudian_platform, 0);


        //开票金额 若是当月就以 开票金额 = 回款金额 + 平台扣点 为准， 若是次月就以财务提供数据为准
        if ($arr['time'] == $day_month) {
            $invoice_amount = $return_amount + $koudian_platform;
        } else {
            $invoice_amount = $sales_month;
//            $invoice_amount = $arr['invoice_amount'];
        }

        //商品成本金额
        $cost_of_goods = $arr['cost_of_goods'];
        $cost_of_goods = round($cost_of_goods, 0);


        $sales_volume = $arr['sales_volume'];//销售件数
        $operation_cost_shop = $arr['operation_cost_shop'];//店铺费用


        $gross_profit = $invoice_amount - $cost_of_goods;//毛利

        $operation_cost_taxes = round($operation_cost_taxes, 0);//税
        $operation_cost = $operation_cost_shop + $operation_cost_taxes;//店铺费用小计总


        //利润额 = 回款额 - 商品成本金额 - 费用小计
        $amount_of_profit = $return_amount - $cost_of_goods - $operation_cost;
        $amount_of_profit = round($amount_of_profit, 0);


        $payment_rate = ($return_amount / $invoice_amount) * 100;
        $payment_rate = round($payment_rate, 2);//回款率


        $price_per = ($invoice_amount / $sales_volume);
        $price_per = round($price_per, 0);//销售单价


        $cost_unit_price = ($cost_of_goods / $sales_volume);
        $cost_unit_price = round($cost_unit_price, 0);//成本单价


        $gross_unit_profit = ($gross_profit / $sales_volume);
        $gross_unit_profit = round($gross_unit_profit, 0);//单件毛利


        $profit_unit_price = $amount_of_profit / $sales_volume;
        $profit_unit_price = round($profit_unit_price, 0);//单件利润


        $cost_rate = ($cost_of_goods / $invoice_amount) * 100;
        $cost_rate = round($cost_rate, 2);//成本率


        $gross_profit_rate = ($gross_profit / $invoice_amount) * 100;//毛利率
        $gross_profit_rate = round($gross_profit_rate, 2);//毛利率


        $all_cost = (($operation_cost + $koudian_platform) / $invoice_amount) * 100;
        $all_cost = round($all_cost, 2);//总费率


        $profit_rate = ($amount_of_profit / $invoice_amount) * 100;
        $profit_rate = round($profit_rate, 2);//利润率


        $operation_cost_rate = ($operation_cost / $invoice_amount) * 100;
        $operation_cost_rate = round($operation_cost_rate, 2);//运营费用率


        $return_data = "";
        $return_data .= '{"sales_month":"' . $sales_month . '",';
        $return_data .= '"invoice_amount":"' . $invoice_amount . '",';
        $return_data .= '"koudian_platform":"' . $koudian_platform . '",';
        $return_data .= '"return_amount":"' . $return_amount . '",';
        $return_data .= '"sales_volume":"' . $sales_volume . '",';
        $return_data .= '"cost_of_goods":"' . $cost_of_goods . '",';
        $return_data .= '"operation_cost":"' . $operation_cost . '",';
        $return_data .= '"operation_cost_shop":"' . $operation_cost_shop . '",';//店铺费用
        $return_data .= '"operation_cost_taxes":"' . $operation_cost_taxes . '",';
        $return_data .= '"amount_of_profit":"' . $amount_of_profit . '",';
        $return_data .= '"payment_rate":"' . $payment_rate . '%",';//回款率
        $return_data .= '"gross_profit":"' . $gross_profit . '",';//毛利
        $return_data .= '"price_per":"' . $price_per . '",';
        $return_data .= '"cost_unit_price":"' . $cost_unit_price . '",';
        $return_data .= '"gross_unit_profit":"' . $gross_unit_profit . '",';
        $return_data .= '"profit_unit_price":"' . $profit_unit_price . '",';//单件利润
        $return_data .= '"cost_rate":"' . $cost_rate . '%",';//成本率
        $return_data .= '"gross_profit_rate":"' . $gross_profit_rate . '%",';//毛利率
        $return_data .= '"all_cost":"' . $all_cost . '%",';//总费率
        $return_data .= '"profit_rate":"' . $profit_rate . '%",';//利润率
        $return_data .= '"operation_cost_rate":"' . $operation_cost_rate . '%"}';//运营费用率

        return $return_data;
    }

    function get_json_expense_detail($arr)
    {
        $return_data = "";
        $shop = $arr['shop'];
        $time = date('Y-m', time());


        $shop_all = $arr['wages'] + $arr['sbyb'] + $arr['bonus'] + $arr['travel_expense'] + $arr['platform_fee'] + $arr['software_fee'] + $arr['depreciation_fee'] + $arr['device_fee'] + $arr['express_yd_fee'] + $arr['express_return_fee'] + $arr['photography_fee'] + $arr['subway_fee'] + $arr['sms_fee'] + $arr['sd_fee'] + $arr['shangou_fee'] + $arr['tuiguang_fee'] + $arr['sale_fee'] + $arr['tbk_fee'] + $arr['other_fee'];
        $return_data .= '{"wages":"' . $arr['wages'] . '",';//基本工资
        $return_data .= '"sbyb":"' . $arr['sbyb'] . '",';//社保医保
        $return_data .= '"bonus":"' . $arr['bonus'] . '",';//提成
        $return_data .= '"travel_expense":"' . $arr['travel_expense'] . '",';//差旅费
        $return_data .= '"platform_fee":"' . $arr['platform_fee'] . '",';//平台使用费
        $return_data .= '"software_fee":"' . $arr['software_fee'] . '",';//软件费
        $return_data .= '"depreciation_fee":"' . $arr['depreciation_fee'] . '",';//折旧费
        $return_data .= '"device_fee":"' . $arr['device_fee'] . '",';//设备费
        $return_data .= '"express_yd_fee":"' . $arr['express_yd_fee'] . '",';//韵达快递费
        $return_data .= '"express_return_fee":"' . $arr['express_return_fee'] . '",';//退换货运费
        $return_data .= '"photography_fee":"' . $arr['photography_fee'] . '",';//拍照费用
        $return_data .= '"subway_fee":"' . $arr['subway_fee'] . '",';//直通车费用
        $return_data .= '"sms_fee":"' . $arr['sms_fee'] . '",';//短信充值费
        $return_data .= '"sd_fee":"' . $arr['sd_fee'] . '",';//刷单值费
        $return_data .= '"shangou_fee":"' . $arr['shangou_fee'] . '",';//闪购费
        $return_data .= '"tuiguang_fee":"' . $arr['tuiguang_fee'] . '",';//推广费
        $return_data .= '"sale_fee":"' . $arr['sale_fee'] . '",';//闪购费
        $return_data .= '"tbk_fee":"' . $arr['tbk_fee'] . '",';//淘宝客费用
        $return_data .= '"other_fee":"' . $arr['other_fee'] . '",';//其他费用
        $return_data .= '"shop_all":"' . $shop_all . '"}';//店铺总费用
        $this->e_mysql_connect();
        $qs_up = "UPDATE `tbapi_yibu_profit_statement` SET `operation_cost_shop` = '$shop_all' WHERE `time` = '$time' AND `shop` = '$shop'";
        mysql_query($qs_up);
        return $return_data;
    }

    function get_first_cost_percent($season,$age){
        //获得商品折扣成本 比率
        $spring_1st = 14;
        $spring_2nd = 26;
        $spring_3rd = 38;

        $summer_1st = 16;
        $summer_2nd = 28;
        $summer_3rd = 40;

        $autumn_1st = 21;
        $autumn_2nd = 33;
        $autumn_3rd = 45;

        $winter_1st = 23;
        $winter_2nd = 35;
        $winter_3rd = 47;

        $year = date('Y', time());//获得当前时间
        $month = date('m', time());//获得当前时间

        $sale_time_now = (($year - $age) * 12) + $month;//对应打折力度 的年份 月份

        switch ($season) {
            case "A":
                switch ($sale_time_now) {
                    case $sale_time_now < $spring_1st:
                        $prime_cost = "prime_cost_1st";
                        break;
                    case $sale_time_now >= $spring_1st && $sale_time_now < $spring_2nd:
                        $prime_cost = "prime_cost_2nd";
                        break;
                    case $sale_time_now >= $spring_2nd && $sale_time_now < $spring_3rd:
                        //折扣年份在第三梯队
                        $prime_cost = "prime_cost_3rd";
                        break;
                    case $sale_time_now > $spring_3rd:
                        $prime_cost = "prime_cost_4th";
                        break;
                }
                break;
            case "B":
                switch ($sale_time_now) {
                    case $sale_time_now < $summer_1st:
                        $prime_cost = "prime_cost_1st";
                        break;
                    case $sale_time_now >= $summer_1st && $sale_time_now < $summer_2nd:
                        $prime_cost = "prime_cost_2nd";
                        break;
                    case $sale_time_now >= $summer_2nd && $sale_time_now < $summer_3rd:
                        //折扣年份在第三梯队
                        $prime_cost = "prime_cost_3rd";
                        break;
                    case $sale_time_now > $summer_3rd:
                        $prime_cost = "prime_cost_4th";
                        break;
                }
                break;
            case "C":
                switch ($sale_time_now) {
                    case $sale_time_now < $autumn_1st:
                        $prime_cost = "prime_cost_1st";
                        break;
                    case $sale_time_now >= $autumn_1st && $sale_time_now < $autumn_2nd:
                        $prime_cost = "prime_cost_2nd";
                        break;
                    case $sale_time_now >= $autumn_2nd && $sale_time_now < $autumn_3rd:
                        //折扣年份在第三梯队
                        $prime_cost = "prime_cost_3rd";
                        break;
                    case $sale_time_now > $autumn_3rd:
                        $prime_cost = "prime_cost_4th";
                        break;
                }
                break;
            case "D":
                switch ($sale_time_now) {
                    case $sale_time_now < $winter_1st:
                        $prime_cost = "prime_cost_1st";
                        break;
                    case $sale_time_now >= $winter_1st && $sale_time_now < $winter_2nd:
                        $prime_cost = "prime_cost_2nd";
                        break;
                    case $sale_time_now >= $winter_2nd && $sale_time_now < $winter_3rd:
                        //折扣年份在第三梯队
                        $prime_cost = "prime_cost_3rd";
                        break;
                    case $sale_time_now > $winter_3rd:
                        $prime_cost = "prime_cost_4th";
                        break;
                }
                break;
        }
        $season = $age.$season;//产品年份季度
        //从数据库得知对应商品的折扣比例 这里效率慢了
        $qs_sale = "SELECT $prime_cost FROM `tbapi_yibu_cost_accounting` WHERE `season` = '$season'";
        $sale_percent_arr = $this->e_mysql_search($qs_sale);
        $sale_percent = $sale_percent_arr[0][$prime_cost];
        return $sale_percent;
    }
}