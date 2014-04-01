<?php
/**
 * @author: Jonathan Hollingsworth
 * @copyright: Able Futures, 2014
 * @description: Page Router
 */
require "common/dbconnection.php";
//require "classes/category.class.php";
require "classes/product.class.php";
require "classes/helper/page.helper.php";

//require_once('recipe.helper.php');
$method = $_SERVER['REQUEST_METHOD'];
$action = isset($_GET['action']) ? $_GET['action'] : 'none';

switch ($method) {
    case "GET":
        //Get all tasks
        $categoryHelper = new PageHelper();
        $categories = $categoryHelper->getAllPages();

        echo json_encode($categories);
        break;
    case "POST":
        if ($action === 'save') {
            $page = json_decode(file_get_contents("php://input"));
            $pageHelper = new PageHelper();
            echo json_encode($pageHelper->savePage($page));
        }
        break;
}