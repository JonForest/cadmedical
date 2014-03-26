<?php
/**
 * @author: Jonathan Hollingsworth
 * @copyright: Able Futures, 2014
 * @description: Image Router
 */
require "common/dbconnection.php";
require "classes/product.class.php";
require "classes/helper/image.helper.php";

/**
 * Saves the uploaded image
 * Creates different image sizes (thumbnail and common)
 *
 * @param mysqli $con
 * @throws Exception
 */
function saveUpload(mysqli $con)
{
    $imageHelper = new imageHelper($con);


    $mimeTypes = array(
        "image/png",
        "image/jpg",
        "image/gif"
    );

    $productId = $_POST['productId'];

    if (!isset($productId)) {
        throw new Exception("No activity Id provided", 500);
    }

    if ($_FILES['file_upload']['error'] > 0) {
        throw new Exception("Error uploading", 500);
    } elseif (in_array($_FILES['file_upload']['type'], $mimeTypes) ) {
        //TODO: test this
        throw new Exception("Invalid type", 500);
    }

    $filename = uniqid($productId) . $_FILES['file_upload']['name'];
    $tmp_file = $_FILES['file_upload']['tmp_name'];
    $new_file = "../images/original/" . $filename;
    $thumbnail = "../images/thumbnail/" . $filename;
    $common = "../images/common/" . $filename;

    $result = move_uploaded_file($tmp_file, $new_file);
    if (!$result ) {
        throw new Exception ("Failed to copy file", 500);
    }

    $imageHelper->createThumbnail($new_file, $thumbnail);
    $imageHelper->createCommon($new_file, $common);


    //Now save to database
    $sql = "INSERT INTO images (productId, created, lastUpdated, imagePath) VALUES (?, NOW(), NOW(), ?)";

    /* @var mysqli-stmt $stmt */
    $stmt = $con->prepare($sql);

    $stmt->bind_param("is",$productId, $filename);
    $stmt->execute();
    $imageId = mysqli_insert_id($con);
//    $stmt->close();

    $data = array ( 'productId' => $productId,
        'imageId' => $imageId,
        'original' => substr($new_file,3),
        'thumbnail' => substr($thumbnail,3),
        'common' => substr($common,3) );

    header('Content-type: application/json');
    echo json_encode($data, JSON_FORCE_OBJECT);
}


//require_once('recipe.helper.php');
$method = $_SERVER['REQUEST_METHOD'];
$action = isset($_GET['a']) ? $_GET['a'] : 'none';

$imageHelper = new imageHelper($con);

switch ($method) {
    case "GET":

        break;
    case "POST":
        switch ($action) {
            case 'none':
                saveUpload($con);
                break;
            case 'delete':
                $imageId = json_decode(file_get_contents("php://input"));
                echo (json_encode($imageHelper->deleteImage($imageId)));
                break;
            case 'caption':
                $captionInfo  = json_decode(file_get_contents("php://input"));
                echo (json_encode($imageHelper->saveCaption($con, $captionInfo)));
                break;
        }
    break;

}