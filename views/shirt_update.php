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

$colname_update = "-1";
if (isset($_GET['no_tagihan'])) {
  $colname_update = $_GET['no_tagihan'];
}
mysql_select_db($database_KaosKece, $KaosKece);
$query_update = sprintf("SELECT * FROM daftartagihan WHERE no_tagihan = %s", GetSQLValueString($colname_update, "int"));
$update = mysql_query($query_update, $KaosKece) or die(mysql_error());
$row_update = mysql_fetch_assoc($update);
$totalRows_update = mysql_num_rows($update);

mysql_select_db($database_KaosKece, $KaosKece);
$query_ukuran = "SELECT * FROM ukuran";
$ukuran = mysql_query($query_ukuran, $KaosKece) or die(mysql_error());
$row_ukuran = mysql_fetch_assoc($ukuran);
$totalRows_ukuran = mysql_num_rows($ukuran);
?><link href="css/bootstrap.min.css" rel="stylesheet" type="text/css" />


		<div class="section page">

			<div class="wrapper">

				<div class="breadcrumb"><a href="../../shirts.php">Kaos</a> &gt; <?php echo $product["name"]; ?></div>

				<div class="shirt-picture">
					<span>
					<img src="<?php echo $product["img"]; ?>" alt="<?php echo $product["name"]; ?>" >
					</span>
				</div>

				<div class="shirt-details">

					<h1><span class="price">Rp <?php echo $row_update['price']; ?> ribu</span> <?php echo $row_update['name']; ?></h1>


				  <form name="form" action="<?php echo $editFormAction; ?>" method="POST">
						<table>

						<tr>
						  <th for="no_tagihan">No Tagihan</th>
						  <td>                        <?php echo $row_update['no_tagihan']; ?></td>
						  </tr>
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
				  </form><input name="" type="hidden" value="" />


					<p class="note-designer">* KaosKece Production.</p>

				</div>

			</div>

		</div>

<?php include("inc/footer.php"); ?>
<?php
mysql_free_result($update);

mysql_free_result($ukuran);
?>
