<?php
/**
 * @author: Jonathan Hollingsworth
 * @description: Main page for admin
 */

if ($_SERVER['SERVER_NAME'] === 'localhost' || $_SERVER['SERVER_NAME'] === 'www.able-futures.com' ||
    $_SERVER['SERVER_NAME'] === 'able-futures.com' ) {
    $path = '/cadmedical';
} else {
    $path = '';
}

// Required files
require $_SERVER["DOCUMENT_ROOT"]. $path ."/api/common/dbconnection.php";
require $_SERVER["DOCUMENT_ROOT"]. $path ."/api/common/checkpermissions.php";
require $_SERVER["DOCUMENT_ROOT"]. $path ."/api/classes/helper/category.helper.php";
require $_SERVER["DOCUMENT_ROOT"]. $path ."/api/classes/helper/page.helper.php";

//Prepare the categories object for bootstrapping into the page
$categoryHelper = new CategoryHelper($con);
$categories = $categoryHelper->getAllCategories();

$pageHelper = new PageHelper();
$pages = $pageHelper->getPages();


$productsActive = '';
$contentActive = '';
if (isset($_GET['a']) && $_GET['a'] === 'content') {
    $contentActive = 'active';
} else {
    $productsActive = 'active';
}

?>

<html>
<head>
    <title></title>
    <link rel="stylesheet" type="text/css" href="../bootstrap/3.0.3/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="../bootstrap/3.0.3/css/bootstrap-theme.css">
<!--    <link rel="stylesheet" type="text/css" href="../css/site.css">-->
</head>
<body>
<h1>Admin page</h1>


<section id="body" class="container">
    <ul class="nav nav-tabs">
        <li class="<?=$productsActive?>"><a href="#products" data-toggle="tab">Products and Categories</a></li>
        <li class="<?=$contentActive?>"><a href="#content" data-toggle="tab">Page Content</a></li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane <?=$productsActive?>" id="products">
            <a href="productedit.php" class="btn btn-success">Add Product</a>


            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th></th>
                            <th>Category Name</th>
                            <th></th>
                        </tr>
                    </thead>

                    <tbody id="categoryTable">
                    </tbody>

                </table>
            </div>
        </div>
        <div class="tab-pane <?=$contentActive?>" id="content">
<!--            <a href="contentedit.php" class="btn btn-success">Add Content</a>-->
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>Page Name</th>
                        <th>Page Alias</th>
                    </tr>
                    </thead>

                    <tbody id="contentTable">

                    </tbody>
                </table>
            </div>
        </div>
    </div>


</section>


<section id="templates">
    <script type="text/template" id="categoriesList_template">
        <td><button class="btn btn-sm btn-primary showproducts showProducts" data-categoryid="<%=model.get('categoryId')%>">Show Products</button></td>
        <td><a href="categoryedit.php?c=<%=model.get('categoryId')%>"><%=model.get('name')%></a></td>
        <td></td>
    </script>

    <script type="text/template" id="productsList_template">
        <td></td>
        <td><a href="productedit.php?p=<%=model.get('productId')%>" class="productItemLink"><%=model.get('name')%></a></td>
        <td></td>
    </script>

    <script type="text/template" id="pagesList_template">
        <td><a href="contentedit.php?p=<%=model.get('pageId')%>"><%=model.get('title')%></a></td>
        <td><a href="contentedit.php?p=<%=model.get('pageId')%>"><%=model.get('reference')%></a></td>
    </script>
</section>

<script language="Javascript" src="../js/libraries/jquery2.0.3.js"></script>
<script language="JavaScript" src="../js/libraries/underscore-1.5.2-min.js"></script>
<script language="Javascript" src="../bootstrap/3.0.3/js/bootstrap.js"></script>
<script language="JavaScript" src="../js/libraries/backbone-1.1.0-min.js"></script>
<script language="JavaScript" src="js/basiccollectionsmodels.js"></script>
<script language="JavaScript" src="js/landing/productList_view.js"></script>
<script language="JavaScript" src="js/landing/categoryList_view.js"></script>
<script language="JavaScript" src="js/landing/pagesList_view.js"></script>
<script language="JavaScript" src="js/landing/landing_app.js"></script>

<script>
    var categories,
        categoryListView,
        pages,
        pagesListView;

    categories = new ablefutures.cadmedical.collections.categories();
    categories.reset(<?=json_encode($categories)?>);

    categoryListView = new ablefutures.cadmedical.views.categoryList({
        collection : categories,
        el : '#categoryTable'
    });
    categoryListView.render();

    pages = new ablefutures.cadmedical.collections.pages();
    pages.reset(<?=json_encode($pages)?>);

    pagesListView = new ablefutures.cadmedical.views.pagesList({
        collection : pages,
        el : '#contentTable'
    });

    pagesListView.render();



//    success: function(collection, response, options) {
    //                var categoryListView = new ablefutures.cadmedical.views.categoryList({
    //                    collection : collection,
    //                    el : '#categoryTable'
    //                });
</script>

</body>
</html>