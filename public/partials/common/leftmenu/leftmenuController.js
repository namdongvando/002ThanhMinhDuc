app.controller("leftmenuController", leftmenuController);
function leftmenuController($scope, $rootScope, $http, $routeParams) {
    $scope._leftMenu = null;
    $http.get("/api/getmainMenu").then(function (res) {
        $scope._leftMenu = res.data;
    });

}