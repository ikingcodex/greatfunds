<?php
require_once '../class.db.php';

if($admin->is_loggedin())
{
 $admin->redirect('index.php');
}

if(isset($_POST['btn-login']))
{
 $username = htmlspecialchars(strip_tags(trim($_POST['username'])));
 $password = htmlspecialchars(strip_tags(trim($_POST['password'])));
 if($admin->login($username,$password))
 {
  $admin->redirect('index.php');
 }
 else
 {
  $error = "Wrong Details !";
 }
}
?>

<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <title>OpenPay - Login</title>

  <!-- Stylesheets -->
  <link rel="stylesheet" href="../css/style.css">
  <link rel="stylesheet" href="../css/set1.css">
  <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

  <!--Google Fonts-->
  <link href='https://fonts.googleapis.com/css?family=Playfair+Display' rel='stylesheet' type='text/css'>
  <link href='https://fonts.googleapis.com/css?family=Lato:400,700' rel='stylesheet' type='text/css'>

</head>

<body>
  <nav id="mainNav" class="navbar navbar-default navbar-fixed-top">
      <div class="container">
          <!-- Brand and toggle get grouped for better mobile display -->
          <div class="navbar-header">
              <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                  <span class="sr-only">Toggle navigation</span> Menu <i class="fa fa-bars"></i>
              </button>
              <a class="navbar-brand page-scroll" href="../index.php">OpenPay</a>
          </div>

          <!-- /.navbar-collapse -->
      </div>
      <!-- /.container-fluid -->
  </nav>
  <header class="header" style="line-height: 65px">
    <span>continue to</span>
    <h3>Admin Login.</h3>
  </header>
<div id="main-wrapper">
  <div class="container-fluid">
    <div class="row">
      <form class="" action="login.php" method="post" name="logform" onsubmit="return login()">
        <div class="col-md-6 right-side" style="float: none;margin: auto">
          <span class="input input--hoshi">
            <input class="input__field input__field--hoshi" type="text" id="username" name="username" required/>
            <label class="input__label input__label--hoshi input__label--hoshi-color-3" for="username">
              <span class="input__label-content input__label-content--hoshi">UserName</span>
            </label>
          </span>
          <span class="input input--hoshi">
            <input class="input__field input__field--hoshi" type="password" id="password" name="password" required/>
            <label class="input__label input__label--hoshi input__label--hoshi-color-3" for="password">
              <span class="input__label-content input__label-content--hoshi">password</span>
            </label>
          </span>
          <div class="cta" style="padding-left: 10px">
            <button type="submit" name="btn-login" class="btn btn-primary pull-left">
              Login Now
            </button>
          </div>
        </div>
      </form>
    </div>
  </div>

</div> <!-- end #main-wrapper -->

<!-- Scripts -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="../vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="../js/scripts.js"></script>
<script src="../js/classie.js"></script>
<script src="../js/validate.js"></script>
<script>
  (function() {
    // trim polyfill : https://developer.mozilla.org/en-US/docs/Web/JavaScript/Reference/Global_Objects/String/Trim
    if (!String.prototype.trim) {
      (function() {
        // Make sure we trim BOM and NBSP
        var rtrim = /^[\s\uFEFF\xA0]+|[\s\uFEFF\xA0]+$/g;
        String.prototype.trim = function() {
          return this.replace(rtrim, '');
        };
      })();
    }

    [].slice.call( document.querySelectorAll( 'input.input__field' ) ).forEach( function( inputEl ) {
      // in case the input is already filled..
      if( inputEl.value.trim() !== '' ) {
        classie.add( inputEl.parentNode, 'input--filled' );
      }

      // events:
      inputEl.addEventListener( 'focus', onInputFocus );
      inputEl.addEventListener( 'blur', onInputBlur );
    } );

    function onInputFocus( ev ) {
      classie.add( ev.target.parentNode, 'input--filled' );
    }

    function onInputBlur( ev ) {
      if( ev.target.value.trim() === '' ) {
        classie.remove( ev.target.parentNode, 'input--filled' );
      }
    }
  })();
</script>

</body>
</html>
