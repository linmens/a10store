<?php
/**
 * Created by PhpStorm.
 * User: Ein
 * Date: 17/3/8
 * Time: 下午5:11
 */
require('../../config/config_mysql.php');
$ein = new ein_mysql();
$ein->e_mysql_connect();

$goods_season = $_GET['time'];
switch($goods_season){
    case "春":
        $goods_season = "春装";
        break;
    case "夏":
        $goods_season = "夏装";
        break;
    case "秋":
        $goods_season = "秋装";
        break;
    case "冬":
        $goods_season = "冬装";
        break;
}

$qs = "SELECT * FROM `tbapi_yibu_orders_info_goods` WHERE `goods_season` = '$goods_season'";
$data = $ein->e_mysql_search($qs);

$year_2017_1 = 0;
$year_2016_1 = 0;
$year_2015_1 = 0;
$year_2014_1 = 0;
$year_2013_1 = 0;
$year_2012_1 = 0;
$year_2011_1 = 0;

$year_2017_2 = $year_2016_2 = $year_2015_2 = $year_2014_2 = $year_2013_2 = $year_2012_2 = $year_2011_2 =  0;
$year_2017_3 = $year_2016_3 = $year_2015_3 = $year_2014_3 = $year_2013_3 = $year_2012_3 = $year_2011_3 =  0;
$year_2017_4 = $year_2016_4 = $year_2015_4 = $year_2014_4 = $year_2013_4 = $year_2012_4 = $year_2011_4 =  0;
$year_2017_5 = $year_2016_5 = $year_2015_5 = $year_2014_5 = $year_2013_5 = $year_2012_5 = $year_2011_5 =  0;
$year_2017_6 = $year_2016_6 = $year_2015_6 = $year_2014_6 = $year_2013_6 = $year_2012_6 = $year_2011_6 =  0;
$year_2017_7 = $year_2016_7 = $year_2015_7 = $year_2014_7 = $year_2013_7 = $year_2012_7 = $year_2011_7 =  0;
$year_2017_8 = $year_2016_8 = $year_2015_8 = $year_2014_8 = $year_2013_8 = $year_2012_8 = $year_2011_8 =  0;
$year_2017_9 = $year_2016_9 = $year_2015_9 = $year_2014_9 = $year_2013_9 = $year_2012_9 = $year_2011_9 =  0;
$year_2017_10 = $year_2016_10 = $year_2015_10 = $year_2014_10 = $year_2013_10 = $year_2012_10 = $year_2011_10 =  0;
$year_2017_11 = $year_2016_11 = $year_2015_11 = $year_2014_11 = $year_2013_11 = $year_2012_11 = $year_2011_11 =  0;
$year_2017_12 = $year_2016_12 = $year_2015_12 = $year_2014_12 = $year_2013_12 = $year_2012_12 = $year_2011_12 =  0;
$year_2017_13 = $year_2016_13 = $year_2015_13 = $year_2014_13 = $year_2013_13 = $year_2012_13 = $year_2011_13 =  0;
$year_2017_14 = $year_2016_14 = $year_2015_14 = $year_2014_14 = $year_2013_14 = $year_2012_14 = $year_2011_14 =  0;
$year_2017_15 = $year_2016_15 = $year_2015_15 = $year_2014_15 = $year_2013_15 = $year_2012_15 = $year_2011_15 =  0;
$year_2017_16 = $year_2016_16 = $year_2015_16 = $year_2014_16 = $year_2013_16 = $year_2012_16 = $year_2011_16 =  0;//羽绒裤
$year_2017_17 = $year_2016_17 = $year_2015_17 = $year_2014_17 = $year_2013_17 = $year_2012_17 = $year_2011_17 =  0;//呢大衣
$year_2017_18 = $year_2016_18 = $year_2015_18 = $year_2014_18 = $year_2013_18 = $year_2012_18 = $year_2011_18 =  0;//短袖衫
$year_2017_19 = $year_2016_19 = $year_2015_19 = $year_2014_19 = $year_2013_19 = $year_2012_19 = $year_2011_19 =  0;//真皮大衣
$year_2017_20 = $year_2016_20 = $year_2015_20 = $year_2014_20 = $year_2013_20 = $year_2012_20 = $year_2011_20 =  0;//牛仔裤
$year_2017_21 = $year_2016_21 = $year_2015_21 = $year_2014_21 = $year_2013_21 = $year_2012_21 = $year_2011_21 =  0;//马夹
$year_2017_22 = $year_2016_22 = $year_2015_22 = $year_2014_22 = $year_2013_22 = $year_2012_22 = $year_2011_22 =  0;//短裙
$year_2017_23 = $year_2016_23 = $year_2015_23 = $year_2014_23 = $year_2013_23 = $year_2012_23 = $year_2011_23 =  0;//棉裤
$year_2017_24 = $year_2016_24 = $year_2015_24 = $year_2014_24 = $year_2013_24 = $year_2012_24 = $year_2011_24 =  0;//套装
$year_2017_25 = $year_2016_25 = $year_2015_25 = $year_2014_25 = $year_2013_25 = $year_2012_25 = $year_2011_25 =  0;//女上衣
$year_2017_26 = $year_2016_26 = $year_2015_26 = $year_2014_26 = $year_2013_26 = $year_2012_26 = $year_2011_26 =  0;//针织两件套
$year_2017_27 = $year_2016_27 = $year_2015_27 = $year_2014_27 = $year_2013_27 = $year_2012_27 = $year_2011_27 =  0;//针织上衣
$year_2017_28 = $year_2016_28 = $year_2015_28 = $year_2014_28 = $year_2013_28 = $year_2012_28 = $year_2011_28 =  0;//呢上衣
$year_2017_29 = $year_2016_29 = $year_2015_29 = $year_2014_29 = $year_2013_29 = $year_2012_29 = $year_2011_29 =  0;//女风衣
$year_2017_30 = $year_2016_30 = $year_2015_30 = $year_2014_30 = $year_2013_30 = $year_2012_30 = $year_2011_30 =  0;//棉风衣
$year_2017_31 = $year_2016_31 = $year_2015_31 = $year_2014_31 = $year_2013_31 = $year_2012_31 = $year_2011_31 =  0;//皮风衣
$year_2017_32 = $year_2016_32 = $year_2015_32 = $year_2014_32 = $year_2013_32 = $year_2012_32 = $year_2011_32 =  0;//女中裤
$year_2017_33 = $year_2016_33 = $year_2015_33 = $year_2014_33 = $year_2013_33 = $year_2012_33 = $year_2011_33 =  0;//女长裤
$year_2017_34 = $year_2016_34 = $year_2015_34 = $year_2014_34 = $year_2013_34 = $year_2012_34 = $year_2011_34 =  0;//中裤
$year_2017_35 = $year_2016_35 = $year_2015_35 = $year_2014_35 = $year_2013_35 = $year_2012_35 = $year_2011_35 =  0;//旗袍
$year_2017_36 = $year_2016_36 = $year_2015_36 = $year_2014_36 = $year_2013_36 = $year_2012_36 = $year_2011_36 =  0;//棉背心
$year_2017_37 = $year_2016_37 = $year_2015_37 = $year_2014_37 = $year_2013_37 = $year_2012_37 = $year_2011_37 =  0;//针织裙
$year_2017_38 = $year_2016_38 = $year_2015_38 = $year_2014_38 = $year_2013_38 = $year_2012_38 = $year_2011_38 =  0;//新娘装
$year_2017_39 = $year_2016_39 = $year_2015_39 = $year_2014_39 = $year_2013_39 = $year_2012_39 = $year_2011_39 =  0;//针织连衣裙
$year_2017_40 = $year_2016_40 = $year_2015_40 = $year_2014_40 = $year_2013_40 = $year_2012_40 = $year_2011_40 =  0;//针织女裤
$year_2017_41 = $year_2016_41 = $year_2015_41 = $year_2014_41 = $year_2013_41 = $year_2012_41 = $year_2011_41 =  0;//针织短袖
$year_2017_42 = $year_2016_42 = $year_2015_42 = $year_2014_42 = $year_2013_42 = $year_2012_42 = $year_2011_42 =  0;//套裙
$year_2017_43 = $year_2016_43 = $year_2015_43 = $year_2014_43 = $year_2013_43 = $year_2012_43 = $year_2011_43 =  0;//棉短袖
$year_2017_44 = $year_2016_44 = $year_2015_44 = $year_2014_44 = $year_2013_44 = $year_2012_44 = $year_2011_44 =  0;//两件套上衣
$year_2017_45 = $year_2016_45 = $year_2015_45 = $year_2014_45 = $year_2013_45 = $year_2012_45 = $year_2011_45 =  0;//四面弹女裤
$year_2017_46 = $year_2016_46 = $year_2015_46 = $year_2014_46 = $year_2013_46 = $year_2012_46 = $year_2011_46 =  0;//锦棉绉女裤
$year_2017_47 = $year_2016_47 = $year_2015_47 = $year_2014_47 = $year_2013_47 = $year_2012_47 = $year_2011_47 =  0;//锦棉绉风衣
$year_2017_48 = $year_2016_48 = $year_2015_48 = $year_2014_48 = $year_2013_48 = $year_2012_48 = $year_2011_48 =  0;//锦棉绉女风衣
$year_2017_49 = $year_2016_49 = $year_2015_49 = $year_2014_49 = $year_2013_49 = $year_2012_49 = $year_2011_49 =  0;//锦棉绉棉袄


foreach($data as $v){
    $goods_class_gs = $v['goods_class_gs'];
    $goods_year = $v['goods_year'];

    switch($goods_class_gs){
        case "针织衫":
            switch($goods_year){
                case "2017":
                    $year_2017_1 = $year_2017_1 + $v['num'];
                    break;
                case "2016":
                    $year_2016_1 = $year_2016_1 + $v['num'];
                    break;
                case "2015":
                    $year_2015_1 = $year_2015_1 + $v['num'];
                    break;
                case "2014":
                    $year_2014_1 = $year_2014_1 + $v['num'];
                    break;
                case "2013":
                    $year_2013_1 = $year_2013_1 + $v['num'];
                    break;
                case "2012":
                    $year_2012_1 = $year_2012_1 + $v['num'];
                    break;
                case "2011":
                    $year_2011_1 = $year_2011_1 + $v['num'];
                    break;
            }
            break;
        case "羽绒服":
            switch($goods_year){
                case "2017":
                    $year_2017_2 = $year_2017_2 + $v['num'];
                    break;
                case "2016":
                    $year_2016_2 = $year_2016_2 + $v['num'];
                    break;
                case "2015":
                    $year_2015_2 = $year_2015_2 + $v['num'];
                    break;
                case "2014":
                    $year_2014_2 = $year_2014_2 + $v['num'];
                    break;
                case "2013":
                    $year_2013_2 = $year_2013_2 + $v['num'];
                    break;
                case "2012":
                    $year_2012_2 = $year_2012_2 + $v['num'];
                    break;
                case "2011":
                    $year_2011_2 = $year_2011_2 + $v['num'];
                    break;
            }
            break;
        case "真丝短袖衫":
            switch($goods_year){
                case "2017":
                    $year_2017_3 = $year_2017_3 + $v['num'];
                    break;
                case "2016":
                    $year_2016_3 = $year_2016_3 + $v['num'];
                    break;
                case "2015":
                    $year_2015_3 = $year_2015_3 + $v['num'];
                    break;
                case "2014":
                    $year_2014_3 = $year_2014_3 + $v['num'];
                    break;
                case "2013":
                    $year_2013_3 = $year_2013_3 + $v['num'];
                    break;
                case "2012":
                    $year_2012_3 = $year_2012_3 + $v['num'];
                    break;
                case "2011":
                    $year_2011_3 = $year_2011_3 + $v['num'];
                    break;
            }
            break;
        case "棉袄":
            switch($goods_year){
                case "2017":
                    $year_2017_4 = $year_2017_4 + $v['num'];
                    break;
                case "2016":
                    $year_2016_4 = $year_2016_4 + $v['num'];
                    break;
                case "2015":
                    $year_2015_4 = $year_2015_4 + $v['num'];
                    break;
                case "2014":
                    $year_2014_4 = $year_2014_4 + $v['num'];
                    break;
                case "2013":
                    $year_2013_4 = $year_2013_4 + $v['num'];
                    break;
                case "2012":
                    $year_2012_4 = $year_2012_4 + $v['num'];
                    break;
                case "2011":
                    $year_2011_4 = $year_2011_4 + $v['num'];
                    break;
            }
            break;
        case "短棉袄":
            switch($goods_year){
                case "2017":
                    $year_2017_5 = $year_2017_5 + $v['num'];
                    break;
                case "2016":
                    $year_2016_5 = $year_2016_5 + $v['num'];
                    break;
                case "2015":
                    $year_2015_5 = $year_2015_5 + $v['num'];
                    break;
                case "2014":
                    $year_2014_5 = $year_2014_5 + $v['num'];
                    break;
                case "2013":
                    $year_2013_5 = $year_2013_5 + $v['num'];
                    break;
                case "2012":
                    $year_2012_5 = $year_2012_5 + $v['num'];
                    break;
                case "2011":
                    $year_2011_5 = $year_2011_5 + $v['num'];
                    break;
            }
            break;
        case "真丝连衣裙":
            switch($goods_year){
                case "2017":
                    $year_2017_6 = $year_2017_6 + $v['num'];
                    break;
                case "2016":
                    $year_2016_6 = $year_2016_6 + $v['num'];
                    break;
                case "2015":
                    $year_2015_6 = $year_2015_6 + $v['num'];
                    break;
                case "2014":
                    $year_2014_6 = $year_2014_6 + $v['num'];
                    break;
                case "2013":
                    $year_2013_6 = $year_2013_6 + $v['num'];
                    break;
                case "2012":
                    $year_2012_6 = $year_2012_6 + $v['num'];
                    break;
                case "2011":
                    $year_2011_6 = $year_2011_6 + $v['num'];
                    break;
            }
            break;
        case "上衣":
            switch($goods_year){
                case "2017":
                    $year_2017_7 = $year_2017_7 + $v['num'];
                    break;
                case "2016":
                    $year_2016_7 = $year_2016_7 + $v['num'];
                    break;
                case "2015":
                    $year_2015_7 = $year_2015_7 + $v['num'];
                    break;
                case "2014":
                    $year_2014_7 = $year_2014_7 + $v['num'];
                    break;
                case "2013":
                    $year_2013_7 = $year_2013_7 + $v['num'];
                    break;
                case "2012":
                    $year_2012_7 = $year_2012_7 + $v['num'];
                    break;
                case "2011":
                    $year_2011_7 = $year_2011_7 + $v['num'];
                    break;
            }
            break;
        case "两件套":
            switch($goods_year){
                case "2017":
                    $year_2017_8 = $year_2017_8 + $v['num'];
                    break;
                case "2016":
                    $year_2016_8 = $year_2016_8 + $v['num'];
                    break;
                case "2015":
                    $year_2015_8 = $year_2015_8 + $v['num'];
                    break;
                case "2014":
                    $year_2014_8 = $year_2014_8 + $v['num'];
                    break;
                case "2013":
                    $year_2013_8 = $year_2013_8 + $v['num'];
                    break;
                case "2012":
                    $year_2012_8 = $year_2012_8 + $v['num'];
                    break;
                case "2011":
                    $year_2011_8 = $year_2011_8 + $v['num'];
                    break;
            }
            break;
        case "女上装":
            switch($goods_year){
                case "2017":
                    $year_2017_9 = $year_2017_9 + $v['num'];
                    break;
                case "2016":
                    $year_2016_9 = $year_2016_9 + $v['num'];
                    break;
                case "2015":
                    $year_2015_9 = $year_2015_9 + $v['num'];
                    break;
                case "2014":
                    $year_2014_9 = $year_2014_9 + $v['num'];
                    break;
                case "2013":
                    $year_2013_9 = $year_2013_9 + $v['num'];
                    break;
                case "2012":
                    $year_2012_9 = $year_2012_9 + $v['num'];
                    break;
                case "2011":
                    $year_2011_9 = $year_2011_9 + $v['num'];
                    break;
            }
            break;
        case "尼克服":
            switch($goods_year){
                case "2017":
                    $year_2017_10 = $year_2017_10 + $v['num'];
                    break;
                case "2016":
                    $year_2016_10 = $year_2016_10 + $v['num'];
                    break;
                case "2015":
                    $year_2015_10 = $year_2015_10 + $v['num'];
                    break;
                case "2014":
                    $year_2014_10 = $year_2014_10 + $v['num'];
                    break;
                case "2013":
                    $year_2013_10 = $year_2013_10 + $v['num'];
                    break;
                case "2012":
                    $year_2012_10 = $year_2012_10 + $v['num'];
                    break;
                case "2011":
                    $year_2011_10 = $year_2011_10 + $v['num'];
                    break;
            }
            break;
        case "女裤":
            switch($goods_year){
                case "2017":
                    $year_2017_11 = $year_2017_11 + $v['num'];
                    break;
                case "2016":
                    $year_2016_11 = $year_2016_11 + $v['num'];
                    break;
                case "2015":
                    $year_2015_11 = $year_2015_11 + $v['num'];
                    break;
                case "2014":
                    $year_2014_11 = $year_2014_11 + $v['num'];
                    break;
                case "2013":
                    $year_2013_11 = $year_2013_11 + $v['num'];
                    break;
                case "2012":
                    $year_2012_11 = $year_2012_11 + $v['num'];
                    break;
                case "2011":
                    $year_2011_11 = $year_2011_11 + $v['num'];
                    break;
            }
            break;
        case "背心":
            switch($goods_year){
                case "2017":
                    $year_2017_12 = $year_2017_12 + $v['num'];
                    break;
                case "2016":
                    $year_2016_12 = $year_2016_12 + $v['num'];
                    break;
                case "2015":
                    $year_2015_12 = $year_2015_12 + $v['num'];
                    break;
                case "2014":
                    $year_2014_12 = $year_2014_12 + $v['num'];
                    break;
                case "2013":
                    $year_2013_12 = $year_2013_12 + $v['num'];
                    break;
                case "2012":
                    $year_2012_12 = $year_2012_12 + $v['num'];
                    break;
                case "2011":
                    $year_2011_12 = $year_2011_12 + $v['num'];
                    break;
            }
            break;
        case "连衣裙":
            switch($goods_year){
                case "2017":
                    $year_2017_13 = $year_2017_13 + $v['num'];
                    break;
                case "2016":
                    $year_2016_13 = $year_2016_13 + $v['num'];
                    break;
                case "2015":
                    $year_2015_13 = $year_2015_13 + $v['num'];
                    break;
                case "2014":
                    $year_2014_13 = $year_2014_13 + $v['num'];
                    break;
                case "2013":
                    $year_2013_13 = $year_2013_13 + $v['num'];
                    break;
                case "2012":
                    $year_2012_13 = $year_2012_13 + $v['num'];
                    break;
                case "2011":
                    $year_2011_13 = $year_2011_13 + $v['num'];
                    break;
            }
            break;
        case "风衣":
            switch($goods_year){
                case "2017":
                    $year_2017_14 = $year_2017_14 + $v['num'];
                    break;
                case "2016":
                    $year_2016_14 = $year_2016_14 + $v['num'];
                    break;
                case "2015":
                    $year_2015_14 = $year_2015_14 + $v['num'];
                    break;
                case "2014":
                    $year_2014_14 = $year_2014_14 + $v['num'];
                    break;
                case "2013":
                    $year_2013_14 = $year_2013_14 + $v['num'];
                    break;
                case "2012":
                    $year_2012_14 = $year_2012_14 + $v['num'];
                    break;
                case "2011":
                    $year_2011_14 = $year_2011_14 + $v['num'];
                    break;
            }
            break;
        case "大衣":
            switch($goods_year){
                case "2017":
                    $year_2017_15 = $year_2017_15 + $v['num'];
                    break;
                case "2016":
                    $year_2016_15 = $year_2016_15 + $v['num'];
                    break;
                case "2015":
                    $year_2015_15 = $year_2015_15 + $v['num'];
                    break;
                case "2014":
                    $year_2014_15 = $year_2014_15 + $v['num'];
                    break;
                case "2013":
                    $year_2013_15 = $year_2013_15 + $v['num'];
                    break;
                case "2012":
                    $year_2012_15 = $year_2012_15 + $v['num'];
                    break;
                case "2011":
                    $year_2011_15 = $year_2011_15 + $v['num'];
                    break;
            }
            break;
        case "羽绒裤":
            switch($goods_year){
                case "2017":
                    $year_2017_16 = $year_2017_16 + $v['num'];
                    break;
                case "2016":
                    $year_2016_16 = $year_2016_16 + $v['num'];
                    break;
                case "2015":
                    $year_2015_16 = $year_2015_16 + $v['num'];
                    break;
                case "2014":
                    $year_2014_16 = $year_2014_16 + $v['num'];
                    break;
                case "2013":
                    $year_2013_16 = $year_2013_16 + $v['num'];
                    break;
                case "2012":
                    $year_2012_16 = $year_2012_16 + $v['num'];
                    break;
                case "2011":
                    $year_2011_16 = $year_2011_16 + $v['num'];
                    break;
            }
            break;
        case "呢大衣":
            switch($goods_year){
                case "2017":
                    $year_2017_17 = $year_2017_17 + $v['num'];
                    break;
                case "2016":
                    $year_2016_17 = $year_2016_17 + $v['num'];
                    break;
                case "2015":
                    $year_2015_17 = $year_2015_17 + $v['num'];
                    break;
                case "2014":
                    $year_2014_17 = $year_2014_17 + $v['num'];
                    break;
                case "2013":
                    $year_2013_17 = $year_2013_17 + $v['num'];
                    break;
                case "2012":
                    $year_2012_17 = $year_2012_17 + $v['num'];
                    break;
                case "2011":
                    $year_2011_17 = $year_2011_17 + $v['num'];
                    break;
            }
            break;
        case "短袖衫":
            switch($goods_year){
                case "2017":
                    $year_2017_18 = $year_2017_18 + $v['num'];
                    break;
                case "2016":
                    $year_2016_18 = $year_2016_18 + $v['num'];
                    break;
                case "2015":
                    $year_2015_18 = $year_2015_18 + $v['num'];
                    break;
                case "2014":
                    $year_2014_18 = $year_2014_18 + $v['num'];
                    break;
                case "2013":
                    $year_2013_18 = $year_2013_18 + $v['num'];
                    break;
                case "2012":
                    $year_2012_18 = $year_2012_18 + $v['num'];
                    break;
                case "2011":
                    $year_2011_18 = $year_2011_18 + $v['num'];
                    break;
            }
            break;
        case "真皮大衣":
            switch($goods_year){
                case "2017":
                    $year_2017_19 = $year_2017_19 + $v['num'];
                    break;
                case "2016":
                    $year_2016_19 = $year_2016_19 + $v['num'];
                    break;
                case "2015":
                    $year_2015_19 = $year_2015_19 + $v['num'];
                    break;
                case "2014":
                    $year_2014_19 = $year_2014_19 + $v['num'];
                    break;
                case "2013":
                    $year_2013_19 = $year_2013_19 + $v['num'];
                    break;
                case "2012":
                    $year_2012_19 = $year_2012_19 + $v['num'];
                    break;
                case "2011":
                    $year_2011_19 = $year_2011_19 + $v['num'];
                    break;
            }
            break;
        case "牛仔裤":
            switch($goods_year){
                case "2017":
                    $year_2017_20 = $year_2017_20 + $v['num'];
                    break;
                case "2016":
                    $year_2016_20 = $year_2016_20 + $v['num'];
                    break;
                case "2015":
                    $year_2015_20 = $year_2015_20 + $v['num'];
                    break;
                case "2014":
                    $year_2014_20 = $year_2014_20 + $v['num'];
                    break;
                case "2013":
                    $year_2013_20 = $year_2013_20 + $v['num'];
                    break;
                case "2012":
                    $year_2012_20 = $year_2012_20 + $v['num'];
                    break;
                case "2011":
                    $year_2011_20 = $year_2011_20 + $v['num'];
                    break;
            }
            break;
        case "马夹":
            switch($goods_year){
                case "2017":
                    $year_2017_21 = $year_2017_21 + $v['num'];
                    break;
                case "2016":
                    $year_2016_21 = $year_2016_21 + $v['num'];
                    break;
                case "2015":
                    $year_2015_21 = $year_2015_21 + $v['num'];
                    break;
                case "2014":
                    $year_2014_21 = $year_2014_21 + $v['num'];
                    break;
                case "2013":
                    $year_2013_21 = $year_2013_21 + $v['num'];
                    break;
                case "2012":
                    $year_2012_21 = $year_2012_21 + $v['num'];
                    break;
                case "2011":
                    $year_2011_21 = $year_2011_21 + $v['num'];
                    break;
            }
            break;
        case "短裙":
            switch($goods_year){
                case "2017":
                    $year_2017_22 = $year_2017_22 + $v['num'];
                    break;
                case "2016":
                    $year_2016_22 = $year_2016_22 + $v['num'];
                    break;
                case "2015":
                    $year_2015_22 = $year_2015_22 + $v['num'];
                    break;
                case "2014":
                    $year_2014_22 = $year_2014_22 + $v['num'];
                    break;
                case "2013":
                    $year_2013_22 = $year_2013_22 + $v['num'];
                    break;
                case "2012":
                    $year_2012_22 = $year_2012_22 + $v['num'];
                    break;
                case "2011":
                    $year_2011_22 = $year_2011_22 + $v['num'];
                    break;
            }
            break;
        case "棉裤":
            switch($goods_year){
                case "2017":
                    $year_2017_23 = $year_2017_23 + $v['num'];
                    break;
                case "2016":
                    $year_2016_23 = $year_2016_23 + $v['num'];
                    break;
                case "2015":
                    $year_2015_23 = $year_2015_23 + $v['num'];
                    break;
                case "2014":
                    $year_2014_23 = $year_2014_23 + $v['num'];
                    break;
                case "2013":
                    $year_2013_23 = $year_2013_23 + $v['num'];
                    break;
                case "2012":
                    $year_2012_23 = $year_2012_23 + $v['num'];
                    break;
                case "2011":
                    $year_2011_23 = $year_2011_23 + $v['num'];
                    break;
            }
            break;
        case "套装":
            switch($goods_year){
                case "2017":
                    $year_2017_24 = $year_2017_24 + $v['num'];
                    break;
                case "2016":
                    $year_2016_24 = $year_2016_24 + $v['num'];
                    break;
                case "2015":
                    $year_2015_24 = $year_2015_24 + $v['num'];
                    break;
                case "2014":
                    $year_2014_24 = $year_2014_24 + $v['num'];
                    break;
                case "2013":
                    $year_2013_24 = $year_2013_24 + $v['num'];
                    break;
                case "2012":
                    $year_2012_24 = $year_2012_24 + $v['num'];
                    break;
                case "2011":
                    $year_2011_24 = $year_2011_24 + $v['num'];
                    break;
            }
            break;
        case "女上衣":
            switch($goods_year){
                case "2017":
                    $year_2017_25 = $year_2017_25 + $v['num'];
                    break;
                case "2016":
                    $year_2016_25 = $year_2016_25 + $v['num'];
                    break;
                case "2015":
                    $year_2015_25 = $year_2015_25 + $v['num'];
                    break;
                case "2014":
                    $year_2014_25 = $year_2014_25 + $v['num'];
                    break;
                case "2013":
                    $year_2013_25 = $year_2013_25 + $v['num'];
                    break;
                case "2012":
                    $year_2012_25 = $year_2012_25 + $v['num'];
                    break;
                case "2011":
                    $year_2011_25 = $year_2011_25 + $v['num'];
                    break;
            }
            break;
        case "针织两件套":
            switch($goods_year){
                case "2017":
                    $year_2017_26 = $year_2017_26 + $v['num'];
                    break;
                case "2016":
                    $year_2016_26 = $year_2016_26 + $v['num'];
                    break;
                case "2015":
                    $year_2015_26 = $year_2015_26 + $v['num'];
                    break;
                case "2014":
                    $year_2014_26 = $year_2014_26 + $v['num'];
                    break;
                case "2013":
                    $year_2013_26 = $year_2013_26 + $v['num'];
                    break;
                case "2012":
                    $year_2012_26 = $year_2012_26 + $v['num'];
                    break;
                case "2011":
                    $year_2011_26 = $year_2011_26 + $v['num'];
                    break;
            }
            break;
        case "针织上衣":
            switch($goods_year){
                case "2017":
                    $year_2017_27 = $year_2017_27 + $v['num'];
                    break;
                case "2016":
                    $year_2016_27 = $year_2016_27 + $v['num'];
                    break;
                case "2015":
                    $year_2015_27 = $year_2015_27 + $v['num'];
                    break;
                case "2014":
                    $year_2014_27 = $year_2014_27 + $v['num'];
                    break;
                case "2013":
                    $year_2013_27 = $year_2013_27 + $v['num'];
                    break;
                case "2012":
                    $year_2012_27 = $year_2012_27 + $v['num'];
                    break;
                case "2011":
                    $year_2011_27 = $year_2011_27 + $v['num'];
                    break;
            }
            break;
        case "呢上衣":
            switch($goods_year){
                case "2017":
                    $year_2017_28 = $year_2017_28 + $v['num'];
                    break;
                case "2016":
                    $year_2016_28 = $year_2016_28 + $v['num'];
                    break;
                case "2015":
                    $year_2015_28 = $year_2015_28 + $v['num'];
                    break;
                case "2014":
                    $year_2014_28 = $year_2014_28 + $v['num'];
                    break;
                case "2013":
                    $year_2013_28 = $year_2013_28 + $v['num'];
                    break;
                case "2012":
                    $year_2012_28 = $year_2012_28 + $v['num'];
                    break;
                case "2011":
                    $year_2011_28 = $year_2011_28 + $v['num'];
                    break;
            }
            break;
        case "女风衣":
            switch($goods_year){
                case "2017":
                    $year_2017_29 = $year_2017_29 + $v['num'];
                    break;
                case "2016":
                    $year_2016_29 = $year_2016_29 + $v['num'];
                    break;
                case "2015":
                    $year_2015_29 = $year_2015_29 + $v['num'];
                    break;
                case "2014":
                    $year_2014_29 = $year_2014_29 + $v['num'];
                    break;
                case "2013":
                    $year_2013_29 = $year_2013_29 + $v['num'];
                    break;
                case "2012":
                    $year_2012_29 = $year_2012_29 + $v['num'];
                    break;
                case "2011":
                    $year_2011_29 = $year_2011_29 + $v['num'];
                    break;
            }
            break;
        case "棉风衣":
            switch($goods_year){
                case "2017":
                    $year_2017_30 = $year_2017_30 + $v['num'];
                    break;
                case "2016":
                    $year_2016_30 = $year_2016_30 + $v['num'];
                    break;
                case "2015":
                    $year_2015_30 = $year_2015_30 + $v['num'];
                    break;
                case "2014":
                    $year_2014_30 = $year_2014_30 + $v['num'];
                    break;
                case "2013":
                    $year_2013_30 = $year_2013_30 + $v['num'];
                    break;
                case "2012":
                    $year_2012_30 = $year_2012_30 + $v['num'];
                    break;
                case "2011":
                    $year_2011_30 = $year_2011_30 + $v['num'];
                    break;
            }
            break;
        case "皮风衣":
            switch($goods_year){
                case "2017":
                    $year_2017_31 = $year_2017_31 + $v['num'];
                    break;
                case "2016":
                    $year_2016_31 = $year_2016_31 + $v['num'];
                    break;
                case "2015":
                    $year_2015_31 = $year_2015_31 + $v['num'];
                    break;
                case "2014":
                    $year_2014_31 = $year_2014_31 + $v['num'];
                    break;
                case "2013":
                    $year_2013_31 = $year_2013_31 + $v['num'];
                    break;
                case "2012":
                    $year_2012_31 = $year_2012_31 + $v['num'];
                    break;
                case "2011":
                    $year_2011_31 = $year_2011_31 + $v['num'];
                    break;
            }
            break;
        case "女中裤":
            switch($goods_year){
                case "2017":
                    $year_2017_32 = $year_2017_32 + $v['num'];
                    break;
                case "2016":
                    $year_2016_32 = $year_2016_32 + $v['num'];
                    break;
                case "2015":
                    $year_2015_32 = $year_2015_32 + $v['num'];
                    break;
                case "2014":
                    $year_2014_32 = $year_2014_32 + $v['num'];
                    break;
                case "2013":
                    $year_2013_32 = $year_2013_32 + $v['num'];
                    break;
                case "2012":
                    $year_2012_32 = $year_2012_32 + $v['num'];
                    break;
                case "2011":
                    $year_2011_32 = $year_2011_32 + $v['num'];
                    break;
            }
            break;
        case "女长裤":
            switch($goods_year){
                case "2017":
                    $year_2017_33 = $year_2017_33 + $v['num'];
                    break;
                case "2016":
                    $year_2016_33 = $year_2016_33 + $v['num'];
                    break;
                case "2015":
                    $year_2015_33 = $year_2015_33 + $v['num'];
                    break;
                case "2014":
                    $year_2014_33 = $year_2014_33 + $v['num'];
                    break;
                case "2013":
                    $year_2013_33 = $year_2013_33 + $v['num'];
                    break;
                case "2012":
                    $year_2012_33 = $year_2012_33 + $v['num'];
                    break;
                case "2011":
                    $year_2011_33 = $year_2011_33 + $v['num'];
                    break;
            }
            break;
        case "中裤":
            switch($goods_year){
                case "2017":
                    $year_2017_34 = $year_2017_34 + $v['num'];
                    break;
                case "2016":
                    $year_2016_34 = $year_2016_34 + $v['num'];
                    break;
                case "2015":
                    $year_2015_34 = $year_2015_34 + $v['num'];
                    break;
                case "2014":
                    $year_2014_34 = $year_2014_34 + $v['num'];
                    break;
                case "2013":
                    $year_2013_34 = $year_2013_34 + $v['num'];
                    break;
                case "2012":
                    $year_2012_34 = $year_2012_34 + $v['num'];
                    break;
                case "2011":
                    $year_2011_34 = $year_2011_34 + $v['num'];
                    break;
            }
            break;
        case "旗袍":
            switch($goods_year){
                case "2017":
                    $year_2017_35 = $year_2017_35 + $v['num'];
                    break;
                case "2016":
                    $year_2016_35 = $year_2016_35 + $v['num'];
                    break;
                case "2015":
                    $year_2015_35 = $year_2015_35 + $v['num'];
                    break;
                case "2014":
                    $year_2014_35 = $year_2014_35 + $v['num'];
                    break;
                case "2013":
                    $year_2013_35 = $year_2013_35 + $v['num'];
                    break;
                case "2012":
                    $year_2012_35 = $year_2012_35 + $v['num'];
                    break;
                case "2011":
                    $year_2011_35 = $year_2011_35 + $v['num'];
                    break;
            }
            break;
        case "棉背心":
            switch($goods_year){
                case "2017":
                    $year_2017_36 = $year_2017_36 + $v['num'];
                    break;
                case "2016":
                    $year_2016_36 = $year_2016_36 + $v['num'];
                    break;
                case "2015":
                    $year_2015_36 = $year_2015_36 + $v['num'];
                    break;
                case "2014":
                    $year_2014_36 = $year_2014_36 + $v['num'];
                    break;
                case "2013":
                    $year_2013_36 = $year_2013_36 + $v['num'];
                    break;
                case "2012":
                    $year_2012_36 = $year_2012_36 + $v['num'];
                    break;
                case "2011":
                    $year_2011_36 = $year_2011_36 + $v['num'];
                    break;
            }
            break;
        case "针织裙":
            switch($goods_year){
                case "2017":
                    $year_2017_37 = $year_2017_37 + $v['num'];
                    break;
                case "2016":
                    $year_2016_37 = $year_2016_37 + $v['num'];
                    break;
                case "2015":
                    $year_2015_37 = $year_2015_37 + $v['num'];
                    break;
                case "2014":
                    $year_2014_37 = $year_2014_37 + $v['num'];
                    break;
                case "2013":
                    $year_2013_37 = $year_2013_37 + $v['num'];
                    break;
                case "2012":
                    $year_2012_37 = $year_2012_37 + $v['num'];
                    break;
                case "2011":
                    $year_2011_37 = $year_2011_37 + $v['num'];
                    break;
            }
            break;
        case "新娘装":
            switch($goods_year){
                case "2017":
                    $year_2017_38 = $year_2017_38 + $v['num'];
                    break;
                case "2016":
                    $year_2016_38 = $year_2016_38 + $v['num'];
                    break;
                case "2015":
                    $year_2015_38 = $year_2015_38 + $v['num'];
                    break;
                case "2014":
                    $year_2014_38 = $year_2014_38 + $v['num'];
                    break;
                case "2013":
                    $year_2013_38 = $year_2013_38 + $v['num'];
                    break;
                case "2012":
                    $year_2012_38 = $year_2012_38 + $v['num'];
                    break;
                case "2011":
                    $year_2011_38 = $year_2011_38 + $v['num'];
                    break;
            }
            break;
        case "针织连衣裙":
            switch($goods_year){
                case "2017":
                    $year_2017_39 = $year_2017_39 + $v['num'];
                    break;
                case "2016":
                    $year_2016_39 = $year_2016_39 + $v['num'];
                    break;
                case "2015":
                    $year_2015_39 = $year_2015_39 + $v['num'];
                    break;
                case "2014":
                    $year_2014_39 = $year_2014_39 + $v['num'];
                    break;
                case "2013":
                    $year_2013_39 = $year_2013_39 + $v['num'];
                    break;
                case "2012":
                    $year_2012_39 = $year_2012_39 + $v['num'];
                    break;
                case "2011":
                    $year_2011_39 = $year_2011_39 + $v['num'];
                    break;
            }
            break;
        case "针织女裤":
            switch($goods_year){
                case "2017":
                    $year_2017_40 = $year_2017_40 + $v['num'];
                    break;
                case "2016":
                    $year_2016_40 = $year_2016_40 + $v['num'];
                    break;
                case "2015":
                    $year_2015_40 = $year_2015_40 + $v['num'];
                    break;
                case "2014":
                    $year_2014_40 = $year_2014_40 + $v['num'];
                    break;
                case "2013":
                    $year_2013_40 = $year_2013_40 + $v['num'];
                    break;
                case "2012":
                    $year_2012_40 = $year_2012_40 + $v['num'];
                    break;
                case "2011":
                    $year_2011_40 = $year_2011_40 + $v['num'];
                    break;
            }
            break;
        case "针织短袖":
            switch($goods_year){
                case "2017":
                    $year_2017_41 = $year_2017_41 + $v['num'];
                    break;
                case "2016":
                    $year_2016_41 = $year_2016_41 + $v['num'];
                    break;
                case "2015":
                    $year_2015_41 = $year_2015_41 + $v['num'];
                    break;
                case "2014":
                    $year_2014_41 = $year_2014_41 + $v['num'];
                    break;
                case "2013":
                    $year_2013_41 = $year_2013_41 + $v['num'];
                    break;
                case "2012":
                    $year_2012_41 = $year_2012_41 + $v['num'];
                    break;
                case "2011":
                    $year_2011_41 = $year_2011_41 + $v['num'];
                    break;
            }
            break;
        case "套裙":
            switch($goods_year){
                case "2017":
                    $year_2017_42 = $year_2017_42 + $v['num'];
                    break;
                case "2016":
                    $year_2016_42 = $year_2016_42 + $v['num'];
                    break;
                case "2015":
                    $year_2015_42 = $year_2015_42 + $v['num'];
                    break;
                case "2014":
                    $year_2014_42 = $year_2014_42 + $v['num'];
                    break;
                case "2013":
                    $year_2013_42 = $year_2013_42 + $v['num'];
                    break;
                case "2012":
                    $year_2012_42 = $year_2012_42 + $v['num'];
                    break;
                case "2011":
                    $year_2011_42 = $year_2011_42 + $v['num'];
                    break;
            }
            break;
        case "棉短袖":
            switch($goods_year){
                case "2017":
                    $year_2017_43 = $year_2017_43 + $v['num'];
                    break;
                case "2016":
                    $year_2016_43 = $year_2016_43 + $v['num'];
                    break;
                case "2015":
                    $year_2015_43 = $year_2015_43 + $v['num'];
                    break;
                case "2014":
                    $year_2014_43 = $year_2014_43 + $v['num'];
                    break;
                case "2013":
                    $year_2013_43 = $year_2013_43 + $v['num'];
                    break;
                case "2012":
                    $year_2012_43 = $year_2012_43 + $v['num'];
                    break;
                case "2011":
                    $year_2011_43 = $year_2011_43 + $v['num'];
                    break;
            }
            break;
        case "两件套上衣":
            switch($goods_year){
                case "2017":
                    $year_2017_44 = $year_2017_44 + $v['num'];
                    break;
                case "2016":
                    $year_2016_44 = $year_2016_44 + $v['num'];
                    break;
                case "2015":
                    $year_2015_44 = $year_2015_44 + $v['num'];
                    break;
                case "2014":
                    $year_2014_44 = $year_2014_44 + $v['num'];
                    break;
                case "2013":
                    $year_2013_44 = $year_2013_44 + $v['num'];
                    break;
                case "2012":
                    $year_2012_44 = $year_2012_44 + $v['num'];
                    break;
                case "2011":
                    $year_2011_44 = $year_2011_44 + $v['num'];
                    break;
            }
            break;
        case "四面弹女裤":
            switch($goods_year){
                case "2017":
                    $year_2017_45 = $year_2017_45 + $v['num'];
                    break;
                case "2016":
                    $year_2016_45 = $year_2016_45 + $v['num'];
                    break;
                case "2015":
                    $year_2015_45 = $year_2015_45 + $v['num'];
                    break;
                case "2014":
                    $year_2014_45 = $year_2014_45 + $v['num'];
                    break;
                case "2013":
                    $year_2013_45 = $year_2013_45 + $v['num'];
                    break;
                case "2012":
                    $year_2012_45 = $year_2012_45 + $v['num'];
                    break;
                case "2011":
                    $year_2011_45 = $year_2011_45 + $v['num'];
                    break;
            }
            break;
        case "锦棉绉女裤":
            switch($goods_year){
                case "2017":
                    $year_2017_46 = $year_2017_46 + $v['num'];
                    break;
                case "2016":
                    $year_2016_46 = $year_2016_46 + $v['num'];
                    break;
                case "2015":
                    $year_2015_46 = $year_2015_46 + $v['num'];
                    break;
                case "2014":
                    $year_2014_46 = $year_2014_46 + $v['num'];
                    break;
                case "2013":
                    $year_2013_46 = $year_2013_46 + $v['num'];
                    break;
                case "2012":
                    $year_2012_46 = $year_2012_46 + $v['num'];
                    break;
                case "2011":
                    $year_2011_46 = $year_2011_46 + $v['num'];
                    break;
            }
            break;
        case "锦棉绉风衣":
            switch($goods_year){
                case "2017":
                    $year_2017_47 = $year_2017_47 + $v['num'];
                    break;
                case "2016":
                    $year_2016_47 = $year_2016_47 + $v['num'];
                    break;
                case "2015":
                    $year_2015_47 = $year_2015_47 + $v['num'];
                    break;
                case "2014":
                    $year_2014_47 = $year_2014_47 + $v['num'];
                    break;
                case "2013":
                    $year_2013_47 = $year_2013_47 + $v['num'];
                    break;
                case "2012":
                    $year_2012_47 = $year_2012_47 + $v['num'];
                    break;
                case "2011":
                    $year_2011_47 = $year_2011_47 + $v['num'];
                    break;
            }
            break;
        case "锦棉绉女风衣":
            switch($goods_year){
                case "2017":
                    $year_2017_48 = $year_2017_48 + $v['num'];
                    break;
                case "2016":
                    $year_2016_48 = $year_2016_48 + $v['num'];
                    break;
                case "2015":
                    $year_2015_48 = $year_2015_48 + $v['num'];
                    break;
                case "2014":
                    $year_2014_48 = $year_2014_48 + $v['num'];
                    break;
                case "2013":
                    $year_2013_48 = $year_2013_48 + $v['num'];
                    break;
                case "2012":
                    $year_2012_48 = $year_2012_48 + $v['num'];
                    break;
                case "2011":
                    $year_2011_48 = $year_2011_48 + $v['num'];
                    break;
            }
            break;
        case "锦棉绉棉袄":
            switch($goods_year){
                case "2017":
                    $year_2017_49 = $year_2017_49 + $v['num'];
                    break;
                case "2016":
                    $year_2016_49 = $year_2016_49 + $v['num'];
                    break;
                case "2015":
                    $year_2015_49 = $year_2015_49 + $v['num'];
                    break;
                case "2014":
                    $year_2014_49 = $year_2014_49 + $v['num'];
                    break;
                case "2013":
                    $year_2013_49 = $year_2013_49 + $v['num'];
                    break;
                case "2012":
                    $year_2012_49 = $year_2012_49 + $v['num'];
                    break;
                case "2011":
                    $year_2011_49 = $year_2011_49 + $v['num'];
                    break;
            }
            break;
    }
}

$year_all_1 = $year_2017_1 + $year_2016_1 + $year_2015_1 + $year_2014_1 + $year_2013_1 + $year_2012_1 + $year_2011_1;
$year_all_2 = $year_2017_2 + $year_2016_2 + $year_2015_2 + $year_2014_2 + $year_2013_2 + $year_2012_2 + $year_2011_2;
$year_all_3 = $year_2017_3 + $year_2016_3 + $year_2015_3 + $year_2014_3 + $year_2013_3 + $year_2012_3 + $year_2011_3;
$year_all_4 = $year_2017_4 + $year_2016_4 + $year_2015_4 + $year_2014_4 + $year_2013_4 + $year_2012_4 + $year_2011_4;
$year_all_5 = $year_2017_5 + $year_2016_5 + $year_2015_5 + $year_2014_5 + $year_2013_5 + $year_2012_5 + $year_2011_5;
$year_all_6 = $year_2017_6 + $year_2016_6 + $year_2015_6 + $year_2014_6 + $year_2013_6 + $year_2012_6 + $year_2011_6;
$year_all_7 = $year_2017_7 + $year_2016_7 + $year_2015_7 + $year_2014_7 + $year_2013_7 + $year_2012_7 + $year_2011_7;
$year_all_8 = $year_2017_8 + $year_2016_8 + $year_2015_8 + $year_2014_8 + $year_2013_8 + $year_2012_8 + $year_2011_8;
$year_all_9 = $year_2017_9 + $year_2016_9 + $year_2015_9 + $year_2014_9 + $year_2013_9 + $year_2012_9 + $year_2011_9;
$year_all_10 = $year_2017_10 + $year_2016_10 + $year_2015_10 + $year_2014_10 + $year_2013_10 + $year_2012_10 + $year_2011_10;
$year_all_11 = $year_2017_11 + $year_2016_11 + $year_2015_11 + $year_2014_11 + $year_2013_11 + $year_2012_11 + $year_2011_11;
$year_all_12 = $year_2017_12 + $year_2016_12 + $year_2015_12 + $year_2014_12 + $year_2013_12 + $year_2012_12 + $year_2011_12;
$year_all_13 = $year_2017_13 + $year_2016_13 + $year_2015_13 + $year_2014_13 + $year_2013_13 + $year_2012_13 + $year_2011_13;
$year_all_14 = $year_2017_14 + $year_2016_14 + $year_2015_14 + $year_2014_14 + $year_2013_14 + $year_2012_14 + $year_2011_14;
$year_all_15 = $year_2017_15 + $year_2016_15 + $year_2015_15 + $year_2014_15 + $year_2013_15 + $year_2012_15 + $year_2011_15;
$year_all_16 = $year_2017_16 + $year_2016_16 + $year_2015_16 + $year_2014_16 + $year_2013_16 + $year_2012_16 + $year_2011_16;
$year_all_17 = $year_2017_17 + $year_2016_17 + $year_2015_17 + $year_2014_17 + $year_2013_17 + $year_2012_17 + $year_2011_17;
$year_all_18 = $year_2017_18 + $year_2016_18 + $year_2015_18 + $year_2014_18 + $year_2013_18 + $year_2012_18 + $year_2011_18;
$year_all_19 = $year_2017_19 + $year_2016_19 + $year_2015_19 + $year_2014_19 + $year_2013_19 + $year_2012_19 + $year_2011_19;
$year_all_20 = $year_2017_20 + $year_2016_20 + $year_2015_20 + $year_2014_20 + $year_2013_20 + $year_2012_20 + $year_2011_20;
$year_all_21 = $year_2017_21 + $year_2016_21 + $year_2015_21 + $year_2014_21 + $year_2013_21 + $year_2012_21 + $year_2011_21;
$year_all_22 = $year_2017_22 + $year_2016_22 + $year_2015_22 + $year_2014_22 + $year_2013_22 + $year_2012_22 + $year_2011_22;
$year_all_23 = $year_2017_23 + $year_2016_23 + $year_2015_23 + $year_2014_23 + $year_2013_23 + $year_2012_23 + $year_2011_23;
$year_all_24 = $year_2017_24 + $year_2016_24 + $year_2015_24 + $year_2014_24 + $year_2013_24 + $year_2012_24 + $year_2011_24;
$year_all_25 = $year_2017_25 + $year_2016_25 + $year_2015_25 + $year_2014_25 + $year_2013_25 + $year_2012_25 + $year_2011_25;
$year_all_26 = $year_2017_26 + $year_2016_26 + $year_2015_26 + $year_2014_26 + $year_2013_26 + $year_2012_26 + $year_2011_26;
$year_all_27 = $year_2017_27 + $year_2016_27 + $year_2015_27 + $year_2014_27 + $year_2013_27 + $year_2012_27 + $year_2011_27;
$year_all_28 = $year_2017_28 + $year_2016_28 + $year_2015_28 + $year_2014_28 + $year_2013_28 + $year_2012_28 + $year_2011_28;
$year_all_29 = $year_2017_29 + $year_2016_29 + $year_2015_29 + $year_2014_29 + $year_2013_29 + $year_2012_29 + $year_2011_29;
$year_all_30 = $year_2017_30 + $year_2016_30 + $year_2015_30 + $year_2014_30 + $year_2013_30 + $year_2012_30 + $year_2011_30;
$year_all_31 = $year_2017_31 + $year_2016_31 + $year_2015_31 + $year_2014_31 + $year_2013_31 + $year_2012_31 + $year_2011_31;
$year_all_32 = $year_2017_32 + $year_2016_32 + $year_2015_32 + $year_2014_32 + $year_2013_32 + $year_2012_32 + $year_2011_32;
$year_all_33 = $year_2017_33 + $year_2016_33 + $year_2015_33 + $year_2014_33 + $year_2013_33 + $year_2012_33 + $year_2011_33;
$year_all_34 = $year_2017_34 + $year_2016_34 + $year_2015_34 + $year_2014_34 + $year_2013_34 + $year_2012_34 + $year_2011_34;
$year_all_35 = $year_2017_35 + $year_2016_35 + $year_2015_35 + $year_2014_35 + $year_2013_35 + $year_2012_35 + $year_2011_35;
$year_all_36 = $year_2017_36 + $year_2016_36 + $year_2015_36 + $year_2014_36 + $year_2013_36 + $year_2012_36 + $year_2011_36;
$year_all_37 = $year_2017_37 + $year_2016_37 + $year_2015_37 + $year_2014_37 + $year_2013_37 + $year_2012_37 + $year_2011_37;
$year_all_38 = $year_2017_38 + $year_2016_38 + $year_2015_38 + $year_2014_38 + $year_2013_38 + $year_2012_38 + $year_2011_38;
$year_all_39 = $year_2017_39 + $year_2016_39 + $year_2015_39 + $year_2014_39 + $year_2013_39 + $year_2012_39 + $year_2011_39;
$year_all_40 = $year_2017_40 + $year_2016_40 + $year_2015_40 + $year_2014_40 + $year_2013_40 + $year_2012_40 + $year_2011_40;
$year_all_41 = $year_2017_41 + $year_2016_41 + $year_2015_41 + $year_2014_41 + $year_2013_41 + $year_2012_41 + $year_2011_41;
$year_all_42 = $year_2017_42 + $year_2016_42 + $year_2015_42 + $year_2014_42 + $year_2013_42 + $year_2012_42 + $year_2011_42;
$year_all_43 = $year_2017_43 + $year_2016_43 + $year_2015_43 + $year_2014_43 + $year_2013_43 + $year_2012_43 + $year_2011_43;
$year_all_44 = $year_2017_44 + $year_2016_44 + $year_2015_44 + $year_2014_44 + $year_2013_44 + $year_2012_44 + $year_2011_44;
$year_all_45 = $year_2017_45 + $year_2016_45 + $year_2015_45 + $year_2014_45 + $year_2013_45 + $year_2012_45 + $year_2011_45;
$year_all_46 = $year_2017_46 + $year_2016_46 + $year_2015_46 + $year_2014_46 + $year_2013_46 + $year_2012_46 + $year_2011_46;
$year_all_47 = $year_2017_47 + $year_2016_47 + $year_2015_47 + $year_2014_47 + $year_2013_47 + $year_2012_47 + $year_2011_47;
$year_all_48 = $year_2017_48 + $year_2016_48 + $year_2015_48 + $year_2014_48 + $year_2013_48 + $year_2012_48 + $year_2011_48;
$year_all_49 = $year_2017_49 + $year_2016_49 + $year_2015_49 + $year_2014_49 + $year_2013_49 + $year_2012_49 + $year_2011_49;


$year_2017_all = $year_2017_1 + $year_2017_2 + $year_2017_3 + $year_2017_4 + $year_2017_5 + $year_2017_6 + $year_2017_7 + $year_2017_8 + $year_2017_9 + $year_2017_10 + $year_2017_11 + $year_2017_12 + $year_2017_13 + $year_2017_14 + $year_2017_15 + $year_2017_16 + $year_2017_17 + $year_2017_18 + $year_2017_19 + $year_2017_20 + $year_2017_21 + $year_2017_22 + $year_2017_23 + $year_2017_24 + $year_2017_25 + $year_2017_26 + $year_2017_27 + $year_2017_28 + $year_2017_29 + $year_2017_30 + $year_2017_31 + $year_2017_32 + $year_2017_33 + $year_2017_34 + $year_2017_35 + $year_2017_36 + $year_2017_37 + $year_2017_38 + $year_2017_39 + $year_2017_40 + $year_2017_41 + $year_2017_42 + $year_2017_43 + $year_2017_44 + $year_2017_45 + $year_2017_46 + $year_2017_47 + $year_2017_48 + $year_2017_49;
$year_2016_all = $year_2016_1 + $year_2016_2 + $year_2016_3 + $year_2016_4 + $year_2016_5 + $year_2016_6 + $year_2016_7 + $year_2016_8 + $year_2016_9 + $year_2016_10 + $year_2016_11 + $year_2016_12 + $year_2016_13 + $year_2016_14 + $year_2016_15 + $year_2016_16 + $year_2016_17 + $year_2016_18 + $year_2016_19 + $year_2016_20 + $year_2016_21 + $year_2016_22 + $year_2016_23 + $year_2016_24 + $year_2016_25 + $year_2016_26 + $year_2016_27 + $year_2016_28 + $year_2016_29 + $year_2016_30 + $year_2016_31 + $year_2016_32 + $year_2016_33 + $year_2016_34 + $year_2016_35 + $year_2016_36 + $year_2016_37 + $year_2016_38 + $year_2016_39 + $year_2016_40 + $year_2016_41 + $year_2016_42 + $year_2016_43 + $year_2016_44 + $year_2016_45 + $year_2016_46 + $year_2016_47 + $year_2016_48 + $year_2016_49;
$year_2015_all = $year_2015_1 + $year_2015_2 + $year_2015_3 + $year_2015_4 + $year_2015_5 + $year_2015_6 + $year_2015_7 + $year_2015_8 + $year_2015_9 + $year_2015_10 + $year_2015_11 + $year_2015_12 + $year_2015_13 + $year_2015_14 + $year_2015_15 + $year_2015_16 + $year_2015_17 + $year_2015_18 + $year_2015_19 + $year_2015_20 + $year_2015_21 + $year_2015_22 + $year_2015_23 + $year_2015_24 + $year_2015_25 + $year_2015_26 + $year_2015_27 + $year_2015_28 + $year_2015_29 + $year_2015_30 + $year_2015_31 + $year_2015_32 + $year_2015_33 + $year_2015_34 + $year_2015_35 + $year_2015_36 + $year_2015_37 + $year_2015_38 + $year_2015_39 + $year_2015_40 + $year_2015_41 + $year_2015_42 + $year_2015_43 + $year_2015_44 + $year_2015_45 + $year_2015_46 + $year_2015_47 + $year_2015_48 + $year_2015_49;
$year_2014_all = $year_2014_1 + $year_2014_2 + $year_2014_3 + $year_2014_4 + $year_2014_5 + $year_2014_6 + $year_2014_7 + $year_2014_8 + $year_2014_9 + $year_2014_10 + $year_2014_11 + $year_2014_12 + $year_2014_13 + $year_2014_14 + $year_2014_15 + $year_2014_16 + $year_2014_17 + $year_2014_18 + $year_2014_19 + $year_2014_20 + $year_2014_21 + $year_2014_22 + $year_2014_23 + $year_2014_24 + $year_2014_25 + $year_2014_26 + $year_2014_27 + $year_2014_28 + $year_2014_29 + $year_2014_30 + $year_2014_31 + $year_2014_32 + $year_2014_33 + $year_2014_34 + $year_2014_35 + $year_2014_36 + $year_2014_37 + $year_2014_38 + $year_2014_39 + $year_2014_40 + $year_2014_41 + $year_2014_42 + $year_2014_43 + $year_2014_44 + $year_2014_45 + $year_2014_46 + $year_2014_47 + $year_2014_48 + $year_2014_49;
$year_2013_all = $year_2013_1 + $year_2013_2 + $year_2013_3 + $year_2013_4 + $year_2013_5 + $year_2013_6 + $year_2013_7 + $year_2013_8 + $year_2013_9 + $year_2013_10 + $year_2013_11 + $year_2013_12 + $year_2013_13 + $year_2013_14 + $year_2013_15 + $year_2013_16 + $year_2013_17 + $year_2013_18 + $year_2013_19 + $year_2013_20 + $year_2013_21 + $year_2013_22 + $year_2013_23 + $year_2013_24 + $year_2013_25 + $year_2013_26 + $year_2013_27 + $year_2013_28 + $year_2013_29 + $year_2013_30 + $year_2013_31 + $year_2013_32 + $year_2013_33 + $year_2013_34 + $year_2013_35 + $year_2013_36 + $year_2013_37 + $year_2013_38 + $year_2013_39 + $year_2013_40 + $year_2013_41 + $year_2013_42 + $year_2013_43 + $year_2013_44 + $year_2013_45 + $year_2013_46 + $year_2013_47 + $year_2013_48 + $year_2013_49;
$year_2012_all = $year_2012_1 + $year_2012_2 + $year_2012_3 + $year_2012_4 + $year_2012_5 + $year_2012_6 + $year_2012_7 + $year_2012_8 + $year_2012_9 + $year_2012_10 + $year_2012_11 + $year_2012_12 + $year_2012_13 + $year_2012_14 + $year_2012_15 + $year_2012_16 + $year_2012_17 + $year_2012_18 + $year_2012_19 + $year_2012_20 + $year_2012_21 + $year_2012_22 + $year_2012_23 + $year_2012_24 + $year_2012_25 + $year_2012_26 + $year_2012_27 + $year_2012_28 + $year_2012_29 + $year_2012_30 + $year_2012_31 + $year_2012_32 + $year_2012_33 + $year_2012_34 + $year_2012_35 + $year_2012_36 + $year_2012_37 + $year_2012_38 + $year_2012_39 + $year_2012_40 + $year_2012_41 + $year_2012_42 + $year_2012_43 + $year_2012_44 + $year_2012_45 + $year_2012_46 + $year_2012_47 + $year_2012_48 + $year_2012_49;
$year_2011_all = $year_2011_1 + $year_2011_2 + $year_2011_3 + $year_2011_4 + $year_2011_5 + $year_2011_6 + $year_2011_7 + $year_2011_8 + $year_2011_9 + $year_2011_10 + $year_2011_11 + $year_2011_12 + $year_2011_13 + $year_2011_14 + $year_2011_15 + $year_2011_16 + $year_2011_17 + $year_2011_18 + $year_2011_19 + $year_2011_20 + $year_2011_21 + $year_2011_22 + $year_2011_23 + $year_2011_24 + $year_2011_25 + $year_2011_26 + $year_2011_27 + $year_2011_28 + $year_2011_29 + $year_2011_30 + $year_2011_31 + $year_2011_32 + $year_2011_33 + $year_2011_34 + $year_2011_35 + $year_2011_36 + $year_2011_37 + $year_2011_38 + $year_2011_39 + $year_2011_40 + $year_2011_41 + $year_2011_42 + $year_2011_43 + $year_2011_44 + $year_2011_45 + $year_2011_46 + $year_2011_47 + $year_2011_48 + $year_2011_49;


$year_all = $year_2017_all + $year_2016_all + $year_2015_all + $year_2014_all + $year_2013_all + $year_2012_all + $year_2011_all;

$re_data = '[{"title":"针织衫","year_2017":"'. $year_2017_1 .'","year_2016":"'. $year_2016_1 .'","year_2015":"'. $year_2015_1 .'","year_2014":"'. $year_2014_1 .'","year_2013":"'. $year_2013_1 .'","year_2012":"'. $year_2012_1 .'","year_2011":"'. $year_2011_1 .'","year_all":"'. $year_all_1 .'"},';
$re_data .= '{"title":"羽绒服","year_2017":"'. $year_2017_2 .'","year_2016":"'. $year_2016_2 .'","year_2015":"'. $year_2015_2 .'","year_2014":"'. $year_2014_2 .'","year_2013":"'. $year_2013_2 .'","year_2012":"'. $year_2012_2 .'","year_2011":"'. $year_2011_2 .'","year_all":"'. $year_all_2 .'"},';
$re_data .= '{"title":"真丝短袖衫","year_2017":"'. $year_2017_3 .'","year_2016":"'. $year_2016_3 .'","year_2015":"'. $year_2015_3 .'","year_2014":"'. $year_2014_3 .'","year_2013":"'. $year_2013_3 .'","year_2012":"'. $year_2012_3 .'","year_2011":"'. $year_2011_3 .'","year_all":"'. $year_all_3 .'"},';
$re_data .= '{"title":"棉袄","year_2017":"'. $year_2017_4 .'","year_2016":"'. $year_2016_4 .'","year_2015":"'. $year_2015_4 .'","year_2014":"'. $year_2014_4 .'","year_2013":"'. $year_2013_4 .'","year_2012":"'. $year_2012_4 .'","year_2011":"'. $year_2011_4 .'","year_all":"'. $year_all_4 .'"},';
$re_data .= '{"title":"短棉袄","year_2017":"'. $year_2017_5 .'","year_2016":"'. $year_2016_5 .'","year_2015":"'. $year_2015_5 .'","year_2014":"'. $year_2014_5 .'","year_2013":"'. $year_2013_5 .'","year_2012":"'. $year_2012_5 .'","year_2011":"'. $year_2011_5 .'","year_all":"'. $year_all_5 .'"},';
$re_data .= '{"title":"真丝连衣裙","year_2017":"'. $year_2017_6 .'","year_2016":"'. $year_2016_6 .'","year_2015":"'. $year_2015_6 .'","year_2014":"'. $year_2014_6 .'","year_2013":"'. $year_2013_6 .'","year_2012":"'. $year_2012_6 .'","year_2011":"'. $year_2011_6 .'","year_all":"'. $year_all_6 .'"},';
$re_data .= '{"title":"上衣","year_2017":"'. $year_2017_7 .'","year_2016":"'. $year_2016_7 .'","year_2015":"'. $year_2015_7 .'","year_2014":"'. $year_2014_7 .'","year_2013":"'. $year_2013_7 .'","year_2012":"'. $year_2012_7 .'","year_2011":"'. $year_2011_7 .'","year_all":"'. $year_all_7 .'"},';
$re_data .= '{"title":"两件套","year_2017":"'. $year_2017_8 .'","year_2016":"'. $year_2016_8 .'","year_2015":"'. $year_2015_8 .'","year_2014":"'. $year_2014_8 .'","year_2013":"'. $year_2013_8 .'","year_2012":"'. $year_2012_8 .'","year_2011":"'. $year_2011_8 .'","year_all":"'. $year_all_8 .'"},';
$re_data .= '{"title":"女上装","year_2017":"'. $year_2017_9 .'","year_2016":"'. $year_2016_9 .'","year_2015":"'. $year_2015_9 .'","year_2014":"'. $year_2014_9 .'","year_2013":"'. $year_2013_9 .'","year_2012":"'. $year_2012_9 .'","year_2011":"'. $year_2011_9 .'","year_all":"'. $year_all_9 .'"},';
$re_data .= '{"title":"尼克服","year_2017":"'. $year_2017_10 .'","year_2016":"'. $year_2016_10 .'","year_2015":"'. $year_2015_10 .'","year_2014":"'. $year_2014_10 .'","year_2013":"'. $year_2013_10 .'","year_2012":"'. $year_2012_10 .'","year_2011":"'. $year_2011_10 .'","year_all":"'. $year_all_10 .'"},';
$re_data .= '{"title":"女裤","year_2017":"'. $year_2017_11 .'","year_2016":"'. $year_2016_11 .'","year_2015":"'. $year_2015_11 .'","year_2014":"'. $year_2014_11 .'","year_2013":"'. $year_2013_11 .'","year_2012":"'. $year_2012_11 .'","year_2011":"'. $year_2011_11 .'","year_all":"'. $year_all_11 .'"},';
$re_data .= '{"title":"背心","year_2017":"'. $year_2017_12 .'","year_2016":"'. $year_2016_12 .'","year_2015":"'. $year_2015_12 .'","year_2014":"'. $year_2014_12 .'","year_2013":"'. $year_2013_12 .'","year_2012":"'. $year_2012_12 .'","year_2011":"'. $year_2011_12 .'","year_all":"'. $year_all_12 .'"},';
$re_data .= '{"title":"连衣裙","year_2017":"'. $year_2017_13 .'","year_2016":"'. $year_2016_13 .'","year_2015":"'. $year_2015_13 .'","year_2014":"'. $year_2014_13 .'","year_2013":"'. $year_2013_13 .'","year_2012":"'. $year_2012_13 .'","year_2011":"'. $year_2011_13 .'","year_all":"'. $year_all_13 .'"},';
$re_data .= '{"title":"风衣","year_2017":"'. $year_2017_14 .'","year_2016":"'. $year_2016_14 .'","year_2015":"'. $year_2015_14 .'","year_2014":"'. $year_2014_14 .'","year_2013":"'. $year_2013_14 .'","year_2012":"'. $year_2012_14 .'","year_2011":"'. $year_2011_14 .'","year_all":"'. $year_all_14 .'"},';
$re_data .= '{"title":"大衣","year_2017":"'. $year_2017_15 .'","year_2016":"'. $year_2016_15 .'","year_2015":"'. $year_2015_15 .'","year_2014":"'. $year_2014_15 .'","year_2013":"'. $year_2013_15 .'","year_2012":"'. $year_2012_15 .'","year_2011":"'. $year_2011_15 .'","year_all":"'. $year_all_15 .'"},';
$re_data .= '{"title":"羽绒裤","year_2017":"'. $year_2017_16 .'","year_2016":"'. $year_2016_16 .'","year_2015":"'. $year_2015_16 .'","year_2014":"'. $year_2014_16 .'","year_2013":"'. $year_2013_16 .'","year_2012":"'. $year_2012_16 .'","year_2011":"'. $year_2011_16 .'","year_all":"'. $year_all_16 .'"},';
$re_data .= '{"title":"呢大衣","year_2017":"'. $year_2017_17 .'","year_2016":"'. $year_2016_17 .'","year_2015":"'. $year_2015_17 .'","year_2014":"'. $year_2014_17 .'","year_2013":"'. $year_2013_17 .'","year_2012":"'. $year_2012_17 .'","year_2011":"'. $year_2011_17 .'","year_all":"'. $year_all_17 .'"},';
$re_data .= '{"title":"短袖衫","year_2017":"'. $year_2017_18 .'","year_2016":"'. $year_2016_18 .'","year_2015":"'. $year_2015_18 .'","year_2014":"'. $year_2014_18 .'","year_2013":"'. $year_2013_18 .'","year_2012":"'. $year_2012_18 .'","year_2011":"'. $year_2011_18 .'","year_all":"'. $year_all_18 .'"},';
$re_data .= '{"title":"真皮大衣","year_2017":"'. $year_2017_19 .'","year_2016":"'. $year_2016_19 .'","year_2015":"'. $year_2015_19 .'","year_2014":"'. $year_2014_19 .'","year_2013":"'. $year_2013_19 .'","year_2012":"'. $year_2012_19 .'","year_2011":"'. $year_2011_19 .'","year_all":"'. $year_all_19 .'"},';
$re_data .= '{"title":"牛仔裤","year_2017":"'. $year_2017_20 .'","year_2016":"'. $year_2016_20 .'","year_2015":"'. $year_2015_20 .'","year_2014":"'. $year_2014_20 .'","year_2013":"'. $year_2013_20 .'","year_2012":"'. $year_2012_20 .'","year_2011":"'. $year_2011_20 .'","year_all":"'. $year_all_20 .'"},';
$re_data .= '{"title":"马夹","year_2017":"'. $year_2017_21 .'","year_2016":"'. $year_2016_21 .'","year_2015":"'. $year_2015_21 .'","year_2014":"'. $year_2014_21 .'","year_2013":"'. $year_2013_21 .'","year_2012":"'. $year_2012_21 .'","year_2011":"'. $year_2011_21 .'","year_all":"'. $year_all_21 .'"},';
$re_data .= '{"title":"短裙","year_2017":"'. $year_2017_22 .'","year_2016":"'. $year_2016_22 .'","year_2015":"'. $year_2015_22 .'","year_2014":"'. $year_2014_22 .'","year_2013":"'. $year_2013_22 .'","year_2012":"'. $year_2012_22 .'","year_2011":"'. $year_2011_22 .'","year_all":"'. $year_all_22 .'"},';
$re_data .= '{"title":"棉裤","year_2017":"'. $year_2017_23 .'","year_2016":"'. $year_2016_23 .'","year_2015":"'. $year_2015_23 .'","year_2014":"'. $year_2014_23 .'","year_2013":"'. $year_2013_23 .'","year_2012":"'. $year_2012_23 .'","year_2011":"'. $year_2011_23 .'","year_all":"'. $year_all_23 .'"},';
$re_data .= '{"title":"套装","year_2017":"'. $year_2017_24 .'","year_2016":"'. $year_2016_24 .'","year_2015":"'. $year_2015_24 .'","year_2014":"'. $year_2014_24 .'","year_2013":"'. $year_2013_24 .'","year_2012":"'. $year_2012_24 .'","year_2011":"'. $year_2011_24 .'","year_all":"'. $year_all_24 .'"},';
$re_data .= '{"title":"女上衣","year_2017":"'. $year_2017_25 .'","year_2016":"'. $year_2016_25 .'","year_2015":"'. $year_2015_25 .'","year_2014":"'. $year_2014_25 .'","year_2013":"'. $year_2013_25 .'","year_2012":"'. $year_2012_25 .'","year_2011":"'. $year_2011_25 .'","year_all":"'. $year_all_25 .'"},';
$re_data .= '{"title":"针织两件套","year_2017":"'. $year_2017_26 .'","year_2016":"'. $year_2016_26 .'","year_2015":"'. $year_2015_26 .'","year_2014":"'. $year_2014_26 .'","year_2013":"'. $year_2013_26 .'","year_2012":"'. $year_2012_26 .'","year_2011":"'. $year_2011_26 .'","year_all":"'. $year_all_26 .'"},';
$re_data .= '{"title":"针织上衣","year_2017":"'. $year_2017_27 .'","year_2016":"'. $year_2016_27 .'","year_2015":"'. $year_2015_27 .'","year_2014":"'. $year_2014_27 .'","year_2013":"'. $year_2013_27 .'","year_2012":"'. $year_2012_27 .'","year_2011":"'. $year_2011_27 .'","year_all":"'. $year_all_27 .'"},';
$re_data .= '{"title":"呢上衣","year_2017":"'. $year_2017_28 .'","year_2016":"'. $year_2016_28 .'","year_2015":"'. $year_2015_28 .'","year_2014":"'. $year_2014_28 .'","year_2013":"'. $year_2013_28 .'","year_2012":"'. $year_2012_28 .'","year_2011":"'. $year_2011_28 .'","year_all":"'. $year_all_28 .'"},';
$re_data .= '{"title":"女风衣","year_2017":"'. $year_2017_29 .'","year_2016":"'. $year_2016_29 .'","year_2015":"'. $year_2015_29 .'","year_2014":"'. $year_2014_29 .'","year_2013":"'. $year_2013_29 .'","year_2012":"'. $year_2012_29 .'","year_2011":"'. $year_2011_29 .'","year_all":"'. $year_all_29 .'"},';
$re_data .= '{"title":"棉风衣","year_2017":"'. $year_2017_30 .'","year_2016":"'. $year_2016_30 .'","year_2015":"'. $year_2015_30 .'","year_2014":"'. $year_2014_30 .'","year_2013":"'. $year_2013_30 .'","year_2012":"'. $year_2012_30 .'","year_2011":"'. $year_2011_30 .'","year_all":"'. $year_all_30 .'"},';
$re_data .= '{"title":"皮风衣","year_2017":"'. $year_2017_31 .'","year_2016":"'. $year_2016_31 .'","year_2015":"'. $year_2015_31 .'","year_2014":"'. $year_2014_31 .'","year_2013":"'. $year_2013_31 .'","year_2012":"'. $year_2012_31 .'","year_2011":"'. $year_2011_31 .'","year_all":"'. $year_all_31 .'"},';
$re_data .= '{"title":"女中裤","year_2017":"'. $year_2017_32 .'","year_2016":"'. $year_2016_32 .'","year_2015":"'. $year_2015_32 .'","year_2014":"'. $year_2014_32 .'","year_2013":"'. $year_2013_32 .'","year_2012":"'. $year_2012_32 .'","year_2011":"'. $year_2011_32 .'","year_all":"'. $year_all_32 .'"},';
$re_data .= '{"title":"女长裤","year_2017":"'. $year_2017_33 .'","year_2016":"'. $year_2016_33 .'","year_2015":"'. $year_2015_33 .'","year_2014":"'. $year_2014_33 .'","year_2013":"'. $year_2013_33 .'","year_2012":"'. $year_2012_33 .'","year_2011":"'. $year_2011_33 .'","year_all":"'. $year_all_33 .'"},';
$re_data .= '{"title":"中裤","year_2017":"'. $year_2017_34 .'","year_2016":"'. $year_2016_34 .'","year_2015":"'. $year_2015_34 .'","year_2014":"'. $year_2014_34 .'","year_2013":"'. $year_2013_34 .'","year_2012":"'. $year_2012_34 .'","year_2011":"'. $year_2011_34 .'","year_all":"'. $year_all_34 .'"},';
$re_data .= '{"title":"旗袍","year_2017":"'. $year_2017_35 .'","year_2016":"'. $year_2016_35 .'","year_2015":"'. $year_2015_35 .'","year_2014":"'. $year_2014_35 .'","year_2013":"'. $year_2013_35 .'","year_2012":"'. $year_2012_35 .'","year_2011":"'. $year_2011_35 .'","year_all":"'. $year_all_35 .'"},';
$re_data .= '{"title":"棉背心","year_2017":"'. $year_2017_36 .'","year_2016":"'. $year_2016_36 .'","year_2015":"'. $year_2015_36 .'","year_2014":"'. $year_2014_36 .'","year_2013":"'. $year_2013_36 .'","year_2012":"'. $year_2012_36 .'","year_2011":"'. $year_2011_36 .'","year_all":"'. $year_all_36 .'"},';
$re_data .= '{"title":"针织裙","year_2017":"'. $year_2017_37 .'","year_2016":"'. $year_2016_37 .'","year_2015":"'. $year_2015_37 .'","year_2014":"'. $year_2014_37 .'","year_2013":"'. $year_2013_37 .'","year_2012":"'. $year_2012_37 .'","year_2011":"'. $year_2011_37 .'","year_all":"'. $year_all_37 .'"},';
$re_data .= '{"title":"新娘装","year_2017":"'. $year_2017_38 .'","year_2016":"'. $year_2016_38 .'","year_2015":"'. $year_2015_38 .'","year_2014":"'. $year_2014_38 .'","year_2013":"'. $year_2013_38 .'","year_2012":"'. $year_2012_38 .'","year_2011":"'. $year_2011_38 .'","year_all":"'. $year_all_38 .'"},';
$re_data .= '{"title":"针织连衣裙","year_2017":"'. $year_2017_39 .'","year_2016":"'. $year_2016_39 .'","year_2015":"'. $year_2015_39 .'","year_2014":"'. $year_2014_39 .'","year_2013":"'. $year_2013_39 .'","year_2012":"'. $year_2012_39 .'","year_2011":"'. $year_2011_39 .'","year_all":"'. $year_all_39 .'"},';
$re_data .= '{"title":"针织女裤","year_2017":"'. $year_2017_40 .'","year_2016":"'. $year_2016_40 .'","year_2015":"'. $year_2015_40 .'","year_2014":"'. $year_2014_40 .'","year_2013":"'. $year_2013_40 .'","year_2012":"'. $year_2012_40 .'","year_2011":"'. $year_2011_40 .'","year_all":"'. $year_all_40 .'"},';
$re_data .= '{"title":"针织短袖","year_2017":"'. $year_2017_41 .'","year_2016":"'. $year_2016_41 .'","year_2015":"'. $year_2015_41 .'","year_2014":"'. $year_2014_41 .'","year_2013":"'. $year_2013_41 .'","year_2012":"'. $year_2012_41 .'","year_2011":"'. $year_2011_41 .'","year_all":"'. $year_all_41 .'"},';
$re_data .= '{"title":"套裙","year_2017":"'. $year_2017_42 .'","year_2016":"'. $year_2016_42 .'","year_2015":"'. $year_2015_42 .'","year_2014":"'. $year_2014_42 .'","year_2013":"'. $year_2013_42 .'","year_2012":"'. $year_2012_42 .'","year_2011":"'. $year_2011_42 .'","year_all":"'. $year_all_42 .'"},';
$re_data .= '{"title":"棉短袖","year_2017":"'. $year_2017_43 .'","year_2016":"'. $year_2016_43 .'","year_2015":"'. $year_2015_43 .'","year_2014":"'. $year_2014_43 .'","year_2013":"'. $year_2013_43 .'","year_2012":"'. $year_2012_43 .'","year_2011":"'. $year_2011_43 .'","year_all":"'. $year_all_43 .'"},';
$re_data .= '{"title":"两件套上衣","year_2017":"'. $year_2017_44 .'","year_2016":"'. $year_2016_44 .'","year_2015":"'. $year_2015_44 .'","year_2014":"'. $year_2014_44 .'","year_2013":"'. $year_2013_44 .'","year_2012":"'. $year_2012_44 .'","year_2011":"'. $year_2011_44 .'","year_all":"'. $year_all_44 .'"},';
$re_data .= '{"title":"四面弹女裤","year_2017":"'. $year_2017_45 .'","year_2016":"'. $year_2016_45 .'","year_2015":"'. $year_2015_45 .'","year_2014":"'. $year_2014_45 .'","year_2013":"'. $year_2013_45 .'","year_2012":"'. $year_2012_45 .'","year_2011":"'. $year_2011_45 .'","year_all":"'. $year_all_45 .'"},';
$re_data .= '{"title":"锦棉绉女裤","year_2017":"'. $year_2017_46 .'","year_2016":"'. $year_2016_46 .'","year_2015":"'. $year_2015_46 .'","year_2014":"'. $year_2014_46 .'","year_2013":"'. $year_2013_46 .'","year_2012":"'. $year_2012_46 .'","year_2011":"'. $year_2011_46 .'","year_all":"'. $year_all_46 .'"},';
$re_data .= '{"title":"锦棉绉风衣","year_2017":"'. $year_2017_47 .'","year_2016":"'. $year_2016_47 .'","year_2015":"'. $year_2015_47 .'","year_2014":"'. $year_2014_47 .'","year_2013":"'. $year_2013_47 .'","year_2012":"'. $year_2012_47 .'","year_2011":"'. $year_2011_47 .'","year_all":"'. $year_all_47 .'"},';
$re_data .= '{"title":"锦棉绉女风衣","year_2017":"'. $year_2017_48 .'","year_2016":"'. $year_2016_48 .'","year_2015":"'. $year_2015_48 .'","year_2014":"'. $year_2014_48 .'","year_2013":"'. $year_2013_48 .'","year_2012":"'. $year_2012_48 .'","year_2011":"'. $year_2011_48 .'","year_all":"'. $year_all_48 .'"},';
$re_data .= '{"title":"锦棉绉棉袄","year_2017":"'. $year_2017_49 .'","year_2016":"'. $year_2016_49 .'","year_2015":"'. $year_2015_49 .'","year_2014":"'. $year_2014_49 .'","year_2013":"'. $year_2013_49 .'","year_2012":"'. $year_2012_49 .'","year_2011":"'. $year_2011_49 .'","year_all":"'. $year_all_49 .'"},';
$re_data .= '{"title":"总计","year_2017":"'. $year_2017_all .'","year_2016":"'. $year_2016_all .'","year_2015":"'. $year_2015_all .'","year_2014":"'. $year_2014_all .'","year_2013":"'. $year_2013_all .'","year_2012":"'. $year_2012_all .'","year_2011":"'. $year_2011_all .'","year_all":"'. $year_all .'"}]';


echo $re_data;