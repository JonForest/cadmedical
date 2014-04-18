<?php
//if ($_SERVER['SERVER_NAME'] === 'localhost' || $_SERVER['SERVER_NAME'] === 'www.able-futures.com' ||
//    $_SERVER['SERVER_NAME'] === 'able-futures.com' ) {
//    $path = '/cadmedical';
//} else {
//    $path = '';
//}
//
//// Required files
//require $_SERVER["DOCUMENT_ROOT"]. $path ."/api/common/dbconnection.php";
//require $_SERVER["DOCUMENT_ROOT"]. $path ."/api/classes/helper/category.helper.php";
//require $_SERVER["DOCUMENT_ROOT"]. $path ."/api/classes/helper/product.helper.php";
//
//$searchTerm = $_REQUEST['searchInput'];
//
//
//$productHelper = new ProductHelper(getConnection());
//$products = $productHelper->searchProducts($searchTerm);
//
//echo json_encode($products);