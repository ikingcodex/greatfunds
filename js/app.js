var app = angular.module('greatfunds', []);
app.controller('profilectrl', function($scope) {
  // $scope.prohelp = [];
  $scope.prohelp = [
    {name:"daniel33",number:"8593483948",account_name:"daniel amos doe",bank_name:"diamond bank",phone_number:"08133995749"}
  ];
  if($scope.prohelp == "" || $scope.prohelp == null){
    return $scope.data = false;
  }
  else{
    return $scope.data = true;
  }
});
