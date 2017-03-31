define(function (require) {
    var app = require('../../app');
    require('jquery');
    require('bootstrap');
    require('datepicker');
    require('moment_timezone');
    app.constant('dateRangePickerConfig', {
        clearLabel: 'Clear',
        locale: {
            separator: ' - ',
            format: 'YYYY-MM-DD'
        },
        "autoApply": true,
        "showDropdowns": true,
        minDate:'2015-1-1',
        maxDate:moment().format("YYYY-MM-DD")
    });
    require('angular-datepicker');
    app.useModule('daterangepicker');
    app.controller('dingdanCtrl', function ($scope, $http, $rootScope, $log, ngDialog,$timeout,filterjson,seedList) {
        $scope.menus = ['所有订单','天猫','淘宝','一号店']
        $scope.dingdanActive = '所有订单'
        $scope.changePage = function (a) {
            $scope.dingdanActive = a
            GetAllEmployee()
        }
        //搜索功能
        $scope.sendSearch = function (text) {
            seedList.search(text).then(function (data) {
                console.log(data)
            })
        }
        $scope.emptyInput = function (text) {
            $scope.search  = ""
        }
        $scope.mykey = function (e, stext) {
            console.log(e)
            console.log(stext)
            if (stext == '') {
                GetAllEmployee()
            }
            var keycode = window.event ? e.keyCode : e.which;//获取按键编码
            if (keycode == 13) {
                $scope.searchWeb(stext);//如果等于回车键编码执行方法
            }
        }
        //配置点击超链接
        $scope.tmgoodlink = 'https://trade.tmall.com/detail/orderDetail.htm?bizOrderId='
        $scope.tbgoodlink = 'https://trade.taobao.com/trade/detail/trade_order_detail.htm?biz_order_id='
        $scope.yhdgoodlink = 'http://shangjia.yhd.com/order/merchantSale/merchantSoDetail.action?soRpcDto.merchantId=141068&soRpcDto.orderId='
        $scope.filterJson = filterjson
        $scope.checkdingdanfukuan = function (m) {
            $scope.fukuanActive = m
            GetAllEmployee()
        }
        var GetAllEmployee = function () {
            // $scope.jsData = [{year: y,status: s,season: e,color: c}]
            var postData = {
                currentPage: $scope.paginationConf.currentPage,
                itemsPerPage: $scope.paginationConf.itemsPerPage,
                startTime: $scope.date.startDate,
                endTime:$scope.date.endDate,
                filter:[$scope.fukuanActive,$scope.dingdanActive]
            }
           $scope.dingdanfresh =  $http.post('app/dingdan/api/order_list.php',postData).success(function (b) {
                $scope.paginationConf.totalItems = b.total;
                $scope.dingdanData = b.list
            })
        }

        $scope.date = {
            startDate: moment(),
            endDate:moment()
        };
        // GetAllEmployee(  $scope.date.startDate,$scope.date.endDate )


        $scope.opts = {
            locale: {
                applyClass: 'btn-green',
                applyLabel: "确定",
                fromLabel: "Od",
                format: "YYYY-MM-DD",
                toLabel: "Do",
                cancelLabel: '取消',
                customRangeLabel: '自定义日期',
                autoApply: true,
                // daysOfWeek: ['周一', '周二', '周三', '周四', '周五', '周六', '周日'],
                firstDay: 1,
                // monthNames: ['一', '二', '三', '四', '五', '六', '七', '八', '九',
                //     '十', '十一', '十二'
                // ]
            },
            ranges: {
                '过去7天': [moment().subtract(6, 'days'), moment()],
                '过去30天': [moment().subtract(29, 'days'), moment()],
                '本月': [moment().startOf("month"), moment()],
                '上月': [moment().subtract(1, 'months'), moment().subtract(1, 'months').endOf('month')],
            }
        };
        //点击设置前一天范围
        $scope.afterday = 0
        $scope.setRange = function () {
            if($scope.afterday<7){
                $scope.afterday = $scope.afterday +1
            }
            $scope.canClickbefore = true
            $scope.date = {
                startDate: moment().subtract( $scope.afterday, "days"),
                endDate: moment().subtract( $scope.afterday, "days")
            };
        };
        $scope.beforeday = 0
        //点击设置后一天范围
        $scope.setbeforeRange = function () {
//             if($scope.date.startDate>moment().subtract(1, "days")){
//                 $scope.canClickbefore = false
// return
//             }
            if(moment($scope.date.startDate).isBefore(moment().subtract(2, "days"))){
                $scope.afterday = $scope.afterday -1
            }
            if(moment($scope.date.startDate).isSame(moment().subtract(2, "days").format('YYYY-MM-DD 00:00:00'))){
                $scope.canClickbefore = false

            }
            $scope.date = {
                startDate: moment().subtract($scope.afterday, "days"),
                endDate: moment().subtract( $scope.afterday, "days")
            };
        };
        // var lastDate = d.endOf("month"); //通过startOf函数指定取月份的末尾即最后一天
        $scope.$watch('date', function(newDate) {
            $scope.date.startDate = newDate.startDate.format('YYYY-MM-DD 00:00:00')
           $scope.date.endDate = newDate.endDate.format('YYYY-MM-DD 23:59:59')
            $scope.$watch('paginationConf.currentPage + paginationConf.itemsPerPage',  GetAllEmployee);
        }, false);
    });
})