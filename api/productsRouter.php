<?php
/**
 * @author: Jonathan Hollingsworth
 * @copyright: Able Futures, 2014
 * @description: Products Router
 */
require "common/dbconnection.php";
require "classes/category.class.php";
//require "classes/product.class.php";
require "classes/helper/product.helper.php";

//
//function getProducts(mysqli $con, $categoryId)
//{
////    $category1 = new Category();
////    $category1->categoryId = 1;
////    $category1->description = 'A test category 1';
////    $category1->status = 1;
////
////    $category2 = new Category();
////    $category2->categoryId = 2;
////    $category2->description = 'A test category 2';
////    $category2->status = 1;
////
////    $categories = array();
////
////    $categories[] = $category1;
////    $categories[] = $category2;
//
////    return $categories;
//
//    $productId=0;
//    $price = 0.0;
//    $name = '';
//    $status = 0;
//
//    /** @var Product[] $products */
//    $products = array();
//    $sql = "select p.productId, p.price, p.name, p.status from products p
//               WHERE p.categoryId = ?";
//    $stmt = $con->prepare($sql);
//    $stmt->bind_param("i",$categoryId);
//    $stmt->execute();
//    $stmt->bind_result($productId, $price, $name, $status);
//
//    while ($stmt->fetch())
//    {
//        /** @var Product $product */
//        $product = new Product();
//
//        $product->productId = $productId;
//        $product->categoryId = $categoryId;
//        $product->name = $name;
//        $product->status = $status;
//
//        $products[] = $product;
//    }
//
//    $stmt->close();
//
//    return $products;
////    return array('results'=>true);
//}


//require_once('recipe.helper.php');
$method = $_SERVER['REQUEST_METHOD'];
$action = isset($_GET['action']) ? $_GET['action'] : 'none';
$categoryId = $_GET['categoryId'];

if (!isset($categoryId)) {
    throw new HttpException('Invalid categoryId', 400);
}

//$recipeHelper = new RecipeHelper($con);

switch ($method) {
    case "GET":
        //Get all tasks
        $productHelper = new ProductHelper($con);
        echo json_encode($productHelper->getProducts($categoryId));
        break;
    case "POST":
}