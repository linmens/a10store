<?php

require('../../config/config_mysql.php');

$ein = new ein_mysql();
$ein->e_mysql_connect();

$qs = "SELECT * FROM `tbapi_yibu_orders_info_goods` WHERE `bar_code_ds` LIKE '%A%' AND `outer_id_ds` = ''";

$data = $ein->e_mysql_search($qs);

foreach($data as $v){

    $bar_code_ds = $v['bar_code_ds'];
    $sp_arr = str_split($bar_code_ds);

    $outer_id_ds = $sp_arr[0].$sp_arr[1].$sp_arr[2].$sp_arr[3].$sp_arr[4].$sp_arr[5].$sp_arr[6];

//    $up = "UPDATE `tbapi_yibu_orders_info_goods` SET `goods_season` = '$goods_season', `goods_year` = '$goods_year', `goods_class_gs` = '$goods_class_gs' WHERE `bar_code_ds` = '$bar_code_ds'";
    $up = "UPDATE `tbapi_yibu_orders_info_goods` SET `outer_id_ds` = '$outer_id_ds' WHERE `bar_code_ds` = '$bar_code_ds'";

//    echo $up;
//    echo "<br>";

    if(mysql_query($up)){
        echo "更新成功";
    }else{
        echo "更新失败";
    }

}