<?php
/**
 * Created by PhpStorm.
 * User: Ein
 * Date: 17/3/8
 * Time: 下午1:52
 */

require('../../config/config_mysql.php');

$ein = new ein_mysql();
$ein->e_mysql_connect();

$qs = "SELECT * FROM `tbapi_yibu_goods_info`";
$data = $ein->e_mysql_search($qs);


$year_2017_spring = 0;
$year_2017_summer = 0;
$year_2017_autumn = 0;
$year_2017_winter = 0;

$year_2016_spring = 0;
$year_2016_summer = 0;
$year_2016_autumn = 0;
$year_2016_winter = 0;

$year_2015_spring = 0;
$year_2015_summer = 0;
$year_2015_autumn = 0;
$year_2015_winter = 0;

$year_2014_spring = 0;
$year_2014_summer = 0;
$year_2014_autumn = 0;
$year_2014_winter = 0;

$year_2013_spring = 0;
$year_2013_summer = 0;
$year_2013_autumn = 0;
$year_2013_winter = 0;

$year_2012_spring = 0;
$year_2012_summer = 0;
$year_2012_autumn = 0;
$year_2012_winter = 0;

$year_2011_spring = 0;
$year_2011_summer = 0;
$year_2011_autumn = 0;
$year_2011_winter = 0;


foreach($data as $v){
    $goods_year = $v['goods_year'];
    $goods_season = $v['goods_season'];

    switch($goods_year){
        case "2017":
            switch($goods_season){
                case "春装":
                    $year_2017_spring = $year_2017_spring + $v['num_ds_ck'];
                    break;
                case "夏装":
                    $year_2017_summer = $year_2017_summer + $v['num_ds_ck'];
                    break;
                case "秋装":
                    $year_2017_autumn = $year_2017_autumn + $v['num_ds_ck'];
                    break;
                case "冬装":
                    $year_2017_winter = $year_2017_winter + $v['num_ds_ck'];
                    break;
            }
            break;
        case "2016":
            switch($goods_season){
                case "春装":
                    $year_2016_spring = $year_2016_spring + $v['num_ds_ck'];
                    break;
                case "夏装":
                    $year_2016_summer = $year_2016_summer + $v['num_ds_ck'];
                    break;
                case "秋装":
                    $year_2016_autumn = $year_2016_autumn + $v['num_ds_ck'];
                    break;
                case "冬装":
                    $year_2016_winter = $year_2016_winter + $v['num_ds_ck'];
                    break;
            }
            break;
        case "2015":
            switch($goods_season){
                case "春装":
                    $year_2015_spring = $year_2015_spring + $v['num_ds_ck'];
                    break;
                case "夏装":
                    $year_2015_summer = $year_2015_summer + $v['num_ds_ck'];
                    break;
                case "秋装":
                    $year_2015_autumn = $year_2015_autumn + $v['num_ds_ck'];
                    break;
                case "冬装":
                    $year_2015_winter = $year_2015_winter + $v['num_ds_ck'];
                    break;
            }
            break;
        case "2014":
            switch($goods_season){
                case "春装":
                    $year_2014_spring = $year_2014_spring + $v['num_ds_ck'];
                    break;
                case "夏装":
                    $year_2014_summer = $year_2014_summer + $v['num_ds_ck'];
                    break;
                case "秋装":
                    $year_2014_autumn = $year_2014_autumn + $v['num_ds_ck'];
                    break;
                case "冬装":
                    $year_2014_winter = $year_2014_winter + $v['num_ds_ck'];
                    break;
            }
            break;
        case "2013":
            switch($goods_season){
                case "春装":
                    $year_2013_spring = $year_2013_spring + $v['num_ds_ck'];
                    break;
                case "夏装":
                    $year_2013_summer = $year_2013_summer + $v['num_ds_ck'];
                    break;
                case "秋装":
                    $year_2013_autumn = $year_2013_autumn + $v['num_ds_ck'];
                    break;
                case "冬装":
                    $year_2013_winter = $year_2013_winter + $v['num_ds_ck'];
                    break;
            }
            break;
        case "2012":
            switch($goods_season){
                case "春装":
                    $year_2012_spring = $year_2012_spring + $v['num_ds_ck'];
                    break;
                case "夏装":
                    $year_2012_summer = $year_2012_summer + $v['num_ds_ck'];
                    break;
                case "秋装":
                    $year_2012_autumn = $year_2012_autumn + $v['num_ds_ck'];
                    break;
                case "冬装":
                    $year_2012_winter = $year_2012_winter + $v['num_ds_ck'];
                    break;
            }
            break;
        case "2011":
            switch($goods_season){
                case "春装":
                    $year_2011_spring = $year_2011_spring + $v['num_ds_ck'];
                    break;
                case "夏装":
                    $year_2011_summer = $year_2011_summer + $v['num_ds_ck'];
                    break;
                case "秋装":
                    $year_2011_autumn = $year_2011_autumn + $v['num_ds_ck'];
                    break;
                case "冬装":
                    $year_2011_winter = $year_2011_winter + $v['num_ds_ck'];
                    break;
            }
            break;

    }
}
$year_2017_all = $year_2017_spring + $year_2017_summer + $year_2017_autumn + $year_2017_winter;
$year_2016_all = $year_2016_spring + $year_2016_summer + $year_2016_autumn + $year_2016_winter;
$year_2015_all = $year_2015_spring + $year_2015_summer + $year_2015_autumn + $year_2015_winter;
$year_2014_all = $year_2014_spring + $year_2014_summer + $year_2014_autumn + $year_2014_winter;
$year_2013_all = $year_2013_spring + $year_2013_summer + $year_2013_autumn + $year_2013_winter;
$year_2012_all = $year_2012_spring + $year_2012_summer + $year_2012_autumn + $year_2012_winter;
$year_2011_all = $year_2011_spring + $year_2011_summer + $year_2011_autumn + $year_2011_winter;
$year_spring_all = $year_2017_spring + $year_2016_spring + $year_2015_spring + $year_2014_spring + $year_2013_spring + $year_2012_spring + $year_2011_spring;
$year_summer_all = $year_2017_summer + $year_2016_summer + $year_2015_summer + $year_2014_summer + $year_2013_summer + $year_2012_summer + $year_2011_summer;
$year_autumn_all = $year_2017_autumn + $year_2016_autumn + $year_2015_autumn + $year_2014_autumn + $year_2013_autumn + $year_2012_autumn + $year_2011_autumn;
$year_winter_all = $year_2017_winter + $year_2016_winter + $year_2015_winter + $year_2014_winter + $year_2013_winter + $year_2012_winter + $year_2011_winter;
$year_all = $year_spring_all + $year_summer_all + $year_autumn_all + $year_winter_all;


$re_data = '[{"title":"2017年","spring":"'. $year_2017_spring .'","summer":"'. $year_2017_summer .'","autumn":"'. $year_2017_autumn .'","winter":"'. $year_2017_winter .'","all":"'. $year_2017_all .'"},';
$re_data .= '{"title":"2016年","spring":"'. $year_2016_spring .'","summer":"'. $year_2016_summer .'","autumn":"'. $year_2016_autumn .'","winter":"'. $year_2016_winter .'","all":"'. $year_2016_all .'"},';
$re_data .= '{"title":"2015年","spring":"'. $year_2015_spring .'","summer":"'. $year_2015_summer .'","autumn":"'. $year_2015_autumn .'","winter":"'. $year_2015_winter .'","all":"'. $year_2015_all .'"},';
$re_data .= '{"title":"2014年","spring":"'. $year_2014_spring .'","summer":"'. $year_2014_summer .'","autumn":"'. $year_2014_autumn .'","winter":"'. $year_2014_winter .'","all":"'. $year_2014_all .'"},';
$re_data .= '{"title":"2013年","spring":"'. $year_2013_spring .'","summer":"'. $year_2013_summer .'","autumn":"'. $year_2013_autumn .'","winter":"'. $year_2013_winter .'","all":"'. $year_2013_all .'"},';
$re_data .= '{"title":"2012年","spring":"'. $year_2012_spring .'","summer":"'. $year_2012_summer .'","autumn":"'. $year_2012_autumn .'","winter":"'. $year_2012_winter .'","all":"'. $year_2012_all .'"},';
$re_data .= '{"title":"2011年","spring":"'. $year_2011_spring .'","summer":"'. $year_2011_summer .'","autumn":"'. $year_2011_autumn .'","winter":"'. $year_2011_winter .'","all":"'. $year_2011_all .'"},';
$re_data .= '{"title":"总计","spring":"'. $year_spring_all .'","summer":"'. $year_summer_all .'","autumn":"'. $year_autumn_all .'","winter":"'. $year_winter_all .'","all":"'. $year_all .'"}]';

echo $re_data;