app.controller("QuanLyTemController", QuanLyTemController);
function QuanLyTemController($scope, $rootScope, $http, $routeParams) {
    $scope.TenSanPham = [];
    $http.get("/sanpham/api/DanhSachTemSanPham/1/100").then(function(res) {
        $scope.TenSanPham = res.data;
    });
    $scope.DangSachTemPhanTrang = function(param, pagesIndex, pagesNumber) {
        $http.get("/sanpham/api/DanhSachTemSanPham/" + pagesIndex + "/" + pagesNumber).then(function(res) {
            $scope.TenSanPham = res.data;
        });
    }

}
