<?php
/**
 * @author: Jonathan Hollingsworth
 * @description: Main page for admin
 */

// Required files
require $_SERVER["DOCUMENT_ROOT"]."/cadmedical/api/common/dbconnection.php";
require $_SERVER["DOCUMENT_ROOT"]."/cadmedical/api/common/checkpermissions.php";
//require "api/common/logging.php"

require $_SERVER["DOCUMENT_ROOT"]."/cadmedical/api/classes/helper/category.helper.php";

//Prepare the categories object for bootstrapping into the page
$categoryHelper = new CategoryHelper($con);
$categories = $categoryHelper->getAllCategories();

?>

<html>
<head>
    <title></title>
    <link rel="stylesheet" type="text/css" href="../bootstrap/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="../bootstrap/css/bootstrap-theme.css">
<!--    <link rel="stylesheet" type="text/css" href="../css/site.css">-->
</head>
<body>
<h1>Admin page</h1>


<section id="body" class="container">


    <a href="productedit.php" class="btn btn-success">Add Product</a>

    <div class="table-responsive"></div>
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
</section>

<script language="Javascript" src="../js/libraries/jquery2.0.3.js"></script>
<script language="JavaScript" src="../js/libraries/underscore-1.5.2-min.js"></script>
<script language="Javascript" src="../bootstrap/js/bootstrap.js"></script>
<script language="JavaScript" src="../js/libraries/backbone-1.1.0-min.js"></script>
<script language="JavaScript" src="js/basiccollectionsmodels.js"></script>
<script language="JavaScript" src="js/landing/productList_view.js"></script>
<script language="JavaScript" src="js/landing/categoryList_view.js"></script>
<script language="JavaScript" src="js/landing/landing_app.js"></script>

<script>

    var categories = new ablefutures.cadmedical.collections.categories();
    categories.reset(<?=json_encode($categories)?>);

    var categoryListView = new ablefutures.cadmedical.views.categoryList({
        collection : categories,
        el : '#categoryTable'
    });
    categoryListView.render();

//    success: function(collection, response, options) {
    //                var categoryListView = new ablefutures.cadmedical.views.categoryList({
    //                    collection : collection,
    //                    el : '#categoryTable'
    //                });
</script>

</body>
</html>