define(function (require) {

    var app = require('../../app');
    require('angular-file-upload')
    app.useModule('angularFileUpload');
    app.controller('caiwuCtrl', function ($scope,ngDialog, $http,$state) {
        $scope.smenu = $state.current.name
        $scope.Pmenu = [{text: '费用明细', sref: 'caiwu.feiyong'},
        ]
        $scope.tabsle = [{
            text: '工资'
        }, {
            text: '提成'
        }, {
            text: '社保医保'
        }, {
            text: '差旅费'
        }, {
            text: '平台使用费'
        }, {
            text: '软件费'
        }, {
            text: '折旧费'
        }, {
            text: '设备'
        }, {
            text: '韵达运费'
        }, {
            text: '退换货运费'
        }, {
            text: '拍照'
        }, {
            text: '直通车费用'
        }, {
            text: '短信充值'
        }, {
            text: '好评费用'
        }, {
            text: '闪购费'
        }, {
            text: '推广费'
        }, {
            text: '促销费'
        }, {
            text: '淘宝客'
        }, {
            text: '其他'
        }]

        $scope.copy_this = function (copy) {
            $scope.formData.class = copy
        }
        $scope.myDate = new Date();

        $scope.minDate = new Date(
            $scope.myDate.getFullYear(),
            $scope.myDate.getMonth() - 2,
            $scope.myDate.getDate());

        $scope.maxDate = new Date(
            $scope.myDate.getFullYear(),
            $scope.myDate.getMonth(),
            $scope.myDate.getDate());

        this.settings = {
            printLayout: true,
            showRuler: true,
            showSpellingSuggestions: true,
            presentationMode: 'edit'
        };

        // $http.get('API/mk_get_profit_statement.php').success(function (all_caiwu) {
        //
        //     $scope.allsscaiwu = all_caiwu.all_data
        //     $scope.tm_caiwu = all_caiwu.tm_date
        //     $scope.data_info = all_caiwu.data_info
        //     console.log(all_caiwu)
        //     $scope.tb_caiwu = all_caiwu.tb_date
        //     $scope.jd_caiwu = all_caiwu.jd_date
        //     $scope.yhd_caiwu = all_caiwu.yhd_date
        //
        //     console.log($scope.allsscaiwu)
        // })
        //	获取 所有费用明细API
        // $http.get('API/mk_get_expense_detail.php').success(function (mk_get_expense_detail) {
        //     //		console.log(all_caiwu)
        //     $scope.all_detail_data = mk_get_expense_detail.all_data
        //     $scope.tm_details = mk_get_expense_detail.tm_date
        //     $scope.tb_details = mk_get_expense_detail.tb_date
        //     $scope.jd_details = mk_get_expense_detail.jd_date
        //     $scope.yhd_details = mk_get_expense_detail.yhd_date
        //
        //     //		console.log($scope.allsscaiwu)
        // })
        $scope.formData = {}
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

        $scope.addTo = function (f, index) {
            console.log(f)
            states = f.state
            $scope.addId = f.id
            $http.post('API/get_list_expense.php', {
                id: f.id,
                state: f.state
            }).success(function (data) {
                // $scope.Sdorder.splice(index, 1);
                feiyong();
                console.log(data)
            })

        }

        $scope.addNewFeiyong = function (ev) {
            ngDialog.open({
                controller: addNewFeiyong,
                templateUrl: 'app/caiwu/addNewFeiyong.html',
                parent: angular.element(document.body),
                targetEvent: ev,
                scope: $scope,
                preserveScope: true
                //      clickOutsideToClose:true
            })
        }

        function addNewFeiyong($scope, $filter) {

            $scope.names = [
                'tm', 'tb'
            ]
            $scope.contacts = [{
                id: 1,
                fullName: '啦',
            }, {
                id: 2,
                fullName: '啦啦'
            }]
            $scope.selectId = 1;
            $scope.date = new Date()
            $scope.pay_time = $filter("date")($scope.date, "yyyy-MM-dd HH:mm:ss");
            $scope.formData = {
                money_state: '未结算',
                state: '未确认',
                pay_time: $scope.pay_time,
                selectedId: $scope.selectId,
                user: $scope.currentUser
            };
            $scope.formData.shop = '依布天猫'
            console.log($scope.selectId)
            $scope.closeModal = function () {
                ngDialog.close();
            }

            $scope.yesToPush = function (formData) {
                console.log(formData)
                if (formData.selectedId == 2) {
                    console.log('should be in huodong')
                    $scope.Sdstates[0].key = 'no'
                    $scope.stateID = 0 //切换到活动单 button
                }
                $http.post('API/get_list_expense.php', {data: formData}).success(function (data) {
                    feiyong()
                    // createNotification();
                    ngDialog.close();
                })
            }
        }

        // $scope.delete = function (event) {
        //     $mdDialog.show({
        //         clickOutsideToClose: true,
        //         controller: 'deleteController',
        //         controllerAs: 'ctrl',
        //         focusOnOpen: false,
        //         targetEvent: event,
        //         locals: {
        //             desserts: $scope.selected
        //         },
        //         templateUrl: 'dialog/delete_dialog.html',
        //     }).then($scope.getDesserts);
        // };
        $scope.submit_new = function (form) {
            console.log(form)
            console.log($scope.tabsle.text)
            //			if(form.class!=$scope.tabsle.text){
            //				toastr.error('请在表头选择正确的支出项目!',  {
            //				timeOut: 3000
            //			});

            //				return false
            //			}
            //
            $scope.add_list = {
                class: form.class,
                class_detail: form.class_detail,
                price: form.price,
                num: form.num,
                all_price: form.all_price,
                user: form.user,
                shop: form.shop,
                invoice: '未收到',
                state: '未报销',
                buy_time: $scope.myDate,
                reimburse_time: $scope.myDate,
                admin_confirm: '未审核'
            }
            console.log($scope.add_list)
            $scope.mk_expense_list.push($scope.add_list)

            angular.forEach($scope.mk_expense_list, function (data, index, array) {
                //data等价于array[index]
                if (data.class === $scope.formData.class) {
                    $http.post('API/mk_expense_list.php', {
                        formData: $scope.formData,
                        datetime: $scope.myDate
                    }).success(function (rs) {
                        console.log(rs)
                    })
                    console.log(data.class + '=' + array[index].class);
                }

            });

        }

        //		console.log($scope.allsscaiwu)
        //	})
        //})
    })
    app.directive('affixMe', ['$timeout','$window', function($timeout, $window) {
        return {
            restrict: 'A',
            link: function(scope, element) {
                scope.width = element.prop('offsetWidth');
                var elWidth = scope.width + 'px',
                    elChild = angular.element(element[0].querySelector(':first-child'));
                console.log(elWidth)
                elChild.css('width', elWidth);
                angular.element($window).bind("scroll", function() {
                    var affixElement = document.getElementById('affix'),
                        xPosition = 0,
                        yPosition = 0;
                    function getPosition(element) {
                        while(element) {
                            yPosition += (element.offsetTop - element.scrollTop + element.clientTop);
                            element = element.offsetParent;
                        }
                    }
                    getPosition(affixElement);
                    if (yPosition >= 0) {
                        elChild.removeClass('affix');
                    } else if ( yPosition < 0) {
                        elChild.addClass('affix');
                    };
                });
            }
        };
    }])
    app.controller('caiwu_feiyongmingxijiCtrl', function ($scope,ngDialog, $http,caiwuList,FileUploader) {
        $scope.menuActive = '所有'
        $scope.selectedActive = '刷单'
        $scope.statusActive = '不限'
        $scope.feiyongMenu = ['所有', '刷单', '闪购费', '拍照费', '直通车费用', '软件费', '短信费']
        $scope.feiyongtableTh = ['费用项', '说明', '店铺', '金额', '状态', '申请时间', '报销人', '操作']
        $scope.feiyongstatus = ['未打款', '已打款', '已报销']
        $scope.feiyongshop = ['天猫','淘宝', '一号店']
        var reget = function () {
            var postdata = {menu: $scope.menuActive,status: $scope.statusActive ,shop:$scope.shopActive}
            $scope.caiwupromise =  caiwuList.getfeiyong(postdata).then(function (data) {
               $scope.jsonFeiyong = data.data
           })
       }
        reget();
        $scope.changePage = function (myId) {
            $scope.menuActive = myId
            reget()
        }
        $scope.selected = function (ms) {
            $scope.selectedActive = ms
        }
        $scope.status = function (ms) {
            $scope.statusActive = ms
            reget()
        }
        $scope.shops = function (ms) {
            console.log(ms)
            $scope.shopActive = ms
            reget()
        }
        $scope.check = function (k) {
            $scope.isSelected = !$scope.isSelected
        }
        //确认按钮
        $scope.checktrue = function (item) {
            caiwuList.queren(item.id,item.state).then(function (data) {
                console.log(data)
            })
            reget()
        }
        $scope.shopvalue = '天猫'
        $scope.shop = ['天猫','淘宝','一号店']
        $scope.changeValue = function (v) {
            $scope.shopvalue = v
            $scope.isSelected = false
        }
        $scope.addNewSd = function (ev) {
            ngDialog.open({
                controller:feiyongCtrl,
                template: 'addfeiyong.html',
                scope: $scope
            })

        }
        $scope.priewImg = function (img) {
            console.log(img)
            $scope.img_src =img
            if(img==''){
                alert('暂无图片')
            }else {
                $('.weui-gallery').fadeIn()
                $('body').css('overflow','hidden')
            }

        }

        function feiyongCtrl($scope,FileUploader) {
            var uploader = $scope.uploader = new FileUploader({
                autoUpload: false,
                queueLimit:5
            })
            uploader.filters.push({
                name: 'imageFilter',
                fn: function(item /*{File|FileLikeObject}*/, options) {
                    var type = '|' + item.type.slice(item.type.lastIndexOf('/') + 1) + '|';
                    return '|jpg|png|jpeg|bmp|gif|'.indexOf(type) !== -1;
                }
            })
            uploader.onAfterAddingFile = function(fileItem) {
                console.info('onAfterAddingFile', fileItem);
                // console.log(this.queue)
                if(this.queue.length>5){
                    alert('不能多于5张图!')
                }
            };
            uploader.onProgressAll = function(progress) {
                console.info('onProgressAll', progress);

            };
            uploader.onBeforeUploadItem =  function(item) {
                var $form = $("#form");
                $form.form();

                var format = function(time, format)

                {
                    var t = new Date(time);
                    var tf = function(i){return (i < 10 ? '0' : '') + i};
                    return format.replace(/yyyy|MM|dd|HH|mm|ss/g, function(a){
                        switch(a){
                            case 'yyyy':
                                return tf(t.getFullYear());
                                break;
                            case 'MM':
                                return tf(t.getMonth() + 1);
                                break;
                            case 'mm':
                                return tf(t.getMinutes());
                                break;
                            case 'dd':
                                return tf(t.getDate());
                                break;
                            case 'HH':
                                return tf(t.getHours());
                                break;
                            case 'ss':
                                return tf(t.getSeconds());
                                break;
                        }
                    })
                }

                var youWant =  format($scope.justDate, 'yyyy-MM-dd HH:mm:ss')

            console.log(youWant)

                $form.validate(function(error){
                    if(error){

                    }else{
                        // var  youWant = $filter("date")($scope.justDate, "yyyy-MM-dd HH:mm:ss")

                        // var  youWant=d.getFullYear() + '-' + (d.getMonth() + 1) + '-' + d.getDate() + ' ' + d.getHours() + ':' + d.getMinutes() + ':' + d.getSeconds();
                        item.url = 'app/caiwu/api/add_new_expense.php?f='+ $scope.selectedActive + '&shop='+$scope.shopvalue+'&price='+$scope.price+'&date='+youWant +'&shuoming='+$scope.shuoming+ '&user='+$scope.currentUser
                    }
                });

//yyyy-MM-dd hh:mm:ss
            }

            uploader.onCompleteAll = function() {
                console.info('onCompleteAll');
                // $.toast("操作成功")
                $.toptips('验证通过提交','ok');
                ngDialog.close()
                reget()
            };
            // uploader.uploadAll = function () {
            //
            // }

            // $("#formSubmitBtn").on("click", function(){
            //
            //
            //
            // });

            $scope.hoverIn = function(){
                this.hoverEdit = true;
            };

            $scope.hoverOut = function(){
                this.hoverEdit = false;
            };

        }


    })
})
