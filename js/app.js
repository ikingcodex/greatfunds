var app = angular.module('greatfunds', []);
app.controller('profilectrl', function($scope,$http,$interval,$window) {
  $scope.prohelp = [];
  $scope.paired_user = {};
  $scope.field = false;
  show();
  function show() {
    $http({
        method: 'GET',
        url: './api/gethelp.php?view=user'
    }).then(function successCallback(response) {
      console.log("check");
      console.log(response.data.paired_user)
      $scope.paired_user = response.data.paired_user;
      if ($scope.paired_user != {} && $scope.paired_user != "") {
         $http({
             method: 'GET',
             url: './api/gethelp.php?view='+$scope.paired_user,
         }).then(function successCallback(response){
           console.log("check 2");
           console.log($scope.paired_user);
           $scope.prohelp = response.data.user;
           $scope.field = true;
           var demo = document.getElementById('demo');
           if (demo != null && demo != "") {
             demo.innerHTML = $scope.paired_user+" has been paired with you";
             $interval.cancel(check);
           }
         });
      }
      else{
        $interval(check , 20000);
        console.log("no data");
      }
    });
  }
function check(){
  $http({
        method: 'GET',
        url: './api/gethelp.php?view=check',
    }).then(function successCallback(response){
        console.log("Check function");
        $scope.paired_user = response.data;
        if ($scope.paired_user != {} && $scope.paired_user != "") {
          show();
        }
    });
  }
});
