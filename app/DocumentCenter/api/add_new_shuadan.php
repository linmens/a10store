<?php

require('../../config/config_mysql.php');

$ein = new ein_mysql();
$ein->e_mysql_connect();

$params = json_decode(file_get_contents('php://input'), true);

$selectedId = $params['data']['selectedId'];//分辨是新增刷单订单，还是MK订单
$order_id = $params['data']['order_id'];//分辨是新增刷单订单，还是MK订单

if ($order_id != "") {

    switch ($selectedId) {
        //新增刷单订单
        case 1:
            $data = $params['data'];

            $shop = $data['shop'];//店铺
            $buyer_nick = $data['buyer_nick'];//淘宝用户名
            $order_id = $data['order_id'];//淘宝订单号
            $order_money = $data['order_money'];//订单金额
            $order_yongjin = $data['order_yongjin'];//佣金
            $pay_time = $data['pay_time'];//付款时间


            $ins_qs = "INSERT INTO `tbapi_yibu_orders_shuadan` (`shop`,`buyer_nick`,`order_id`,`order_money`,`order_yongjin`,`pay_time`,`state`) VALUES ('$shop','$buyer_nick','$order_id','$order_money','$order_yongjin','$pay_time','未确认')";
            if (mysql_query($ins_qs)) {
                $mes = "success";
            } else {
                $mes = "no";
            }


            $qs = "SELECT * FROM `tbapi_yibu_orders_shuadan` WHERE `state` = '未确认' ORDER BY `pay_time` ASC";
            $order = $ein->e_mysql_search($qs);

            $info_all_yongjin = 0;//总佣金
            $info_all_benjin = 0;//总本金

            foreach ($order as $v) {
                $order_yongjin = round($v['order_yongjin'], 2);//佣金
                $order_money = round($v['order_money'], 2);//本金


                $info_all_yongjin = +$info_all_yongjin + $order_yongjin;//累计加佣金
                $info_all_benjin = +$info_all_benjin + $order_money;//累计加本金
            }

            $info_all_yongjin = round($info_all_yongjin, 2);

            $data = '{"data_info":"' . $mes . '","info_all_benjin":"' . $info_all_benjin . '","info_all_yongjin":"' . $info_all_yongjin . '"}';
            echo $data;
            break;

        //新增MK订单
        case 2:

            $data = $params['data'];

            $shop = $data['shop'];//店铺
            $buyer_nick = $data['buyer_nick'];//淘宝用户名
            $order_id = $data['order_id'];//淘宝订单号
            $order_money = $data['order_money'];//订单金额
            $order_yongjin = $data['order_yongjin'];//佣金
            $pay_time = $data['pay_time'];//付款时间
            $money_state = $data['money_state'];//结算状态


            $ins_qs = "INSERT INTO `tbapi_yibu_orders_mk` (`shop`,`buyer_nick`,`order_id`,`order_money`,`pay_time`,`state`,`money_state`) VALUES ('$shop','$buyer_nick','$order_id','$order_money','$pay_time','未确认','$money_state')";
            if (mysql_query($ins_qs)) {
                $mes = "success";
            } else {
                $mes = "no";
            }
            echo $ins_qs;

            $data = '{"data_info":"' . $mes . '"}';
            echo $data;

            break;
    }
}

