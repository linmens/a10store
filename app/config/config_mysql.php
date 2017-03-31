<?php
/*定义数据库各数据表通用变量开始*/
define("EIN_SQL_SERVER_IP","localhost");//数据库 IP地址
define("EIN_SQL_SERVER_USERNAME","root");//数据库用户名
define("EIN_SQL_SERVER_PASSWORD","");//数据库密码

define("EIN_SQL_SHEET_GOODS","tbapi_yibu_goods");//数据库商品表 表名
define("EIN_SQL_SHEET_WEBSITE_USER","tbapi_yibu_website_user");//登陆用户 表名
/*定义数据库各数据表通用变量结束*/


class ein_mysql
{
    /*通用方法  开始*************/
    function e_mysql_connect()
    {
        /*连接数据库方法*/
        //已优化
        $con = mysql_connect(EIN_SQL_SERVER_IP, EIN_SQL_SERVER_USERNAME, EIN_SQL_SERVER_PASSWORD);
        mysql_select_db("sq_a10store", $con);
        mysql_query('set names utf8');
    }
    function e_html_set_header()
    {
        header("Content-type: text/html; charset=utf-8");
    }
    function e_mysql_search($serch_qs)
    {
        /*搜索数据库方法,返回搜索结果数组*/
        $result = mysql_query($serch_qs);//执行语句
        $result_arr = array();
        while ($row = mysql_fetch_assoc($result)) {
            $result_arr[] = $row;
        }
        return $result_arr;//返回数组
    }
}