<?php
if (!empty($_FILES)) {
    require('../../config/class/phpexcelreader2.21/excel_reader2.php');

    $file_name_up = $_FILES['file']['name'];//上传文件名;
    $file_type_arr = explode(".", $file_name_up);
    $file_type = $file_type_arr[1];//获取文件格式
    $file_time = date("Ymd", time());

    switch ($case) {
        case "导入订单_天猫":
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
                    case "导入订单_天猫":
                        if ($data->sheets[0]['cells'][$i][$j] === "订单编号") {
                            $order_id_j = $j;//外部平台单号
                        }
                        if ($data->sheets[0]['cells'][$i][$j] === "联系手机") {
                            $buyer_phone_j = $j;//买家_手机
                        }
                        if ($data->sheets[0]['cells'][$i][$j] === "订单创建时间") {
                            $time_xiadan_j = $j;//买家_下单时间
                        }
                        break;
                }
            } else {
                //获取对应数据
                switch ($case) {
                    case "导入订单_天猫":
                        switch ($j) {
                            case $order_id_j://外部平台单号
                                $order_id = $data->sheets[0]['cells'][$i][$j];
                                break;
                            case $buyer_phone_j://买家_手机
                                $buyer_phone = $data->sheets[0]['cells'][$i][$j];
                                break;
                            case $time_xiadan_j://买家_下单时间
                                $time_xiadan = $data->sheets[0]['cells'][$i][$j];
                                break;
                        }
                        break;
                }
            }
        }

        //一行数据结束后，总结为一个json数据组
        if ($i != 1) {
            switch ($case) {
                case "导入订单_天猫":
                    if ($re_data != "") {
                        $re_data .= ",";
                    }
                    $re_data .= '{"shop_name":"yb_tm",';
                    $re_data .= '"order_id":"' . $order_id . '",';
                    $re_data .= '"buyer_phone":"' . $buyer_phone . '",';
                    $re_data .= '"time_xiadan":"' . $time_xiadan . '"}';
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
        case "导入订单_天猫":
            foreach ($data_arr as $vv) {
                $shop_name = $vv['shop_name'];
                $order_id = $vv['order_id'];
                $buyer_phone = $vv['buyer_phone'];
                $time_xiadan = $vv['time_xiadan'];

                if ($shop_name != '' && $order_id != '') {

                    $ins = "INSERT INTO `tbapi_yibu_orders_info` ";
                    $ins .= "(`shop_name`,`order_id`,`buyer_phone`,`time_xiadan`) VALUES ";
                    $ins .= "('$shop_name','$order_id','$buyer_phone','$time_xiadan')";

                    if (mysql_query($ins)) {
                    } else {
                        $up = "UPDATE `tbapi_yibu_orders_info` SET ";
                        $up .= " `buyer_phone` = '$buyer_phone',";//手机号只能从淘宝导入
                        $up .= " `time_xiadan` = '$time_xiadan'";//更新订单时间 临时使用
                        $up .= " WHERE `order_id` = '$order_id' AND `shop_name` = '$shop_name'";
                        if (mysql_query($up)) {
                        }
                    }
                }
            }
            break;
    }
    echo '{"percent":' . $params['key'] . '}';
}