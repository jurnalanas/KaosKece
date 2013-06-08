<?php require_once('../Connections/KaosKece.php'); ?>
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

$colname_produk = "-1";
if (isset($_GET['id'])) {
  $colname_produk = $_GET['id'];
}
mysql_select_db($database_KaosKece, $KaosKece);
$query_produk = sprintf("SELECT * FROM produk WHERE id = %s", GetSQLValueString($colname_produk, "int"));
$produk = mysql_query($query_produk, $KaosKece) or die(mysql_error());
$row_produk = mysql_fetch_assoc($produk);
$totalRows_produk = mysql_num_rows($produk);

mysql_select_db($database_KaosKece, $KaosKece);
$query_status = "SELECT * FROM status";
$status = mysql_query($query_status, $KaosKece) or die(mysql_error());
$row_status = mysql_fetch_assoc($status);
$totalRows_status = mysql_num_rows($status);

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}



if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {

  $insertSQL = sprintf("INSERT INTO testimoni (id_baju, owner, nama_baju, status, komentator, komentar) VALUES (%s, %s, %s, %s, %s, %s)",
  GetSQLValueString($row_produk['id'], "number"),
                       GetSQLValueString($row_produk['uploader'], "text"),
                       GetSQLValueString($row_produk['name'], "text"),
                       GetSQLValueString($_POST['status'], "text"),
                       GetSQLValueString($_SESSION['MM_Username'], "text"),
                       GetSQLValueString($_POST['komentar'], "text"));

  mysql_select_db($database_KaosKece, $KaosKece);
  $Result1 = mysql_query($insertSQL, $KaosKece) or die(mysql_error());

  $insertGoTo = "shirt.php?id=" . $row_produk['id'] . "";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}


 

?>
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/bootstrap-responsive.min.css" rel="stylesheet">
<link href="../jquery-ui-1.7.2/css/base/ui.core.css" rel="stylesheet" type="text/css" />
<link href="../jquery-ui-1.7.2/css/base/ui.dialog.css" rel="stylesheet" type="text/css" />
<link href="../jquery-ui-1.7.2/css/base/ui.theme.css" rel="stylesheet" type="text/css" />
<link href="../jquery-ui-1.7.2/css/base/ui.images.css" rel="stylesheet" type="text/css" />
<?php 
$pageTitle = "Isi Testimonial";
$section = "contact";
include('inc/header.php'); ?>

    <div class="section page">

        <div class="wrapper">

            
           <form class="form-horizontal" action="<?php echo $editFormAction; ?>" method="POST" name="form1" id="form1">
<fieldset>

<!-- Form Name -->
<legend>Isi Testimonial</legend>

<!-- Text input-->
<div class="control-group">
  <label class="control-label">Owner</label>
  <div class="controls">
    <input id="disabledInput" name="owner" type="text" value="<?php echo $row_produk['uploader']; ?>" placeholder="" class="input-xlarge" disabled>
    
  </div>
</div>

<!-- Text input-->
<div class="control-group">
  <label class="control-label">Nama Baju</label>
  <div class="controls">
    <input id="disabledInput" name="nama_baju" type="text" value="<?php echo $row_produk['name']; ?>" class="input-xlarge" disabled>
    
  </div>
</div>

<!-- Select Basic -->
<div class="control-group">
  <label class="control-label">Status</label>
  <div class="controls">
    <select id="status" name="status" class="input-xlarge">
      <?php
do {  
?>
      <option value="<?php echo $row_status['status']?>"><?php echo $row_status['status']?></option>
      <?php
} while ($row_status = mysql_fetch_assoc($status));
  $rows = mysql_num_rows($status);
  if($rows > 0) {
      mysql_data_seek($status, 0);
	  $row_status = mysql_fetch_assoc($status);
  }
?>
    </select>
  </div>
</div>

<!-- Text input-->
<div class="control-group">
  <label class="control-label">Komentator</label>
  <div class="controls">
    <input id="disabledInput" name="komentator" value="<?php echo $_SESSION['MM_Username']; ?>" type="text" class="input-xlarge" disabled>
    
  </div>
</div>

<!-- Textarea -->
<div class="control-group">
  <label class="control-label">Komentar</label>
  <div class="controls">                     
    <textarea id="komentar" name="komentar">default text</textarea>
  </div>
</div>

<!-- Button -->
<div class="control-group">
  <label class="control-label"></label>
  <div class="controls">
    <button id="submit"  type="submit" name="submit" class="btn btn-primary">Submit</button>
  </div>
</div>

</fieldset>
<input type="hidden" name="MM_insert" value="form1" />
          </form>

            <p>&nbsp;</p>
        </div>

    </div>

    <?php include('inc/footer.php');

mysql_free_result($produk);

mysql_free_result($status);
?>
