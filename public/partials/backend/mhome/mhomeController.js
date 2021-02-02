app.controller("mhomeController", mhomeController);
function mhomeController($scope, $rootScope, $http, $routeParams) {

    $scope.wellcone = function() {
        $http.get("/backend/backendhomeapi/").then(function(res) {
            $scope.wellconeapi = res.data;
            console.log($scope.wellconeapi);
        });

    }

    $scope.AppMobieData = function() {
        $http.get("/backend/backendhomeapi/").then(function(res) {
            $scope.wellconeapi = res.data;
            console.log($scope.wellconeapi);
        });
    }

    $scope.Theme = "home1";
    $http.get("/mpage/getPages/").then(function(res) {
        $scope.ListPages = res.data;

    });

    $scope.mhomeobj = function(ConfigHome) {

    }
    $scope.mhomeInit = function(theme, ConfigHome) {
        $scope.Theme = theme;
        $scope.Home = ConfigHome;
        console.log($scope.Home);
        if (!$scope.Home.DanhMucHome) {
            $scope.Home.DanhMucHome = [];
        }

        $scope.clickRemoveCategory = function(item) {
            console.log(item);
            $scope.Home.DanhMucHome.splice(item, 1);
        }
        $scope.clickRemoveDanhMucLeftArea = function(item) {
            $scope.Home.DanhMucLeftArea.splice(item, 1);
        }
        $scope.clickDanhMucLeftArea = function() {

            $scope.Home.DanhMucLeftArea.push(
                    {
                        Display: "0",
                        Pages: ""
                    }
            );
        }
        $scope.clickAddCategory = function() {
            $scope.Home.DanhMucHome.push(
                    {
                        Display: "0",
                        Pages: ""
                    }
            );
        }
        $scope.clickAddItem = function(items, item) {
            items.push(item);
        }
        $scope.clickRemoveItem = function(items, item) {
            items.splice(item, 1);
        }
    }

    $scope.clickAdddisplayPosition = function() {
        $scope.Home.displayPosition.push(
                {
                    DanhMuc: "29",
                    Mau: "mau3"
                }
        );
    }



}