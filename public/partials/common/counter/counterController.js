app.controller("counterController", counterController);
function counterController($scope, $rootScope, $http, $routeParams) {
    $http.get("/api/counter/").then(function (res) {
        $scope.counter = res.data;
    });

    setInterval(function () {
        $http.get("/api/counter/").then(function (res) {
            $scope.counter = res.data;
        });
    }, 3000)
}