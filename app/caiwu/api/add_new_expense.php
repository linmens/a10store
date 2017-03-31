<?php
require('../../config/config_mysql.php');

$ein = new ein_mysql();
$ein->e_mysql_connect();

$class = $_GET['f'];//费用项目
$shop = $_GET['shop'];//店铺名
$all_price = $_GET['price'];//金额
$class_detail = $_GET['shuoming'];//项目明细
$up_time = $_GET['date'];//提交报销时间
$up_time_arr = explode(" ", $up_time);
$up_time = $up_time_arr[0];


$user_ins = $_GET['user'];//申请人

$username_cookie = $_COOKIE['username'];
$username_level_cookie = $_COOKIE['username_level'];

if ($username_cookie == $user_ins) {
    //登陆用户与上传用户相同才执行下面代码
    $sel = "SELECT * FROM `tbapi_yibu_expense_list` ORDER BY `id` DESC LIMIT 0,1";
    $id = $ein->e_mysql_search($sel);
    $id= $id[0]['id'];
    $id = $id + 1;
    $img_src = "http://www.a10store.com/TB_API/app/caiwu/api/img/list_expense/".$id.'.jpg';
    $time_ins = date('Y-m-d H:i:s', time());//获得当前时间 作为上传时间
    $ins = "INSERT INTO `tbapi_yibu_expense_list` ";
    $ins .= "(`id`,`class`,`shop`,`all_price`,`up_time`,`user_ins`,`state`,`img_src`,`class_detail`,`time_ins`) VALUES ";
    $ins .= "('$id','$class','$shop','$all_price','$up_time','$user_ins','未打款','$img_src','$class_detail','$time_ins')";

    if (mysql_query($ins)) {
        if (!empty($_FILES)) {
            $file_name_up = $_FILES['file']['name'];//上传文件名;
            $file_type_arr = explode(".", $file_name_up);
            $file_type = $file_type_arr[1];//获取文件格式

            $file_name = $id.'.'.$file_type;//保存文件名
            $tempPath = $_FILES['file']['tmp_name'];//文件临时保存目录
            $uploadPath = dirname(__FILE__) . DIRECTORY_SEPARATOR . 'img' . DIRECTORY_SEPARATOR . 'list_expense' . DIRECTORY_SEPARATOR . $file_name;//文件保存路径
            move_uploaded_file($tempPath, $uploadPath);//把文件从临时目录移动到指定文件夹 ******
        }
    }

}
