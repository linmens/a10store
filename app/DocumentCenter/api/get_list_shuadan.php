<?php
require('../../config/config_mysql.php');
$ein = new ein_mysql();
$ein->e_mysql_connect();
$ein->e_html_set_header();


$params = json_decode(file_get_contents('php://input'), true);
$state = $_GET['hpm'];
$shop = $_GET['data'];


switch ($state) {
    case "未确认";
        switch ($shop) {
            case "淘宝C店":
                $qs = "SELECT * FROM `tbapi_yibu_orders_shuadan` WHERE `order_state` = '正常订单' AND `state` = '未确认' AND `shop` = 'tb' ORDER BY `pay_time` DESC";
                break;
            case "天猫":
                $qs = "SELECT * FROM `tbapi_yibu_orders_shuadan` WHERE `order_state` = '正常订单' AND `state` = '未确认' AND `shop` = 'tm' ORDER BY `pay_time` DESC";
                break;
            default:
                $qs = "SELECT * FROM `tbapi_yibu_orders_shuadan` WHERE `order_state` = '正常订单' AND `state` = '未确认' ORDER BY `pay_time` DESC";
        }
        break;
    case "已确认";
        switch ($shop) {
            case "淘宝C店":
                $qs = "SELECT * FROM `tbapi_yibu_orders_shuadan` WHERE `order_state` = '正常订单' AND `state` = '已确认' AND `shop` = 'tb' ORDER BY `pay_time` DESC";
                break;
            case "天猫":
                $qs = "SELECT * FROM `tbapi_yibu_orders_shuadan` WHERE `order_state` = '正常订单' AND `state` = '已确认' AND `shop` = 'tm' ORDER BY `pay_time` DESC";
                break;
            default:
                $qs = "SELECT * FROM `tbapi_yibu_orders_shuadan` WHERE `order_state` = '正常订单' AND `state` = '已确认' ORDER BY `pay_time` DESC";
        }
        break;
    case "已结算";
        switch ($shop) {
            case "淘宝C店":
                $qs = "SELECT * FROM `tbapi_yibu_orders_shuadan` WHERE `order_state` = '正常订单' AND `state` = '已结算' AND `shop` = 'tb' ORDER BY `pay_time` DESC";
                break;
            case "天猫":
                $qs = "SELECT * FROM `tbapi_yibu_orders_shuadan` WHERE `order_state` = '正常订单' AND `state` = '已结算' AND `shop` = 'tm' ORDER BY `pay_time` DESC";
                break;
            default:
                $qs = "SELECT * FROM `tbapi_yibu_orders_shuadan` WHERE `order_state` = '正常订单' AND `state` = '已结算' ORDER BY `pay_time` DESC";
        }
        break;
    case "已完成";

        switch ($shop) {
            case "淘宝C店":
                $qs = "SELECT * FROM `tbapi_yibu_orders_shuadan` WHERE `order_state` = '正常订单' AND `state` = '已完成' AND `shop` = 'tb' ORDER BY `pay_time` DESC";
                break;
            case "天猫":
                $qs = "SELECT * FROM `tbapi_yibu_orders_shuadan` WHERE `order_state` = '正常订单' AND `state` = '已完成' AND `shop` = 'tm' ORDER BY `pay_time` DESC";
                break;
            default:
                $qs = "SELECT * FROM `tbapi_yibu_orders_shuadan` WHERE `order_state` = '正常订单' AND `state` = '已完成' ORDER BY `pay_time` DESC";
        }
        break;
    case "删除记录";

        switch ($shop) {
            case "淘宝C店":
                $qs = "SELECT * FROM `tbapi_yibu_orders_shuadan` WHERE `order_state` = '删除订单' AND `shop` = 'tb' ORDER BY `pay_time` DESC";
                break;
            case "天猫":
                $qs = "SELECT * FROM `tbapi_yibu_orders_shuadan` WHERE `order_state` = '删除订单' AND `shop` = 'tm' ORDER BY `pay_time` DESC";
                break;
            default:
                $qs = "SELECT * FROM `tbapi_yibu_orders_shuadan` WHERE `order_state` = '删除订单' ORDER BY `pay_time` DESC";
        }
        break;
    //正常购买订单
    case "活动单";
        $qs = "SELECT * FROM `tbapi_yibu_orders_mk` ORDER BY `pay_time` DESC";
        break;
}

switch ($state) {
    case "未确认":
    case "已确认":
    case "已结算":
    case "删除记录":
    case "已完成":
        $order = $ein->e_mysql_search($qs);

        $arr_order = "";
        $info_all_yongjin = 0;//总佣金
        $info_all_benjin = 0;//总本金

        foreach ($order as $v) {
            $order_yongjin = round($v['order_yongjin'], 2);//佣金
            $order_money = round($v['order_money'], 2);//本金

            if ($arr_order != "") {
                $arr_order .= ",";
            }
            $arr_order .= '{"id":"' . $v['id'] . '",';
            $arr_order .= '"shop":"' . $v['shop'] . '",';
            $arr_order .= '"buyer_nick":"' . $v['buyer_nick'] . '",';
            $arr_order .= '"order_id":"' . $v['order_id'] . '",';
            $arr_order .= '"order_money":"' . $v['order_money'] . '",';
            $arr_order .= '"order_yongjin":"' . $order_yongjin . '",';
            $arr_order .= '"pay_time":"' . $v['pay_time'] . '",';
            $arr_order .= '"state":"' . $v['state'] . '",';
            $arr_order .= '"money_state":"' . $v['money_state'] . '"}';


            $info_all_yongjin = +$info_all_yongjin + $order_yongjin;//累计加佣金
            $info_all_benjin = +$info_all_benjin + $order_money;//累计加本金
        }

        $info_all_yongjin = round($info_all_yongjin, 2);

        $qs = "SELECT * FROM `tbapi_yibu_orders_shuadan` WHERE `order_state` = '正常订单' AND `state` = '未确认'";
        $num_wqr = $ein->e_mysql_search($qs);
        $num_wqr = count($num_wqr);

        $qs = "SELECT * FROM `tbapi_yibu_orders_shuadan` WHERE `order_state` = '正常订单' AND `state` = '已确认'";
        $num_yqr = $ein->e_mysql_search($qs);
        $num_yqr = count($num_yqr);

        $qs = "SELECT * FROM `tbapi_yibu_orders_shuadan` WHERE `order_state` = '正常订单' AND `state` = '已结算'";
        $num_yjs = $ein->e_mysql_search($qs);
        $num_yjs = count($num_yjs);

        $qs = "SELECT * FROM `tbapi_yibu_orders_shuadan` WHERE `order_state` = '正常订单' AND `state` = '已完成'";
        $num_ywc = $ein->e_mysql_search($qs);
        $num_ywc = count($num_ywc);

        $qs = "SELECT * FROM `tbapi_yibu_orders_shuadan` WHERE `order_state` = '删除订单'";
        $num_scjl = $ein->e_mysql_search($qs);
        $num_scjl = count($num_scjl);


        $qs_zj_tm = "SELECT * FROM `tbapi_yibu_expense_list` WHERE `shop` = '天猫' AND `class` = '刷单' AND `state` != '未打款'";
        $qs_zj_tb = "SELECT * FROM `tbapi_yibu_expense_list` WHERE `shop` = '淘宝' AND `class` = '刷单' AND `state` != '未打款'";

        //获取天猫 总申请资金
        $tm_price = 0;
        $zi_tm_arr = $ein->e_mysql_search($qs_zj_tm);
        foreach ($zi_tm_arr as $v_tm) {
            $zj_tm_data = $v_tm['all_price'];
            $tm_price = $tm_price + $zj_tm_data;
        }

        //获取淘宝 总申请资金
        $tb_price = 0;
        $zi_tb_arr = $ein->e_mysql_search($qs_zj_tb);
        foreach ($zi_tb_arr as $v_tm) {
            $zj_tb_data = $v_tm['all_price'];
            $tb_price = $tb_price + $zj_tb_data;
        }


        //获取天猫，淘宝，刷单订单总数
        $qs_order_num_tm = "SELECT * FROM `tbapi_yibu_orders_shuadan` WHERE `order_state` = '正常订单' AND `shop` = 'tm' AND `state` != '未确认'";
        $qs_order_num_tb = "SELECT * FROM `tbapi_yibu_orders_shuadan` WHERE `order_state` = '正常订单' AND `shop` = 'tb' AND `state` != '未确认'";

        $qs_order_num_tm_arr = $ein->e_mysql_search($qs_order_num_tm);
        $order_num_tm = count($qs_order_num_tm_arr);

        $qs_order_num_tb_arr = $ein->e_mysql_search($qs_order_num_tb);
        $order_num_tb = count($qs_order_num_tb_arr);


        //获取天猫 总花费资金
        $qs_hfzj_tm = "SELECT * FROM `tbapi_yibu_orders_shuadan` WHERE `order_state` = '正常订单' AND `shop` = 'tm' AND `state` != '未确认'";
        $tm_hf_price = 0;
        $zi_tm_hf_arr = $ein->e_mysql_search($qs_hfzj_tm);
        foreach ($zi_tm_hf_arr as $v_tm) {
            $hfzjbj_tm_data = $v_tm['order_money'];
            $hfzjyj_tm_data = $v_tm['order_yongjin'];
            $tm_hf_price = $tm_hf_price + $hfzjbj_tm_data + $hfzjyj_tm_data;
        }

        //获取淘宝 总花费资金
        $qs_hfzj_tb = "SELECT * FROM `tbapi_yibu_orders_shuadan` WHERE `order_state` = '正常订单' AND `shop` = 'tb' AND `state` != '未确认'";
        $tb_hf_price = 0;
        $zi_tb_hf_arr = $ein->e_mysql_search($qs_hfzj_tb);
        foreach ($zi_tb_hf_arr as $v_tm) {
            $hfzjbj_tb_data = $v_tm['order_money'];
            $hfzjyj_tb_data = $v_tm['order_yongjin'];
            $tb_hf_price = $tb_hf_price + $hfzjbj_tb_data + $hfzjyj_tb_data;
        }

        $money_usable_tm = $tm_price - $tm_hf_price;
        $money_usable_tb = $tb_price - $tb_hf_price;

        //获取活动单数量
        $get_hdd_tb = "SELECT * FROM `tbapi_yibu_orders_mk` WHERE `shop` = 'tb' AND `state` != '未确认'";
        $get_hdd_tm = "SELECT * FROM `tbapi_yibu_orders_mk` WHERE `shop` = 'tm' AND `state` != '未确认'";
        $get_hdd_tb_arr = $ein->e_mysql_search($get_hdd_tb);
        $get_hdd_tm_arr = $ein->e_mysql_search($get_hdd_tm);
        $hdd_tb_num = count($get_hdd_tb_arr);
        $hdd_tm_num = count($get_hdd_tm_arr);


        $data = '{"tm_sd_info":[{"money_all":"' . $tm_price . '","money_usable":"' . $money_usable_tm . '","order_sd_num":"' . $order_num_tm . '","money_use":"' . $tm_hf_price . '","order_hhd_num":"' . $hdd_tm_num . '"}],';
        $data .= '"tb_sd_info":[{"money_all":"' . $tb_price . '","money_usable":"' . $money_usable_tb . '","order_sd_num":"' . $order_num_tb . '","money_use":"' . $tb_hf_price . '","order_hhd_num":"' . $hdd_tb_num . '"}],';
        $data .= '"arr_order":[' . $arr_order . '],';
        $data .= '"info_all_yongjin":"' . $info_all_yongjin . '",';
        $data .= '"info_all_benjin":"' . $info_all_benjin . '",';
        $data .= '"num_wqr":"' . $num_wqr . '",';
        $data .= '"num_yqr":"' . $num_yqr . '",';
        $data .= '"num_yjs":"' . $num_yjs . '",';
        $data .= '"num_scjl":"' . $num_scjl . '",';
        $data .= '"num_ywc":"' . $num_ywc . '"}';

        echo $data;
        break;

    case "活动单":
        $arr_order = "";
        $order = $ein->e_mysql_search($qs);

        foreach ($order as $v) {

            if ($arr_order != "") {
                $arr_order .= ",";
            }
            $arr_order .= '{"id":"' . $v['id'] . '",';
            $arr_order .= '"shop":"' . $v['shop'] . '",';
            $arr_order .= '"buyer_nick":"' . $v['buyer_nick'] . '",';
            $arr_order .= '"order_id":"' . $v['order_id'] . '",';
            $arr_order .= '"order_money":"' . $v['order_money'] . '",';
            $arr_order .= '"order_no_wl":"' . $v['order_no_wl'] . '",';
            $arr_order .= '"pay_time":"' . $v['pay_time'] . '",';
            $arr_order .= '"money_state":"' . $v['money_state'] . '",';
            $arr_order .= '"state":"' . $v['state'] . '"}';
        }


        $qs_zj_tm = "SELECT * FROM `tbapi_yibu_expense_list` WHERE `shop` = '天猫服饰旗舰店' AND `class` = '站外推广费' AND `state` != '未审核' AND `state` != '已审核' AND `state` != '未打款'";
        $qs_zj_tb = "SELECT * FROM `tbapi_yibu_expense_list` WHERE `shop` = '淘宝C店' AND `class` = '站外推广费' AND `state` != '未审核' AND `state` != '已审核' AND `state` != '未打款'";

        //获取天猫 总申请资金
        $tm_price = 0;
        $zi_tm_arr = $ein->e_mysql_search($qs_zj_tm);
        foreach ($zi_tm_arr as $v_tm) {
            $zj_tm_data = $v_tm['all_price'];
            $tm_price = $tm_price + $zj_tm_data;
        }

        //获取淘宝 总申请资金
        $tb_price = 0;
        $zi_tb_arr = $ein->e_mysql_search($qs_zj_tb);
        foreach ($zi_tb_arr as $v_tm) {
            $zj_tb_data = $v_tm['all_price'];
            $tb_price = $tb_price + $zj_tb_data;
        }


        //获取天猫，淘宝，刷单订单总数
        $qs_order_num_tm = "SELECT * FROM `tbapi_yibu_orders_mk` WHERE `shop` = 'tm' AND `state` != '未确认'";
        $qs_order_num_tb = "SELECT * FROM `tbapi_yibu_orders_mk` WHERE `shop` = 'tb' AND `state` != '未确认'";

        $qs_order_num_tm_arr = $ein->e_mysql_search($qs_order_num_tm);
        $order_num_tm = count($qs_order_num_tm_arr);

        $qs_order_num_tb_arr = $ein->e_mysql_search($qs_order_num_tb);
        $order_num_tb = count($qs_order_num_tb_arr);


        //获取天猫 总花费资金
        $qs_hfzj_tm = "SELECT * FROM `tbapi_yibu_orders_mk` WHERE `shop` = 'tm' AND `state` != '未确认'";
        $tm_hf_price = 0;
        $zi_tm_hf_arr = $ein->e_mysql_search($qs_hfzj_tm);
        foreach ($zi_tm_hf_arr as $v_tm) {
            $hfzjbj_tm_data = $v_tm['order_money'];
            $hfzjyj_tm_data = $v_tm['order_yongjin'];
            $tm_hf_price = $tm_hf_price + $hfzjbj_tm_data + $hfzjyj_tm_data;
        }

        //获取淘宝 总花费资金
        $qs_hfzj_tb = "SELECT * FROM `tbapi_yibu_orders_mk` WHERE `shop` = 'tb' AND `state` != '未确认'";
        $tb_hf_price = 0;
        $zi_tb_hf_arr = $ein->e_mysql_search($qs_hfzj_tb);
        foreach ($zi_tb_hf_arr as $v_tm) {
            $hfzjbj_tb_data = $v_tm['order_money'];
            $hfzjyj_tb_data = $v_tm['order_yongjin'];
            $tb_hf_price = $tb_hf_price + $hfzjbj_tb_data + $hfzjyj_tb_data;
        }

        $money_usable_tm = $tm_price - $tm_hf_price;
        $money_usable_tb = $tb_price - $tb_hf_price;

        //获取活动单数量
        $get_hdd_tb = "SELECT * FROM `tbapi_yibu_orders_mk` WHERE `shop` = 'tb' AND `state` != '未确认'";
        $get_hdd_tm = "SELECT * FROM `tbapi_yibu_orders_mk` WHERE `shop` = 'tm' AND `state` != '未确认'";
        $get_hdd_tb_arr = $ein->e_mysql_search($get_hdd_tb);
        $get_hdd_tm_arr = $ein->e_mysql_search($get_hdd_tm);
        $hdd_tb_num = count($get_hdd_tb_arr);
        $hdd_tm_num = count($get_hdd_tm_arr);

        $data = '{"tm_sd_info":[{"money_all":"' . $tm_price . '","money_usable":"' . $money_usable_tm . '","order_sd_num":"' . $order_num_tm . '","money_use":"' . $tm_hf_price . '","order_hhd_num":"' . $hdd_tm_num . '"}],';
        $data .= '"tb_sd_info":[{"money_all":"' . $tb_price . '","money_usable":"' . $money_usable_tb . '","order_sd_num":"' . $order_num_tb . '","money_use":"' . $tb_hf_price . '","order_hhd_num":"' . $hdd_tb_num . '"}],';
        $data .= '"arr_order":[' . $arr_order . '],';
        $data .= '"info_all_yongjin":"' . $info_all_yongjin . '",';
        $data .= '"info_all_benjin":"' . $info_all_benjin . '",';
        $data .= '"num_wqr":"' . $num_wqr . '",';
        $data .= '"num_yqr":"' . $num_yqr . '",';
        $data .= '"num_yjs":"' . $num_yjs . '",';
        $data .= '"num_ywc":"' . $num_ywc . '"}';


        echo $data;

        break;
}
