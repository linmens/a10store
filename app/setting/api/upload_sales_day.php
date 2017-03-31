<?php
if (!empty($_FILES)) {
    require('../../config/class/phpexcelreader2.21/excel_reader2.php');

    $file_name_up = $_FILES['file']['name'];//上传文件名;
    $file_type_arr = explode(".", $file_name_up);
    $file_type = $file_type_arr[1];//获取文件格式
    $file_time = date("Ymd", time());
    switch ($case) {
        case "导入每日销售":
            $file_case = "sales_day_";
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
                    case "导入每日销售":
                        if ($data->sheets[0]['cells'][$i][$j] === "店铺名称") {
                            $shop_name_j = $j;
                        }
                        if ($data->sheets[0]['cells'][$i][$j] === "验货日期") {
                            $time_date_j = $j;
                        }
                        if ($data->sheets[0]['cells'][$i][$j] === "净销售金额sum") {
                            $sales_j = $j;
                        }
                        break;
                }
            } else {
                //获取对应数据
                switch ($case) {
                    case "导入每日销售":
                        switch ($j) {
                            case $shop_name_j:
                                $shop_name = $data->sheets[0]['cells'][$i][$j];
                                break;
                            case $time_date_j:
                                $time_date = $data->sheets[0]['cells'][$i][$j];
                                break;
                            case $sales_j:
                                $sales = $data->sheets[0]['cells'][$i][$j];
                                break;
                        }
                        break;
                }
            }
        }

        //一行数据结束后，总结为一个json数据组
        if ($i != 1) {
            switch ($case) {
                case "导入每日销售":
                    if ($re_data != "") {
                        $re_data .= ",";
                    }
                    $re_data .= '{"shop_name":"' . $shop_name . '","time_date":"' . $time_date . '","sales":"' . $sales . '"}';
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
        case "导入每日销售":
            foreach ($data_arr as $vv) {

                $shop_name = $vv['shop_name'];
                $date_time_int = $vv['time_date'];
                $sales = $vv['sales'];

                switch ($shop_name) {
                    case "依布服饰旗舰店—天猫":
                        $shop_name = "shop_yibu_tm";
                        break;
                    case "依布专卖店—C店":
                        $shop_name = "shop_yibu_tb";
                        break;
                    case "依布旗舰店—1号":
                        $shop_name = "shop_yibu_yhd";
                        break;
                    case "科尚服饰旗舰店—天猫":
                        $shop_name = "shop_ks_tm";
                        break;
                    case "科尚服饰女装店—C店":
                        $shop_name = "shop_ks_tb";
                        break;
                    case "科尚服饰旗舰店—1号":
                        $shop_name = "shop_ks_yhd";
                        break;
                    default:
                        $shop_name = "";

                }
                if ($shop_name != '') {
                    $ins = "INSERT INTO `tbapi_yibu_sales_info` (`date_time_int`) VALUES ('$date_time_int')";
                    mysql_query($ins);

                    $qs = "UPDATE `tbapi_yibu_sales_info` SET `$shop_name` = '$sales' WHERE `date_time_int` = '$date_time_int'";
                    mysql_query($qs);
                }
            }
            break;
    }
    echo '{"percent":' . $params['key'] . '}';
}