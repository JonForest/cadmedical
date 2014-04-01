<?php
/**
 * @author: Jonathan Hollingsworth
 * @copyright: Able Futures, 2014
 * @description: Page Router
 */
require "common/dbconnection.php";
require "classes/product.class.php";
require "classes/helper/page.helper.php";

$method = $_SERVER['REQUEST_METHOD'];
$action = isset($_GET['action']) ? $_GET['action'] : 'none';

switch ($method) {
    case "GET":
        //Get all tasks
        $pageHelper = new PageHelper();
        $pages = $pageHelper->getPages();

        echo json_encode($pages);
        break;
    case "POST":
        if ($action === 'save') {
            $page = json_decode(file_get_contents("php://input"));
            $pageHelper = new PageHelper();
            echo json_encode($pageHelper->savePage($page));
        }
        break;
}