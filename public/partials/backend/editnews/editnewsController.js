app.controller("editnewsController", editnewsController);
function editnewsController($scope, $rootScope, $http, $routeParams) {

//    $http.get("/mnews/getPages").then(function(res) {
//        $scope.PagesByType = res.data;
//    });

    $scope.GetTinChoDuyet = function() {
        $http.get("/mnews/getDuyetTin/").then(function(res) {
            $scope.__TinChoDuyet = res.data;
            console.log($scope.__TinChoDuyet);
        })
    }

    $http.get("/mnews/getPagesAjax/").then(function(res) {
        $scope.PagesByType = res.data;
        console.log($scope.PagesByType);
    });
    $scope.editnewsInit = function(newsId) {
        $http.get("/mnews/getNews/" + newsId).then(function(res) {
            $scope._New = res.data;
        });
    }

}