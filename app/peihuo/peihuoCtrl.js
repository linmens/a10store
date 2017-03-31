define(function (require) {
    var app = require('../../app');

    require('angular-file-upload')
    app.useModule('angularFileUpload');
    // require('angular-toastr')
    // app.useModule('toastr');
    
    app.controller('peihuoCtrl', function ($scope, $http, FileUploader, ipCookie, $timeout,$state,filterjson) {
        $scope.smenu = $state.current.name
        $scope.filterJson = filterjson
        $scope.Pmenu = [{text:'配货',sref:'peihuo'},{text:'调货',sref:'peihuo.diaohuo'}]
        //年份
        $scope.checkYear = function (m) {
            $scope.isActiveyear = m
            GetAllEmployee()
        }
        $scope.checkSeason = function (m) {
            $scope.activeSeason = m
            GetAllEmployee()
        }
        $scope.changem = function (m) {
            $scope.smenu = m.sref
        }
        $scope.tableTh = [
            {name: '货号',sort:'up'},
            {name: '颜色',sort:'up'},
            {name: '尺码',sort:'up'},
            {name: '电商仓库存',sort:'up'},
            {name: '大仓库存',sort:'up'},
            {name: '周销量',sort:'up'},
            {name: '月销量',sort:'up'},
        ]
        $scope.checkSort = function (m) {
            console.log(m)
            $scope.sortname = m.name;
            (m.sort == 'up') ? m.sort="down" : m.sort="up";
            $scope.sort = m.sort

            GetAllEmployee()
        }
        //配置分页基本参数
        $scope.paginationConf = {
            currentPage: 1,
            itemsPerPage: 10
        };

        //下载
        $scope.downloadPeihuo = function () {
            $http.post('app/peihuo/api/get_excel_peihuo.php',[{year:$scope.isActiveyear,season:$scope.activeSeason,sort:$scope.sort,sortname:$scope.sortname}]).success(function (data) {

                window.location.href = data.down_path // 在新的页面中打开PDF
            })
        }
        var GetAllEmployee = function () {
            var postData = {
                currentPage: $scope.paginationConf.currentPage,
                itemsPerPage: $scope.paginationConf.itemsPerPage,
                filter:[{year:$scope.isActiveyear,season:$scope.activeSeason,sort:$scope.sort,sortname:$scope.sortname}]
            }
            $scope.getJson = $http.post('app/peihuo/api/get_peihuo_sku_info.php',{postData}).success(function (d) {
                $scope.peihuo_list = d.list
                $scope.paginationConf.totalItems = d.total;
            })
        }
        $scope.$watch('paginationConf.currentPage + paginationConf.itemsPerPage', GetAllEmployee);
        var uploader = $scope.uploader = new FileUploader({
            url: "API/update_peihuo_excel.php",
            autoUpload: false,
        });
        // a sync filter
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
                console.log('asyncFilter');
                setTimeout(deferred.resolve, 1e3);
            }
        });
        uploader.onBeforeUploadItem = function (fileItem) {
            console.log(fileItem)

        }
        uploader.onAfterAddingFile = function (fileItem) {
            console.log(fileItem)
            if (fileItem.url === '') {
                $scope.noChoose = true
            }
        }


        $scope.menuId = 0
        //获取总的配货列表
        var reGetPeihuo = function () {
            $http.get('API/get_peihuo_list.php?id=' + $scope.menuId + '&text=未提交物流').success(function (data) {

                $scope.peeihuo_list = data.order_list

                $scope.menus = [
                    {
                        id: 0,
                        text: '未提交物流',
                        num: data.num_wtj
                    }, {
                        id: 1,
                        text: '可提交物流',
                        num: data.num_ktj
                    }, {
                        id: 2,
                        text: '已提交物流',
                        num: data.num_ytj
                    }, {
                        id: 3,
                        text: '删除记录',
                        num: data.num_scjl
                    }

                ]
            })
        }

        // reGetPeihuo()
        uploader.onSuccessItem = function (fileItem, response, status, headers) {
            console.log(fileItem)
            //			console.info('onSuccessItem', fileItem, response, status, headers);
            $scope.available_list = response.available_list
            // $scope.not_available_list = response.not_available_list
            reGetPeihuo()
            //1秒后移除文件
            timeout = $timeout(function () {
                // toastr.success('上传成功！', {});
                fileItem.remove()
            }, 1000);

        };
        //menu操作对应方法

        $scope.all = function (menu) {
            console.log(menu)
            $scope.menuId = menu.id
            $scope.isInDelete = false
            if (menu.id === 3) {
                $scope.isInDelete = true
            }
            if (menu.id === 2) {
                $scope.isInyTj = true
            }

            $http.post('API/get_peihuo_list.php?id=' + menu.id + '&text=' + menu.text).success(function (data) {
                console.log(data.order_list)

                $scope.peeihuo_list = data.order_list

            })
        }
        $scope.shops = [{
            text: '依佈天猫',
            shopNum: 'tm'
        }, {
            text: '依佈淘宝',
            shopNum: 'tb'
        }]
        //检查是不是已经点过订单复制了


        $scope.clickme = function (id) {
            $scope.isCopy = false
            $scope.currentId = id;
        };
        $scope.sendPhone = function (pee) {
            // console.log(pee.phone)
            if (pee.phone.length > 11) {
                alert("text is too long");
                pee.phone = pee.phone.substr(0, 11);
            }
            $http.post('API/update_diaohuo_buyer_phone.php', {
                id: pee.id,
                phone: pee.phone,
                username: $scope.currentUser
            }).success(function (data) {

                if (data.data_info === 'success') {

                    // $scope.currentId = 's'
                    pee.state = '可提交物流'
                }
            })
        }
        //删除记录
        // $scope.deleteJ = function () {
        //     $http.get('API/get_peihuo_list_noneed.php').success(function (data) {
        //         console.log(data)
        //         $scope.peeihuo_list = data
        //         $scope.isInDelete = true
        //     })
        // }


        $scope.alert = function () {
            // toastr.success('复制成功！', {});
        }
        $scope.changeShop = function (shop, pee) {
            console.log(shop)
            pee.shop = shop.shopNum //改变图标样式
            $http.post('API/update_diaohuo_shop.php', {shopNum: shop.shopNum, id: pee.id})
        }
        if (!$scope.yundanhao) {
            console.log('未填写运单号')
        }


        $scope.sendyundan = function (yundanhao) {

            console.log(yundanhao)

        }
        //订单号编辑
        $scope.sendOreder = function (pee) {


            $http.post('API/update_diaohuo_order.php?neworder=' + pee.order_id + '&id=' + pee.id).success(function (data) {
                if (data.data_info === 'success') {

                }

            })
        }
        //更换状态
        $scope.choose = function (status, pee, index) {
            console.log(pee)
            console.log(index)

            pee.state = "" + status.text

            $http.post('API/update_diaohuo_state.php?id=' + pee.id + '&state=' + pee.state)
            // if(pee.state === '调回途中'){
            //     $scope.needyundan = true
            // }

        }
        //移除一项
        $scope.remove = function (index, id, info) {
            console.log(info)
            var textCon = ''
            if (info === 'isInAll') {
                textCon = '确定移除此项吗？'
            }
            if (info === 'isInDelete') {
                textCon = '确定恢复此项吗？'
                $scope.back = true
            }
            if (confirm(textCon)) {
                $scope.peeihuo_list.splice(index, 1);
                $http.post('API/del_new_peihuo.php?id=' + id + '&info=' + info)
            }
        };
    })
})