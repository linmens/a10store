<?php
require('../../config/config_mysql.php');


$ein = new ein_mysql();
$ein->e_html_set_header();
$ein->e_mysql_connect();

$params = json_decode(file_get_contents('php://input'), true);
$username = strtolower($params['username']);
$password = $params['password'];

$qs = "SELECT * FROM `tbapi_yibu_website_user` WHERE `username` = '$username' AND `password` = '$password'";
$data = $ein->e_mysql_search($qs);

$username_sql = strtolower($data[0]['username']);
$password_sql = $data[0]['password'];
$username_level = $data[0]['level'];

if($username == $username_sql && $password === $password_sql){
    $mes = "登陆成功";
    $data_info = "success";


}else{
    $mes =  "登陆失败";
    $data_info = "failure";
}



if($all_goods != ""){
    $all_goods .= ",";
}
$data = '{"data_info":"'. $data_info .'","mes":"'. $mes .'","username":"'. $username_sql .'","username_level":"'. $username_level .'"}';
echo $data;