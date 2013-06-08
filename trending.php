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
$query_fakultas = "SELECT id, name, count(*) as dibeli, daftartagihan.img FROM daftartagihan group by name order by dibeli desc";
$fakultas = mysql_query($query_fakultas, $KaosKece) or die(mysql_error());
$row_fakultas = mysql_fetch_assoc($fakultas);
$totalRows_fakultas = mysql_num_rows($fakultas);
?>



<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/bootstrap-responsive.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="css/hint.min.css"/>


<title>Trending Kaos</title>
</HTML>
<link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/bootstrap-responsive.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="css/hint.min.css"/>
<link rel="stylesheet" type="text/css" href="css/hint.css"/>
<link href="../jquery-ui-1.7.2/css/base/ui.core.css" rel="stylesheet" type="text/css" />
<link href="../jquery-ui-1.7.2/css/base/ui.dialog.css" rel="stylesheet" type="text/css" />
<link href="../jquery-ui-1.7.2/css/base/ui.theme.css" rel="stylesheet" type="text/css" />
<link href="../jquery-ui-1.7.2/css/base/ui.images.css" rel="stylesheet" type="text/css" />
<?php 
$pageTitle = "Isi Testimonial";
$section = "contact";
include('includes/header.php'); ?>

    <div class="section page">

        <div class="wrapper">
        <center>
         <h4>Trending Kaos: </h4>
        <div class="alert alert-info">
        <center>
       
        <br />
       <table width="100%" cellpadding="5" class="table table-striped">
  <tr>
    <td><strong>id</strong></td>
    <td><strong>Nama Baju</strong></td>
    <td><strong>Dibeli</strong></td>
    <td>&nbsp;</td>
  </tr>
  <?php do { ?>
    <tr>
      <td><?php echo $row_fakultas['id']; ?></td>
      <td><strong><a href="http://localhost/kece_experiment/views/shirt.php?id=<?php echo $row_fakultas['id']; ?>"><?php echo $row_fakultas['name']; ?></a></strong></td>
      <td><?php echo $row_fakultas['dibeli']; ?> kali</td>
      <td><img src="views/<?php echo $row_fakultas['img']; ?>" class="img-polaroid" width="30" height="30" class="polaroid" /></td>
    </tr>
    <?php } while ($row_fakultas = mysql_fetch_assoc($fakultas)); ?>
</table>
</center>
</div>
        </div>

    </div>

    <?php include('includes/footer.php');
?>
    <?php
mysql_free_result($fakultas);
?>
