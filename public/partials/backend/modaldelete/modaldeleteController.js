app.controller("modaldeleteController", modaldeleteController);
function modaldeleteController($scope, $rootScope, $http, $routeParams) {
    $scope._modaldelete = null;
    $scope.modaldeleteInit = function (txtName, txtTitle, txtMes, txtLink, txtID) {
        $scope._modaldelete = {
            title: txtTitle
            , link: txtLink
            , id: txtID
            , mes: txtMes
            , name: txtName
        }
    }

    
}