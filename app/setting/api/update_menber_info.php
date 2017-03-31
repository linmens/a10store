<?php
//从sku表中提取商品库存，更新至商品库
require('../../config/config_mysql.php');
$ein = new ein_mysql();
$ein->e_mysql_connect();
$ein->e_html_set_header();

$params = json_decode(file_get_contents('php://input'), true);
$data_arr = $params['check'];


if ($data_arr == '') {
    //如果post数据为空，就执行 返回商品总list
    $select = "SELECT * FROM `tbapi_yibu_orders_info`";
    $data_arr = $ein->e_mysql_search($select);

    foreach ($data_arr as $v22) {
        $buyer_nick = $v22['buyer_nick'];
        $buyer_phone = $v22['buyer_phone'];
        $adress_sheng = $v22['adress_sheng'];
        $adress_shi = $v22['adress_shi'];

        if ($re_data != '') {
            $re_data .= ',';
        }
        $re_data .= '{"buyer_nick":"' . $buyer_nick . '","buyer_phone":"' . $buyer_phone . '","adress_sheng":"' . $adress_sheng . '","adress_shi":"' . $adress_shi . '"}';
    }

    //输出json数据
    $res_data = '{"item_list":[' . $re_data . ']}';
    echo $res_data;
} else {
    //如果post数据不为空，开始更新sku库存合计 到商品表
    $data = $params['data'];

    $qs = "SELECT `buyer_nick` FROM `tbapi_yibu_orders_shuadan`";
    $data_sd = $ein->e_mysql_search($qs);

    foreach ($data as $vv) {
        $buyer_nick = $vv['buyer_nick'];
        $buyer_phone = $vv['buyer_phone'];
        $adress_sheng = $vv['adress_sheng'];
        $adress_shi = $vv['adress_shi'];

        $ck = "NO";

        foreach($data_sd as $v2){
            if($buyer_nick == $v2['buyer_nick']){
                $ck = "YES";
            }
        }

        if($ck=="YES"){
            $state_shuashou = "是";
        }else{
            $state_shuashou = "否";
        }

        $ins = "INSERT INTO `tbapi_yibu_menber_info` (`buyer_nick`,`buyer_phone`,`adress_sheng`,`adress_shi`,`state_shuashou`) VALUES ('$buyer_nick','$buyer_phone','$adress_sheng','$adress_shi','$state_shuashou')";
        mysql_query($ins);

        $up = "UPDATE `tbapi_yibu_menber_info` SET `buyer_phone` = '$buyer_phone', `adress_sheng`='$adress_sheng',`adress_shi` = '$adress_shi', `state_shuashou` = '$state_shuashou' WHERE `buyer_nick` = '$buyer_nick'";
        mysql_query($up);
    }
    echo '{"percent":'.$params['key'].'}';
}