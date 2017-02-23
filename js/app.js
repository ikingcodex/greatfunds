var app = angular.module('greatfunds', []);
app.controller('profilectrl', function($scope,$http,$timeout,$interval) {
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
           $scope.interval = $interval(timer ,1000);
           var demo = document.getElementById('demo');
           if (demo != null && demo != "") {
             demo.innerHTML = $scope.paired_user+" has been paired with you";
           }
         });
      }
      else{
          $scope.field = false;
           $timeout(check , 5000);
      }
    });
  }
  function get() {
    $http({
        method: 'GET',
        url: './api/api.php?view=users'
    }).then(function successCallback(response){
      $scope.gethelp = response.data.users;
      $scope.field = true
      if ($scope.gethelp.length < 2) {
          $timeout(get, 5000);
      }
    });
  }


  function check(){
    console.log("check");
    $http({
          method: 'GET',
          url: './api/api.php?view=check',
      }).then(function successCallback(response){
          $scope.paired_user = response.data;
          if ($scope.paired_user != {} && $scope.paired_user != "") {
            show();
          }
      });
    }

  function timer() {
    $http({
          method: 'GET',
          url: './api/api.php?view=timer',
      }).then(function successCallback(response){
          document.getElementById('timer').innerHTML = "Time Left - "+response.data.timer;
          if (response.data.timer == "00:00:00") {
            console.log("done");
            document.getElementById('timer').innerHTML = "TIME-UP!";
            $interval.cancel($scope.interval);
          }
      });
  }

});
