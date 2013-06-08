<?php require_once('Connections/KaosKece.php'); ?>
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

$user = $_SESSION['MM_Username'];

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "produk")) {
  $insertSQL = sprintf("INSERT INTO produk (`uploader`, name, img, price) VALUES (%s, %s, %s, %s)",
 					   GetSQLValueString($user, "text"),
                       GetSQLValueString($_POST['name'], "text"),
                       GetSQLValueString($_POST['url'], "text"),
                       GetSQLValueString($_POST['price'], "int"));

  mysql_select_db($database_KaosKece, $KaosKece);
  $Result1 = mysql_query($insertSQL, $KaosKece) or die(mysql_error());

  $insertGoTo = "shirt.php?id=105";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}

$colname_user = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_user = $_SESSION['MM_Username'];
}
mysql_select_db($database_KaosKece, $KaosKece);
$query_user = sprintf("SELECT * FROM `admin` WHERE userName = %s", GetSQLValueString($colname_user, "text"));
$user = mysql_query($query_user, $KaosKece) or die(mysql_error());
$row_user = mysql_fetch_assoc($user);
$totalRows_user = mysql_num_rows($user);


 
$pageTitle = "Jual Kaos Baru";
$section = "contact";
include('inc/header.php'); ?>




<div class="section page">

        <div class="wrapper">

            <h1>Jual Kaos</h1>



          <p>Mau jual kaos kamu sendiri? isi form ini dengan lengkap ya</p>
<center>
              <form action="<?php echo $editFormAction; ?>" method="POST" name="produk">

                  <table>
                      <tr>
                          <th>
                              <label for="name">Nama Kaos</label>
                          </th>
                          <td>
                              <input type="text" name="name" id="name" value="kaos aja">
                          </td>
                      </tr>
                      <tr>
                          <th>
                              <label for="url">Url Gambar</label>
                          </th>
                          <td>
                              <input type="text" value="img\" name="url" id="url">
                          </td>
                      </tr>
                      <tr>
                          <th>
                              <label for="price">Harga</label>
                          </th>
                          <td>
                              <input type="text" name="price" id="price" value="20">
                          </td>
                      </tr>
                      <tr>

                      </tr>

                  </table>
                  <input type="submit" class="btn btn-success" value="Submit">
                  <input type="hidden" name="MM_insert" value="produk" />

              </form>
</center>
        </div>

    </div>

<?php include('inc/footer.php') 

?>
