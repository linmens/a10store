<?php
if (!empty($_FILES)) {
    require('../../config/class/phpexcelreader2.21/excel_reader2.php');

    $file_name_up = $_FILES['file']['name'];//上传文件名;
    $file_type_arr = explode(".", $file_name_up);
    $file_type = $file_type_arr[1];//获取文件格式
    $file_time = date("Ymd", time());

    switch ($case) {
        case "导入订单信息-E店宝":
            $file_case = "add_new_goods_";
            break;
    }
    $file_name = $file_case . $file_time . "." . $file_type;//保存文件名
    $tempPath = $_FILES['file']['tmp_name'];//文件临时保存目录
    $uploadPath = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'uploads' . DIRECTORY_SEPARATOR . $file_name;//文件保存路径
    move_uploaded_file($tempPath, $uploadPath);//把文件从临时目录移动到指定文件夹 ******
    $data = new Spreadsheet_Excel_Reader();//创建对象
    $data->read($uploadPath);//读取Excel文件

    //获取表格内数据
    for ($i = 1; $i <= $data->sheets[0]['numRows']; $i++) {//$data->sheets[0]['numRows']为Excel行数
        for ($j = 1; $j <= $data->sheets[0]['numCols']; $j++) {//$data->sheets[0]['numCols']为Excel列数
            //获取数据标题
            if ($i == 1) {
                switch ($case) {
                    case "导入订单信息-E店宝":
                        if ($data->sheets[0]['cells'][$i][$j] === "店铺名称") {
                            $shop_name_j = $j;//店铺名称
                        }
                        if ($data->sheets[0]['cells'][$i][$j] === "外部平台单号") {
                            $order_id_j = $j;//外部平台单号
                        }
                        if ($data->sheets[0]['cells'][$i][$j] === "支付宝") {
                            $buyer_zfb_j = $j;//买家_支付宝
                        }
                        if ($data->sheets[0]['cells'][$i][$j] === "手机") {
                            $buyer_phone_j = $j;//买家_手机
                        }
                        if ($data->sheets[0]['cells'][$i][$j] === "买家ID") {
                            $buyer_nick_j = $j;//买家_ID
                        }
                        if ($data->sheets[0]['cells'][$i][$j] === "订货日期") {
                            $time_xiadan_j = $j;//买家_下单时间
                        }
                        if ($data->sheets[0]['cells'][$i][$j] === "付款日期") {
                            $time_pay_j = $j;//买家_付款时间
                        }
                        if ($data->sheets[0]['cells'][$i][$j] === "快递公司名称") {
                            $wl_gs_j = $j;//快递公司名称
                        }
                        if ($data->sheets[0]['cells'][$i][$j] === "快递单号") {
                            $wl_no_j = $j;//快递公司单号
                        }
                        if ($data->sheets[0]['cells'][$i][$j] === "收货人") {
                            $adress_name_j = $j;//地址_收货人
                        }
                        if ($data->sheets[0]['cells'][$i][$j] === "买家地址") {
                            $adress_detail_j = $j;//地址_买家详细地址
                        }
                        if ($data->sheets[0]['cells'][$i][$j] === "外部订单状态") {
                            $state_order_pingtai_j = $j;//订单状态_外部
                        }
                        if ($data->sheets[0]['cells'][$i][$j] === "省") {
                            $adress_sheng_j = $j;//地址_省
                        }

                        if ($data->sheets[0]['cells'][$i][$j] === "市") {
                            $adress_shi_j = $j;//地址_市
                        }
                        break;
                }
            } else {
                //获取对应数据
                switch ($case) {
                    case "导入订单信息-E店宝":
                        switch ($j) {
                            case $shop_name_j://店铺名称
                                $shop_name = $data->sheets[0]['cells'][$i][$j];
                                switch ($shop_name) {
                                    case "依布服饰旗舰店—天猫":
                                        $shop_name = "yb_tm";
                                        break;
                                    case "依布专卖店—C店":
                                        $shop_name = "yb_tb";
                                        break;
                                    case "依布旗舰店—1号":
                                        $shop_name = "yb_yhd";
                                        break;
                                }
                                break;
                            case $order_id_j://外部平台单号
                                $order_id = $data->sheets[0]['cells'][$i][$j];
                                break;
                            case $buyer_zfb_j://买家_支付宝
                                $buyer_zfb = $data->sheets[0]['cells'][$i][$j];
                                break;
                            case $buyer_phone_j://买家_手机
                                $buyer_phone = $data->sheets[0]['cells'][$i][$j];
                                break;
                            case $buyer_nick_j://买家_ID
                                $buyer_nick = $data->sheets[0]['cells'][$i][$j];
                                break;
                            case $time_xiadan_j://买家_下单时间
                                $time_xiadan = $data->sheets[0]['cells'][$i][$j];
                                break;
                            case $time_pay_j://买家_付款时间
                                $time_pay = $data->sheets[0]['cells'][$i][$j];
                                break;
                            case $wl_gs_j://快递公司名称
                                $wl_gs = $data->sheets[0]['cells'][$i][$j];
                                break;
                            case $wl_no_j://快递公司单号
                                $wl_no = $data->sheets[0]['cells'][$i][$j];
                                break;
                            case $adress_name_j://地址_收货人
                                $adress_name = $data->sheets[0]['cells'][$i][$j];
                                break;
                            case $adress_detail_j://地址_买家详细地址
                                $adress_detail = $data->sheets[0]['cells'][$i][$j];
                                break;
                            case $state_order_pingtai_j://订单状态_外部
                                $state_order_pingtai = $data->sheets[0]['cells'][$i][$j];
                                break;
                            case $adress_sheng_j://地址_省
                                $adress_sheng = $data->sheets[0]['cells'][$i][$j];
                                break;
                            case $adress_shi_j://地址_市
                                $adress_shi = $data->sheets[0]['cells'][$i][$j];
                                break;
                        }
                        break;
                }
            }
        }

        //一行数据结束后，总结为一个json数据组
        if ($i != 1) {
            switch ($case) {
                case "导入订单信息-E店宝":
                    if ($re_data != "") {
                        $re_data .= ",";
                    }
                    $re_data .= '{"shop_name":"' . $shop_name . '",';
                    $re_data .= '"order_id":"' . $order_id . '",';
                    $re_data .= '"buyer_phone":"' . $buyer_phone . '",';
                    $re_data .= '"buyer_nick":"' . $buyer_nick . '",';
                    $re_data .= '"time_xiadan":"' . $time_xiadan . '",';
                    $re_data .= '"time_pay":"' . $time_pay . '",';
                    $re_data .= '"wl_gs":"' . $wl_gs . '",';
                    $re_data .= '"wl_no":"' . $wl_no . '",';
                    $re_data .= '"adress_name":"' . $adress_name . '",';
                    $re_data .= '"adress_detail":"' . $adress_detail . '",';
                    $re_data .= '"state_order_pingtai":"' . $state_order_pingtai . '",';
                    $re_data .= '"adress_sheng":"' . $adress_sheng . '",';
                    $re_data .= '"adress_shi":"' . $adress_shi . '",';
                    $re_data .= '"buyer_zfb":"' . $buyer_zfb . '"}';
                    break;
            }
        }
    }
    //输出json数据
    $res_data = '{"item_list":[' . $re_data . ']}';
    echo $res_data;

} else {
    require('../../config/config_mysql.php');
    $ein = new ein_mysql();
    $ein->e_mysql_connect();

    $info = '';

    $stime = microtime(true);//统计文件开始执行时间
    $params = json_decode(file_get_contents('php://input'), true);
    $data_arr = $params['data'];

    switch ($case) {
        case "导入订单信息-E店宝":
            foreach ($data_arr as $vv) {
                $shop_name = $vv['shop_name'];
                $order_id = $vv['order_id'];
                $buyer_zfb = $vv['buyer_zfb'];
                $buyer_phone = $vv['buyer_phone'];
                $buyer_nick = $vv['buyer_nick'];
                $time_xiadan = $vv['time_xiadan'];
                $time_pay = $vv['time_pay'];
                $wl_gs = $vv['wl_gs'];
                $wl_no = $vv['wl_no'];
                $adress_name = $vv['adress_name'];
                $adress_detail = $vv['adress_detail'];
                $state_order_pingtai = $vv['state_order_pingtai'];
                $adress_sheng = $vv['adress_sheng'];
                $adress_shi = $vv['adress_shi'];

                if ($shop_name != '') {

                    $ins = "INSERT INTO `tbapi_yibu_orders_info` ";
                    $ins .= "(`shop_name`,`order_id`,`buyer_zfb`,`buyer_phone`,`buyer_nick`,`time_xiadan`,`time_pay`,`wl_gs`,`wl_no`,`adress_name`,`adress_detail`,`state_order_pingtai`,`adress_sheng`,`adress_shi`) VALUES ";
                    $ins .= "('$shop_name','$order_id','$buyer_zfb','$buyer_phone','$buyer_nick','$time_xiadan','$time_pay','$wl_gs','$wl_no','$adress_name','$adress_detail','$state_order_pingtai','$adress_sheng','$adress_shi')";

                    if (mysql_query($ins)) {
                    } else {
                        $up = "UPDATE `tbapi_yibu_orders_info` SET ";
                        $up .= " `shop_name` = '$shop_name',";
                        $up .= " `buyer_zfb` = '$buyer_zfb',";
//                        $up .= " `buyer_phone` = '$buyer_phone',";//不能从EDB更新入手机号，不然手机号中间4位会是 *号
                        $up .= " `buyer_nick` = '$buyer_nick',";
                        $up .= " `time_xiadan` = '$time_xiadan',";
                        $up .= " `time_pay` = '$time_pay',";
                        $up .= " `wl_gs` = '$wl_gs',";
                        $up .= " `wl_no` = '$wl_no',";
                        $up .= " `adress_name` = '$adress_name',";
                        $up .= " `adress_detail` = '$adress_detail',";
                        $up .= " `state_order_pingtai` = '$state_order_pingtai',";
                        $up .= " `adress_sheng` = '$adress_sheng',";
                        $up .= " `adress_shi` = '$adress_shi'";
                        $up .= " WHERE `order_id` = '$order_id'";

                        if (mysql_query($up)) {
                            echo $up;
                            echo "<br>";
                        }
                    }
                }
            }
            break;
    }
    echo '{"percent":' . $params['key'] . '}';
}