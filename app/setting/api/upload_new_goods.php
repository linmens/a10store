<?php
if (!empty($_FILES)) {
    require('../../config/class/phpexcelreader2.21/excel_reader2.php');

    $file_name_up = $_FILES['file']['name'];//上传文件名;
    $file_type_arr = explode(".", $file_name_up);
    $file_type = $file_type_arr[1];//获取文件格式
    $file_time = date("Ymd", time());
    switch ($case) {
        case "导入新品信息":
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
                    case "导入新品信息":
                        if ($data->sheets[0]['cells'][$i][$j] === "货号") {
                            $outer_id_gs_j = $j;//产品编号_公司
                        }
                        if ($data->sheets[0]['cells'][$i][$j] === "颜色说明") {
                            $goods_color_j = $j;//颜色说明_公司
                        }
                        if ($data->sheets[0]['cells'][$i][$j] === "颜色编号") {
                            $goods_color_no_j = $j;//颜色编号_公司
                        }
                        if ($data->sheets[0]['cells'][$i][$j] === "年份") {
                            $goods_year_j = $j;//年份
                        }
                        if ($data->sheets[0]['cells'][$i][$j] === "季节") {
                            $goods_season_j = $j;//季节
                        }
                        if ($data->sheets[0]['cells'][$i][$j] === "类别") {
                            $goods_class_gs_j = $j;//类别
                        }
                        if ($data->sheets[0]['cells'][$i][$j] === "吊牌价") {
                            $price_gs_j = $j;//吊牌价
                        }
                        break;
                }
            } else {
                //获取对应数据
                switch ($case) {
                    case "导入新品信息":
                        switch ($j) {
                            case $outer_id_gs_j://产品编号_公司
                                $outer_id_gs = $data->sheets[0]['cells'][$i][$j];
                                break;
                            case $goods_color_j://颜色说明_公司
                                $goods_color = $data->sheets[0]['cells'][$i][$j];
                                break;
                            case $goods_color_no_j://颜色编号_公司
                                $goods_color_no = $data->sheets[0]['cells'][$i][$j];
                                break;
                            case $goods_year_j://年份
                                $goods_year = $data->sheets[0]['cells'][$i][$j];
                                break;
                            case $goods_season_j://季节
                                $goods_season = $data->sheets[0]['cells'][$i][$j];
                                break;
                            case $goods_class_gs_j://类别
                                $goods_class_gs = $data->sheets[0]['cells'][$i][$j];
                                break;
                            case $price_gs_j://吊牌价
                                $price_gs = $data->sheets[0]['cells'][$i][$j];
                                break;
                        }
                        break;
                }
            }
        }

        //一行数据结束后，总结为一个json数据组
        if ($i != 1) {
            switch ($case) {
                case "导入新品信息":
                    if ($re_data != "") {
                        $re_data .= ",";
                    }
                    $re_data .= '{"outer_id_gs":"' . $outer_id_gs . '","goods_color_gs":"' . $goods_color . '","goods_color_no_gs":"' . $goods_color_no . '","goods_year":"' . $goods_year . '","goods_season":"' . $goods_season . '","goods_class_gs":"' . $goods_class_gs . '","price_gs":"' . $price_gs . '"}';
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
        case "导入新品信息":
            foreach ($data_arr as $vv) {
                $outer_id_gs = $vv['outer_id_gs'];
                $goods_color_gs = $vv['goods_color_gs'];
                $goods_color_no_gs = $vv['goods_color_no_gs'];
                $goods_year = $vv['goods_year'];
                $goods_season = $vv['goods_season'];
                $goods_class_gs = $vv['goods_class_gs'];
                $price_gs = $vv['price_gs'];
                $un_id = md5($outer_id_gs.$goods_class_gs.$goods_color_gs);

                $ins = "INSERT INTO `tbapi_yibu_goods_info` ";
                $ins .= "(`un_id`,`outer_id_gs`,`goods_class_gs`,`goods_color_gs`,`goods_color_no_gs`,`goods_season`,`price_gs`,`goods_year`) VALUES ";
                $ins .= "('$un_id','$outer_id_gs','$goods_class_gs','$goods_color_gs','$goods_color_no_gs','$goods_season','$price_gs','$goods_year')";

                mysql_query($ins);

            }
            break;
    }
    echo '{"percent":' . $params['key'] . '}';
}