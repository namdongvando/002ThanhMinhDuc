app.controller("leftmenunewsController", leftmenunewsController);
function leftmenunewsController($scope, $rootScope, $http, $routeParams) {
    $scope._leftMenu = null;
    $http.get("/api/getPages").then(function (res) {
        $scope._leftMenuNews = res.data;
        console.log($scope._leftMenuNews);
    });

}