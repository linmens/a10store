define(function (require) {
    var app = require('../app');
    require('angular-file-upload')
    app.useModule('angularFileUpload');
    app.directive('ngFiles', ['$parse', function ($parse) {

        function fn_link(scope, element, attrs) {
            var onChange = $parse(attrs.ngFiles);
            element.on('change', function (event) {
                onChange(scope, { $files: event.target.files });
            });
        };

        return {
            link: fn_link
        }
    } ])
    app.controller('mainCtrl', function ($scope, $http, FileUploader, $rootScope, $q, ngDialog,$timeout) {
        var formdata = new FormData();
        $scope.getTheFiles = function ($files) {
            angular.forEach($files, function (value, key) {
                formdata.append(key, value);
            });
        };

        // NOW UPLOAD THE FILES.
        $scope.uploadFiles = function () {

            var request = {
                method: 'POST',
                url: 'app/setting/api/upload.php?upload=导入大仓库存',
                data: formdata,
                headers: {
                    'Content-Type': undefined
                }
            };

            // SEND THE FILES.
            $http(request)
                .success(function (d) {
                    alert(d);
                })
                .error(function () {
                });

            console.log(formdata)
        }

        $scope.iamSelected = '导入大仓库存'
        $scope.iamPinactive = '同步丽晶数据'
        $scope.templeUrl =  'app/setting/api/uploads/template/nun_gs_ck.xls';
        var json1 = [{text: '导入大仓库存',myValue:'nun_gs_ck'}, {text: '导入商场库存',myValue:'nun_gs_shop'}, {text: '导入新品信息',myValue:'new_goods'}]
        var json2 = [{text: '导入每日销售',myValue:'sales_day'}, {text: '导入库存销量',myValue:'sales7_30_ds_num'}, {text: '导入总销量',myValue:'sales_volume_all'}, {text: '导入缺货订单',myValue:'sales_day'},
            {text: '导入订单信息-E店宝',myValue:'sales_day'}]
        $scope.uploadJson = json1
        $scope.isTongbu = false //判断是不是在更新数据页力
        $scope.pintai = [{pin: '同步丽晶数据'},{pin: '同步E店宝数据'},{pin: '同步天猫数据'},{pin: '同步淘宝数据'},{pin: '更新数据'}]
        $scope.changePage = function (st) {
            $scope.iamPinactive = st.pin
            if (st.pin == '同步丽晶数据') {
                $scope.templeUrl =  'app/setting/api/uploads/template/nun_gs_ck.xls';
                $scope.iamSelected = '导入大仓库存'
                $scope.uploadJson = json1
            }
            if (st.pin == '同步E店宝数据') {
                $scope.templeUrl =  'app/setting/api/uploads/template/sales_day.xls';
                $scope.iamSelected = '导入每日销售'
                $scope.uploadJson = json2
            }
            if(st.pin=='更新数据'){
                $scope.iamSelected = '同步库存'
                $scope.isTongbu = true
                $scope.uploadJson = [{text: '同步库存'},{text:'更新会员数据'},{text:'更新sku信息'}]
            }else {
                $scope.isTongbu = false
            }
            if(st.pin=='同步天猫数据'){
                $scope.iamSelected = '导入订单_天猫'
                $scope.uploadJson = [{text: '导入订单_天猫'},{text:'导入订单商品_天猫'},{text:'导入促销价_天猫'}]
            }
            if(st.pin=='同步淘宝数据'){
                $scope.iamSelected = '导入促销价_淘宝'
                $scope.uploadJson = [{text: '导入促销价_淘宝'}]
            }

            console.log($scope.iamSelected)
        }
        $scope.update= function () {

            $http.get('app/setting/api/update.php?check='+$scope.iamSelected).success(function (data) {
                var dataLength = data.item_list.length/100
                $scope.total = data.item_list.length
                var itemlist = data.item_list
                var len = Math.ceil(dataLength)
                for (var i = 0; i < len; i++) {
                    $scope.isUpdating = true
                    var start = i * 100
                    var end = (i + 1) * 100
                    console.log(itemlist.slice(start, [end]))
                    $http.post('app/setting/api/update.php', {
                        data: itemlist.slice(start, [end]),
                        key: i,
                        check:$scope.iamSelected
                    }).success(function (data) {
                        $scope.thisIndex  = Math.round((data.percent + 1) / len * 100)
                        var toDo = function () {
                            if($scope.thisIndex==100){
                                $scope.isUpdating = false
                            }
                        };
                        $timeout(toDo,2000)
                        // i = Inew+1
                        // fileItem.index = Math.round((data.percent + 1) / len * 100)
                    })
                }
            })


        }



        var uploader = $scope.uploader = new FileUploader({
            autoUpload: false,
        });
        uploader.filters.push({
            name: 'syncFilter',
            fn: function (item /*{File|FileLikeObject}*/, options) {
                console.log('syncFilter');
                return this.queue.length < 10;
            }
        });

        // an async filter
        uploader.filters.push({
            name: 'asyncFilter',
            fn: function (item /*{File|FileLikeObject}*/, options, deferred) {
                console.log(deferred);
                setTimeout(deferred.resolve, 1e3);
            }
        });
        $scope.checkUpload = function (i) {
            console.log(i)
            $scope.iamSelected = i.text
            $scope.templeUrl = 'app/setting/api/uploads/template/'+ i.myValue + '.xls'
            $scope.uploadUrl = 'app/setting/api/upload.php?upload=' + $scope.iamSelected
        }

        uploader.onBeforeUploadItem = function (item) {
            console.log($scope.iamSelected)
            $scope.uploadUrl = 'app/setting/api/upload.php?upload=' + $scope.iamSelected
            item.url = $scope.uploadUrl
        }
        // uploader.onAfterAddingFile = function (fileItem, headers) {
        //     fileItem.url = $scope.uploadUrl
        // };
        uploader.onSuccessItem = function (fileItem, response, status) {
            //分组每次一百
            // var resLen = response.item_list.length / 5000
            // var len = Math.ceil(resLen)
            // console.log(fileItem)
            // for (var i = 0; i < len; i++) {
            //     var start = i * 5000
            //     var end = (i + 1) * 5000
            //     sliceData = response.item_list.slice(start, [end])
            //     // index = i
            //     // repost()
            //     // console.log(response.item_list.slice(start, [end]))
            //     $http.post($scope.uploadUrl, {
            //         data: sliceData,
            //         key: i
            //     }).success(function (data) {
            //         fileItem.index = Math.round((data.percent + 1) / len * 100)
            //     })
            // }
        }
    })
})