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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form1")) {
  $insertSQL = sprintf("INSERT INTO testimoni (owner, nama_baju, status, komentator, komentar) VALUES (%s, %s, %s, %s, %s)",
                       GetSQLValueString($_POST['owner'], "text"),
                       GetSQLValueString($_POST['nama_baju'], "text"),
                       GetSQLValueString($_POST['status'], "text"),
                       GetSQLValueString($_POST['komentator'], "text"),
                       GetSQLValueString($_POST['komentar'], "text"));

  mysql_select_db($database_KaosKece, $KaosKece);
  $Result1 = mysql_query($insertSQL, $KaosKece) or die(mysql_error());

  $insertGoTo = "daftarbelanja.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
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
$user = $_SESSION['MM_Username'];
mysql_select_db($database_KaosKece, $KaosKece);
$query_testi = "SELECT * FROM testimoni WHERE `komentator` = '".$user."'";
$testi = mysql_query($query_testi, $KaosKece) or die(mysql_error());
$row_testi = mysql_fetch_assoc($testi);
$totalRows_testi = mysql_num_rows($testi);
 

?>

<?php 
$pageTitle = "Isi Testimonial";
$section = "contact";
include('inc/header.php'); ?>

<link href="css/bootstrap-responsive.min.css" rel="stylesheet">
<link href="css/bootstrap.css" rel="stylesheet">
    <div class="section page">

        <div class="wrapper">
          <center><h4>Daftar Testimonial yang sudah kamu buat: </h4></center>
        <div class="alert alert-info">
          <table width="100%" border="0" cellpadding="5" class="table table-striped">
            <tr>
              <td><strong>Id Testi</strong></td>
              <td><strong>Owner Baju</strong></td>
              <td><strong>Nama Baju</strong></td>
              <td><strong>Status</strong></td>
              
              <td><strong>Testi</strong></td>
              <td>&nbsp;</td>
            </tr>
            <?php do { ?>
              <tr>
                <td><?php echo $row_testi['id_testi']; ?></td>
                <td><?php echo $row_testi['owner']; ?></td>
                <td><a href="shirt.php?id=<?php echo $row_produk['id']; ?>"> <?php echo $row_testi['nama_baju']; ?></a></td>
                <td><?php echo $row_testi['status']; ?></td>
                <td><?php echo $row_testi['komentar']; ?></td>
                <td><a class="btn btn-danger" href="testi_edit.php?id=<?php echo $row_testi['id_testi']; ?>">Edit</a></td>
              </tr>
              <?php } while ($row_testi = mysql_fetch_assoc($testi)); ?>
          </table>
<p>&nbsp;</p>
        </div>
      </div>

    </div>

    <?php include('inc/footer.php');

mysql_free_result($produk);

mysql_free_result($testi);
?>
