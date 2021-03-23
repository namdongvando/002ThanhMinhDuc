app.controller("SanphamController", function($scope, $http) {
    $scope.optionInnit = function( ) {
        $http.get("/option/api/options/").then(function(res) {
        });
    }
});