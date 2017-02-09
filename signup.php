<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">

  <title>Great Funds - Signup</title>

  <!-- Stylesheets -->
  <link rel="stylesheet" href="css/style.css">
  <link rel="stylesheet" href="css/set1.css">
  <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" type="text/css" href="css/cs-select.css" />
  <link rel="stylesheet" type="text/css" href="css/cs-skin-elastic.css" />

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
              <a class="navbar-brand page-scroll" href="index.php">Great Funds</a>
          </div>

          <!-- Collect the nav links, forms, and other content for toggling -->
          <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
              <ul class="nav navbar-nav navbar-right">
                  <li>
                      <a class="page-scroll" href="">Join Our Community!</a>
                  </li>
              </ul>
          </div>
          <!-- /.navbar-collapse -->
      </div>
      <!-- /.container-fluid -->
  </nav>
  <header class="header">
    <h3>Create Account, Make Profits.</h3>
  </header>
<div id="main-wrapper">
  <div class="container-fluid">
    <div class="row">
      <form class="" action="index.php" method="post" name="signform" onsubmit="return signup()" novalidate>
        <div class="col-md-6 left-side">
          <span class="input input--hoshi">
            <input class="input__field input__field--hoshi" type="text" id="username" name="username" required/>
            <label class="input__label input__label--hoshi input__label--hoshi-color-3" for="username">
              <span class="input__label-content input__label-content--hoshi">UserName</span>
            </label>
          </span>
          <span class="input input--hoshi">
            <input class="input__field input__field--hoshi" type="email" name="email" id="email" required/>
            <label class="input__label input__label--hoshi input__label--hoshi-color-3" for="email">
              <span class="input__label-content input__label-content--hoshi">E-mail</span>
            </label>
          </span>
          <span class="input input--hoshi">
            <input class="input__field input__field--hoshi" type="text" name="pnumber" id="pnumber" required/>
            <label class="input__label input__label--hoshi input__label--hoshi-color-3" for="pnumber">
              <span class="input__label-content input__label-content--hoshi">Phone Number</span>
            </label>
          </span>
          <select class="cs-select cs-skin-elastic" id="bank" name="bank">
  					<option value="" disabled selected>Please! select your bank</option>
  					<option value="Diamond Bank">Diamond Bank</option>
  					<option value="First Bank">First Bank</option>
  					<option value="Sky Bank">Sky Bank</option>
  					<option value="Eco Bank">Eco Bank</option>
            <option value="Keystone Bank">Keystone Bank</option>
  					<option value="Guaranty Trust Bank">Guaranty Trust Bank</option>
            <option value="Wema Bank">Wema Bank</option>
  					<option value="UBA Bank">UBA Bank</option>
  				</select>
        </div>
        <div class="col-md-6 right-side">
          <span class="input input--hoshi">
            <input class="input__field input__field--hoshi" type="text" name="accnumber" id="accnumber" required/>
            <label class="input__label input__label--hoshi input__label--hoshi-color-3" for="accnumber">
              <span class="input__label-content input__label-content--hoshi">Account Number</span>
            </label>
          </span>
          <span class="input input--hoshi">
            <input class="input__field input__field--hoshi" type="text" name="accname" id="accname" required/>
            <label class="input__label input__label--hoshi input__label--hoshi-color-3" for="accname">
              <span class="input__label-content input__label-content--hoshi">Account Name</span>
            </label>
          </span>
          <span class="input input--hoshi">
            <input class="input__field input__field--hoshi" type="password" name="password" id="password" required/>
            <label class="input__label input__label--hoshi input__label--hoshi-color-3" for="password">
              <span class="input__label-content input__label-content--hoshi">Password</span>
            </label>
          </span>
          <span class="input input--hoshi">
            <input class="input__field input__field--hoshi" type="password" name="rpassword" id="rpassword" required/>
            <label class="input__label input__label--hoshi input__label--hoshi-color-3" for="rpassword">
              <span class="input__label-content input__label-content--hoshi">Repeat Password</span>
            </label>
          </span>
          <div class="cta">
            <button class="btn btn-primary pull-left">
              Sign-Up Now
            </button>
            <span><a href="./login.php">I am already a member</a></span>
          </div>
        </div>
      </form>
    </div>
  </div>

</div> <!-- end #main-wrapper -->

<!-- Scripts -->
<script src="//ajax.googleapis.com/ajax/libs/jquery/2.1.1/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="js/scripts.js"></script>
<script src="js/classie.js"></script>
<script src="js/validate.js"></script>
<script src="js/selectFx.js"></script>
<script>
  (function() {
    [].slice.call( document.querySelectorAll( 'select.cs-select' ) ).forEach( function(el) {
      new SelectFx(el);
    } );
  })();
</script>
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