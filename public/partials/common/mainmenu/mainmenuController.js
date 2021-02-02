app.controller("mainmenuController", mainmenuController);
function mainmenuController($scope, $rootScope, $http, $routeParams) {
    $scope._mainMenu = null;
    $http.get("/api/getmainMenu").then(function (res) {
        $scope._mainMenu = res.data;
    });

}