require.config({
    baseUrl: './',
    paths: {
        'angular': 'assets/angular/angular.min',
        'angular-ui-router': 'assets/angular-ui-router/angular-ui-router.min',
        'angular-async-loader': 'assets/angular-async-loader/angular-async-loader.min',
        'angular-ng-dialog': 'assets/angular-ng-dialog/angular-ng-dialog',
        'angular-cookie': 'assets/angular-cookie/angular-cookie',
        'angular-file-upload': 'assets/angular-file-upload/angular-file-upload',
        'angular-toastr': 'assets/angular-toastr/angular-toastr.tpls',
        'angular-cgBusy': 'assets/angular-cgBusy/angular-cgBusy',
        'angular-datepicker': 'assets/moment/angular-daterangepicker',
        'jquery': 'assets/moment/jquery',
        'bootstrap': 'assets/moment/bootstrap',
        'datepicker': 'assets/moment/datepicker',
        'moment': 'assets/moment/moment',
        'moment_timezone': 'assets/moment/moment_timezone',
        'angular-md5': 'assets/angular-md5/angular-md5',
        'ng-csv': 'assets/ng-csv/ng-csv',
        'angular-sanitize': 'assets/angular-sanitize/angular-sanitize',
    },
    shim: {
        'angular': {exports: 'angular'},
        'angular-ui-router': {deps: ['angular']},
        'bootstrap': {deps: ['jquery']},
    }
});

require(['angular', './app-routes'], function (angular) {
    angular.element(document).ready(function () {
        angular.bootstrap(document, ['app']);
        angular.element(document).find('html').addClass('ng-app');
    });
});

