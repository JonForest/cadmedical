<?php
/**
 * @author: Jonathan Hollingsworth
 * @description: Content Helper Class
 */


require $_SERVER["DOCUMENT_ROOT"]."/cadmedical/api/classes/content.class.php";


class ContentHelper {

    /**
     * @var mysqli $con
     */
    private $con;

    function __construct(mysqli $conArg)
    {
        $this->con = $conArg;
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
        $status = 0;

        //TO only show the categories with products
//        $sql = "select c.categoryId, c.name, c.heroText, c.status from categories c
//                inner join products p on
//                  c.categoryId = p.categoryId
//               WHERE c.status=1 group by c.name";

        //to show all categories
        $sql = "select c.categoryId, c.name, c.heroText, c.status from categories c
               WHERE c.status=1";
        $stmt = $this->con->prepare($sql);
        $stmt->execute();
        $stmt->bind_result($categoryId, $name, $heroText, $status);


        while ($stmt->fetch())
        {
            $category = new Category();

            $category->categoryId = $categoryId;
            $category->name = $name;
            $category->heroText = $heroText;
            $category->status = $status;

            $categories[] = $category;
        }

        $stmt->close();

        return $categories;
    }
}