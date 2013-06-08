
<?php
$pageTitle = "Terimakasih!";
$section = "none";
include("header.php"); 
include ("connect.php");
\ //memanggil file connect.php supaya terkoneksi dengan database

//mengambil data isian dari textfield yang bersesuaian dan menyimpannya dalam variabel
$name = $product["name"];
$price = $product["price"];

if (empty($name) || empty($price) || empty($size))  //cek jika ada texfield yang Kosong
	{
		echo "Form ada yang kosong, silahkan isi ulang";
	}
else
	{
		$queriku = mysql_query("INSERT INTO  daftarbelanja (no ,name , harga , ukuran) VALUES (NULL ,  '$name',  '$price',  '$size');");
		if ($queriku == TRUE)
			{
				echo "Data Berhasil ditambah, silahkan lihat daftar";
			}
		else
			{
				echo "error";
			}
	}
?>

	<div class="section page">

		<div class="wrapper">

			<h1>Terimakasih!</h1>

			<p>Terimakasih untuk pemesanan kaos anda. </p>

			<p>Mau beli Kaos Lagi? Kunjungi <a href="../../../inc/shirts.php">Daftar Kaos</a> lagi.</p>

		</div>

	</div>

<?php include("footer.php"); ?>