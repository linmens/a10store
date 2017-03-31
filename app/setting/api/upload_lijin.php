<?php
if (!empty($_FILES)) {
    require('../../config/class/phpexcelreader2.21/excel_reader2.php');

    $file_name_up = $_FILES['file']['name'];//上传文件名;
    $file_type_arr = explode(".", $file_name_up);
    $file_type = $file_type_arr[1];//获取文件格式
    $file_time = date("Ymd", time());
    switch ($case) {
        case "导入大仓库存":
            $file_case = "num_gs_ck_";
            break;
        case "导入商场库存":
            $file_case = "num_gs_shop_";
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
                    case "导入大仓库存":
                    case "导入商场库存":
                        $data_title = $data->sheets[0]['cells'][$i][$j];
                        switch ($data_title) {
                            case "货号":
                                $outer_id_gs_j = $j;
                                break;
                            case "颜色编号":
                                $goods_color_no_gs_j = $j;
                                break;
                            case "数量":
                                $num_gs_shop_all_j = $j; //库存_商场
                                break;
                            case "M":
                                $size_no_m_j = $j;
                                break;
                            case "L":
                                $size_no_l_j = $j;
                                break;
                            case "XL":
                                $size_no_xl_j = $j;
                                break;
                            case "2XL":
                                $size_no_2xl_j = $j;
                                break;
                            case "3XL":
                                $size_no_3xl_j = $j;
                                break;
                            case "4XL":
                                $size_no_4xl_j = $j;
                                break;
                        }
                        break;
                }
            } else {
                //获取对应数据
                switch ($case) {
                    case "导入大仓库存":
                    case "导入商场库存":
                        switch ($j) {
                            case $outer_id_gs_j://商品编码_公司_数据
                                $outer_id_gs = $data->sheets[0]['cells'][$i][$j];
                                break;
                            case $goods_color_no_gs_j://商品颜色编码_公司_数据
                                $goods_color_no_gs = $data->sheets[0]['cells'][$i][$j];
                                break;
                            case $num_gs_shop_all_j:
                                $num_gs_shop = $data->sheets[0]['cells'][$i][$j];
                                break;
                            case $size_no_m_j:
                                $size_no_m = $data->sheets[0]['cells'][$i][$j];
                                break;
                            case $size_no_l_j:
                                $size_no_l = $data->sheets[0]['cells'][$i][$j];
                                break;
                            case $size_no_xl_j:
                                $size_no_xl = $data->sheets[0]['cells'][$i][$j];
                                break;
                            case $size_no_2xl_j:
                                $size_no_2xl = $data->sheets[0]['cells'][$i][$j];
                                break;
                            case $size_no_3xl_j:
                                $size_no_3xl = $data->sheets[0]['cells'][$i][$j];
                                break;
                            case $size_no_4xl_j:
                                $size_no_4xl = $data->sheets[0]['cells'][$i][$j];
                                break;
                        }
                        break;
                }
            }
        }


        //一行数据结束后，总结为一个json数据组
        if ($i != 1) {
            switch ($case) {
                case "导入大仓库存":
                case "导入商场库存":
                    $bar_code_gs = $outer_id_gs . $goods_color_no_gs;

                    if ($re_data != "") {
                        $re_data .= ",";
                    }


                    if ($size_no_m == '') {
                        $size_no_m = 0;//表格中文本为空 修改为为0的不传输，统一设置成0
                        $re_data .= '{"bar_code_gs":"' . $bar_code_gs . '02","sku_num":"' . $size_no_m . '"},';
                    } else {
                        $re_data .= '{"bar_code_gs":"' . $bar_code_gs . '02","sku_num":"' . $size_no_m . '"},';
                    }

                    if ($size_no_l == '') {
                        $size_no_l = 0;
                        $re_data .= '{"bar_code_gs":"' . $bar_code_gs . '03","sku_num":"' . $size_no_l . '"},';
                    } else {
                        $re_data .= '{"bar_code_gs":"' . $bar_code_gs . '03","sku_num":"' . $size_no_l . '"},';
                    }

                    if ($size_no_xl == '') {
                        $size_no_xl = 0;
                        $re_data .= '{"bar_code_gs":"' . $bar_code_gs . '04","sku_num":"' . $size_no_xl . '"},';
                    } else {
                        $re_data .= '{"bar_code_gs":"' . $bar_code_gs . '04","sku_num":"' . $size_no_xl . '"},';
                    }

                    if ($size_no_2xl == '') {
                        $size_no_2xl = 0;
                        $re_data .= '{"bar_code_gs":"' . $bar_code_gs . '05","sku_num":"' . $size_no_2xl . '"},';
                    } else {
                        $re_data .= '{"bar_code_gs":"' . $bar_code_gs . '05","sku_num":"' . $size_no_2xl . '"},';
                    }

                    if ($size_no_3xl == '') {
                        $size_no_3xl = 0;
                        $re_data .= '{"bar_code_gs":"' . $bar_code_gs . '06","sku_num":"' . $size_no_3xl . '"},';
                    } else {
                        $re_data .= '{"bar_code_gs":"' . $bar_code_gs . '06","sku_num":"' . $size_no_3xl . '"},';
                    }

                    if ($size_no_4xl == '') {
                        $size_no_4xl = 0;
                        $re_data .= '{"bar_code_gs":"' . $bar_code_gs . '07","sku_num":"' . $size_no_4xl . '"}';
                    } else {
                        $re_data .= '{"bar_code_gs":"' . $bar_code_gs . '07","sku_num":"' . $size_no_4xl . '"}';
                    }
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

    $stime = microtime(true);//统计文件开始执行时间
    $params = json_decode(file_get_contents('php://input'), true);
    $data_arr = $params['data'];

    switch ($case) {
        case "导入大仓库存":
            foreach ($data_arr as $vv) {
                $bar_code_gs = $vv['bar_code_gs'];
                $num_gs_ck = $vv['sku_num'];

                $qs = "UPDATE `tbapi_yibu_goods_info_sku` SET `num_gs_ck` = '$num_gs_ck' WHERE `bar_code_gs` = '$bar_code_gs'";
                if (mysql_query($qs)) {
                } else {
                    echo "更新失败";
                }
            }
            break;
        case "导入商场库存":
            foreach ($params['data'] as $k => $vv) {
                $bar_code_gs = $vv['bar_code_gs'];
                $num_gs_shop = $vv['sku_num'];

                $qs = "UPDATE `tbapi_yibu_goods_info_sku` SET `num_gs_shop` = '$num_gs_shop' WHERE `bar_code_gs` = '$bar_code_gs'";
                if (mysql_query($qs)) {
                } else {
                    echo "更新失败";
                }
            }
            break;
    }
    echo '{"percent":'.$params['key'].'}';

}

