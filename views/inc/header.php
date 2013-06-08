<html>
<head>
	<title><?php echo $pageTitle; ?></title>
    <!--<link rel="stylesheet" type="text/css" href="../css/style.css">-->

	<link rel="stylesheet" href="css/style.css" type="text/css">
    <link rel="stylesheet" type="text/css" href="css/bootstrap.min.css"/>
	<link rel="stylesheet" type="text/css" href="css/bootstrap-responsive.css"/>
	<link rel="stylesheet" type="text/css" href="css/docs.css"/>
<!--	<link rel="stylesheet" href="http://fonts.googleapis.com/css?family=Oswald:400,700" type="text/css">-->
	<link data-toggle="tooltip" title="first tooltip" id="logo" rel="shortcut icon" href="img/kedce.png">
	<script type="text/javascript" src="../js/bootstrap.js"></script>
	<script type="text/javascript" src="../js/bootstrap.min.js"></script>
	<script type="text/javascript" src="../js/bootstrap-dropdown.js"></script>

</head>
<body>

	<div class="header">

		<div class="wrapper">

			<h1 class="branding-title"><a href="./">Kaos Kece</a></h1>

			<ul class="nav">
		<!--		<li class="shirts <?php /*?><?php if ($section == "shirts") { echo "on"; } ?><?php */?>" data-original-title="titl data-content="content" rel="popover"><a href="shirts.php">Kaos</a></li>-->
				<li class="contact <?php if ($section == "contact") { echo "on"; } ?>"><a href="daftar_testi.php">Testimonial</a></li>
				<li class="contact <?php if ($section == "jual") { echo "on"; } ?>"><a href="jual.php">Jual Kaos</a></li>
                <li class="contact <?php if ($section == "daftarbelanja") { echo "on"; } ?>"><a href="shirts.php">Katalog</a></li>
				<li class="cart <?php if ($section == "daftarbelanja") { echo "on"; } ?>"><a href="daftarbelanja.php">Daftar Belanja</a></li>
			</ul>

		</div>

	</div>
<div id="content">

<script>
$('#elem').popover()
</script>
