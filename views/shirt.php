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



mysql_select_db($database_KaosKece, $KaosKece);
$query_ukuran = "SELECT * FROM ukuran ORDER BY Id_ukuran ASC";
$ukuran = mysql_query($query_ukuran, $KaosKece) or die(mysql_error());
$row_ukuran = mysql_fetch_assoc($ukuran);
$totalRows_ukuran = mysql_num_rows($ukuran);

$colname_produk = "-1";
if (isset($_GET['id'])) {
  $colname_produk = $_GET['id'];
}
mysql_select_db($database_KaosKece, $KaosKece);
$query_produk = sprintf("SELECT * FROM produk WHERE id = %s", GetSQLValueString($colname_produk, "int"));
$produk = mysql_query($query_produk, $KaosKece) or die(mysql_error());
$row_produk = mysql_fetch_assoc($produk);
$totalRows_produk = mysql_num_rows($produk);

$maxRows_testi = 10;
$pageNum_testi = 0;
if (isset($_GET['pageNum_testi'])) {
  $pageNum_testi = $_GET['pageNum_testi'];
}
$startRow_testi = $pageNum_testi * $maxRows_testi;

$colname_testi = "-1";
if (isset($_GET['id'])) {
  $colname_testi = $_GET['id'];
}
mysql_select_db($database_KaosKece, $KaosKece);
$query_testi = sprintf("SELECT * FROM testimoni WHERE id_baju = %s", GetSQLValueString($colname_testi, "int"));
$query_limit_testi = sprintf("%s LIMIT %d, %d", $query_testi, $startRow_testi, $maxRows_testi);
$testi = mysql_query($query_limit_testi, $KaosKece) or die(mysql_error());
$row_testi = mysql_fetch_assoc($testi);

if (isset($_GET['totalRows_testi'])) {
  $totalRows_testi = $_GET['totalRows_testi'];
} else {
  $all_testi = mysql_query($query_testi);
  $totalRows_testi = mysql_num_rows($all_testi);
}
$totalPages_testi = ceil($totalRows_testi/$maxRows_testi)-1;
?>
<?php include("inc/products.php");

if (isset($_GET["id"])) {
	$product_id = $_GET["id"];
	if (isset($products[$product_id])) {
		$product = $products[$product_id];
	}
}
if (!isset($product)) {
	header("Location: shirts.php");
	exit();
}

$section = "shirts";
$pageTitle = $product["name"];
$user = $_SESSION['MM_Username'];
include("inc/header.php");

if ((isset($_POST["MM_insert"])) && ($_POST["MM_insert"] == "form")) {
  $insertSQL = sprintf("INSERT INTO daftartagihan (`fakultas`, `img`, `username`, price, `id`, `size`, `name`) VALUES (%s, %s, %s, %s, %s, %s, %s)",
  GetSQLValueString($row_produk['fakultas'], "text"),
  					GetSQLValueString($product['img'], "text"),
  					GetSQLValueString($user, "text"),
					GetSQLValueString($product['price'], "number"),
					GetSQLValueString($product_id, "text"),
                       GetSQLValueString($_POST['os0'], "text"),
					   GetSQLValueString($product['name'], "text"));

  mysql_select_db($database_KaosKece, $KaosKece);
  $Result1 = mysql_query($insertSQL, $KaosKece) or die(mysql_error());
  $insertGoTo = "daftarbelanja.php";
    if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}
 ?>
<link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />


		<div class="section page">

			<div class="wrapper">

				<div class="breadcrumb"><a href="../../shirts.php">Kaos</a> &gt; <?php echo $row_produk['name']; ?> <a href="#" class="pull-right"></a></div>

				<div class="shirt-picture">
					<span>
					<img src="<?php echo $row_produk['img']; ?>" alt="<?php echo $product["name"]; ?>" >
					</span>
				</div>

				<div class="shirt-details">

					<h1><span class="price">Rp <?php echo $row_produk['price']; ?> ribu</span> <?php echo $row_produk['name']; ?></h1>


				  <form name="form" action="<?php echo $editFormAction; ?>" method="POST">
						<table>
						<tr>
							<th>
								<input type="hidden" name="on0" value="Size">
								<label for="os0">Ukuran</label>
							</th>
							<td>
								<select name="os0" class="dropdown-toggle" id="os0">
								  <option value=""></option>
								  <?php
do {  
?>
								  <option value="<?php echo $row_ukuran['Ukuran']?>"><?php echo $row_ukuran['Ukuran']?></option>
								  <?php
} while ($row_ukuran = mysql_fetch_assoc($ukuran));
  $rows = mysql_num_rows($ukuran);
  if($rows > 0) {
      mysql_data_seek($ukuran, 0);
	  $row_ukuran = mysql_fetch_assoc($ukuran);
  }
?>
                              </select>
						  </td>
						</tr>
						</table>
						<input name="submit" type="submit" class="btn-success" value="Masukkan ke Daftar Belanja">
						<input type="hidden" name="MM_insert" value="form" />
				  </form>


					<p class="note-designer">* KaosKece Production.</p>

				</div>
			</div>
<div class="span5 well well-small">
  <?php do { ?>
    <blockquote>
      <p><span class="label label-success"><?php echo $row_testi['status']; ?></span>, <?php echo $row_testi['komentar']; ?> </p>
      <small class="pull-right"><cite><strong><?php echo $row_testi['komentator']; ?></strong></cite></small>
    </blockquote>
    <hr />
    <?php } while ($row_testi = mysql_fetch_assoc($testi)); ?>

    <a href="testi.php?id=<?php echo $_GET["id"]; ?>">
  <button class="btn-success text-center">Tambahkan Testimoni</button>
  </a>
</div>
<br />
<!-- <div class="span6">
 </div> -->
		</div>

<?php include("inc/footer.php"); ?>
<?php /*?><?php
mysql_free_result($ukuran);

mysql_free_result($produk);

mysql_free_result($testi);
?>
<?php */?>