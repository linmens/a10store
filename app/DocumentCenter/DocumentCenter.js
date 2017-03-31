
define(function (require) {
    var app = require('../../app');
    require('angular-toastr')
    app.useModule('toaster');
    require('angular-file-upload')
    app.useModule('angularFileUpload');
    app.controller('DocumentCenterCtrl', function ($scope,$http, FileUploader, ipCookie, $interval, $rootScope, $log,ngDialog,$filter,toaster) {
        $scope.iamSelected = '所有'
        $scope.states = '未确认'
        $scope.opSelected = [{title:'所有'},{title:'淘宝C店'},{title:'天猫'}]
        $scope.openTo = function (te) {
            $scope.iamSelected = te.title
            func($scope.states,$scope.iamSelected)
        }

        $scope.selectId = 1
        $scope.isFresh = false
        var func = function (type1,dcdata,dcDelete) {
            $http.get('app/DocumentCenter/api/get_list_shuadan.php?hpm='+type1+'&data='+dcdata).success(function (data) {
                console.log(data)
                $scope.allData = data
                $scope.Sdorder = data.arr_order
                $scope.Sdstates = [{key: 0, text: '活动单',},
                    {key: 1, text: '未确认', num: data.num_wqr},
                    {key: 2, text: '已确认', num: data.num_yqr},
                    {key: 3, text: '已结算', num: data.num_yjs},
                    {key: 4, text: '已完成', num: data.num_ywc},
                    {key: 5, text: '删除记录', num: data.num_scjl},
                    ]
            })
        }
        func($scope.states,$scope.iamSelected)
        // $scope.addTo = function (sd, index, checkselectId) {
        //     $scope.states = sd.state
        //     statesId = checkselectId
        //     if (index === 'add') {
        //         $scope.addId = sd.id
        //     }
        //     func(sd.state,sd.id)
        // }
        $scope.delete = function (id) {
            $http.get('app/DocumentCenter/api/del_shuadan_order.php?id='+id).success(function () {
                func( $scope.states,$scope.iamSelected)
            })
        }
         $scope.queren = function (q) {
            $http.get('app/DocumentCenter/api/update_state_shuadan.php?status='+q.state+'&id='+q.id).success(function () {
                func( $scope.states,$scope.iamSelected)
            })
        }

        // // 定时器 定时刷新数据
        // var timer = $interval(
        //     function () {
        //
        //         func();//自己定义的每次需要执行的函数，也可以写一些其他的内容
        //         $scope.isFresh = true
        //         $scope.FreshDatetime = new Date()
        //     },
        //     60000
        // );
//当DOM元素从页面中被移除时，AngularJS将会在scope中触发$destory事件。
//这让我们可以有机会来cancel任何潜在的定时器。切换controller、页面后即可调用


        $scope.changePage = function (myId, event) {
            $scope.states = myId.text
            if (myId.key == 0) {
                $scope.selectId = 2 //如果是点击活动单这个按钮就把表格触发对应
            } else {
                $scope.selectId = 1
            }
            func($scope.states,$scope.iamSelected)
        }
        $scope.names = [
            'tm', 'tb'
        ]
        $scope.contacts = [{
            id: 1,
            fullName: '刷单',
        }, {
            id: 2,
            fullName: '活动单'
        }]

        $scope.addNewSd = function (ev) {
            ngDialog.open({
                template: 'DCaddnew.html',
                scope: $scope
            })


        }

        $scope.date = new Date()
        $scope.pay_time = $filter("date")($scope.date, "yyyy-MM-dd HH:mm:ss");
        $scope.formData = {
            money_state: '未结算',
            state: '未确认',
            pay_time: $scope.pay_time,
            selectedId: $scope.selectId
        };
        $scope.formData.shop = 'tm'
        $scope.yesToPush = function (formData) {
            if (formData.selectedId == 2) {
                $scope.Sdstates[0].key = 'no'
                $scope.stateID = 0 //切换到活动单 button
            }
            $http.post('app/DocumentCenter/api/add_new_shuadan.php', {data: formData}).success(function (data) {
                func($scope.states,$scope.iamSelected)
                ngDialog.close();
                toaster.pop('success', "新增成功！");
            })
        }
    })


});
