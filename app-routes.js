define(function (require) {
    var app = require('app');
    app.constant('dateRangePickerConfig', {
        clearLabel: 'Clear',
        locale: {
            separator: ' - ',
            format: 'YYYY-MM-DD'
        },
        "autoApply": true,
        "showDropdowns": true,
        minDate:'2015-1-1',
        maxDate:moment().subtract(1, "days").format("YYYY-MM-DD")
    });
    app.run(function ($state, $stateParams, $rootScope, ipCookie, $templateCache, ngDialog, $q, $location) {
        var date = new Date;
        $rootScope.reFresh = date
        $rootScope.nowmonth = $rootScope.reFresh.getMonth() + 1;
        $rootScope.paginationConf = {
            currentPage: 1,
            itemsPerPage: 10
        };
     
        $rootScope.indexMenu = [
            {
                id: 0,
                text: '所有工具',
                uiSerf: 'main'
            }, {
                id: 1,
                text: '经营分析',
                uiSerf: 'summary.yeji'
            }, {
                id: 8,
                text: '客服绩效',
                uiSerf: 'Customerservice'
            }, {
                id: 3,
                text: '订单信息',
                uiSerf: 'dingdan'
            } ,{
                id: 3,
                text: '客户维护',
                uiSerf: 'kehu'
            }, {
                id: 2,
                text: '商品',
                uiSerf: 'goods'
            }, {
                id: 4,
                text: '财务',
                uiSerf: 'caiwu.feiyong'
            }, {
                id: 5,
                text: '调配货',
                uiSerf: 'peihuo'
            }, {
                id: 6,
                text: '单据中心',
                uiSerf: 'DocumentCenter'
            }
        ]
        $rootScope.changeIndexm = function (Imenu) {
            $rootScope.imId = Imenu.id

        }
        $rootScope.currentUser = ipCookie('username')
        $rootScope.username_level = ipCookie('username_level')
        $rootScope.loginout = function () {
            $rootScope.checkLoin = false
            ipCookie.remove('username')
            ipCookie.remove('password')
            $state.go('login')

        }
        $rootScope.checkLoin = true
        if (!$rootScope.currentUser) { // Check if user allowed to transition
            $location.path('/login');
            $rootScope.checkLoin = false
        }
        $rootScope.$on('$stateChangeStart', function (event, next, toState, toParams, fromState, fromParams, current) {
            $rootScope.pageBody = next.name
            $rootScope.hrefs = ['css/app.css','css/ops-base.css','css/sui.css','css/weui.css']
            if(next.name =='login'){
                $rootScope.hrefs = []
            }
            // if(next.name =='summary.yeji'){
            //     $rootScope.hrefs = ['css/app.css','css/ops-base.css']
            // }
            if (typeof(current) !== 'undefined') {
                $templateCache.remove(current.templateUrl);
            }
            angular.forEach($rootScope.indexMenu, function (data, index, array) {
                if (array[index].uiSerf == toState.name) {
                    $rootScope.imId = array[index].id
                }
            });
            $rootScope.state = toState
        })
    });
    app.config(['$stateProvider', '$urlRouterProvider', 'ngDialogProvider', function ($stateProvider, $urlRouterProvider, ngDialogProvider) {
        ngDialogProvider.setDefaults({
            className: 'ngdialog-theme-plain',
            showClose: true,
        })
        $stateProvider
            .state('all_orders', {
                url: '/all_orders',
                templateUrl: 'all_orders.html',
                controller: 'orderCtrl',
            })

            // url will be /form/interests
            .state('main', {
                url: '/main',
                templateUrl: 'app/main.html',
                controller: 'mainCtrl',
                controllerUrl: 'app/mainCtrl',
            })
            .state('login', {
                url: '/login',

                views: {
                    'login': {
                        templateUrl: 'app/login/login.html',
                        controller: 'loginCtrl',
                        controllerUrl: 'app/login/loginCtrl',
                    }
                },
            })

            .state('goods', {
                url: '/goods/:menuType',
                templateUrl: 'app/goods/goods.html',
                controller: 'goodsCtrl',
                controllerUrl: 'app/goods/goods',
                dependencies: ['directive', 'factory'],

            })

            // url will be /form/payment
            .state('all_users', {
                url: '/all_users',
                templateUrl: 'all_users.html',
                controller: 'usersCtrl',

            })
            .state('caiwu', {
                url: '/caiwu',
                templateUrl: 'app/caiwu/caiwu.html',
                controller: 'caiwuCtrl',
                controllerUrl: 'app/caiwu/caiwuCtrl',
                dependencies: ['directive', 'factory'],
            })
            .state('caiwu.feiyong', {
                url: '/feiyong',
                views: {
                    'content': {
                        templateUrl: "app/caiwu/caiwu_feiyongmingxi.html",
                        controller: 'caiwu_feiyongmingxijiCtrl',
                    }
                },
            })
            .state('dingdan', {
                url: '/dingdan',
                templateUrl: 'app/dingdan/dingdan.html',
                controller: 'dingdanCtrl',
                controllerUrl: 'app/dingdan/dingdanCtrl',
                dependencies: ['directive','factory'],
            })

            .state('peihuo', {
                url: '/peihuo',
                templateUrl: 'app/peihuo/peihuo.html',
                controller: 'peihuoCtrl',
                controllerUrl: 'app/peihuo/peihuoCtrl',
                dependencies: ['directive', 'factory'],

            })
            .state('peihuo.diaohuo', {
                url: '/diaohuo',
                views: {
                    'diaohuo': {
                        templateUrl: 'app/peihuo/diaohuo.html',
                        controller: 'peihuoCtrl',
                    }
                },

            })

            .state('DocumentCenter', {
                url: '/DocumentCenter',
                templateUrl: 'app/DocumentCenter/DocumentCenter.html',
                controller: 'DocumentCenterCtrl',
                controllerUrl: 'app/DocumentCenter/DocumentCenter',

            })
            .state('summary', {
                url: '/summary',
                templateUrl: "app/summary/summary.html",
                controller: 'summaryCtrl',
                controllerUrl: 'app/summary/summaryCtrl',
                dependencies: ['factory'],

            })


            .state('summary.yeji', {
                url: '/yeji',
                views: {
                    'columnOne': {
                        templateUrl: "app/summary/summary_yeji.html",
                        controller: 'summaryyejiCtrl',
                    }
                },


            })
            .state('summary.huopin', {
                url: '/huopin',
                views: {
                    'columnOne': {
                        templateUrl: "app/summary/summary_huopin.html",
                        controller: 'summaryhuopinCtrl',
                    }
                }
            })
            .state('summary.dingdan', {
                url: '/dingdanfenxi',
                views: {
                    'columnOne': {
                        templateUrl: "app/summary/summary_dingdan.html",
                        controller: 'summarydingdanCtrl',
                    }
                },

            })
            .state('summary.shangpin', {
                url: '/shangpinfenxi',
                views: {
                    'columnOne': {
                        templateUrl: "app/summary/summary_shangpin.html",
                        controller: 'summaryshangpinCtrl',
                    }
                },

            })
            .state('kehu', {
                url: '/kehu',
                templateUrl: "app/kehu/kehu.html",
                controller: 'kehuCtrl',
                controllerUrl: 'app/kehu/kehuCtrl',
                dependencies: ['factory','directive'],

            })
            .state('Customerservice', {
                url: '/Customerservice',
                templateUrl: 'app/Customerservice/Customerservice.html',
                controller: 'CustomerserviceCtrl',
                controllerUrl: 'app/Customerservice/CustomerserviceCtrl',

            })
        $urlRouterProvider.otherwise("summary/yeji");
    }])

});
