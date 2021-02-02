app.controller("listcategorysController", listcategorysController);
function listcategorysController($scope, $rootScope, $http, $routeParams) {
    $http.get("/backend/getCategorys").then(function(res) {
        $scope.ListCategory = res.data;
//        console.log($scope.ListCategory);
        $scope.showNameCategory = function(id) {
            if (id == 0) {
                return "Là Cấp Cha";
            }
            for (var itemCat in $scope.ListCategory) {
                if ($scope.ListCategory[itemCat].catID == id) {
                    return $scope.ListCategory[itemCat].catName;
                }
            }
        }
    });


    $scope.selectCategory = function(catID) {
        $scope.formcategoryInit(catID, true);
    }
    $scope.newCategory = function() {
        $scope._CategoryDetail = {
            catID: null,
            catName: null,
            catParentID: 0,

        };
    }


}