define(function (require) {
    var app = require('../../app');
    // 使用
    require('ng-csv');
    require('angular-sanitize');
    app.useModule('ngSanitize');
    app.useModule('ngCsv');
    app.controller('summaryCtrl', function ($scope, $http,$state,$rootScope) {

            $scope.smenu = $state.current.name

            $scope.Pmenu = [{text: '业绩分析', sref: 'summary.yeji'}, {text: '货品分析', sref: 'summary.huopin'},
                {text: '订单分析', sref: 'summary.dingdan'}, {text: '商品分析', sref: 'summary.shangpin'},
            ]
            $scope.changem = function (m) {
                $scope.smenu = m.sref
            }

        }
    )
    app.controller('summaryyejiCtrl', function ($scope, $http,$state,$rootScope,seedList,summaryMonth) {

        $scope.smenu = $state.current.name

        $scope.Pmenu = [{text:'业绩分析',sref:'summary'},{text:'货品分析',sref:'summary.huopin'},{text:'订单分析',sref:'summary.dingdan'}]
        $scope.changem = function (m) {
            $scope.smenu = m.sref
        }

            $scope.card1Promise = $http.get('app/summary/api/get_ds_sales_info_all.php').success(function (r) {
                $scope.topAll = r
            })
            var getCsv = function (jIncsv, getOld) {
                $scope.myPromise = $http.get('app/summary/api/summary.php?hpm=' + jIncsv + '&bottom=' + getOld).success(function (csv) {
                    var dom = document.getElementById("summaryMain");

                    $scope.json = csv
                    console.log(csv)
                    var myChart = echarts.init(dom);
                    var app = {};
                    var series = [];
                    for (var i = 0; i < csv.list.length; i++) {
                        series.push({
                            name: csv.list[i].name,
                            type: 'line',
                            data: csv.list[i].data
                        });
                    }
                    option = null;
                    option = {
                        optionToContent: function (opt) {
                            var axisData = opt.xAxis[0].data;
                            var series = opt.series;
                            console.log(series)
                            if (series.length > 2) {
                                table = '<table style="width:100%;text-align:center"><tbody><tr>'
                                    + '<td>时间</td>'
                                    + '<td>' + series[0].name + '</td>'
                                    + '<td>' + series[1].name + '</td>'
                                    + '<td>' + series[2].name + '</td>'
                                    + '<td>' + series[3].name + '</td>'
                                    + '<td>' + series[4].name + '</td>'
                                    + '<td>' + series[5].name + '</td>'
                                    + '</tr>';
                                for (var i = 0, l = axisData.length; i < l; i++) {
                                    table += '<tr>'
                                        + '<td>' + axisData[i] + '</td>'
                                        + '<td>' + series[0].data[i] + '</td>'
                                        + '<td>' + series[1].data[i] + '</td>'
                                        + '<td>' + series[2].data[i] + '</td>'
                                        + '<td>' + series[3].data[i] + '</td>'
                                        + '<td>' + series[4].data[i] + '</td>'
                                        + '<td>' + series[5].data[i] + '</td>'
                                        + '</tr>';
                                }
                                table += '</tbody></table>';
                            } else {
                                var table = '<table style="width:100%;text-align:center"><tbody><tr>'
                                    + '<td>时间</td>'
                                    + '<td>' + series[0].name + '</td>'
                                    + '<td>' + series[1].name + '</td>'
                                    + '</tr>';
                                for (var i = 0, l = axisData.length; i < l; i++) {
                                    table += '<tr>'
                                        + '<td>' + axisData[i] + '</td>'
                                        + '<td>' + series[0].data[i] + '</td>'
                                        + '<td>' + series[1].data[i] + '</td>'
                                        + '</tr>';
                                }
                                table += '</tbody></table>';
                            }

                            return table;
                        },
                        title: {
                            show: false
                        },
                        tooltip: {
                            trigger: 'axis',

                        },
                        toolbox: {
                            show: true,
                            feature: {
                                dataZoom: {
                                    yAxisIndex: 'none'
                                },
                                dataView: {readOnly: false},
                                magicType: {type: ['line', 'bar', 'stack']},
                                restore: {},
                                saveAsImage: {}
                            }
                        }, dataZoom: [{
                            startValue: csv.data_time[0],
                            endValue: csv.data_time.length-1
                        }, {
                            type: 'inside'
                        }],
                        legend: {
                            show: true,
                            // data: ['依布天猫', '依布淘宝', '依布一号店', '科尚天猫', '科尚淘宝','科尚一号店', '去年依布天猫', '去年依布淘宝', '去年依布一号店', '去年科尚天猫', '去年科尚淘宝','去年科尚一号店'],
                            data: csv.data_title,
                            width: 800,
                        },
                        xAxis: {
                            type: 'category',
                            boundaryGap: false,
                            data: csv.data_time
                        },
                        yAxis: {
                            type: 'value',
                        },
                        series: series,
                        color:['rgb(0, 136, 254)','rgb(0, 196, 159)']
                    };

//加载数据
                    if (option && typeof option === "object") {
                        myChart.setOption(option, true);
                    }
                    $scope.opChange = [{
                        id: 0,
                        title: '部门完成(元)',
                        data: csv.list_sale_info_jn.all,
                        dataqn: csv.list_sale_info_qn.all,
                        dayjn:csv.list_sale_info_day_jn.all,dayqn:csv.list_sale_info_day_qn.all
                    },
                        {id: 1, title: '天猫', data: csv.list_sale_info_jn.tm, dataqn: csv.list_sale_info_qn.tm,dayjn:csv.list_sale_info_day_jn.tm,dayqn:csv.list_sale_info_day_qn.tm},
                        {id: 2, title: '淘宝', data: csv.list_sale_info_jn.tb, dataqn: csv.list_sale_info_qn.tb,dayjn:csv.list_sale_info_day_jn.tb,dayqn:csv.list_sale_info_day_qn.tb},
                        {id: 2, title: '一号店', data: csv.list_sale_info_jn.yhd, dataqn: csv.list_sale_info_qn.yhd,dayjn:csv.list_sale_info_day_jn.yhd,dayqn:csv.list_sale_info_day_qn.yhd}
                    ]
                })
            }
            getCsv()
        //业绩页面

            $scope.iamSelected = '总指标'
            $scope.card4 = '月指标',
                $scope.card4_shop = '总指标'
        $scope.ischange = '部门完成(元)'
        $scope.opSelected = [{id: 0, title: '总指标'}, {id: 1, title: '科尚'}, {id: 2, title: '依布'}]
            $scope.opSelectedzhibiao=[]
            $scope.opSelectedzhibiao.shop = [{shop:'总指标'},{shop:'依布'},{shop:'科尚'}]
            $scope.opSelectedzhibiao.tiaojian = [{id: 0, title: '月指标'}, {id: 1, title: '周指标'},{id: 2, title: '天指标'}]
        console.log($scope.opSelectedzhibiao)
            $scope.openTo = function (te,type) {
                $scope.iamSelected = te.title
                getCsv(te.title, $scope.ischange)
            }
            $scope.summary_change = function (t,type) {
                $scope.ischange = t.title
                getCsv($scope.iamSelected, t.title)
            }
            //start---card4 第4个卡片的点击事件,选择条件和对应的店铺
          var reGet_zhibiao_detail = function (shop,tiaojian) { //获取指标数据
            $scope.reGetzhibiaocgBusy =   $http.get('app/summary/api/get_zhibiao_detail.php?hpm='+shop+'&tiaojian='+tiaojian).success(function (data) {
                  $scope.summary_zhibiao_data = data
              })
          }
        reGet_zhibiao_detail()
            $scope.card4_shop_title = '依布' //将表格品牌显示名默认初始化未依布
            $scope.openTocard4 = function (te,type) {
                $scope.card4 = te.title
                console.log($scope.card4_shop,te.title)
                reGet_zhibiao_detail($scope.card4_shop,te.title)
            }
            $scope.openTocard4_shop = function (te,type) {
                $scope.card4_shop = te.shop
                console.log(te.shop ,$scope.card4)
              reGet_zhibiao_detail(te.shop ,$scope.card4)
            }
            //end---card4
            var tmp = "";

            var reGetsummary_monthdata = function () {
               $scope.summary_monthCHange = $http.get('app/summary/api/get_sales_month.php?month=' + $scope.nowmonth).success(function (data) {
                    $scope.summary_month_data = data
                })
            }
            reGetsummary_monthdata()
            $scope.summary_month = summaryMonth

            //默认选择当前月份
            $scope.summary_change_month = function (val) {
                $scope.nowmonth = val.value
                reGetsummary_monthdata()
            }
            // $scope.summary_zhibiao_data = [
            //     {shop:'天猫',ybzhibiao:[{m:55.1,success:65},{m:552,success:652},{m:2.7,success:65},{m:3.7,success:65},{m:4.7,success:65},{m:5.7,success:65},{m:6.7,success:65},{m:7.7,success:65},{m:55.7,success:65},{m:55.7,success:65},{m:55.7,success:65},{m:55.7,success:65}],total:810},
            //     {shop:'淘宝',ybzhibiao:[{m:45.1},{m:552},{m:2.7},{m:3.7},{m:3.7},{m:5.7},{m:6.7},{m:7.7},{m:55.7},{m:55.7},{m:55.7},{m:55.7}],total:50},
            //     {shop:'一号店',m1:1,m2:1,m3:1.5,m4:2,total:20}]
        }
    )
    app.controller('summaryhuopinCtrl', function ($scope, $http,$state) {
            // seedList.gethuopinData().then(function (res) {
            //     $scope.topAll = res.data
            // })

            //业绩页面
            var getCsv = function (jIncsv, getOld) {
                $scope.myPromise = $http.get('app/summary/api/get_chart_sales_num.php?hpm=' + jIncsv + '&bottom=' + getOld).success(function (csv) {
                    var dom = document.getElementById("summaryMain");

                    $scope.json = csv
                    var myChart = echarts.init(dom);
                    var app = {};
                    // var series = [];
                    // for (var i = 0; i < csv.list.length; i++) {
                    //     series.push({
                    //         name: csv.list[i].name,
                    //         type: 'line',
                    //         data: csv.list[i].data
                    //     });
                    // }
                    option = null;
                    option = {
                        title: {
                            show:false
                        },
                        visualMap: {
                            // 不显示 visualMap 组件，只用于明暗度的映射
                            show: false,
                            // 映射的最小值为 80
                            min: 80,
                            // 映射的最大值为 600
                            max: 600,
                            inRange: {
                                // 明暗度的范围是 0 到 1
                                colorLightness: [0, 1]
                            }
                        },
                        tooltip : {
                            trigger: 'item',
                            formatter: "{a} <br/>{b} : {c} ({d}%)"
                        },
                        series : [
                            {
                                name:'销售件数',
                                type:'pie',
                                radius : '55%',
                                center: ['50%', '50%'],
                                data:csv.chart,
                                // roseType: 'angle',
                            }
                        ]
                    };

//加载数据
                    if (option && typeof option === "object") {
                        myChart.setOption(option, true);
                    }

                })
            }
            getCsv()
            $scope.iamSelected = '数据总览'
            $scope.card4 = '月指标',
                $scope.card4_shop = '总指标'
            $scope.ischange = '总计'
            $scope.opSelected = [{id: 0, title: '数据总览'}]
            $scope.opSelectedzhibiao=[]
            $scope.opSelectedzhibiao.shop = [{shop:'总指标'},{shop:'依布'},{shop:'科尚'}]
            $scope.opSelectedzhibiao.tiaojian = [{id: 0, title: '月指标'}, {id: 1, title: '周指标'},{id: 2, title: '天指标'}]
            console.log($scope.opSelectedzhibiao)
            $scope.openTo = function (te,type) {
                $scope.iamSelected = te.title
                getCsv(te.title, $scope.ischange)
            }
            $scope.summary_change = function (t,type) {
                $scope.ischange = t.name
                getCsv($scope.iamSelected, $scope.ischange)
            }
            //start---card4 第4个卡片的点击事件,选择条件和对应的店铺
            var reGet_zhibiao_detail = function (shop,tiaojian) { //获取指标数据
                $scope.reGetzhibiaocgBusy =   $http.get('app/summary/api/get_zhibiao_detail.php?hpm='+shop+'&tiaojian='+tiaojian).success(function (data) {
                    $scope.summary_zhibiao_data = data
                })
            }
            reGet_zhibiao_detail()
            $scope.card4_shop_title = '依布' //将表格品牌显示名默认初始化未依布
            $scope.openTocard4 = function (te,type) {
                $scope.card4 = te.title
                console.log($scope.card4_shop,te.title)
                reGet_zhibiao_detail($scope.card4_shop,te.title)
            }
            $scope.openTocard4_shop = function (te,type) {
                $scope.card4_shop = te.shop
                console.log(te.shop ,$scope.card4)
                reGet_zhibiao_detail(te.shop ,$scope.card4)
            }
            //end---card4
          
            // var monthPicker = document.getElementById("DayPicker")

            // month =(month<10 ? month:month);
            var reGetsummary_monthdata = function () {
                $scope.summary_monthCHange = $http.get('app/summary/api/get_sales_month.php?month=' + $scope.nowmonth).success(function (data) {
                    $scope.summary_month_data = data
                })
            }
            reGetsummary_monthdata()
            $scope.summary_month = [{month: '一月', value: 1}, {month: '二月', value: 2},
                {month: '三月', value: 3},
                {month: '四月', value: 4},
                {month: '五月', value: 5}, {month: '六月', value: 6}, {month: '七月', value: 7}, {month: '八月', value: 8},
                {month: '九月', value: 9}, {month: '十月', value: 10}, {month: '十一月', value: 11}, {month: '十二月', value: 12}]

            //默认选择当前月份
            $scope.summary_change_month = function (val) {
                $scope.nowmonth = val.value
                reGetsummary_monthdata()
            }
            // $scope.summary_zhibiao_data = [
            //     {shop:'天猫',ybzhibiao:[{m:55.1,success:65},{m:552,success:652},{m:2.7,success:65},{m:3.7,success:65},{m:4.7,success:65},{m:5.7,success:65},{m:6.7,success:65},{m:7.7,success:65},{m:55.7,success:65},{m:55.7,success:65},{m:55.7,success:65},{m:55.7,success:65}],total:810},
            //     {shop:'淘宝',ybzhibiao:[{m:45.1},{m:552},{m:2.7},{m:3.7},{m:3.7},{m:5.7},{m:6.7},{m:7.7},{m:55.7},{m:55.7},{m:55.7},{m:55.7}],total:50},
            //     {shop:'一号店',m1:1,m2:1,m3:1.5,m4:2,total:20}]
        }
    )

    app.controller('summarydingdanCtrl', function ($scope, $http,$state,seedList,summaryMonth) {
            // console.log(seedList.getData())
            seedList.getData().then(function(res){
                    $scope.yearDingdan = res.data
            });
        $scope.summary_month = summaryMonth
        }
    )
    app.controller('summaryshangpinCtrl', function ($scope, $http,$state,seedList,summaryMonth) {
            // console.log(seedList.getData())

        if(moment().quarter()==1){
            $scope.seasonActive ='春'
        }
        if(moment().quarter()==2){
            $scope.seasonActive ='夏'
        }
        if(moment().quarter()==3){
            $scope.seasonActive ='秋'
        }
        if(moment().quarter()==4){
            $scope.seasonActive ='冬'
        }
       var reget = function () {
           $scope.isReload = seedList.getsPdata($scope.seasonActive).then(function(res){
               $scope.shangpindata = res.data
           });
       }
        reget()
            $scope.menus = ['春','夏','秋','冬']

        console.log(moment().quarter())

        $scope.changePage = function (res) {
            $scope.seasonActive = res
            reget()
        }
        $scope.summary_month = summaryMonth
        }
    )
})


