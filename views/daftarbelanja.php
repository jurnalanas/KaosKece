<?php 
ob_start();
require_once('../Connections/KaosKece.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";

// *** Akses terlarang, harus login dulu: Ijinkan atau tolak akses ke halaman ini
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // Untuk keamanan, asumsikan bahwa visitor GAK dikenal 
  $isValid = False; 

  // Saat visitor udah login ke situs ini, variabel Session MM_Username nge-set sama dengan usernamenya.. 
  // Jadinya, kita tahu kalau user GAK login jika variabel Session blank. 
  if (!empty($UserName)) { 
    // Selain bisa login, lu boleh ngakses ke ganya beberapa user berdasarkan ID saat mereka login.
    // Parse string ke arrays.
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Atau, lu bisa ngebuat restrict access hanya ke beberapa user berdasarkan username.
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && true) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "../signin.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0) 
  $MM_referrer .= "?" . $_SERVER['QUERY_STRING'];
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?>
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
$query_daftarbelanja = "SELECT * FROM daftartagihan";
$daftarbelanja = mysql_query($query_daftarbelanja, $KaosKece) or die(mysql_error());
$row_daftarbelanja = mysql_fetch_assoc($daftarbelanja);
$totalRows_daftarbelanja = mysql_num_rows($daftarbelanja);
?>

<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/bootstrap-responsive.min.css" rel="stylesheet">
<link href="../jquery-ui-1.7.2/css/base/ui.core.css" rel="stylesheet" type="text/css" />
<link href="../jquery-ui-1.7.2/css/base/ui.dialog.css" rel="stylesheet" type="text/css" />
<link href="../jquery-ui-1.7.2/css/base/ui.theme.css" rel="stylesheet" type="text/css" />
<link href="../jquery-ui-1.7.2/css/base/ui.images.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/jquery.js"></script>
<script type="text/javascript" src="js/bootbox.min.js"></script>
<script src="../jquery-ui-1.7.2/js/jquery-1.3.2.min.js" type="text/javascript"></script>
<script src="../jquery-ui-1.7.2/js/jquery-ui-1.7.2.min.js" type="text/javascript"></script>
    
<?php
$pageTitle = "Jual Kaos Baru";
$section = "jual";
$nomor = 0; $total=0;
include('inc/header.php');
include('connect.php'); ?>
<?php
$user=$_SESSION['MM_Username'];
$result = $mysqli->query("SELECT * FROM daftartagihan WHERE `username` = '".$user."'");

if ($result) : ?>
<html>
<style type="text/css">
/* BeginOAWidget_Instance_2142022: #dialog */

		#dialog .ui-widget {
			font-family: inherit;
		}
		
		.ui-state-default a, .ui-state-default a:link, .ui-state-default a:visited {
			color: #ffffff;
		}
		
		.ui-widget-header {
			font-size:1em;
			font-weight: bold;
			font-family: "Lucida Sans Unicode", "Lucida Grande", sans-serif;
			background: #5c9ccc;
			border-color: #666666;
			border-width: 1px;
		}
			
		.ui-dialog-title {
			line-height: 1em;
			color: #ffffff;
			font-weight: bold;
		}
		
		.ui-widget-content {
			font-size:1em;
			font-weight: bold;
			font-family: "Lucida Sans Unicode", "Lucida Grande", sans-serif;
			background: #fcfdfd;
			border-color: #dddddd;
			border-width: 1px;
		}
		
		/* tab panel bounding box */ 
		.ui-dialog-content {
			font-family: "Lucida Sans Unicode", "Lucida Grande", sans-serif;
			color: #222222;
			font-size:.8em;
			padding: 10px;
		} 
		
		.ui-dialog-buttonpane {
			font-size:.8em;
		}
		
		
/* EndOAWidget_Instance_2142022 */
</style>

<div class="section page">
<div class="wrapper">

 <center>
  <h4>Terimakasih sudah memesan! Berikut Kantong Belanja anda: </h4> 
     <!-- <p>Content here. <a class="alert" href=#>Alert!</a></p> -->

  <div class="alert alert-info">
    <br>
<table class="table table-striped">
  <tr>
    <th>&nbsp;</th>
    <th> No </th>
    <th> Nama </th>
    <th> Harga </th>
    <th> Ukuran </th>
    <th>  </th>

  </tr>

    <?php while ($row = $result->fetch_object()) : ?>

    <tr>
      <td><img src="<?php echo $row->img; ?>" class="img-polaroid" width="30" height="30" /></td>
      <td><span class="badge badge-success"><?php echo $nomor+=1; ?></span></td>
      <td><a href="http://localhost/kece_experiment/views/shirt.php?id=<?php echo $row->id; ?>"> <?php echo $row->name; ?></a></td>
      <td><strong>Rp <?php echo $row->price; $total+=$row->price; ?>.000,00</strong></td>
      <td><a href="update.php?no_tagihan=<?php echo $row_daftarbelanja['no_tagihan']; ?>"><?php echo $row->size; ?></a></td>
      <td><a class="btn btn-danger"  href="receipt.php?no_tagihan=<?php echo $row_daftarbelanja['no_tagihan']; ?>">Hapus</a>
      </td>

    </tr>

    <?php endwhile; ?>
  
</table>

</center>
<strong>Anda sudah memesan <?php echo $nomor ?> buah item, dengan Total Tagihan: </strong>
<br />
<br />
<div class="alert alert-error">
<table width="100%" border="0">
  <tr>
    <td width="74%"><h4><strong>Rp <?php echo $total ?>.000,00</strong></h4></td>
    <td width="26%"><button class="btn btn-success">Konfirmasi Pembayaran</button></td>
  </tr>
</table>
</div>
</div>
</div>
</div>


<?php endif; ?>

<?php include("inc/footer.php"); ?>
<?php 
mysql_free_result($daftarbelanja);
?>
</html>