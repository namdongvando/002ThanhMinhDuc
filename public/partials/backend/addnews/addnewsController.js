
app.controller("addnewsController", addnewsController);
function addnewsController($scope, $rootScope, $http, $routeParams) {

//    $http.get("/mnews/getPages").then(function(res) {
//        $scope.PagesByType = res.data;
//    });
    $http.get("/mnews/getPagesAjax/").then(function(res) {
        $scope.PagesByType = res.data;
    });
    $scope.addnewsInit = function(idPa) {

        $scope._New = {PageID: idPa}
    }

    $scope.serializeData = function(data) {
        // If this is not an object, defer to native stringification.
        var buffer = [];
        // Serialize each key in the object.
        for (var name in data) {
            var value = data[ name ];
            buffer.push(
                    encodeURIComponent(name) +
                    "=" +
                    encodeURIComponent((value == null) ? "" : value)
                    );

        }
        // Serialize the buffer and clean it up for transportation.
        var source = buffer
                .join("&")
                .replace(/%20/g, "+");
        return(source);
    }

    $scope.OncheckTieuDe = function(res) {
        $scope.lableCheckTieuDe = res;
//            console.log($scope.lableCheckTieuDe);
        if ($scope.lableCheckTieuDe == 0) {
//                console.log("ok");
            $("#TaoBaiVietId").show();
        } else {
//                console.log("nook");
            $("#TaoBaiVietId").hide();
        }
    }

    $scope.checkTieuDe = function(tieude) {
        if (typeof (tieude) === 'undefined') {
            $scope.OncheckTieuDe(1);
            return;
        }
        if (tieude.length <= 3) {
            $scope.OncheckTieuDe(1);
            return;
        }
        var postData = {};
        postData["TieuDe"] = tieude;
        postData = $scope.serializeData(postData);
        $http.post("/mnews/checknews/", postData, {"headers": {"Content-Type": "application/x-www-form-urlencoded; charset=utf-8"}}).then(function(res) {
            $scope.OncheckTieuDe(res.data);

        });
    }

    $scope.OncheckTieuDe(0);

}