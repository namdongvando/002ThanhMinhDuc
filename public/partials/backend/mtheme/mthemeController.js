app.controller("mthemeController", mthemeController);
function mthemeController($scope, $rootScope, $http, $routeParams) {
    $http.get("/mtheme/getThemes/").then(function(res) {
        $scope._Themes = res.data;
        console.log($scope._Themes);
    });

    $scope.Plugin = function() {
        $http.get("/mtheme/getMenuByTheme/" + theme).then(function(res) {

        });
    };
    $scope.clickChonTheme = function(theme) {
        $http.get("/mtheme/getMenuByTheme/" + theme).then(function(res) {
            $scope._MenuByTheme = res.data;
            console.log($scope._MenuByTheme);
        });
    };
    $scope.clickChonConfig = function(theme, config) {

        $http.get("/backend/getConfig/" + theme + '/' + config).then(function(res) {
            $scope._MenuByTheme = res.data;
        });
    };
}