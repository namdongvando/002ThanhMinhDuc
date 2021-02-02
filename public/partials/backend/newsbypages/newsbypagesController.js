app.controller("newsbypagesController", newsbypagesController);
function newsbypagesController($scope, $rootScope, $http, $routeParams) {

    $scope.newsbypagesInit = function(idPa) {
        $http.get("/mnews/getNewsByPages/" + idPa).then(function(res) {
            $scope.newsByPage = res.data;
            $scope._pagesID = idPa;

        })
    }

}