app.controller("editpageController", editpageController);
function editpageController($scope, $rootScope, $http, $routeParams) {

    $scope.editpageInit = function(Id) {
        $http.get('/mpage/getPagesById/' + Id).then(function(res) {
            $scope.itemPage = res.data;
            $scope.itemPage.Note = JSON.parse($scope.itemPage.Note);
        });
        $http.get("/mnews/getPagesAjax/").then(function(res) {
            $scope._Pages = res.data;
            console.log($scope._Pages);
        });
//        $http.get("/mnews/getPages").then(function(res) {
//            $scope._Pages = res.data;
//        });
    }
    $scope.addpageInit = function() {
        $scope.itemPage = {
            "Type": "1"
            , "idGroup": "0"
        };
        $http.get("/mnews/getPagesAjax/").then(function(res) {
            $scope._Pages = res.data;
        });
    }

}