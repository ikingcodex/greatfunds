var app = angular.module('greatfunds', []);
app.controller('profilectrl', function($scope,$http,$interval,$window) {
  $scope.prohelp = [];
  $scope.gethelp = [];
  $scope.paired_user = {};
  $scope.field = false;
  var ph = document.getElementById('ph-table');
  var gh = document.getElementById('gh-table');
  if (ph != null && ph != ""){
      show();
  }
  if (gh != null && gh != ""){
      get();
  }
  function show() {
    $http({
        method: 'GET',
        url: './api/api.php?view=user'
    }).then(function successCallback(response) {

      $scope.paired_user = response.data.paired_user;
      if ($scope.paired_user != {} && $scope.paired_user != "") {
         $http({
             method: 'GET',
             url: './api/api.php?view='+$scope.paired_user
         }).then(function successCallback(response){

           $scope.prohelp = response.data.paired_user_info;
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

      }
    });
  }
  function get() {
    $http({
        method: 'GET',
        url: './api/api.php?view=users'
    }).then(function successCallback(response){
      $scope.gethelp = response.data.users;
    });
  }


  function check(){
    $http({
          method: 'GET',
          url: './api/api.php?view=check',
      }).then(function successCallback(response){
          console.log("Check function");
          $scope.paired_user = response.data;
          if ($scope.paired_user != {} && $scope.paired_user != "") {
            show();
          }
      });
    }
});
