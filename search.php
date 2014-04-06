<?php
// Required files
require $_SERVER["DOCUMENT_ROOT"]."/cadmedical/api/common/dbconnection.php";
require $_SERVER["DOCUMENT_ROOT"]."/cadmedical/api/classes/helper/category.helper.php";
require $_SERVER["DOCUMENT_ROOT"]."/cadmedical/api/classes/helper/product.helper.php";

$searchTerm = $_REQUEST['searchInput'];


$productHelper = new ProductHelper(getConnection());
$products = $productHelper->searchProducts($searchTerm);

echo json_encode($products);