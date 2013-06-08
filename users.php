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

$colname_users = "-1";
if (isset($_GET['fakultas'])) {
  $colname_users = $_GET['fakultas'];
}
mysql_select_db($database_KaosKece, $KaosKece);
$query_users = sprintf("SELECT adminId, nama, username, email, count(adminId) as jumlah FROM `admin` WHERE fakultas = %s ", GetSQLValueString($colname_users, "text"));
$users = mysql_query($query_users, $KaosKece) or die(mysql_error());
$row_users = mysql_fetch_assoc($users);
$totalRows_users = mysql_num_rows($users);

$colname_jual = "-1";
if (isset($_GET['fakultas'])) {
  $colname_jual = $_GET['fakultas'];
}
mysql_select_db($database_KaosKece, $KaosKece);
$query_jual = sprintf("SELECT uploader, id, name, img, price FROM produk WHERE fakultas = %s", GetSQLValueString($colname_jual, "text"));
$query_jual2 = sprintf("SELECT uploader, id, name, img, price, count(id) as jual FROM produk WHERE fakultas = %s", GetSQLValueString($colname_jual, "text"));
$jual = mysql_query($query_jual, $KaosKece) or die(mysql_error());
$jual2 = mysql_query($query_jual2, $KaosKece) or die(mysql_error());
$row_jual = mysql_fetch_assoc($jual);
$row_jual2 = mysql_fetch_assoc($jual2);
$totalRows_jual = mysql_num_rows($jual);

$colname_daftartagihan = "-1";
if (isset($_GET['fakultas'])) {
  $colname_daftartagihan = $_GET['fakultas'];
}
mysql_select_db($database_KaosKece, $KaosKece);
$query_daftartagihan = sprintf("SELECT * FROM daftartagihan WHERE fakultas = %s", GetSQLValueString($colname_daftartagihan, "text"));
$query_daftartagihan2 = sprintf("SELECT *, count(username) as banyakbeli  FROM daftartagihan WHERE fakultas = %s", GetSQLValueString($colname_daftartagihan, "text"));
$daftartagihan = mysql_query($query_daftartagihan, $KaosKece) or die(mysql_error());
$daftartagihan2 = mysql_query($query_daftartagihan2, $KaosKece) or die(mysql_error());
$row_daftartagihan = mysql_fetch_assoc($daftartagihan);
$row_daftartagihan2 = mysql_fetch_assoc($daftartagihan2);
$totalRows_daftartagihan = mysql_num_rows($daftartagihan);
?><link href="css/bootstrap.min.css" rel="stylesheet">
<link href="css/bootstrap-responsive.min.css" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="css/hint.min.css"/>


<title>Users</title>
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
         <h4>Ada <?php echo $row_users['jumlah']; ?> orang dari fakultas <?php echo $_GET['fakultas']; ?> yang sudah bergabung dengan kaos kece!</h4>
        <div class="alert alert-info">
        <center>
       
        <br />
        <table width="100%" border="0" cellpadding="5" class="table table-striped">
          <tr>
            
            <td><strong>Nama</strong></td>
            <td><strong>username</strong></td>
            <td><strong>email</strong></td>
           

          </tr>
          <?php do { ?>
            <tr>
              
              <td><?php echo $row_users['nama']; ?></td>
              <td><?php echo $row_users['username']; ?></td>
              <td><?php echo $row_users['email']; ?></td>

            </tr>
            <?php } while ($row_users = mysql_fetch_assoc($users)); ?>
        </table>
        </center>
</div>
        </div>
        
        <div class="wrapper">
        <center>
         <h4>Ada <?php echo $row_daftartagihan2['banyakbeli']; ?> baju yang di beli anak-anak fakultas <?php echo $_GET['fakultas']; ?>.</h4>
        <div class="alert alert-info">
        <center>
       
        <br />
        <table width="100%" border="0" cellpadding="5" class="table  table-striped">
          <tr>

            <td><strong>Username</strong></td>

            <td><strong>Nama</strong></td>
            <td><strong>Ukuran yang dibeli</strong></td>

            <td>&nbsp;</td>

          </tr>
          <?php do { ?>
            <tr>

              <td><?php echo $row_daftartagihan['username']; ?></td>

              <td><?php echo $row_daftartagihan['name']; ?></td>
              <td><?php echo $row_daftartagihan['size']; ?></td>

              <td><img src="views/<?php echo $row_daftartagihan['img']; ?>" class="img-polaroid" width="40"  /></td>

            </tr>
            <?php } while ($row_daftartagihan = mysql_fetch_assoc($daftartagihan)); ?>
        </table>
        </center>
</div>


        </div>
<div class="wrapper">
        <center>
         <h4>Ada <?php echo $row_jual2['jual']; ?> baju yang di jual anak-anak fakultas <?php echo $_GET['fakultas']; ?>.</h4>
        <div class="alert alert-info">
        <center>
       
        <br />
        <table class="table table-striped" width="100%" border="0" cellpadding="5">
          <tr>
            <td><strong>Penjual</strong></td>
            <td><strong>id</strong></td>
            <td><strong>Nama</strong></td>
            <td><strong>Gambar</strong></td>
            <td><strong>Harga</strong></td>
          </tr>
          <?php do { ?>
            <tr>
              <td><?php echo $row_jual['uploader']; ?></td>
              <td><?php echo $row_jual['id']; ?></td>
              <td><?php echo $row_jual['name']; ?></td>
              <td><img src="views/<?php echo $row_jual['img']; ?>" width="40" class="img-polaroid"  /></td>
              <td>Rp <?php echo $row_jual['price']; ?> ribu</td>
            </tr>
            <?php } while ($row_jual = mysql_fetch_assoc($jual)); ?>
        </table>
        </center>
</div>


        </div>

    </div>

    <?php include('includes/footer.php');
?>
<?php
mysql_free_result($users);

mysql_free_result($jual);

mysql_free_result($daftartagihan);
?>
