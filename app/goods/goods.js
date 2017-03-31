define(function (require) {
    var app = require('app');
        require('ng-csv');
        require('angular-sanitize');
    app.useModule('ngCsv');
    app.useModule('ngSanitize');
    app.controller('goodsCtrl', function ($http, $q, $timeout, $scope, $element, $filter, $rootScope,dataService, $interval, $stateParams, ngDialog, goods,filterjson) {
        $scope.filterJson = filterjson
        $scope.activeMenu = '所有宝贝'
        $scope.menu = [
            {name: '所有宝贝'},
            {name: '天猫'},
            {name: '淘宝'},
            {name: '一号店'}
        ]
        $scope.tableTh = [
            {name: '商品分类',sort:'up'},
            {name: '吊牌价',sort:'up'},
            {name: '促销价',sort:'up'},
            {name: '库存',sort:'up'},
            {name: '7天销量',sort:'up'},
            {name: '30天销量',sort:'up'},
            {name: '总销量',sort:'up'},
            {name: '动销率',sort:'up'},
            {name: '周转时间',sort:'up'},
            {name: '上架时间',sort:'up'},
        ]
        $scope.checkYear = function (m) {
            $scope.isActiveyear = m

            GetAllEmployee()
        }
        $scope.checkStatus = function (m) {
            $scope.activeStatus = m
            GetAllEmployee()
        }
        $scope.checkSeason = function (m) {
            $scope.activeSeason = m
            GetAllEmployee()
        }
        $scope.checkColor = function (m) {
            $scope.activeColor = m
            GetAllEmployee()
        }
        $scope.checkPaishe = function (m) {
            $scope.activePaishe = m
            GetAllEmployee()
        }
        $scope.checkSort = function (m) {
            console.log(m)
            $scope.sortname = m.name;
            (m.sort == 'up') ? m.sort="down" : m.sort="up";
            $scope.sort = m.sort

            GetAllEmployee()
        }
        $scope.reset = function () {
            $scope.isActiveyear =""
            $scope.activeStatus =""
            $scope.activeSeason =""
            $scope.activeColor =""
            $scope.activePaishe =""
            $scope.sortname =""
            $scope.sort =""
            GetAllEmployee()
        }
        var GetAllEmployee = function () {
           var postData = {
                currentPage: $scope.paginationConf.currentPage,
                itemsPerPage: $scope.paginationConf.itemsPerPage,
                filter: [{year: $scope.isActiveyear,status: $scope.activeStatus,season: $scope.activeSeason,color: $scope.activeColor,paishe:$scope.activePaishe,shops:$scope.activeMenu,sortName:$scope.sortname,sort:$scope.sort}],
            }
            postData.search = $scope.searchInSdorder
            $scope.myPromise = goods.list( postData).success(function (response) {
                if(response.total == 0){
                    // checkisSearch = false
                    $scope.goods = ""
                }else {
                    $scope.paginationConf.totalItems = response.total;
                    $scope.goods = response.list;
                    console.log(response)
                }
            });
        }
        $scope.getExcel = function () {
            $http.get('http://yibu.a10store.com/app/goods/api/get_excel_sg.php')
        }
        $scope.mykey = function (e, stext) {
            if (stext == '') {
                GetAllEmployee()
            }
            var keycode = window.event ? e.keyCode : e.which;//获取按键编码
            if (keycode == 13) {
                $scope.searchWeb(stext);//如果等于回车键编码执行方法
            }
        }
        $scope.searchWeb = function (s) {
            GetAllEmployee()
        }
        $scope.needJson = function (json, dowhat) {
            $scope.activeMenu = json.name //判断是哪个店铺
            GetAllEmployee()
        }
        $scope.$watch('paginationConf.currentPage + paginationConf.itemsPerPage  ', GetAllEmployee);

        /***************************************************************
         当页码和页面记录数发生变化时监控后台查询
         如果把currentPage和itemsPerPage分开监控的话则会触发两次后台事件。

         ***************************************************************/
        $scope.jsonArray = []
        $scope.jsonArrayId = '1'

        $scope.reSetData = function (json) {
            reGetGoodsJson()
        }
        $scope.contacts = [
            {
                'id': 1,
                'group': '天猫',
                'title': "导入销量-库存",
            }, {
                'id': 5,
                'group': '天猫',
                'title': "导入促销价",
            }, {
                'id': 8,
                'group': '天猫',
                'title': "导入总销量",
            }, {
                'id': 3,
                'group': '一号店',
                'title': "导入所有商品信息",
            }, {
                'id': 4,
                'group': '所有宝贝',
                'title': "导入大仓库存",
            }, {
                'id': 6,
                'group': '所有宝贝',
                'title': "导入商场库存",
            }, {
                'id': 7,
                'group': '所有宝贝',
                'title': "导入生意数据",
            }];
        var newVal


        $scope.selectedUser = function () {
            return $filter('filter')($scope.contacts, {id: $scope.selectedId})[0].lastName;
        };




        $scope.showgoodsSkusDialog = function (item, sh) {
            $scope.showwhats = sh
            console.log(sh)
            $scope.outerid = item.outer_id_gs
            $scope.showwhat = function (s) {
                console.log(s)

                $scope.yesI = s.id
                if (s.id == 1) {
                    $http.get('app/goods//API/get_list_num_goods_class_gs.php').success(function (pinlei) {
                        $scope.pinlei = pinlei
                    })
                }
            }
            if (sh == 'showBaobiao') {
                $scope.bao = [
                    {
                        id: 0,
                        text: '库存报表'
                    }, {
                        id:1,
                        text: '库存报表-品类'
                    }, {
                        id:2,
                        text: '库存对比'
                    }
                ]

                $scope.yesI = 0


                // alert('needJson')
                $http.get('app/goods/api/get_list_num_ds_ck_all.php').success(function (baobiao) {
                    $scope.baobiao = baobiao
                    // console.log(baobiao)
                })

            }
            if (sh == 'showThree') {
                $scope.yesI = 2
                $http.get('app/goods/api/get_list_sku_info.php?outer_id=' + item.outer_id_gs + '&color=' + item.goods_color_gs).success(function (sku) {
                    console.log(sku)
                    $scope.sKus = sku
                })
            }
            ngDialog.open({
                template: 'app/goods/goodSkus.tmpl.html',
                scope: $scope,
                cache: false
            });
        }
        $scope.formData = {};
        $scope.save = function (form) {
            $scope.submitted = true
            console.log(form)
        }
        // FILTERS




        $scope.Newvalue = function (val) {
            console.info(val);
            newVal = val.title
        }




        $scope.changeType = function (t) {
            $scope.typeDianpu = t
        }
        //								当输入搜索内容发生变化时执行
        $scope.sendsth = function (initS, search) {

            //									initS 是搜索结果；
            $scope.instock_length = filteredtm.length;
            //										console.log(initS)
            if (search.length != 0) {
                //											将分页数据改为搜索结果
                $scope.instock_length = initS.length;

            }
        }
        $scope.change_old = function (old) {
            console.log(old)
            $scope.search = old

        }
        // var nowTime = new  Date()
        // var timer = $interval(function(){
        //     if(nowTime.getHours()==='23'){
        //         $http.get("issues/get_json").success(
        //             function(response){
        //                 $scope.names = response;
        //             });
        //     }
        //     console.log('未到执行点')
        // },1000)

        //如果是在23点则发送api

        //每隔24小时刷新


        $scope.options = {
            rowSelection: true,
            multiSelect: true,
            autoSelect: true,
            decapitate: false,
            largeEditDialog: false,
            boundaryLinks: false,
            limitSelect: true,
            pageSelect: true
        };
        $scope.joinShangou = function (selected) {
            $scope.isSelect = true
            if (selected != Object) {
                console.log('ldksd')
            }
            console.log(selected)
            // $http.post('API/update_yhd_sg.php',{myselected:selected})
        }
        $scope.exportyhd_shangou = function () {
            window.location.href = 'app/goods/api/get_excel_sg.php'
        }
        $scope.isLast = function (flag) {

            return flag ? 'trlast' : 'not_trlast';
        };
        $scope.toggleLimitOptions = function () {
            $scope.limitOptions = $scope.limitOptions ? undefined : [10, 50, 100, 200];
        };
        $scope.onPaginate = function (page, limit) {
            console.log('Scope Page: ' + $scope.query.page + ' Scope Limit: ' + $scope.query.limit);
            console.log('Page: ' + page + ' Limit: ' + limit);

            $scope.promise = $timeout(function () {

            }, 1000);
        };
        $scope.new_array = []
        $scope.log = function (item) {
            console.log(item.outer_id_gs, 'was selected');
            //如果页面不在一号店本页面则返回 不执行api请求
            if ($scope.whatD != 'yhd') {
                return false
            }
            $http.post('API/update_yhd_sg.php?outer_id_gs=' + item.outer_id_gs + '&select=yes').success(function (data) {
                console.log(data)
                item.yhd_sg = 'yes'
            })
        };
        $scope.deselect = function (item) {
            console.log(item.outer_id_gs, 'was deselected');
            if ($scope.whatD != 'yhd') {
                return false
            }
            $http.post('API/update_yhd_sg.php?outer_id_gs=' + item.outer_id_gs + '&select=no').success(function (data) {
                console.log(data)
                item.yhd_sg = 'no'
            })

        };


        $scope.updata_success = true


        $scope.alert = '';

        $scope.status = '  ';
        $scope.customFullscreen = false;

        function goodSkusController($mdDialog, $scope, $http) {
            $scope.selectSkus = []
            $http.post('API/get_sku_info.php?outer_id_gs=' + $scope.outerid).success(function (thisInfo) {
                console.log(thisInfo)
                $scope.skus = thisInfo


            })
            //减少
            $scope.reduce = function (index) {
                if ($scope.skus[index].num > 1) {
                    $scope.skus[index].num--;
                } else {
                    $scope.remove(index);
                }
            };
            //增加
            $scope.add = function (index) {
                $scope.skus[index].num++;
            };
            //添加到预览
            $scope.selectAdd = function (skus) {
                $scope.selectSkus.push(skus)
                console.log(skus)
            }
            //将选择的数据传到服务器
            $scope.send = function (data) {
                $http.post('API/add_new_peihuo.php', {data: data}).success(function (relog) {
                    console.log(relog)
                    if (relog.data_info === 'success') {
                        $scope.selectSkus = []
                        alert('新增成功')
                    }

                })
            }
            //移除一项
            $scope.remove = function (index) {
                if (confirm('确定移除此项吗？')) {
                    $scope.selectSkus.splice(index, 1);
                }
            };
            // // 计算总数量
            // $scope.allNum=function(){
            //     var allShu=0;
            //     for(var i=0;i<$scope.selectSkus.length;i++){
            //         allShu +=$scope.selectSkus[i].num;
            //     }
            //     return allShu;
            // };

            //使得输入框中不得小于等于0
            $scope.change = function (index) {
                if ($scope.skus[index].num >= 1) {
                } else {
                    $scope.skus[index].num = 1;
                }
            };
            //清空购物车
            $scope.removeAll = function () {
                if (confirm('确定清空购物车')) {
                    $scope.selectSkus = [];
                }
            }
            $scope.cancel = function () {
                $mdDialog.cancel();
            };
            console.log($scope.outerid)
        }

        function yhdpriceController($mdDialog, $scope, $http) {
            $scope.myDate = new Date();
            $scope.myendDate = [];

            $scope.minDate = new Date(
                $scope.myDate.getFullYear(),
                $scope.myDate.getMonth() - 2,
                $scope.myDate.getDate()
            );

            $scope.maxDate = new Date(
                $scope.myDate.getFullYear(),
                $scope.myDate.getMonth() + 2,
                $scope.myDate.getDate()
            );


            $scope.Computation = function (sDate1, sDate2) {
                var sDate1 = $filter('date')(sDate1, 'yyyy-MM-dd');
                var sDate2 = $filter('date')(sDate2, 'yyyy-MM-dd');
                var aDate, oDate1, oDate2, iDays
                aDate = sDate1.split("-")
                oDate1 = new Date(aDate[1] + '-' + aDate[2] + '-' + aDate[0]) //转换为12-13-2008格式
                aDate = sDate2.split("-")
                oDate2 = new Date(aDate[1] + '-' + aDate[2] + '-' + aDate[0])
                iDays = parseInt(Math.abs(oDate1 - oDate2) / 1000 / 60 / 60 / 24) //把相差的毫秒数转换为天数
                $scope.iDay = iDays;
            }

            $scope.exPortyHd_price = function (ms, me, tableId) {

                var mystartDate = $filter('date')(ms, 'yyyy-MM-dd hh:mm:ss');
                var myendDate = $filter('date')(me, 'yyyy-MM-dd 23:59:59');
                window.location.href = 'API/get_excel_yhd.php?start=' + mystartDate + '&end=' + myendDate;
                $mdDialog.cancel();
//			$http.get('API/get_excel_yhd.php?start='+ mystartDate+'&end='+myendDate).success(function (all_good) {
//
//	});

//			})


            }
            $scope.cancel = function () {
                $mdDialog.cancel();
            };

            $scope.answer = function (answer) {
                $mdDialog.hide(answer);
            };
        }

        $scope.showGridBottomSheet = function (whatD) {
            // console.log(whatD)
            // $scope.$broadcast("change_call", {whatD});

            $scope.alert = '';
            $mdBottomSheet.show({
                templateUrl: 'parts/dialog/toSave.html',
                controller: 'GridBottomSheetCtrl',
                clickOutsideToClose: true
            }).then(function (clickedItem) {
                $mdToast.show(
                    $mdToast.simple()
                        .textContent(clickedItem['name'] + ' clicked!')
                        .position('top right')
                        .hideDelay(1500)
                );
            });
        };




        $scope.getTextToCopy = function (text) {
            console.log(text)
            var ss = "https://detail.tmall.com/item.htm?id=" + "" + text;
            return ss
        }
        $scope.copy_status = '点击复制文本!'
        $scope.doSomething = function (item, textInfo) {
            if (textInfo === 'pc') {
                // toaster.success('复制PC链接成功!', item.outer_id_gs, {

            }
            if (textInfo === 'wap') {
                // toaster.success('复制手机链接成功!', item.outer_id_gs, {
                    timeOut: 3000

            }
        }


        $scope.exportData = function (wh) {

            //		console.log(wh)


        };

        $scope.tm_dianpu = "onsale";

        $scope.selected = [];
        $scope.choes = ''
        $scope.perpage = 10;
        $scope.totalItems = [];


        $scope.currentPage = 1; //初始当前页
        $scope.maxSize = 3; //最多显示3页其他的用···代替
        //    $scope.allitem=[];//存放所有页


        $element.find('input').on('keydown', function (ev) {
            ev.stopPropagation();
        });
        $scope.selectedVegetables = [];
        $scope.printSelectedToppings = function printSelectedToppings() {
            var numberOfToppings = this.selectedVegetables.length;

            if (numberOfToppings > 1) {
                var needsOxfordComma = numberOfToppings > 2;
                var lastToppingConjunction = (needsOxfordComma ? ',' : '');
                var lastTopping = lastToppingConjunction +
                    this.selectedVegetables[this.selectedVegetables.length - 1];
                return this.selectedVegetables.slice(0, -1).join(', ') + lastTopping;
            }

            return this.selectedVegetables.join('');
        };

        $scope.demo = {
            showTooltip: false,
            tipDirection: ''
        };

        $scope.demo.delayTooltip = undefined;
        $scope.$watch('demo.delayTooltip', function (val) {
            $scope.demo.delayTooltip = parseInt(val, 10) || 0;
        });

        $scope.$watch('demo.tipDirection', function (val) {
            if (val && val.length) {
                $scope.demo.showTooltip = true;
            }
        })
        $scope.updata_status = '更新产品'


        $scope.updatagoods = function (stUP, fowhat) {
            console.log(fowhat)
            //		$scope.updata_success = true
            stUP = true
            console.log(stUP)
            $scope.to_opcatiy = true
            $scope.last_modified = ''
            // toaster.info('一次最多更新40条数据', '更新中...', {
            //     closeButton: true,
            //     progressBar: true,
            //     timeOut: 3000
            // })

            //		$http.post('API/taobao.items.onsale.get.php', {
            //			last_modified: $scope.last_modified
            //		}).success(function (upgoodsdata) {
            //			console.log(upgoodsdata)
            //			$scope.last_modified = upgoodsdata.last_modified
            //
            //
            //		})
            $scope.$watch('last_modified', function (newVal, oldVal) {
                console.log(newVal + 'xin')
                console.log(oldVal + 'jiu')
                console.log($scope.last_modified + '$scope')
                oldVal = 'need_'

                if ($scope.last_modified != oldVal) {
                    $scope.updata_success = true
                    $scope.updata_status = '更新中...'
                    $http.post('API/taobao.items.onsale.get.php', {
                        last_modified: newVal,
                        forwhat: fowhat
                    }).success(function (data) {
                        $scope.last_modified = data.last_modified

                    });

                }
                if ($scope.last_modified === 'complete') {
                    console.log('相等')
                    $scope.to_opcatiy = false
                    $scope.updata_success = false
                    $scope.updata_status = '更新产品'
                    // dataService.getUserInfo().then(function (res) {
                    //     console.log(res)
                    //     $scope.filteredgoods = res.all_goods
                    //     toastr.success('更新成功!', 'Toastr fun!', {
                    //         timeOut: 3000
                    //     });
                    // })
                }
            })
        }

        $scope.updataprice = function () {
            $http.post('API/update_prime_cost.php').success(function () {

            })
        }
        $scope.updataskus = function () {
            $scope.to_opcatiy = true

            $mdToast.show({
                hideDelay: 3000,
                position: 'bottom right',
                controller: 'ToastCtrl',
                templateUrl: 'toast-modal.html'
            }).then(function () {
                $scope.to_opcatiy = false
                $http.post('API/taobao.items.seller.list.get.php').success(function (musdata) {
                    //
                    $mdToast.show({
                        hideDelay: 3000,
                        textContent: 'Simple Toast!',
                        position: 'bottom right',
                    })


                    $scope.musdata = musdata;
                })
            })
        }

        $scope.search_goodsinfo = function (i, even) {

            if (i === undefined) {
                $scope.check_status = true
                even.stopPropagation;
            } else {
                $http.post('API/mk_get_all_goods.php', {
                    values: i
                }).success(function (newData) {

                    $scope.goods = newData.all_goods;
                })

            }

        }
        $scope.updatasale = function (filteredgoods) {
            //		console.log(filteredgoods)
            //		angular.forEach(filteredgoods, function(data,index,array){
            ////data等价于array[index]
            //console.log(filteredgoods[index].tmall_shop_num_iid);
            //});

            $http.post('API/update_sales_volume.php').success(function (newgoods) {

                if (newgoods.num_iid === filteredgoods.tmall_shop_num_iid) {
                    console.log('yeshi')
                }
                // dataService.getUserInfo().then(function (res) {
                //     console.log(res)
                //     $scope.filteredgoods = res.all_goods
                //     toastr.success('更新成功!', 'Toastr fun!', {
                //         timeOut: 3000
                //     });
                // })
                $timeout(function () {
                    $scope.to_opcatiy = false
                }, 2000)
            })
        }

    });

});


