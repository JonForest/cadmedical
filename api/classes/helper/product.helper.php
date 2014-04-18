<?php
/**
 * @author: Jonathan Hollingsworth
 * @description: Category class
 */

if ($_SERVER['SERVER_NAME'] === 'localhost' || $_SERVER['SERVER_NAME'] === 'www.able-futures.com' ||
    $_SERVER['SERVER_NAME'] === 'able-futures.com' ) {
    $path = '/cadmedical';
} else {
    $path = '';
}


require $_SERVER["DOCUMENT_ROOT"] . $path . "/api/classes/product.class.php";
require $_SERVER["DOCUMENT_ROOT"] . $path . "/api/classes/productDetailItem.class.php";


class ProductHelper {

    /**
     * @var mysqli $con
     */
    private $con;

    function __construct(mysqli $conArg)
    {
        $this->con = $conArg;
    }

    public function getProducts($categoryId)
    {
        $productId=0;
        $price = 0.0;
        $name = '';
        $status = 0;

        /** @var Product[] $products */
        $products = array();
        $sql = "select p.productId, p.price, p.name, p.status from products p
               WHERE p.categoryId = ? and p.status=1 order by sequence, productId";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("i",$categoryId);
        $stmt->execute();
        $stmt->bind_result($productId, $price, $name, $status);

        $con2 = getConnection();

        while ($stmt->fetch())
        {
            /** @var Product $product */
            $product = new Product();

            $product->productId = $productId;
            $product->categoryId = $categoryId;
            $product->price = $price;
            $product->name = $name;
            $product->status = $status;

            $product->prices = $this->getPrices($product->productId);
            $product->images = $this->getImages($product->productId);
            $product->productDetailItems = $this->getProductDetailItems($product->productId);

            $products[] = $product;
        }


        return $products;
    }

    private function getProductDetailItems($productId)
    {
        $con = getConnection();
        $productDetailItemId = 0;
        $description = '';
        $status='';

        $sql = "select productDetailItemId, description, status from productdetailitems
               WHERE productId = ? and status=1";
        $stmt2 = $con->prepare($sql);
        $stmt2->bind_param("i",$productId);
        $stmt2->execute();
        $stmt2->store_result();
        $stmt2->bind_result($productDetailItemId, $description, $status);

        /** @var ProductDetailItem[] $productDetailItems */
        $productDetailItems = array();

        if ($stmt2->num_rows > 0) {
            while ($stmt2->fetch())
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

    private function getPrices($productId)
    {
        $con = getConnection();
        $priceId = 0;
        $priceAmount = 0;
        $priceFrom = 0;
        $priceDiscriminator = '';
        $priceOnRequest = 0;

        $sql = "select priceId, price, priceFrom, priceDiscriminator, priceOnRequest from prices where productId=? and status=1";
        $stmt2 = $con->prepare($sql);
        $stmt2->bind_param("i",$productId);
        $stmt2->execute();
        $stmt2->store_result();
        $stmt2->bind_result($priceId, $priceAmount, $priceFrom, $priceDiscriminator, $priceOnRequest);

        /** @var ProductDetailItem[] $productDetailItems */
        $prices = array();

        if ($stmt2->num_rows > 0) {
            while ($stmt2->fetch())
            {
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


    private function getImages($productId)
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

    public function getNewProductId()
    {
        $con = getConnection();
        $sql = "insert into products (price, status, created, lastupdated) values (0, 2, now(), now())";
        $stmt = $con->prepare($sql);
        $stmt->execute();
        return $stmt->insert_id;
    }

    public function searchProducts($searchTerm)
    {
        $individualTerms = explode(' ', $searchTerm);
        $searchTerm = '%'.$searchTerm.'%';

        $parameters = array();

        /** @var /Product[] $products */
        $products  = array();
        $sql = " select SUM(res.relevance) as relevance, res.productId, res.categoryId, res.price, res.name from (
                      SELECT 10 as relevance, p.*, 'title' FROM products p
                        WHERE name LIKE ? and p.status=1
                    ";
        $parameters[] = &$searchTerm;

        $itemCount = count($individualTerms) > 6 ? 6 : count($individualTerms);
        for ($x=0; $x < $itemCount; $x++) {
            $sql .= " union
                        select 5 as relevance, p.*, '".$x."' FROM products p
                        WHERE p.status = 1 and ";
            $sql .= 'name like ? ';
            $term = '%'.$individualTerms[$x].'%';
            $parameters[] = &$term;
        }

        $sql .=        " union
                            select 4 as relevance, p.*, 'description' FROM products p
                                inner join productdetailitems pd on
                                    pd.productId = p.productId
                            WHERE pd.status=1 and pd.description LIKE ?";


        $parameters[] = &$searchTerm;

        for ($x=0; $x < $itemCount; $x++) {
            unset($term);
            $sql .= " union
                            select 2 as relevance, p.*, '".$x."' from products p
                             inner join productdetailitems pd on
                                    pd.productId = p.productId
                            WHERE pd.status = 1 and ";
            $sql .= 'description like ? ';
            $term = '%'.$individualTerms[$x].'%';
            $parameters[] = &$term;
        }

        $sql .= ") as res group by productId order by relevance desc";

        $stmt = $this->con->prepare($sql);

        $paramsArray = array();
        $paramsArray[] = str_repeat('s', count($parameters));
       foreach ($parameters as $param) {
           $paramsArray[] = $param;
       }

        switch (count($parameters)) {
            case 4: //1 param
                $stmt->bind_param('ssss', $parameters[0], $parameters[1], $parameters[2], $parameters[3]);
                break;
            case 6: //two params
                $stmt->bind_param('ssssss', $parameters[0], $parameters[1], $parameters[2], $parameters[3],
                    $parameters[4], $parameters[5]);
                break;
            case 8: //thre params
                $stmt->bind_param('ssssssss', $parameters[0], $parameters[1], $parameters[2], $parameters[3],
                    $parameters[4], $parameters[5], $parameters[6], $parameters[7]);
                break;
            case 10: //four params
                $stmt->bind_param('ssssssssss', $parameters[0], $parameters[1], $parameters[2], $parameters[3],
                    $parameters[4], $parameters[5], $parameters[6], $parameters[7], $parameters[8], $parameters[9]);
                break;
            case 12: //five params
                $stmt->bind_param('ssssssssssss', $parameters[0], $parameters[1], $parameters[2], $parameters[3],
                    $parameters[4], $parameters[5], $parameters[6], $parameters[7], $parameters[8], $parameters[9],
                    $parameters[10], $parameters[11]);
                break;

            default: //trim to six
                $stmt->bind_param('ssssssssssssss', $parameters[0], $parameters[1], $parameters[2], $parameters[3],
                    $parameters[4], $parameters[5], $parameters[6], $parameters[7], $parameters[8], $parameters[9],
                    $parameters[10], $parameters[11], $parameters[12], $parameters[13]);
                break;
        }

        $relevance = 0;
        $categoryId=0;
        $price=0;
        $name ='';

        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($relevance, $productId, $categoryId, $price, $name);

        $products = array();
        if ($stmt->num_rows > 0) {
            while ($stmt->fetch()) {
                /** @var Product $product */
                $product = new Product();

                $product->productId = $productId;
                $product->categoryId = $categoryId;
                $product->price = $price;
                $product->name = $name;

                $product->prices = $this->getPrices($product->productId);
                $product->images = $this->getImages($product->productId);
                $product->productDetailItems = $this->getProductDetailItems($product->productId);

                $products[] = $product;
            }
        }

        return $products;
    }
}