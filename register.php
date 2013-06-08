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

mysql_select_db($database_KaosKece, $KaosKece);
$query_fakultas = "SELECT * FROM fakultas";
$fakultas = mysql_query($query_fakultas, $KaosKece) or die(mysql_error());
$row_fakultas = mysql_fetch_assoc($fakultas);
$totalRows_fakultas = mysql_num_rows($fakultas);

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "register")) {
  $insertSQL = sprintf("INSERT INTO `admin` (nama, email, fakultas, userName, password) VALUES (%s, %s, %s, %s, %s)",
  						GetSQLValueString($_POST['nama'], "text"),
                       GetSQLValueString($_POST['email'], "text"),
                       GetSQLValueString($_POST['fakultas'], "text"),
					   GetSQLValueString($_POST['username'], "text"),
                       GetSQLValueString($_POST['password'], "text"));

  mysql_select_db($database_KaosKece, $KaosKece);
  $Result1 = mysql_query($insertSQL, $KaosKece) or die(mysql_error());

  $insertGoTo = "signin_baru.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));

}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Register . KaosKece</title>
    

    <!-- Le styles -->
<link rel="stylesheet" type="text/css" href="css/bootstrap-responsive.css">
<link rel="stylesheet" type="text/css" href="css/bootstrap.css">
<link rel="stylesheet" type="text/css" href="css/bootstrap.min.css">
<link rel="stylesheet" type="text/css" href="css/docs.css">
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
                                   <link href="SpryAssets/SpryValidationConfirm.css" rel="stylesheet" type="text/css">
  <script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
  <script src="SpryAssets/SpryValidationPassword.js" type="text/javascript"></script>
  <script src="SpryAssets/SpryValidationConfirm.js" type="text/javascript"></script>
  </head>

<div class="navbar navbar-toolbar">
  <div class="navbar-inner navbar-fixed-top">
    <a class="brand" href="http://localhost/kece_experiment">KaosKece</a>
    <ul class="nav">
      <li class="active"><a href="#">Daftar</a></li>
      <li><a href="#">Trending</a></li>
      <li><a href="#">Terbaru</a></li>
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

      <form method="POST" action="<?php echo $editFormAction; ?>" class="form-signin" name="register">
        <h2 class="form-signin-heading"><center><img src="views/img/kaoskece.png" width="182" height="160" alt="KaosKece"></center></h2>
        <input type="text" name="nama" class="input-block-level" id="email2" placeholder="nama">
        <input type="text" name="email" class="input-block-level" id="email" placeholder="Email">
        <div class="controls">
    
    <select id="fakultas" name="fakultas" class="input-block-level">
      <?php
do {  
?>
      <option value="<?php echo $row_fakultas['fakultas']?>"><?php echo $row_fakultas['fakultas']?></option>
      <?php
} while ($row_fakultas = mysql_fetch_assoc($fakultas));
  $rows = mysql_num_rows($fakultas);
  if($rows > 0) {
      mysql_data_seek($fakultas, 0);
	  $row_fakultas = mysql_fetch_assoc($fakultas);
  }
?>
    </select>
  </div><span id="sprytextfield2">
        <span class="textfieldRequiredMsg">Email harus diisi</span></span> 
        <span id="sprytextfield1">
        <input type="text" name="username" class="input-block-level" placeholder="Username">
        <span class="textfieldRequiredMsg">Username Harus diisi</span></span>
        <span id="sprypassword1">
        <input type="password" name="password" id="password" class="input-block-level" placeholder="Password">
        <span class="passwordRequiredMsg">Password Harus diisi.</span></span>
        <span id="spryconfirm1">
        <label>
          <input type="password" name="password2" id="password2" class="input-block-level" placeholder="Konfirmasi Password">
        </label>
        <span class="confirmRequiredMsg">Konfirmasi harus diisi.</span><span class="confirmInvalidMsg">Konfirmasi password tidak cocok.</span></span>
        <button class="btn btn-large btn-success" type="submit">Daftar</button>  
        <input type="hidden" name="MM_insert" value="register">
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
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2");
var spryconfirm1 = new Spry.Widget.ValidationConfirm("spryconfirm1", "password");
  </script>
  </body>
</html>
<?php
mysql_free_result($fakultas);
?>
