
define(function (require) {
    var angular = require('angular');
    var app = require('app');
    app.factory("filterjson",function(){
        var filter = {};
        filter.year = ["2011",'2012','2013','2014','2015','2016','2017'];
        filter.season = ["春装",'夏装','秋装','冬装'];
        filter.color = ["单色",'多色'];
        filter.status = ["正常",'缺货','售空'];
        filter.paishe = ["拍摄中",'已拍摄','未拍摄'];
        filter.dingdanfukuan = ["未付款",'已付款','已发货','交易关闭','待退款全部退款'];
        return filter;
    })
    // goods api
    app.factory('goods', ['$http', function ($http) {

        return {
            list: function(postData) {
                return  $http.post('app/goods/api/goods.php',postData);
            }
        }

    }]);
    app.factory('dataService', function ($http, $q) {
        var userInfo = {};
        return {
            getUserInfo: function () {       // 如果已存在则直接返回

                if (userInfo.name) {
                    return $q.when(userInfo);
                }       //如果不存在数据则加载

                return $http.get('API/get_list_all_goods.php').then(function (res) {         // 把数据存到server中并返回

                    userInfo = res.data;
                    return res.data;
                })
            }
        }
    })
    app.factory("summaryMonth",function(){
        var filter;
        filter = [{month: '一月', value: 1}, {month: '二月', value: 2},
            {month: '三月', value: 3},
            {month: '四月', value: 4},
            {month: '五月', value: 5}, {month: '六月', value: 6}, {month: '七月', value: 7}, {month: '八月', value: 8},
            {month: '九月', value: 9}, {month: '十月', value: 10}, {month: '十一月', value: 11}, {month: '十二月', value: 12}];
        return filter;
    })
    //app/summary/summarydingdanctrl
    app.factory('seedList',['$http',function($http){
        return {
            getData: function(memberId) {
                return  $http.get('app/summary/api/get_order_num_info.php');
            },
            search: function(orderID) {
                return  $http.post('app/summary/api/get_order_num_info.php',orderID);
            },
            getsPdata: function(timestamp) {
                return  $http.get('app/summary/api/get_ds_sales_info_goods.php?time='+timestamp);
            },
        }
    }])
    app.factory('userList',['$http',function($http){
        return {
            getuser: function(post) {
                return  $http.post('app/kehu/api/get_menber_list.php',post)
            }
        }
    }])
    //caiwu api
    app.factory('caiwuList',['$http',function($http){
        return {
            getfeiyong: function(post) {
                return  $http.post('app/caiwu/api/list_expense_get.php',post)
            },
            queren: function(id,status) {
                return  $http.get('app/caiwu/api/list_expense_update.php?id='+id+'&status='+status)
            },
        }
    }])
})
