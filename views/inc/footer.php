<?php
//initialize the session
if (!isset($_SESSION)) {
  session_start();
}

// ** Logout the current user. **
$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")){
  $logoutAction .="&". htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){
  //to fully log out a visitor we need to clear the session varialbles
  $_SESSION['MM_Username'] = NULL;
  $_SESSION['MM_UserGroup'] = NULL;
  $_SESSION['PrevUrl'] = NULL;
  unset($_SESSION['MM_Username']);
  unset($_SESSION['MM_UserGroup']);
  unset($_SESSION['PrevUrl']);
	
  $logoutGoTo = "../signin.php";
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
    exit;
  }
}
?>
</div>
<!-- <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css"/>
<link rel="stylesheet" type="text/css" href="css/bootstrap-responsive.css"/>
<link rel="stylesheet" type="text/css" href="css/docs.css"/> -->
<link href="../css/bootstrap.min.css" rel="stylesheet" type="text/css" />

<div class="footer">

<div class="wrapper">

    <!--- <ul>		
        <li><a href="http://twitter.com/">Twitter</a></li>
        <li><a href="https://www.facebook.com/">Facebook</a></li>
    </ul> --->
    <div class="alert alert-error">
    
<table width="100%" border="0">
  <tr>
    <td width="83%">Hey, <strong class="badge badge-warning"><?php echo $_SESSION['MM_Username']; ?></strong>, selamat berbelanja!</td>
    <td width="17%"> <span class="btn btn-inverse"><a href="<?php echo $logoutAction ?>">Log out</a></span></td>
  </tr>
</table>

</div>
<!--			. <p>&copy;<?php echo date('Y'); ?> KaosKece</p>-->
</div>

			

</div>
	
	</div>

<script src="js/jquery.js"></script>
<script src="js/bootstrap-transition.js"></script>
<script src="js/bootstrap-alert.js"></script>
<script src="js/bootstrap-modal.js"></script>
<script src="js/bootstrap-dropdown.js"></script>
<script src="js/bootstrap-scrollspy.js"></script>
<script src="js/bootstrap-tab.js"></script>
<script src="js/bootstrap-tooltip.js"></script>
<script src="js/bootstrap-popover.js"></script>
<script src="js/bootstrap-button.js"></script>
<script src="js/bootstrap-collapse.js"></script>
<script src="js/bootstrap-carousel.js"></script>
<script src="js/bootstrap-typeahead.js"></script>
<script src="js/bootstrap-affix.js"></script>

<script src="js/holder/holder.js"></script>
<script src="js/google-code-prettify/prettify.js"></script>

<script src="js/application.js"></script>
</body>
</html>