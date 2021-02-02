app.controller("bklayoutController", bklayoutController);
function bklayoutController($scope, $http) {

    var tabNVD = new TabVND(1000, 50);


    $scope.DangNhap = null;
    $scope.bklayoutInit = function(quantri) {
        $scope.DangNhap = quantri;
    }

    $http.get("/backend/getMenuByuser/").then(function(res) {
        $scope.__Menus = res.data;
        console.log(res.data);
    });

    $scope.TimKiem = function(keyword) {
        if (keyword.length < 3) {
            return;
        }
        $http.get("/api/timkiem/" + keyword + "/").then(function(res) {
            $scope.KetQuaTimKiem = res.data;
        });

    }

    $scope.getAllTabs = function() {
        var tabVND = new TabVND();
        return  tabVND.getTabs();
    }

}