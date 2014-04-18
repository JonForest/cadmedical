<?php
/**
 * @author: Jonathan Hollingsworth
 * @description: Category Helper Class
 */

if ($_SERVER['SERVER_NAME'] === 'localhost' || $_SERVER['SERVER_NAME'] === 'www.able-futures.com' ||
    $_SERVER['SERVER_NAME'] === 'able-futures.com' ) {
    $path = '/cadmedical';
} else {
    $path = '';
}

require $_SERVER["DOCUMENT_ROOT"]. $path . "/api/classes/category.class.php";


class CategoryHelper {

    /**
     * @var mysqli $con
     */
    private $con;

    function __construct()
    {
        $this->con = getConnection();
    }

    public function getAllCategories()
    {
        /** @var Category $categories */
        $categories = array();

//    $categories[] = $category1;
//    $categories[] = $category2;

        $categoryId=0;
        $name = '';
        $heroText = '';
        $details = '';
        $sizingHtml = '';
        $status = 0;

            //TO only show the categories with products
//        $sql = "select c.categoryId, c.name, c.heroText, c.status from categories c
//                inner join products p on
//                  c.categoryId = p.categoryId
//               WHERE c.status=1 group by c.name";

        //to show all categories
        $sql = "select c.categoryId, c.name, c.heroText, c.details, c.sizingHtml,  c.status from categories c
               WHERE c.status=1";
        $stmt = $this->con->prepare($sql);
        $stmt->execute();
        $stmt->bind_result($categoryId, $name, $heroText, $details, $sizingHtml, $status);


        while ($stmt->fetch())
        {
            $category = new Category();

            $category->categoryId = $categoryId;
            $category->name = $name;
            $category->heroText = $heroText;
            $category->details = $details;
            $category->sizingHtml = $sizingHtml;
            $category->status = $status;
           // $category->categoryDetailItems = $this->getCategoryDetails($categoryId);

            $categories[] = $category;
        }

        $stmt->close();

        return $categories;
    }

    /**
     * currently DEPRECATED and not used
     * @param $categoryId
     * @return array
     */
    private function getCategoryDetails($categoryId)
    {
        $con = getConnection();
        $categoryDetailItemId = 0;
        $description = '';

        $sql = "select categoryDetailItemId, description from categorydetailitems where categoryId=? and status=1";
        $stmt = $con->prepare($sql);
        $stmt->bind_param("i",$categoryId);
        $stmt->execute();
        $stmt->store_result();
        $stmt->bind_result($categoryDetailId, $description);

        /** @var ProductDetailItem[] $productDetailItems */
        $categoryDetails = array();

        if ($stmt->num_rows > 0) {
            while ($stmt->fetch())
            {
                $categoryDetail = new stdClass();
                $categoryDetail->categoryDetailId = $categoryDetailId;
                $categoryDetail->description = $description;

                $categoryDetails[] = $categoryDetail;
            }
        }

        return $categoryDetails;
    }

    public function saveCategory($category)
    {
        $sql = 'update categories set name=?, heroText=?, details=?, sizingHtml=? where categoryId=?';
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param('ssssi', $category->name, $category->heroText, $category->details, $category->sizingHtml ,$category->categoryId);
        $stmt->execute();

        $this->addUpdateCategoryDetails($category);

        return array('success'=>true);
    }

    private function addUpdateCategoryDetails($category)
    {
        $sql = "delete from categorydetailitems where categoryId=?";
        $stmt = $this->con->prepare($sql);
        $stmt->bind_param("i", $category->categoryId);
        $stmt->execute();


        foreach ($category->categoryDetailItems as $categoryDetailItem) {
            $sql = "insert into categorydetailitems (categoryId, description, created, lastUpdated) values (?,?, now(), now())";
            $stmt = $this->con->prepare($sql);
            $stmt->bind_param("is", $category->categoryId, $categoryDetailItem->description);
            $stmt->execute();
        }
    }
}