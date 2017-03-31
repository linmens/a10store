define(function (require) {
    var app = require('../../app');
    app.controller('loginCtrl', function ($scope, $http, ipCookie, $timeout,$state,$rootScope) {
        $scope.loginWeb = function () {
            $http.post('app/login/api/login.php', {
                username: $scope.credentials.username,
                password: $scope.credentials.password
            }).success(function (data) {
                if (data.data_info === 'success') {
                    ipCookie('username', $scope.credentials.username)
                    ipCookie('password', $scope.credentials.password)
                    ipCookie('username_level', data.username_level)
                    $rootScope.currentUser = data.username
                    $rootScope.username_level = data.username_level
                    $state.go('main');
                    $rootScope.checkLoin = true
                }
                if (data.data_info === 'failure') {
                    return
                }
            })
        }

    })
})