app.controller("slidebackgroundController", slidebackgroundController);
function slidebackgroundController($scope, $rootScope, $http, $routeParams) {
    $scope._listSlideBackground = [];
//    $http.get('/api/getAdvByGroup/homeslide').then(function (res) {
//        $scope._listSlideBackground = res.data;
//
//    });
    $scope.slidebackgroundInit = function () {
        $http.get('/api/getAdvByGroup/homeslide').then(function (res) {
        for (var item in res.data) {
                res.data[item].Attribute = JSON.parse(res.data[item].Attribute);
            }
            $scope._listSlideBackground = res.data;
            console.log($scope._listSlideBackground);
        });
    }

}