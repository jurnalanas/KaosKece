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

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_POST["MM_update"])) && ($_POST["MM_update"] == "form1")) {
  $updateSQL = sprintf("UPDATE testimoni SET status=%s, komentar=%s WHERE id_testi=%s",
                       
                       GetSQLValueString($_POST['status'], "text"),
                       
                       GetSQLValueString($_POST['komentar'], "text"),
                       GetSQLValueString($_GET['id'], "int"));

  mysql_select_db($database_KaosKece, $KaosKece);
  $Result1 = mysql_query($updateSQL, $KaosKece) or die(mysql_error());

  $updateGoTo = "daftar_testi.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}

$colname_testi = "-1";
if (isset($_GET['id'])) {
  $colname_testi = $_GET['id'];
}
mysql_select_db($database_KaosKece, $KaosKece);
$query_testi = sprintf("SELECT * FROM testimoni WHERE id_testi = %s", GetSQLValueString($colname_testi, "int"));
$testi = mysql_query($query_testi, $KaosKece) or die(mysql_error());
$row_testi = mysql_fetch_assoc($testi);
$totalRows_testi = mysql_num_rows($testi);

mysql_select_db($database_KaosKece, $KaosKece);
$query_status = "SELECT * FROM status";
$status = mysql_query($query_status, $KaosKece) or die(mysql_error());
$row_status = mysql_fetch_assoc($status);
$totalRows_status = mysql_num_rows($status);
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
<legend>Update Testimonial</legend>

<!-- Text input-->
<div class="control-group">
  <label class="control-label">Id Testi</label>
  <div class="controls">
    <input id="disabledInput" name="id" type="text" value="<?php echo $row_testi['id_testi']; ?>" placeholder="" class="input-xlarge" disabled>
    
  </div>
</div>

<!-- Text input-->
<div class="control-group">

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

<!-- Text input--><!-- Textarea -->
<div class="control-group">
  <label class="control-label">Komentar</label>
  <div class="controls">                     
    <textarea id="komentar" name="komentar"><?php echo $row_testi['komentar']; ?></textarea>
  </div>
</div>

<!-- Button -->
<div class="control-group">
  <label class="control-label"></label>
  <div class="controls">
    <button id="submit"  type="submit" name="submit" class="btn btn-primary">Update</button>
  </div>
</div>

</fieldset>
<input type="hidden" name="MM_insert" value="form1" />
<input type="hidden" name="MM_update" value="form1" />
          </form>

            <p>&nbsp;</p>
        </div>

    </div>

    <?php include('inc/footer.php');

?>
<?php
mysql_free_result($testi);

mysql_free_result($status);
?>
