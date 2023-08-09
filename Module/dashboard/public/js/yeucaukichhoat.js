app.controller("YeucaukichhoatController", YeucaukichhoatController);
function YeucaukichhoatController($scope, $rootScope, $http, $routeParams) {
}

function OnChon(code, time) {
    try {
        console.log(code);
        console.log(time);
        $("#mayeucau").val(code);
        $("#ngaybatdau").val(time);
    } catch (error) {
        console.log(error);
    }

}

function DongYKichHoat() {
    var dataFormString = $("#formXacNhanKichHoat").serialize();
    $.ajax({
        url: `/dashboard/yeucaukichhoat/dongy/`,
        type: 'GET',
        data: dataFormString,
        contentType: 'application/x-www-form-urlencoded; charset=UTF-8',
        success: function (response) {
            alert("cập nhật thành công");
            window.location.reload();
        },
        error: function () {
            alert("error");
        }
    });
    return false;
}

function TuChoiKichHoat(code, e) {
    $.ajax({
        url: `/dashboard/yeucaukichhoat/tuchoi/${code}`,
        type: 'GET',
        success: function (response) {
            alert("cập nhật thành công");
            window.location.reload();
        },
        error: function () {
            alert("error");
        }
    });
    return false;
}

function LamLaiKichHoat(code, e) {
    $.ajax({
        url: `/dashboard/yeucaukichhoat/lamlai/${code}`,
        type: 'GET',
        success: function (response) {
            alert("cập nhật thành công");
            window.location.reload();
        },
        error: function () {
            alert("error");
        }
    });
    return false;
} 