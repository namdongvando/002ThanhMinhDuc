app.controller("categorydetailController", categorydetailController);
function categorydetailController($scope, $rootScope, $http, $routeParams) {

    $scope._CategoryDetail;
    $scope.categorydetailInit = function (catID) {
        $http.get("/backend/cattegorydetail/"+catID).then(function (res) {
                $scope._CategoryDetail = res.data;
        });
        $http.get("/backend/getCategorysByParentID/"+catID).then(function (res) {
                $scope._ListCategoryByParent = res.data;
        });
        
        
        
    }

}