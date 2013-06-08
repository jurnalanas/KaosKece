<?php require_once('../Connections/KaosKece.php'); ?>
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
$nomorid = $row_tagihan['id'];
if ((isset($_GET['no_tagihan'])) && ($_GET['no_tagihan'] != "")) {
  $deleteSQL = sprintf("DELETE FROM daftartagihan WHERE no_tagihan=%s",
                       GetSQLValueString($_GET['no_tagihan'], "int"));

  mysql_select_db($database_KaosKece, $KaosKece);
  $Result1 = mysql_query($deleteSQL, $KaosKece) or die(mysql_error());


}
$deleteGoTo = "shirt.php?id=" . $nomorid . "";
if (isset($_SERVER['QUERY_STRING'])) {
	$deleteGoTo .= (strpos($deleteGoTo, '?')) ? "&" : "?";
	$deleteGoTo .= $_SERVER['QUERY_STRING'];
}
header(sprintf("Location: %s", $deleteGoTo));
  
mysql_select_db($database_KaosKece, $KaosKece);
$query_tagihan = "SELECT * FROM daftartagihan";
$tagihan = mysql_query($query_tagihan, $KaosKece) or die(mysql_error());
$row_tagihan = mysql_fetch_assoc($tagihan);
$totalRows_tagihan = mysql_num_rows($tagihan);



mysql_free_result($tagihan);
?>