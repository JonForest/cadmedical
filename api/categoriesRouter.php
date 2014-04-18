<?php
/**
 * @author: Jonathan Hollingsworth
 * @copyright: Able Futures, 2014
 * @description: Categories Router
 */
require "common/dbconnection.php";
require "classes/product.class.php";
require "classes/helper/category.helper.php";

$method = $_SERVER['REQUEST_METHOD'];
$action = isset($_GET['action']) ? $_GET['action'] : 'none';

switch ($method) {
    case "GET":
        //Get all tasks
        $categoryHelper = new CategoryHelper();
        $categories = $categoryHelper->getAllCategories();

        echo json_encode($categories);
        break;
    case "POST":
        if ($action === 'save') {
            $category = json_decode(file_get_contents("php://input"));
            $categoryHelper = new CategoryHelper();
            echo json_encode($categoryHelper->saveCategory($category));
        }
        break;
}