<?php
/**
 * @author: Jonathan Hollingsworth
 * @copyright: Able Futures, 2014
 * @description: Products Router
 */
require "common/dbconnection.php";
require "classes/category.class.php";
require "classes/helper/product.helper.php";


$method = $_SERVER['REQUEST_METHOD'];
$action = isset($_GET['action']) ? $_GET['action'] : 'none';
$categoryId = $_GET['categoryId'];

if (!isset($categoryId)) {
    throw new HttpException('Invalid categoryId', 400);
}

switch ($method) {
    case "GET":
        //Get all tasks
        $productHelper = new ProductHelper($con);
        echo json_encode($productHelper->getProducts($categoryId));
        break;
    case "POST":
}