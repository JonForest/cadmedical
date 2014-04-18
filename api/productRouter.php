<?php
/**
 * @author: Jonathan Hollingsworth
 * @copyright: Able Futures, 2014
 * @description: Product Router
 */
require "common/dbconnection.php";
require "classes/category.class.php";
require "classes/product.class.php";
require "classes/productDetailItem.class.php";
require "classes/price.class.php";

//TODO: put into helper class

function getProduct(mysqli $con, $productId)
{
    $price = 0.0;
    $name = '';
    $status = 0;
    $categoryId = 0;
    $sequence = 0;

    /** @var Product[] $products */
    $products = array();
    $sql = "select p.categoryId, p.price, p.name, p.sequence, p.status from products p
               WHERE p.productId = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("i",$productId);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($categoryId, $price, $name, $sequence, $status);

    /** @var Product $product */
    $product = new Product();

    //Should only be one result, can probably refactor this into better code
    while ($stmt->fetch()) {
        $product->productId = $productId;
        $product->categoryId = $categoryId;
        $product->price = $price;
        $product->name = $name;
        $product->sequence = $sequence;
        $product->status = $status;
    }


   $product->prices = getPrices($productId);



    //$stmt->close();

    $product->prices = getPrices($productId);
    $product->images = getImages($productId);
    $product->productDetailItems = getProductDetailItems($productId);




    return $product;
}

function getPrices($productId)
{
    $con = getConnection();
    $priceId=0;
    $priceAmount = '';
    $priceFrom = 0;
    $priceDiscriminator = '';
    $priceOnRequest  = '';

    $sql = "select priceId, price, priceFrom, priceDiscriminator, priceOnRequest from prices where productId=? and status=1";
    $stmt2 = $con->prepare($sql);
    $stmt2->bind_param("i", $productId);
    $stmt2->execute();
    $stmt2->store_result();
    $stmt2->bind_result($priceId, $priceAmount, $priceFrom, $priceDiscriminator, $priceOnRequest);

    $prices = array();

    if ($stmt2->num_rows > 0) {
        while ($stmt2->fetch()) {
            $price = new stdClass();
            $price->priceId = $priceId;
            $price->price = $priceAmount;
            $price->priceFrom = $priceFrom;
            $price->priceDiscriminator = $priceDiscriminator;
            $price->priceOnRequest = $priceOnRequest;
            $prices[] = $price;
        }
    }

    return $prices;
}

function getImages($productId)
{
    $con = getConnection();

    $imageId=0;
    $imageTitle = '';
    $imagePath = '';
    $caption  = '';
    $sql = "select i.imageId, i.imageTitle, i.caption, i.imagePath from images i where i.productId=? and i.status=1";
    $stmt2 = $con->prepare($sql);
    $stmt2->bind_param("i", $productId);
    $stmt2->execute();
    $stmt2->store_result();
    $stmt2->bind_result($imageId, $imageTitle, $caption, $imagePath);


    $images = array();
    if ($stmt2->num_rows > 0) {
        while ($stmt2->fetch()) {
            $image = new stdClass();
            $image->imageId = $imageId;
            $image->imageTitle = $imageTitle;
            $image->caption = $caption;
            $image->imagePath = $imagePath;
            $image->thumbnail = "images/thumbnail/".$imagePath;
            $images[] = $image;
        }

    }

    return $images;

}

function getProductDetailItems($productId)
{
    $con = getConnection();

    $productDetailItemId = 0;
    $description = '';
    $status=0;
    $sql = "select productDetailItemId, description, status from productdetailitems p
               WHERE p.productId = ?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("i",$productId);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($productDetailItemId, $description, $status);

    /** @var ProductDetailItem[] $productDetailItems */
    $productDetailItems = array();

    if ($stmt->num_rows > 0) {
        while ($stmt->fetch())
        {
            /** @var ProductDetailItem $productDetailItem */
            $productDetailItem = new ProductDetailItem();
            $productDetailItem->productId = $productId;
            $productDetailItem->productDetailItemId = $productDetailItemId;
            $productDetailItem->description = $description;
            $productDetailItem->status = $status;

            $productDetailItems[] = $productDetailItem;
        }

    }

    return $productDetailItems;
}


/**
 * @param $productId
 * @return Price[]
 * @throws Exception
 */
function getPricesByProductId($productId)
{
    $priceId = 0;
    $price = 0;
    $priceDiscriminator = '';
    $priceOnRequest = 0;

    $con = getConnection();
    $sql = "select priceId, price, priceDiscriminator, priceOnRequest from prices where status=1 and productId=?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("i", $productId);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($priceId, $price, $priceDiscriminator, $priceOnRequest);

    /** @var $prices Price[]*/
    $prices[] = array();

    if ($stmt->num_rows > 0) {
        while ($stmt->fetch())
        {
            /** @var ProductDetailItem $productDetailItem */
            $price = new Price();
            $price->priceId = $priceId;
            $price->productId = $productId;
            $price->price = $price;
            $price->priceDiscriminator = $priceDiscriminator;
            $price->priceOnRequest = $priceDiscriminator;

            $prices[] = $price;
        }
    }

    return $prices;
}

function addUpdatePrices(mysqli $con, $product)
{
    //A bit of a hack, but lets delete everything and recreate it from the model
    $sql = "delete from prices where productId=?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("i", $product->productId);
    $stmt->execute();

    if (isset($product->prices)) {
        foreach ($product->prices as $price) {
            $sql = "insert into prices (productId, price, priceFrom, priceDiscriminator, priceOnRequest, created, lastUpdated)
            values (?,?, ?, ?, ?, now(), now())";
            $stmt = $con->prepare($sql);
            $stmt->bind_param("idisi", $product->productId, $price->price, $price->priceFrom, $price->priceDiscriminator,
                $price->priceOnRequest);
            $stmt->execute();
        }
    }
}

function addUpdateProductDetails(mysqli $con, $product)
{
    //Since we might have deleted some products, then lets delete any product detail items associated with the product
    //and then recreate them all.  Sledge hammer and nut, but fastest way to develop

    $sql = "delete from productdetailitems where productId=?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("i", $product->productId);
    $stmt->execute();


    foreach ($product->productDetailItems as $productDetailItem) {
        //Insert
        $sql = "insert into productdetailitems (productId, description, created, lastUpdated) values (?,?, now(), now())";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("is", $product->productId, $productDetailItem->description);
        $stmt->execute();
    }
}

function addUpdateImages(mysqli $con, $product)
{
    if (isset($product->images)) {
        foreach ($product->images as $image) {
            if (isset($image->imageId)) {
                //update
                $sql = "update images set imageTitle=?, caption=? where imageId=?";
                $stmt = $con->prepare($sql);
                $stmt->bind_param("ssi",$image->imageTitle, $image->caption, $image->imageId);
                $stmt->execute();
            }
        }
    }
}


function updateProduct(mysqli $con, $product)
{
    $sequence = isset($product->sequence) ? $product->sequence : getLatestSequence($product->categoryId);
    $sql="update products set categoryId=?, name=?, price=?, sequence=?, status=1 where productId=?";
    $stmt = $con->prepare($sql);
    $stmt->bind_param('isidi', $product->categoryId, $product->name, $product->price, $sequence, $product->productId);
    $stmt->execute();

    addUpdatePrices($con, $product);
    addUpdateProductDetails($con, $product);
    addUpdateImages($con, $product);


    return array('result' => 'success');
}

function getLatestSequence($categoryId)
{
    $sequence = 0;

    $con = getConnection();
    $sql="SELECT sequence+1 from products where categoryId=? order by sequence desc limit 1;";
    $stmt = $con->prepare($sql);
    $stmt->bind_param("i", $categoryId);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($sequence);

    //Should only be one result, can probably refactor this into better code
    while ($stmt->fetch()) {
        if (!isset($sequence)) {
            return 1;
        } else {
            return $sequence;
        }
    }

}



$method = $_SERVER['REQUEST_METHOD'];
$action = isset($_GET['action']) ? $_GET['action'] : 'none';


switch ($method) {
    case "GET":
        //Get all tasks
        if (!isset($_GET['productId'])) {
            throw new Exception('No valid productId supplied');
        }
        $product = getProduct($con, $_GET['productId']);
        echo json_encode($product);
        break;
    case "POST":
        /** @var Product $product */
        $product  = json_decode(file_get_contents("php://input"));
        if (isset($product->productId)) {
            echo json_encode(updateProduct($con, $product));
        } else {
           // echo json_encode(addProduct($con, $product));
        }
        break;

}