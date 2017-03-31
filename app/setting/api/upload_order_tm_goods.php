<?php
if (!empty($_FILES)) {
    require('../../config/class/phpexcelreader2.21/excel_reader2.php');

    $file_name_up = $_FILES['file']['name'];//上传文件名;
    $file_type_arr = explode(".", $file_name_up);
    $file_type = $file_type_arr[1];//获取文件格式
    $file_time = date("Ymd", time());

    switch ($case) {
        case "导入订单商品_天猫":
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
                    case "导入订单商品_天猫":
                        if ($data->sheets[0]['cells'][$i][$j] === "订单编号") {
                            $order_id_j = $j;//外部平台单号
                        }
                        if ($data->sheets[0]['cells'][$i][$j] === "价格") {
                            $price_j = $j;//商品价格
                        }
                        if ($data->sheets[0]['cells'][$i][$j] === "购买数量") {
                            $num_j = $j;//购买数量
                        }
                        if ($data->sheets[0]['cells'][$i][$j] === "商家编码") {
                            $bar_code_ds_j = $j;//商家编码_电商
                        }
                        break;
                }
            } else {
                //获取对应数据
                switch ($case) {
                    case "导入订单商品_天猫":
                        switch ($j) {
                            case $order_id_j://外部平台单号
                                $order_id = $data->sheets[0]['cells'][$i][$j];
                                break;
                            case $num_j://购买数量
                                $num = $data->sheets[0]['cells'][$i][$j];
                                break;
                            case $bar_code_ds_j://商家编码_电商
                                $bar_code_ds = $data->sheets[0]['cells'][$i][$j];
                                break;
                        }
                        break;
                }
            }
        }

        //一行数据结束后，总结为一个json数据组
        if ($i != 1) {
            switch ($case) {
                case "导入订单商品_天猫":
                    if ($re_data != "") {
                        $re_data .= ",";
                    }
                    $re_data .= '{"shop_name":"yb_tm",';
                    $re_data .= '"order_id":"' . $order_id . '",';
                    $re_data .= '"num":"' . $num . '",';
                    $re_data .= '"bar_code_ds":"' . $bar_code_ds . '"}';
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
        case "导入订单商品_天猫":
            foreach ($data_arr as $vv) {
                $shop_name = $vv['shop_name'];
                $order_id = $vv['order_id'];
                $bar_code_ds = $vv['bar_code_ds'];
                $num = $vv['num'];

                $uid = $shop_name . $order_id . $bar_code_ds . $num;
                $uid = md5($uid);

                if ($shop_name != '' && $order_id != '') {

                    $is_order_id = '';

                    $sear = "SELECT * FROM `tbapi_yibu_orders_info` WHERE `order_id` = '$order_id' AND `shop_name` = '$shop_name'";
                    $is_data = $ein->e_mysql_search($sear);

                    $is_order_id = $is_data[0]['order_id'];

                    if ($is_order_id != '') {

                        $sss = "SELECT * FROM `tbapi_yibu_goods_info_sku` WHERE `bar_code_ds` = '$bar_code_ds'";
                        $sku_info = $ein->e_mysql_search($sss);
                        $goods_season = $sku_info[0]['goods_season'];
                        $goods_year = $sku_info[0]['goods_year'];
                        $goods_class_gs = $sku_info[0]['goods_class_gs'];
                        $outer_id_ds = $sku_info[0]['outer_id_ds'];


                        $ins = "INSERT INTO `tbapi_yibu_orders_info_goods` ";
                        $ins .= "(`shop_name`,`uid`,`order_id`,`bar_code_ds`,`num`,`goods_season`,`goods_year`,`goods_class_gs`,`outer_id_ds`) VALUES ";
                        $ins .= "('$shop_name','$uid','$order_id','$bar_code_ds','$num','$goods_season','$goods_year','$goods_class_gs','$outer_id_ds')";

                        if(mysql_query($ins)){
                            echo "<br>";
                            echo $ins;
                            echo "插入成功";
                            echo "<br>";

                        }else{
                            echo "<br>";
                            echo "插入失败";
                            echo $ins;
                            echo "<br>";


                            $update = "UPDATE `tbapi_yibu_orders_info_goods` SET ";
                            $update .= " `goods_season` = '$goods_season',";
                            $update .= " `goods_year` = '$goods_year',";
                            $update .= " `goods_class_gs` = '$goods_class_gs',";
                            $update .= " `outer_id_ds` = '$outer_id_ds'";
                            $update .= "WHERE `order_id` = '$order_id' AND `bar_code_ds` = '$bar_code_ds'";
                            if(mysql_query($update)){
                                echo "<br>";
                                echo "更新成功";
                                echo $update;
                                echo "<br>";
                            }else{
                                echo "更新失败";
                                echo "<br>";
                                echo $update;
                                echo "<br>";
                            }
                        }
                    }

                }
            }
            break;
    }
    echo '{"percent":' . $params['key'] . '}';
}