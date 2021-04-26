const  APISanPham = {
    GetPages: "/sanpham/api/TemSanPham"
    , Dowloadzipfile: "/sanpham/api/dowloadzipfile"
    , CreateFileExcell: function(pagesIndex) {
        return  "/sanpham/api/CreateFileExcell/" + pagesIndex;
    },
    TemSanPhamPT: function(name, pagesIndex, pagesNumber) {
        var str = "/sanpham/api/TemSanPhamPT/[i]/[j]/[name]";
        var str1 = str.replace("[i]", pagesIndex);
        str1 = str1.replace("[j]", pagesNumber);
        str1 = str1.replace("[name]", name);
        return  str1;
    }
};

function sleep(ms) {
    return new Promise(resolve => setTimeout(resolve, ms));
}


app.controller("TemsanphamController", function($scope, $http) {
    $scope.expagesIndex = "1";
    $scope.expagesTotal = 1;
    $scope.expagesNumber = "10";
    $scope.TimKiemTemSanPham = function(Params, pagesIndex, pagesNumber)
    {
        /* tim tem sản phẩm phân trang */
        $http.get(APISanPham.TemSanPhamPT(Params.TuKhoa, pagesIndex, pagesNumber)).then(function(res) {
            $scope._ListItem = res.data;
            console.log($scope._ListItem);
            $scope.expagesIndex = pagesIndex;
            $scope.expagesTotal = $scope._ListItem.pagesTotal;
            $scope.expagesNumber = pagesNumber;
        });
    }
    $scope.TimKiemTemSanPham({"TuKhoa": ""}, $scope.expagesIndex, $scope.expagesNumber);
    $scope.XuatExcell = function() {
//        return;
        $http.get(APISanPham.GetPages).then(async function(res) {
//            $scope.expagesIndex = 0;
//            $scope.expagesTotal = res.data.TotalPage;
//            for (var i = 1; i <= $scope.expagesTotal; i++) {
//                await $scope.CreateFileExcell(APISanPham.CreateFileExcell(i)).then(function(res1) {
//                    $scope.expagesIndex++;
//                });
//            }
            await $http.get(APISanPham.Dowloadzipfile).then(function(res2) {
                console.log(res2.data.url);
                window.location.href = res2.data.url;
            });
        });
    }
    $scope.CreateFileExcell = function(link) {
        return $http.get(link);
    };

});