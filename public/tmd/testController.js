app.controller("testController",function($scope,$http){
    $scope.hoTen = "Test";
    $http.get("/api/testapi").then((res)=>{
        // console.log(res.data);
        $scope.infor = res.data;
    });
});