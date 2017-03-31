<?php
if (!empty($_FILES)) {
    require('../../config/class/phpexcelreader2.21/excel_reader2.php');
    require('../../config/config_mysql.php');

    $file_name_up = $_FILES['file']['name'];//上传文件名;
    $file_type_arr = explode(".", $file_name_up);
    $file_type = $file_type_arr[1];//获取文件格式
    $file_time = date("Ymd", time());
    switch ($case) {
        case "导入库存销量":
            $file_case = "num_ds_ck_sales7_";
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
                    case "导入库存销量":
                        //现用来更新 库存_电商仓库sku库存,所有sku7天销量,所有sku30天销量
                        if ($data->sheets[0]['cells'][$i][$j] === "条形码") {
                            $bar_code_ds_j = $j;//SKU编码_电商
                        }
                        if ($data->sheets[0]['cells'][$i][$j] === "7天销量") {
                            $sales_volume_7d_j = $j;//7天销量
                        }
                        if ($data->sheets[0]['cells'][$i][$j] === "30天销量") {
                            $sales_volume_30d_j = $j;//30天销量
                        }
                        if ($data->sheets[0]['cells'][$i][$j] === "台账库存") {
                            $num_ds_ck_j = $j;//电商仓库库存
                        }
                        break;
                }
            } else {
                //获取对应数据
                switch ($case) {
                    case "导入库存销量":
                        switch ($j) {
                            case $bar_code_ds_j://SKU编码_电商
                                $bar_code_ds = $data->sheets[0]['cells'][$i][$j];
                                break;
                            case $sales_volume_7d_j://7天销量
                                $sales_volume_7d = $data->sheets[0]['cells'][$i][$j];
                                break;
                            case $sales_volume_30d_j://30天销量
                                $sales_volume_30d = $data->sheets[0]['cells'][$i][$j];
                                break;
                            case $num_ds_ck_j://电商仓库库存
                                $num_ds_ck = $data->sheets[0]['cells'][$i][$j];
                                break;
                        }
                        break;
                }
            }
        }

        //一行数据结束后，更新对应数据
        if ($i != 1 && $bar_code_ds != '') {

            //如果sku不存在 就插入新sku
            $ins = "INSERT INTO `tbapi_yibu_goods_info_sku` (`bar_code_ds`,`bar_code_gs`) VALUES ('$bar_code_ds','$bar_code_ds')";
            mysql_query($ins);

            $up = "UPDATE `tbapi_yibu_goods_info_sku` SET ";
            $up .= "`num_ds_ck` = '$num_ds_ck', ";
            $up .= "`sales_volume_7d` = '$sales_volume_7d', ";
            $up .= "`sales_volume_30d` = '$sales_volume_30d' ";
            $up .= "WHERE `bar_code_ds` = '$bar_code_ds'";
            mysql_query($up);
            $num_ds_ck = $sales_volume_7d = $sales_volume_30d = $bar_code_ds = '';
        }
    }
    //输出json数据
    echo '{"percent":1}';
}