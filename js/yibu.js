define(function (require) {
    var app = require('../app');



    app.run(function ($rootScope, $state, ipCookie, $interval, $http, $mdDialog, $templateCache) {
        //监听路由事件
        // var username = ipCookie('username')
        // var nowTime = new  Date()
        // //test
        // $http.get("http://www.a10store.com/TB_API/API/update_timing_loop.php").success(
        //     function(response){
        //         // $scope.names = response;
        //         console.log(response)
        //     });
        //
        // var timer = $interval(function(){
        //     //时间未到23点不执行
        //     if(nowTime.getHours()==='23'){
        //         $http.get("http://www.a10store.com/TB_API/API/update_timing_loop.php").success(
        //             function(response){
        //                 // $scope.names = response;
        //                 console.log(response)
        //             });
        //     }
        //     console.log('未到执行点')
        // },1000)



        /* To show current active state on menu */


    });


    app.controller('ParentController',
        function ($scope, $rootScope, $mdDialog, ipCookie, $interval, $notification, $log, $state) {



            var p = [];
            $scope.enable = true
            $scope.showTabSet = function () {
                $mdDialog.show({
                    controller: settingCtrl,
                    templateUrl: 'dialog/setting.html',
                    parent: angular.element(document.body),
                    targetEvent: event,
                    scope: $scope,
                    preserveScope: true
                    //      clickOutsideToClose:true
                })
            }

            function settingCtrl($scope, $state, $window, $http, ipCookie, $mdDialog) {
                $scope.closeModal = function () {
                    $mdDialog.hide();
                }
                $scope.toggleShowtable = function (ny) {
                    if (ny === true) {
                        $notification.requestPermission()
                            .then(function success(value) {
                                new Notification('已设置为允许桌面通知', {
                                    body: $scope.currentUser,
                                    delay: 5000,
                                    icon: 'img/timg.jpg'
                                });
                            }, function error() {
                                $log.error("Can't request for notification");
                            })
                    }
                }
            }

            $scope.notify = function notify() {
                createNotification();
            };


            function createNotification() {
                var notification = $notification('New message', {
                    body: 'You have a new message.',
                    delay: 2000
                });
                notification.$on('show', function () {
                    $log.debug('My notification is displayed.');
                });
                notification.$on('click', function () {
                    $log.debug('The user has clicked in my notification.');
                });
                notification.$on('close', function () {
                    $log.debug('The user has closed my notification.');
                });
                notification.$on('error', function () {
                    $log.debug('The notification encounters an error.');
                });
            }


        });

    app.config(['ngClipProvider', 'toastrConfig', function (ngClipProvider, toastrConfig) {
        ngClipProvider.setPath("//cdn.bootcss.com/zeroclipboard/2.3.0/ZeroClipboard.swf");

        angular.extend(toastrConfig, {
            autoDismiss: false,
            containerId: 'toast-container',
            maxOpened: 0,
            newestOnTop: true,
            positionClass: 'toast-top-center',
            preventDuplicates: false,
            preventOpenDuplicates: false,
            target: '#content',
            timeOut: 2000,
        });
    }])

    app.config(function ($stateProvider, $urlRouterProvider, $httpProvider) {
        // $httpProvider.interceptors.push('UserInterceptor');
        if (!$httpProvider.defaults.headers.get) {
            $httpProvider.defaults.headers.get = {};
        }
        $httpProvider.defaults.headers.common["X-Requested-With"] = 'XMLHttpRequest';
        $httpProvider.defaults.headers.get['Cache-Control'] = 'no-cache';
        $httpProvider.defaults.headers.get['Pragma'] = 'no-cache';



    })
        .filter('keyboardShortcut', function ($window) {
            return function (str) {
                if (!str) return;
                var keys = str.split('-');
                var isOSX = /Mac OS X/.test($window.navigator.userAgent);

                var seperator = (!isOSX || keys.length > 2) ? '+' : '';

                var abbreviations = {
                    M: isOSX ? '⌘' : 'Ctrl',
                    A: isOSX ? 'Option' : 'Alt',
                    S: 'Shift'
                };

                return keys.map(function (key, index) {
                    var last = index == keys.length - 1;
                    return last ? key : abbreviations[key];
                }).join(seperator);
            };
        })


    app.controller('deleteController', function ($authorize, $scope, $http, $mdDialog, desserts, $nutrition, $q) {


        console.log(desserts)
        console.log($authorize)


        this.cancel = $mdDialog.cancel;

        function deleteDessert(dessert, index) {
            var deferred = $nutrition.desserts.remove({
                id: dessert.id
            });
            console.log(dessert)
            deferred.$promise.then(function () {
                desserts.splice(index, 1);
            });

            return deferred.$promise;
        }

        function onComplete() {
            $mdDialog.hide();
        }

        function error() {
            $scope.error = 'Invalid secret.';
        }

        function success() {
            $q.all(desserts.forEach(deleteDessert)).then(onComplete);
        }

        this.authorizeUser = function () {
            $authorize.get({
                secret: $scope.authorize.secret
            }, success, error);
        };

    })
// app.factory('$nutrition', ['$resource', function ($resource) {
//     'use strict';
//
//     return {
//         desserts: $resource('http://www.a10store.com/TB_API/API/mk_expense_list.php/:id')
//     };
// }]);


    app.controller('mainCtrl', function ($scope, $mdToast, $mdDialog, $http, toastr) {

        $http.get('http://www.a10store.com/TB_API/API/info_top.php').success(function (data) {
            $scope.all_data = data
            console.log($scope.all_data)

        })


    })

   

//会员页面
    app.controller('usersCtrl', function ($scope, $http, $filter) {
        $scope.ePage = 20;
        $http.post('http://www.a10store.com/TB_API/API/mk_get_all_users.php', {}).success(function (users) {
            $scope.users = users.all_users
        })
    })
//商品管理页面
    app.controller('ToastCtrl', function ($scope, $mdToast, $mdDialog) {

        $scope.closeToast = function () {
            if (isDlgOpen) return;

            $mdToast
                .hide()
                .then(function () {
                    isDlgOpen = false;
                });
        };

        $scope.openMoreInfo = function (e) {
            if (isDlgOpen) return;
            isDlgOpen = true;

            $mdDialog
                .show($mdDialog
                    .alert()
                    .title('More info goes here.')
                    .textContent('Something witty.')
                    .ariaLabel('More info')
                    .ok('Got it')
                    .targetEvent(e)
                )
                .then(function () {
                    isDlgOpen = false;
                })
        };
    });

    app.controller('GridBottomSheetCtrl', function ($scope, $mdBottomSheet, $filter) {


        $scope.items = [{
            name: '淘宝',
            saveas: 'tb',
            icon: 'img/tbao.png'
        }, {
            name: '天猫',
            saveas: 'tm',
            icon: 'img/tmall7d.png'
        }, {
            name: '一号店',
            saveas: 'yhd',
            icon: 'img/yhd7d.png'
        }, {
            name: '京东',
            saveas: 'jd',
            icon: 'img/jd7d.png'
        }, {
            name: '货品补货',
            saveas: 'buhuo',
            icon: 'img/quehuo7d.png'
        }];
        $scope.listItemClick = function ($index) {

            var clickedItem = $scope.items[$index];
            console.log(clickedItem.saveas)
            var Wclick = clickedItem.saveas
            $mdBottomSheet.hide(clickedItem);
            var today_date = new Date();
            var myJsDate = $filter('date')(today_date, 'yyyy-MM-dd');
            $('.' + Wclick).table2excel({
                filename: Wclick + myJsDate,
                fileext: ".xlsx",
            })
            //		console.log(myJsDate)
            //
            //		var blob = new Blob([document.getElementById(clickedItem.saveas).innerHTML],{
            //							type: 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet' })
            //		saveAs(blob, clickedItem.saveas + myJsDate + ".xlsx");

            //			$scope.$emit("change_call", {clickedItem});
        };
    })




    app.filter('count', function () {
        return function (collection, key) {
            //		console.log(collection)
            var out = "test";
            for (var i = 0; i < collection.length; i++) {
                //			console.log(collection[i].pants);
                //var out = myApp.filter('filter')(collection[i].pants, "42", true);
            }
            return out;
        }
    });


    app.filter('groupBy',
        function () {
            return function (collection, key) {
                if (collection === null) return;
                return uniqueItems(collection, key);
            };
        });

    app.controller('orderCtrl', function ($scope, $http, $filter) {
        $scope.ePage = 20;
        $scope.month = ''
        $scope.begin_time = ''
        $scope.end_time = ''
        $scope.orders = ''
        $scope.click_toorderinfo = function (order_id) {
            console.log(order_id)
            window.open("https://trade.tmall.com/detail/orderDetail.htm?bizOrderId=" + order_id)
        }
        //	$scope.currentPage = 0;
        //	$scope.pageSize = 20;
        //	$scope.data = [];
        $scope.q = '';
        $scope.date_refresh1 = new Date()
        $scope.date_refresh2 = $filter("date")($scope.date_refresh1, "yyyy-MM");

        console.log($scope.date_refresh2);
        $http.post('http://www.a10store.com/TB_API/API/mk_get_all_order.php', {
            newmonth: $scope.date_refresh2
        }).success(function (response) {
            $scope.data_i = response.data_info[0]

            //			console.log($scope.data_i)
            if (response.all_orders.length == 0) {
                console.log(response.all_orders.length)
                $scope.noorder = true;
                $scope.orders = ''
            } else {
                $scope.noorder = false;


                $scope.orders = response.all_orders
            }


        });
        $scope.getData = function () {

            return $filter('filter')($scope.data, $scope.q)
            console.log($scope.data)

        }
        $scope.numberOfPages = function () {
            return Math.ceil($scope.orders.length / $scope.pageSize);
        }

        $scope.change = function () {
            console.log($scope.month)
            $http.post('http://www.a10store.com/TB_API/API/mk_get_all_order.php', {
                newmonth: $scope.month
            }).success(function (response) {
                $scope.data_i = response.data_info[0]

                //			console.log($scope.data_i)
                if (response.all_orders.length == 0) {
                    console.log(response.all_orders.length)
                    $scope.noorder = true;
                    $scope.orders = ''
                } else {
                    $scope.noorder = false;


                    $scope.orders = response.all_orders
                }


            });


        }
        $scope.change_start = function () {
            console.log($scope.begin_time)
            console.log($scope.end_time)
            $scope.sendtime = function () {
                $http.post('http://www.a10store.com/TB_API/API/taobao.trades.sold.get.php', {
                    begin_time: $scope.begin_time,
                    end_time: $scope.end_time
                }).success(function (beginToend) {

                    window.location.reload;
                })
            }

        }


    });

})

// var app = angular.module('myApp', ['ngClipboard', 'ui.router', 'ngMaterial', 'ipCookie', 'md.data.table',
//     'angularFileUpload', 'ngAnimate', 'toastr', 'me-lazyimg', 'ngMessages', 'notification', 'uiSwitch', 'ngDialog', 'cgBusy', 'ngScreening',
//
//
// ])
