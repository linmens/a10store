<?php
if (!empty($_FILES)) {
    require('../../config/class/phpexcelreader2.21/excel_reader2.php');

    $file_name_up = $_FILES['file']['name'];//上传文件名;
    $file_type_arr = explode(".", $file_name_up);
    $file_type = $file_type_arr[1];//获取文件格式
    $file_time = date("Ymd", time());
    switch ($case) {
        case "导入总销量":
            $file_case = "sales_volume_all_";
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
                    case "导入总销量":
                        if ($data->sheets[0]['cells'][$i][$j] === "产品编号") {
                            $outer_id_ds_j = $j;//产品编号_电商
                        }
                        if ($data->sheets[0]['cells'][$i][$j] === "规格") {
                            $size_color_j = $j;
                        }
                        if ($data->sheets[0]['cells'][$i][$j] === "净销售数量sum") {
                            $sales_volume_all_j = $j;
                        }
                        break;
                }
            } else {
                //获取对应数据
                switch ($case) {
                    case "导入总销量":
                        switch ($j) {
                            case $outer_id_ds_j:
                                $outer_id_ds = $data->sheets[0]['cells'][$i][$j];
                                break;
                            case $size_color_j:
                                $size_color = $data->sheets[0]['cells'][$i][$j];
                                break;
                            case $sales_volume_all_j:
                                $sales_volume_all = $data->sheets[0]['cells'][$i][$j];
                                break;
                        }
                        break;
                }
            }
        }

        //一行数据结束后，总结为一个json数据组
        if ($i != 1) {
            switch ($case) {
                case "导入总销量":
                    if ($re_data != "") {
                        $re_data .= ",";
                    }
                    $size_color_arr = explode("_",$size_color);
                    $goods_color_gs = $size_color_arr[0];
                    $goods_size_gs = $size_color_arr[1];

                    $re_data .= '{"outer_id_ds":"' . $outer_id_ds . '","goods_color_gs":"' . $goods_color_gs . '","goods_size_gs":"' . $goods_size_gs . '","sales_volume_all":"' . $sales_volume_all . '"}';
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
        case "导入总销量":
            foreach ($data_arr as $vv) {
                $outer_id_ds = $vv['outer_id_ds'];
                $goods_color_gs = $vv['goods_color_gs'];
                $goods_size_gs = $vv['goods_size_gs'];
                $sales_volume_all = $vv['sales_volume_all'];

                $update = "UPDATE `tbapi_yibu_goods_info_sku` SET `sales_volume_all` = '$sales_volume_all' WHERE `outer_id_ds` = '$outer_id_ds' AND `goods_color_gs` = '$goods_color_gs' AND `goods_size_gs` = '$goods_size_gs'";
                mysql_query($update);
            }
            break;
    }
    echo '{"percent":' . $params['key'] . '}';
}