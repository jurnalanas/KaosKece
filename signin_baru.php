<?php require_once('Connections/KaosKece.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}
?>
<?php
// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}

$loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
}

if (isset($_POST['username'])) {
  $loginUsername=$_POST['username'];
  $password=$_POST['password'];
  $MM_fldUserAuthorization = "";
  $MM_redirectLoginSuccess = "views/index.php";
  $MM_redirectLoginFailed = "signin.php";
  $MM_redirecttoReferrer = true;
  mysql_select_db($database_KaosKece, $KaosKece);
  
  $LoginRS__query=sprintf("SELECT userName, password FROM `admin` WHERE userName=%s AND password=%s",
    GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text")); 
   
  $LoginRS = mysql_query($LoginRS__query, $KaosKece) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  if ($loginFoundUser) {
     $loginStrGroup = "";
    
	if (PHP_VERSION >= 5.1) {session_regenerate_id(true);} else {session_regenerate_id();}
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
    $_SESSION['MM_UserGroup'] = $loginStrGroup;	      

    if (isset($_SESSION['PrevUrl']) && true) {
      $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
    }
    header("Location: " . $MM_redirectLoginSuccess );
  }
  else {
    header("Location: ". $MM_redirectLoginFailed );
  }
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Sign in · KaosKece</title>
    

    <!-- Le styles -->
<link rel="stylesheet" type="text/css" href="css/bootstrap-responsive.css">
<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="css/hint.css">
<link rel="stylesheet" type="text/css" href="css/select2.css">
<link rel="stylesheet" type="text/css" href="css/todc-bootstrap.css">
    

    <style type="text/css">
      body {
        padding-top: 40px;
        padding-bottom: 40px;
        background-color: #f5f5f5;
        background-image: url(img/purty_wood.png);
        background-repeat: repeat;
      }

      .form-signin {
        max-width: 300px;
        padding: 19px 29px 29px;
        margin: 0 auto 20px;
        background-color: #fff;
        border: 1px solid #e5e5e5;
        -webkit-border-radius: 5px;
           -moz-border-radius: 5px;
                border-radius: 5px;
        -webkit-box-shadow: 0 1px 2px rgba(0,0,0,.05);
           -moz-box-shadow: 0 1px 2px rgba(0,0,0,.05);
                box-shadow: 0 1px 2px rgba(0,0,0,.05);
      }
      .form-signin .form-signin-heading,
      .form-signin .checkbox {
	margin-bottom: 10px;
	text-align: center;
      }
      .form-signin input[type="text"],
      .form-signin input[type="password"] {
        font-size: 16px;
        height: auto;
        margin-bottom: 15px;
        padding: 7px 9px;
      }

    </style>
    <!--<link href="views/css/bootstrap-responsive.css" rel="stylesheet">
-->
    <!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="views/js/html5shiv.js"></script>
    <![endif]-->

    <!-- Fav and touch icons -->
    <link rel="apple-touch-icon-precomposed" sizes="144x144" href="views/ico/apple-touch-icon-144-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="views/ico/apple-touch-icon-114-precomposed.png">
      <link rel="apple-touch-icon-precomposed" sizes="72x72" href="views/ico/apple-touch-icon-72-precomposed.png">
                    <link rel="apple-touch-icon-precomposed" href="views/ico/apple-touch-icon-57-precomposed.png">
                                   <link rel="shortcut icon" href="views/img/kedce.png">
                                   <link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">
                                   <link href="SpryAssets/SpryValidationPassword.css" rel="stylesheet" type="text/css">
  <script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
  <script src="SpryAssets/SpryValidationPassword.js" type="text/javascript"></script>
  </head>
<div class="navbar navbar-toolbar">
  <div class="navbar-inner navbar-fixed-top">
    <a class="brand" href="http://localhost/kece_experiment">KaosKece</a>
    <ul class="nav">
      <li class="active"><a href="#">Sign In</a></li>
      <li><a href="trending.php">Trending</a></li>
      <li><a href="cari.html">Cari</a></li>
    </ul>
     
    <div class="btn-group pull-right">
        <a href="#" class="btn btn-danger">Admin</a>
    </div>
  </div>
</div>
<br>
<br>
  <body>

    <div class="container">

      <form ACTION="<?php echo $loginFormAction; ?>" METHOD="POST" class="form-signin" name="loginForm">
<!-- <div class="alert">
<button type="button" class="close" data-dismiss="alert">&times;</button>
<strong>Selamat!</strong> Akun kamu berhasil dibuat, silahkan login..
</div> -->
        <h2 class="form-signin-heading"><center><a href="#" class="hint--right  hint--always hint--success  hint--rounded" data-hint="Selamat! Akun kamu berhasil dibuat, silahkan login.."><img src="views/img/kaoskece.png" width="182" height="160" alt="KaosKece"></center></a></h2>
        <h2 class="form-signin-heading">
        
        </h2>
        <span id="sprytextfield1">
        <input type="text" name="username" class="input-block-level" placeholder="Username">
        <span class="textfieldRequiredMsg">Username Harus diisi</span></span>
        <span id="sprypassword1">
        <input type="password" name="password" class="input-block-level" placeholder="Password">
        <span class="passwordRequiredMsg">Password Harus diisi.</span></span>
        
        
        <table width="100%"  border="0">
  <tr>
    <td width="50%"><button class="btn btn-large btn-primary" type="submit">Sign in</button></td>
    <!-- <td width="50%"><a href="register.php"><i class="icon-user"></i>User Baru? Daftar Yok!</a></td> -->
  </tr>
</table>

      </form>

    </div> <!-- /container -->

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
<script src="js/application.js"></script>
<script src="js/bootstrap-affix.js"></script>
<script src="js/bootstrap-alert.js"></script>
<script src="js/bootstrap-button.js"></script>
<script src="js/bootstrap-carousel.js"></script>
<script src="js/bootstrap-collapse.js"></script>
<script src="js/bootstrap-dropdown.js"></script>
<script src="js/bootstrap-modal.js"></script>
<script src="js/bootstrap-popover.js"></script>
<script src="js/bootstrap-scrollspy.js"></script>
<script src="js/bootstrap-tab.js"></script>
<script src="js/bootstrap-tooltip.js"></script>
<script src="js/bootstrap-transition.js"></script>
<script src="js/bootstrap-typeahead.js"></script>
<script src="js/bootstrap.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/html5shiv.js"></script>
<script src="js/jquery.js"></script>
<script src="js/select2.min.js"></script>
  <script type="text/javascript">
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
var sprypassword1 = new Spry.Widget.ValidationPassword("sprypassword1");
$(".alert").alert();
  </script>
  </body>
</html>
