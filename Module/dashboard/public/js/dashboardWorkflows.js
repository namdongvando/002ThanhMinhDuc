app.config(function($routeProvider) {
    $routeProvider
            .when("/", {
                templateUrl: "/dashboard/workflow/index/"
                , controller: "DashboadController"
            })
            .when("/detail/:id", {
                templateUrl: "/Eventwf/detail"
                , controller: "EventWFController"
            });
});
app.directive("subMenu", function() {
    return {
        restrict: 'AEC',
        templateUrl: "/dashboard/wodkflow/menu",

    };
});

app.controller("DashboadController", DashboadController);
function DashboadController($scope, $rootScope, $http, $routeParams) {

}
