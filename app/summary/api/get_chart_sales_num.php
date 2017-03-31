<?php
require('../../config/config_mysql.php');
$ein = new ein_mysql();
$ein->e_mysql_connect();

$season = $_GET['bottom'];


$qs = "SELECT * FROM `tbapi_yibu_goods_info`";
$data = $ein->e_mysql_search($qs);

$sales_volume_all = 0;
$sales_volume_spring_all = 0;
$sales_volume_summer_all = 0;
$sales_volume_autumn_all = 0;
$sales_volume_winter_all = 0;

$kc_num_spring = 0;
$kc_num_summer = 0;
$kc_num_autumn = 0;
$kc_num_winter = 0;

$sales_volume_2011 =0;
$sales_volume_2012 =0;
$sales_volume_2013 =0;
$sales_volume_2014 =0;
$sales_volume_2015 =0;
$sales_volume_2016 =0;
$sales_volume_2017 =0;

foreach($data as $v1){

    $sales_volume_7d = $v1['sales_volume_7d'];
    $sales_volume_all = $sales_volume_all + $sales_volume_7d;

    switch($v1['goods_season']){
        case "春装":
            $sales_volume_spring = $v1['sales_volume_7d'];
            $sales_volume_spring_all = $sales_volume_spring_all + $sales_volume_spring;

            $num_spring = $v1['num_ds_ck'];
            $kc_num_spring = $kc_num_spring + $num_spring;
            if($season=="春装"){
                switch($v1['goods_year']){
                    case 2011:
                        $sales_volume_2011 = $sales_volume_2011 + $sales_volume_spring;
                        break;
                    case 2012:
                        $sales_volume_2012 = $sales_volume_2012 + $sales_volume_spring;
                        break;
                    case 2013:
                        $sales_volume_2013 = $sales_volume_2013 + $sales_volume_spring;
                        break;
                    case 2014:
                        $sales_volume_2014 = $sales_volume_2014 + $sales_volume_spring;
                        break;
                    case 2015:
                        $sales_volume_2015 = $sales_volume_2015 + $sales_volume_spring;
                        break;
                    case 2016:
                        $sales_volume_2016 = $sales_volume_2016 + $sales_volume_spring;
                        break;
                    case 2017:
                        $sales_volume_2017 = $sales_volume_2017 + $sales_volume_spring;
                        break;
                }
            }

            break;
        case "夏装":
            $sales_volume_summer = $v1['sales_volume_7d'];
            $sales_volume_summer_all = $sales_volume_summer_all + $sales_volume_summer;

            $num_summer = $v1['num_ds_ck'];
            $kc_num_summer = $kc_num_summer + $num_summer;

            if($season=="夏装"){
                switch($v1['goods_year']){
                    case "2011":
                        $sales_volume_2011 = $sales_volume_2011 + $sales_volume_summer;
                        break;
                    case "2012":
                        $sales_volume_2012 = $sales_volume_2012 + $sales_volume_summer;
                        break;
                    case "2013":
                        $sales_volume_2013 = $sales_volume_2013 + $sales_volume_summer;
                        break;
                    case "2014":
                        $sales_volume_2014 = $sales_volume_2014 + $sales_volume_summer;
                        break;
                    case "2015":
                        $sales_volume_2015 = $sales_volume_2015 + $sales_volume_summer;
                        break;
                    case "2016":
                        $sales_volume_2016 = $sales_volume_2016 + $sales_volume_summer;
                        break;
                    case "2017":
                        $sales_volume_2017 = $sales_volume_2017 + $sales_volume_summer;
                        break;
                }
            }

            break;
        case "秋装":
            $sales_volume_autumn = $v1['sales_volume_7d'];
            $sales_volume_autumn_all = $sales_volume_autumn_all + $sales_volume_autumn;

            $num_autumn = $v1['num_ds_ck'];
            $kc_num_autumn = $kc_num_autumn + $num_autumn;


            if($season=="秋装"){
                switch($v1['goods_year']){
                    case "2011":
                        $sales_volume_2011 = $sales_volume_2011 + $sales_volume_autumn;
                        break;
                    case "2012":
                        $sales_volume_2012 = $sales_volume_2012 + $sales_volume_autumn;
                        break;
                    case "2013":
                        $sales_volume_2013 = $sales_volume_2013 + $sales_volume_autumn;
                        break;
                    case "2014":
                        $sales_volume_2014 = $sales_volume_2014 + $sales_volume_autumn;
                        break;
                    case "2015":
                        $sales_volume_2015 = $sales_volume_2015 + $sales_volume_autumn;
                        break;
                    case "2016":
                        $sales_volume_2016 = $sales_volume_2016 + $sales_volume_autumn;
                        break;
                    case "2017":
                        $sales_volume_2017 = $sales_volume_2017 + $sales_volume_autumn;
                        break;
                }
            }
            break;
        case "冬装":
            $sales_volume_winter = $v1['sales_volume_7d'];
            $sales_volume_winter_all = $sales_volume_winter_all + $sales_volume_winter;

            $num_winter = $v1['num_ds_ck'];
            $kc_num_winter = $kc_num_winter + $num_winter;

            if($season=="冬装"){
                switch($v1['goods_year']){
                    case "2011":
                        $sales_volume_2011 = $sales_volume_2011 + $sales_volume_winter;
                        break;
                    case "2012":
                        $sales_volume_2012 = $sales_volume_2012 + $sales_volume_winter;
                        break;
                    case "2013":
                        $sales_volume_2013 = $sales_volume_2013 + $sales_volume_winter;
                        break;
                    case "2014":
                        $sales_volume_2014 = $sales_volume_2014 + $sales_volume_winter;
                        break;
                    case "2015":
                        $sales_volume_2015 = $sales_volume_2015 + $sales_volume_winter;
                        break;
                    case "2016":
                        $sales_volume_2016 = $sales_volume_2016 + $sales_volume_winter;
                        break;
                    case "2017":
                        $sales_volume_2017 = $sales_volume_2017 + $sales_volume_winter;
                        break;
                }
            }
            break;
    }
}
$sales_volume_spring_percent = round((($sales_volume_spring_all / $sales_volume_all)*100),2);
$sales_volume_summer_percent = round((($sales_volume_summer_all / $sales_volume_all)*100),2);
$sales_volume_autumn_percent = round((($sales_volume_autumn_all / $sales_volume_all)*100),2);
$sales_volume_winter_percent = round((($sales_volume_winter_all / $sales_volume_all)*100),2);


$kxb_spring = round(($kc_num_spring / $sales_volume_spring_all),0);
$kxb_summer = round(($kc_num_summer / $sales_volume_summer_all),0);
$kxb_autumn = round(($kc_num_autumn / $sales_volume_autumn_all),0);
$kxb_winter = round(($kc_num_winter / $sales_volume_winter_all),0);

$sales_volume_percent = $sales_volume_spring_percent + $sales_volume_summer_percent + $sales_volume_autumn_percent + $sales_volume_winter_percent;
$kc_num = $kc_num_spring + $kc_num_summer + $kc_num_autumn + $kc_num_winter;
$kxb = round(($kc_num/$sales_volume_all),0);

$chart_list = '[';
$chart_list .= '{"value":'. $sales_volume_all .',"name":"总计","percent":"'. $sales_volume_percent .'%","kucun":'. $kc_num .',"day":'. $kxb .'},';
$chart_list .= '{"value":'. $sales_volume_spring_all .',"name":"春装","percent":"'. $sales_volume_spring_percent .'%","kucun":'. $kc_num_spring .',"day":'. $kxb_spring .'},';
$chart_list .= '{"value":'. $sales_volume_summer_all .',"name":"夏装","percent":"'. $sales_volume_summer_percent .'%","kucun":'. $kc_num_summer .',"day":'. $kxb_summer .'},';
$chart_list .= '{"value":'. $sales_volume_autumn_all .',"name":"秋装","percent":"'. $sales_volume_autumn_percent .'%","kucun":'. $kc_num_autumn .',"day":'. $kxb_autumn .'},';
$chart_list .= '{"value":'. $sales_volume_winter_all .',"name":"冬装","percent":"'. $sales_volume_winter_percent .'%","kucun":'. $kc_num_winter .',"day":'. $kxb_winter .'}';
$chart_list .= ']';

switch($season){
    case "春装":
    case "夏装":
    case "秋装":
    case "冬装":
        $chart = '[';
        $chart .= '{"value":'. $sales_volume_2011 .',"name":"2011"},';
        $chart .= '{"value":'. $sales_volume_2012 .',"name":"2012"},';
        $chart .= '{"value":'. $sales_volume_2013 .',"name":"2013"},';
        $chart .= '{"value":'. $sales_volume_2014 .',"name":"2014"},';
        $chart .= '{"value":'. $sales_volume_2015 .',"name":"2015"},';
        $chart .= '{"value":'. $sales_volume_2016 .',"name":"2016"},';
        $chart .= '{"value":'. $sales_volume_2017 .',"name":"2017"}';
        $chart .= ']';
        break;
    default:
        $chart = '[';
        $chart .= '{"value":'. $sales_volume_spring_all .',"name":"春装"},';
        $chart .= '{"value":'. $sales_volume_summer_all .',"name":"夏装"},';
        $chart .= '{"value":'. $sales_volume_autumn_all .',"name":"秋装"},';
        $chart .= '{"value":'. $sales_volume_winter_all .',"name":"冬装"}';
        $chart .= ']';
}

echo '{"all":'. $chart_list .',"chart":'. $chart .'}';