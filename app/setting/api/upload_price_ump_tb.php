<?php
if (!empty($_FILES)) {
    require('../../config/class/phpexcelreader2.21/excel_reader2.php');

    $file_name_up = $_FILES['file']['name'];//上传文件名;
    $file_type_arr = explode(".", $file_name_up);
    $file_type = $file_type_arr[1];//获取文件格式
    $file_time = date("Ymd", time());
    switch ($case) {
        case "导入促销价_淘宝":
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
                    case "导入促销价_淘宝":
                        if ($data->sheets[0]['cells'][$i][$j] === "商家编码") {
                            $outer_id_ds_j = $j;//产品编号_电商
                        }
                        if ($data->sheets[0]['cells'][$i][$j] === "最终价") {
                            $goods_price_ump_tb_j = $j;//促销价_淘宝
                        }
                        if ($data->sheets[0]['cells'][$i][$j] === "淘宝Id") {
                            $num_iid_tb_j = $j;//宝贝ID_淘宝
                        }
                        if ($data->sheets[0]['cells'][$i][$j] === "宝贝状态") {
                            $state_onsale_tb_j = $j;//宝贝状态
                        }
                        break;
                }
            } else {
                //获取对应数据
                switch ($case) {
                    case "导入促销价_淘宝":
                        switch ($j) {
                            case $outer_id_ds_j://产品编号_电商
                                $outer_id_ds = $data->sheets[0]['cells'][$i][$j];
                                break;
                            case $goods_price_ump_tb_j://促销价_淘宝
                                $goods_price_ump_tb = $data->sheets[0]['cells'][$i][$j];
                                break;
                            case $num_iid_tb_j://宝贝ID_淘宝
                                $num_iid_tb = $data->sheets[0]['cells'][$i][$j];
                                break;
                            case $state_onsale_tb_j://宝贝状态
                                $state_onsale_tb = $data->sheets[0]['cells'][$i][$j];
                                switch($state_onsale_tb){
                                    case "出售中":
                                        $state_onsale_tb = "Y";
                                        break;
                                    case "仓库中":
                                        $state_onsale_tb = "N";
                                        break;
                                }
                                break;
                        }
                        break;
                }
            }
        }

        //一行数据结束后，总结为一个json数据组
        if ($i != 1) {
            switch ($case) {
                case "导入促销价_淘宝":
                    if ($re_data != "") {
                        $re_data .= ",";
                    }
                    $re_data .= '{"outer_id_ds":"' . $outer_id_ds . '",';
                    $re_data .= '"goods_price_ump_tb":"' . $goods_price_ump_tb . '",';
                    $re_data .= '"num_iid_tb":"' . $num_iid_tb . '",';
                    $re_data .= '"state_onsale_tb":"' . $state_onsale_tb . '"}';
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
        case "导入促销价_淘宝":
            foreach ($data_arr as $vv) {
                $outer_id_ds = $vv['outer_id_ds'];
                $goods_price_ump_tb = $vv['goods_price_ump_tb'];
                $num_iid_tb = $vv['num_iid_tb'];
                $state_onsale_tb = $vv['state_onsale_tb'];

                $up = "UPDATE `tbapi_yibu_goods_info` SET ";
                $up .= "`num_iid_tb` = '$num_iid_tb',";
                $up .= " `goods_price_ump_tb` = '$goods_price_ump_tb', ";
                $up .= " `state_onsale_tb` = '$state_onsale_tb' ";
                $up .= "WHERE `outer_id_ds` = '$outer_id_ds'";

                if($outer_id_ds!='' && $goods_price_ump_tm!=''){
                    mysql_query($up);
                }

            }
            break;
    }
    echo '{"percent":' . $params['key'] . '}';
}