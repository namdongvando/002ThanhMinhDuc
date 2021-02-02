app.controller("formcategoryController", formcategoryController);
function formcategoryController($scope, $rootScope, $http, $routeParams) {

    $scope.formcategoryInit = function (catID, showreset) {
        $http.get("/backend/cattegorydetail/" + catID).then(function (res) {
            $scope._CategoryDetail = res.data;
        });
        $scope.showreset = showreset;
    }
    $http.get("/backend/getCategorys").then(function (res) {
        $scope.ListCategory = res.data;
    });

    $scope.clickReset = function () {
        $scope._CategoryDetail = {
            catID: null,
            catName: null,
            catParentID: 0,

        };
    }

}