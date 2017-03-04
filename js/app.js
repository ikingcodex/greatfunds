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
      confirm();
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
          $interval.cancel($scope.checkt);
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
           $scope.checkt = $interval(check , 5000);
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
      $timeout(get, 5000);
      var demo = document.getElementById('demo');
      $http({
          method: 'GET',
          url: './api/api.php?view=iscon'
      }).then(function successCallback(response){
        if ($scope.gethelp.length > 0) {
          demo.innerHTML ="";
        }
        if (response.data.iscon == "1" && $scope.gethelp.length == 0) {
          demo.innerHTML ="Please Hold on, while our system is trying to pair you with the last user";
        }else if (response.data.iscon == null) {
          demo.innerHTML ="Please Hold on, while our system is trying to pair you.";
        }
      });
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
          if (response.data.timer == "done") {
            $interval.cancel($scope.interval);
            window.location = "http://localhost/greatfunds/"
          }
          else if (response.data.timer == "Timer Stopped") {
            document.getElementById('timer').innerHTML = "Hold on while your being confirmed by "+$scope.paired_user;
            $interval.cancel($scope.interval);
          }
      });
  }

  function confirm() {
    $http({
          method: 'GET',
          url: './api/api.php?view=confirm',
      }).then(function successCallback(response){
          if (response.data.confirmation == "true") {
            window.location = "http://localhost/greatfunds/"
          }
          else {
            $timeout(confirm, 5000);
          }
      });
  }


});

var modal = document.getElementById('myModal');

// Get the image and insert it inside the modal - use its "alt" text as a caption
var img = document.getElementsByClassName('myImg');
var modalImg = document.getElementById("img01");
function clicki(app){
    modal.style.display = "block";
    modalImg.src = "uploads/"+app.attributes[2].value;
  console.log(app.attributes[2].value);
}
// Get the <span> element that closes the modal
var span = document.getElementsByClassName("close")[0];

// When the user clicks on <span> (x), close the modal
span.onclick = function() {
  modal.style.display = "none";
}
window.onclick = function(event) {
  if (event.target == modal) {
      modal.style.display = "none";
  }
}
