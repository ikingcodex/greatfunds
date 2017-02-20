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
         });
      }
      else{
        $interval(check , 10000);
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
  // console.log($scope.prohelp);
  // $scope.show = function(){
  //   $scope.prohelp = [
  //     {name:"daniel33",number:"8593483948",account_name:"daniel amos doe",bank_name:"diamond bank",phone_number:"08133995749"}
  //   ];
  //   $scope.field = true;
  //   document.getElementById('demo').innerHTML = $scope.prohelp[0].name+" has been paired with you";
  // }
  // if($scope.prohelp == null || $scope.prohelp == "" || $scope.prohelp == []){
  //   $timeout($scope.show , 5000);
  // }
  // $scope.test = function(){
  //   $http({
  //         method : "POST",
  //         url : "../profile.php"
  //     }).then(function mySucces(response) {
  //         $scope.res = response.data;
  //     }, function myError(response) {
  //         $scope.err = response.statusText;
  //     });
  // }
  // $http({
  //       method : "GET",
  //       url : "./api/gethelp.php"
  //   }).then(function mySucces(response) {
  //       $scope.myWelcome = response.data;
  //   }, function myError(response) {
  //       $scope.myWelcome = response.statusText;
  //   });
});
