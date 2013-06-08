
<?php

function get_list_view_html($product_id, $product) {
    
    $output = "";

    $output = $output . "<li>";
    $output = $output . '<a href="shirt.php?id=' . $product_id . '">';
    $output = $output . '<img src="' . $product["img"] . '" alt="' . $product["name"] . '">';
    $output = $output . "<p>Selengkapnya</p>";
    $output = $output . "</a>";
    $output = $output . "</li>";

    return $output;
}

$products = array();
$products[101] = array(
	"name" => "Kaos satu",
	"img" => "img/shirts/shirt-101.png",
	"price" => 18,
	"id" => "9P7DLECFD4LKE",
    "sizes" => array("Small","Medium","Large","X-Large")
);
$products[102] = array(
	"name" => "Kaos dua",
    "img" => "img/shirts/shirt-102.png",
    "price" => 20,
    "id" => "SXKPTHN2EES3J",
    "sizes" => array("Small","Medium","Large","X-Large")
);
$products[103] = array(
    "name" => "Kaos tiga",
    "img" => "img/shirts/shirt-103.png",    
    "price" => 20,
    "id" => "7T8LK5WXT5Q9J",
    "sizes" => array("Small","Medium","Large","X-Large")
);
$products[104] = array(
    "name" => "kaos lima",
    "img" => "img/shirts/shirt-104.png",    
    "price" => 18,
    "id" => "YKVL5F87E8PCS",
    "sizes" => array("Small","Medium","Large","X-Large")
);
$products[105] = array(
    "name" => "Kaos enam",
    "img" => "img/shirts/shirt-105.png",    
    "price" => 25,
    "id" => "4CLP2SCVYM288",
    "sizes" => array("Small","Medium","Large","X-Large")
);
$products[106] = array(
    "name" => "Kaos tujuh",
    "img" => "img/shirts/shirt-106.png",    
    "price" => 20,
    "id" => "TNAZ2RGYYJ396",
    "sizes" => array("Small","Medium","Large","X-Large")
);
$products[107] = array(
    "name" => "Kaos delapan",
    "img" => "img/shirts/shirt-107.jpg",    
    "price" => 20,
    "id" => "S5FMPJN6Y2C32",
    "sizes" => array("Small","Medium","Large","X-Large")
);
$products[108] = array(
    "name" => "Kaos sembilan",
    "img" => "img/shirts/shirt-108.jpg",    
    "price" => 25,
    "id" => "JMFK7P7VEHS44",
    "sizes" => array("Large","X-Large")
);



?>
