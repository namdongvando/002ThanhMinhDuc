app.config(function($routeProvider) {
    $routeProvider
            .when("/:id", {
                templateUrl: "/trungtambaohanh/yeucaubaohanh/detail"
                , controller: "yeucaubaohanhController"
            })
            .when("/edit/:id", {
                templateUrl: "/Eventwf/edit"
                , controller: "EventWFController"
            })
            .when("/detail/:id", {
                templateUrl: "/Eventwf/detail"
                , controller: "EventWFController"
            });
});
app.controller("yeucaubaohanhController", yeucaubaohanhController);
app.controller("formyeucauController", formyeucauController);
const  ApiWf = {
    YeuCauBaoHanh: {
        GetByCode: function(code) {
            return "/trungtambaohanh/api/GetYeuCauBaoHanhByCode/" + code;
        },
        GetStatusYeuCauBaoHanh: "/trungtambaohanh/api/GetStatusYeuCauBaoHanh",
        Update: "/trungtambaohanh/api/ycbhUpdate",
        UpdateKhachHangTieuDung: "/trungtambaohanh/api/thongtinkhachhang"
    },
    TrungTamBaoHanh: {
        Get: "/trungtambaohanh/api/getTTBH",
    }
    , NhanVienBaohanh: {
        Get: "/trungtambaohanh/api/NhanVienBaoHang",
    }
    , Options: {
        KhuVuc: "/option/api/optionsbyGroups/khuvuc"
    }
}
app.directive("formXulyYeucauBaohanh", function() {
    return {
        restrict: 'AEC',
        templateUrl: "/trungtambaohanh/yeucaubaohanh/form",
        scope: {
            formdataDefaut: '=',
            onClickNotify: "&onSubmit",
        },
        controller: "formyeucauController",
        replace: true,
        transclude: false,
        link: function(scope, element, attrs, controller) {
            scope.onSubmit = function() {
                if (typeof (scope.onClickNotify) == 'function') {
                    scope.onClickNotify();
                }
            }
        }
    };
});

function formyeucauController(appService, $scope, $rootScope, $http, $routeParams) {

    appService._Get(ApiWf.YeuCauBaoHanh.GetStatusYeuCauBaoHanh).then(function(res) {
        $scope.listStatus = res.data;
    });
    appService._Get(ApiWf.TrungTamBaoHanh.Get).then(function(res) {
        $scope._TrungTamBaoHanh = res.data;
        console.log(res.data);
    });
    appService._Get(ApiWf.NhanVienBaohanh.Get).then(function(res) {
        $scope._NhanVienBaoHanh = res.data;
        console.log(res.data);
        console.log("++++");
    });
    appService._Get(ApiWf.Options.KhuVuc).then(function(res) {
        $scope._KhuVuc = res.data;
        console.log(res.data);
    });
    $scope.LuuThongTinKhachHang = function(modelkhachhang, isCofirm) {
        try {
            if (isCofirm == true)
                if (window.confirm("Bạn Muốn Cập Nhật Thông Tin Khách Hàng.") == false) {
                    return;
                }
            $param = modelkhachhang;
            appService._Post(ApiWf.YeuCauBaoHanh.UpdateKhachHangTieuDung, $param).then(function(res) {
                alert("Đã cập nhật thông tin");
            });
        } catch (e) {
            alert(e)
        }
    }
    $scope.SaveFormData = function(data) {
        try {
            if (window.confirm("Bạn Muốn Cập Nhật Thông Tin.") == false) {
                return;
            }
            if (data.Status == null) {
                throw "Bạn Chưa Chọn Tình Trạng";
            }
            var $param = data;
            $scope.LuuThongTinKhachHang(data.ThongTinKhachHang, false);
            // cập nhật thông tin tem sản pham
            appService._Post(ApiWf.YeuCauBaoHanh.Update, $param).then(function(res) {
                console.log(res);
//                alert("Đã cập nhật thông tin");
            });
        } catch (e) {
            alert(e)
        }

    }
    $("#imgInp").change(function() {
        input = this;
        if (input.files && input.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#imgpreview').attr('src', e.target.result);
            }
            reader.readAsDataURL(input.files[0]); // convert to base64 string
        }
    });
}

function yeucaubaohanhController(appService, $scope, $rootScope, $http, $routeParams) {
    console.log($routeParams.id);
    $scope.Location = "abc";
    $scope.alert = {
        isShow: false,
        type: null,
        content: null,
    };
    appService._Get(ApiWf.YeuCauBaoHanh.GetByCode($routeParams.id)).then(function(res) {
        console.log(res.data);
        console.log("====");
        $scope._Yeucaubaohanh = res.data;
        $scope._Yeucaubaohanh.CreateDate = new Date(Date.parse($scope._Yeucaubaohanh.CreateDate));
//        $scope._Yeucaubaohanh.idNhanVien = parseInt($scope._Yeucaubaohanh.idNhanVien);
        console.log($scope._Yeucaubaohanh.idNhanVien);
        $scope._Yeucaubaohanh.NgayBaoHanh = new Date(Date.parse($scope._Yeucaubaohanh.NgayBaoHanh));
        $scope._Yeucaubaohanh.TemSanPham.NgayKetThuc
                = new Date(Date.parse($scope._Yeucaubaohanh.TemSanPham.NgayKetThuc));
        console.log($scope._Yeucaubaohanh);
    });
    appService._Get(ApiWf.YeuCauBaoHanh.GetStatusYeuCauBaoHanh).then(function(res) {
        $scope._StatusYeucaubaohanh = res.data;
    });
}



