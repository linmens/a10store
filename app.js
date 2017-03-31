define(function (require, exports, module) {
    var angular = require('angular');
    var asyncLoader = require('angular-async-loader');

    require('angular-ui-router');
    require('angular-cookie');
    require('angular-ng-dialog');
    require('angular-cgBusy');

    var app = angular.module('app', ['ui.router','ipCookie','ngDialog','cgBusy']);

    asyncLoader.configure(app);

    module.exports = app;
});
