app.controller("madvController", madvController);
function madvController($scope, $rootScope, $http, $routeParams) {
    $scope._Attribute = [];
    $scope._Advs = null;
    $scope._DetailAdvs = null;
    $scope.madvInit = function () {

    }

    $http.get("/madv/getAdvs").then(function (res) {
        $scope._Advs = res.data;
    });
    $http.get("/madv/getGroupAdvs").then(function (res) {
        $scope._GroupsAdv = res.data;
    });

    $scope.clickRemoveAtt = function (index) {
        $scope._Attribute.splice(index, 1);
    }
    $scope.clickAddAtt = function () {
        $scope._Attribute.push({key: "", value: ""});
    }

    $scope.clickSuaQuangCao = function (ID) {
        $scope._DetailAdvs = null;
        $http.get("/madv/getAdvsByID/" + ID).then(function (res) {
            $scope._editDetailAdvs = res.data;
            $scope._Attribute = JSON.parse($scope._editDetailAdvs.DataAttribute);
        });
    }
    $scope.clickCopyQuangCao = function (ID) {
//       tạo
        $scope._editDetailAdvs = null;
        $http.get("/madv/getAdvsByID/" + ID).then(function (res) {
            $scope._DetailAdvs = res.data;
            $scope._Attribute = JSON.parse($scope._DetailAdvs.DataAttribute);
        });



    }

}