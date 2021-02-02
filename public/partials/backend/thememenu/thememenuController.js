app.controller("thememenuController", thememenuController);
function thememenuController($scope, $rootScope, $http, $routeParams) {
    $scope._curentTheme = "";
//    $scope._LinkPages = [];
    $scope._curentMenu = "";

    $scope.thememenuInit = function(idTheme, idMenu) {
//        console.log(idTheme);
        $http.get("/mtheme/getMenuByTheme/" + idTheme).then(function(res) {
            $scope._MenusByThemeId = res.data;
//            console.log($scope._MenusByThemeId);
        });
        $http.get("/mtheme/getMenuByThemeAndGroup/" + idTheme + "/" + idMenu).then(function(res) {
            $scope._MenuByThemeAndGroup = res.data;
//            console.log($scope._MenusByThemeId);
        })
    };
    $scope.selectMenuByGroup = function(idTheme, Groups) {
        $scope._curentMenu = Groups;
        $scope._curentTheme = idTheme;

        $http.get("/mtheme/getMenuByThemeAndGroup/" + idTheme + "/" + Groups).then(function(res) {
            $scope._MenuByThemeAndGroup = res.data;
//            console.log($scope._MenusByThemeId);
        })
    }

    $scope.RemoveItemMenu = function(id, IDMenu) {
        $http.get("/mtheme/deletemenu/" + IDMenu).then(function(res) {});
        $scope._MenuByThemeAndGroup.splice(id, 1);
    }
    $scope.AddItemMenu = function(idTheme, Groups) {
        $http.get("/mtheme/createMenu4ThemeGroups/" + idTheme + "/" + Groups).then(function(res) {
            $scope._MenuByThemeAndGroup.push(res.data);
        })
    }

    $http.get("/api/getPagesLink/").then(function(res) {
        $scope._LinkPages = res.data;
        console.log($scope._LinkPages);
    });
    $http.get("/api/getCatLink/").then(function(res) {
        $scope._LinkCats = res.data;
    });

}