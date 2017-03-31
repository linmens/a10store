<?php

require('../../config/config_mysql.php');
$ein = new ein_mysql();
$ein->e_mysql_connect();

$this_year = '';
$last_year = '';

$time_xiadan = 1;

$all_num_jn = 0;
$all_num_qn = 0;

for($i=1;$i<=12;$i++){
    if($i<10){
        $ii = '0'.$i;
    }else{
        $ii = $i;
    }


    $time_jn_start = '2017-'.$ii.'-01 00:00:00';
    $time_jn_end = '2017-'.$ii.'-31 23:59:59';
    $qs = "SELECT count(id) FROM `tbapi_yibu_orders_info` WHERE `time_xiadan` > '$time_jn_start' AND `time_xiadan` < '$time_jn_end'";
    $data = $ein->e_mysql_search($qs);
    $num_jn =  $data[0]['count(id)'];
    if($this_year!=''){
        $this_year.=',';
    }
    $this_year .= '{"num":'. $num_jn .'}';
    $all_num_jn = $all_num_jn + $num_jn;


    $time_qn_start = '2016-'.$ii.'-01 00:00:00';
    $time_qn_end = '2016-'.$ii.'-31 23:59:59';
    $qs = "SELECT count(id) FROM `tbapi_yibu_orders_info` WHERE `time_xiadan` > '$time_qn_start' AND `time_xiadan` < '$time_qn_end'";
    $data = $ein->e_mysql_search($qs);
    $num_qn =  $data[0]['count(id)'];
    if($last_year!=''){
        $last_year.=',';
    }
    $last_year .= '{"num":'. $num_qn .'}';
    $all_num_qn = $all_num_qn + $num_qn;
}

$this_year .= ',{"num":'. $all_num_jn .'}';
$last_year .= ',{"num":'. $all_num_qn .'}';

echo '{"this_year":['. $this_year .'],"last_year":['. $last_year .']}';