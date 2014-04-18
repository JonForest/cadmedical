<?php
/**
 * @author: Jonathan Hollingsworth
 * @description: Add a new product
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
require $_SERVER["DOCUMENT_ROOT"]. $path ."/api/classes/helper/product.helper.php";

//Prepare the categories object for bootstrapping into the page
$categoryHelper = new CategoryHelper($con);
$categories = $categoryHelper->getAllCategories();

$productHelper = new ProductHelper($con);

if (isset($_REQUEST['p'])) {
    $productId = $_REQUEST['p'];
    $newProduct = false;
} else {
    $productId = $productHelper->getNewProductId();
    $newProduct = true;
}

?>

<html>
<head>
    <title></title>
    <link rel="stylesheet" type="text/css" href="../bootstrap/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="../bootstrap/css/bootstrap-theme.css">
    <link rel="stylesheet" type="text/css" href="../css/site.css">
    <link rel="stylesheet" type="text/css" href="css/admin.css">
</head>
<body>
    <h1>Admin page - <?=$productId?></h1>

    <section>
        <div class="container">
            <div class="row">
                <div class="col-md-2"></div>
                <div class="col-md-8" id="body"></div>
                <div class="col-md-2"></div>
            </div>
        </div>

    </section>





<section id="templates">
    <script type="text/template" id="productedit_template">
        <form role="form" class="form-horizontal" id="editProductForm">
            <div class="form-group">
                <label for="categorySelect">Category</label>
                <select id="categorySelect" class="form-control">
                    <option value="0">Select category...</option>
                </select>
            </div>
            <div class="form-group">
                <label for="productNameInput">Product Name</label>
                <input id="productNameInput" placeholder="Enter product name" class="form-control" value="<%=model.get('name')%>")>
            </div>
            <div class="form-group">

                <div id="thumbnailsDiv">
                    <label class="bigLabel">Add photo</label><br>
                    <button class="btn btn-primary" id="uploadImageButton">
                        <span class="glyphicon glyphicon-camera"></span>
                    </button>

                </div>
            </div>

            <div class="form-group">
                    <label>Prices</label>
                    <div id="prices"></div>
                    <button class="btn btn-primary" id="addPricesButton"><span class="glyphicon glyphicon-plus"></span> Add</button>
            </div>

            <!--<div class="form-group">-->
                <!--<label for="productPriceInput">Product Price</label>-->
                <!--<div class="input-group">-->
                    <!--<span class="input-group-addon">$</span>-->
                    <!--<input id="productPriceInput" placeholder="Amount in dollars" class="form-control" value="<%=model.get('price')%>">-->
                <!--</div>-->
            <!--</div>-->
            <div class="form-group" >
                <label>Product Details</label>
                <ol id="detailsGroup">
                </ol>
                <button class="btn btn-primary" id="addDetailsButton"><span class="glyphicon glyphicon-plus"></span> Add</button>
            </div>
            <!--        <div class="form-group">-->
            <!--            <label for="productNameInput">Product Name</label>-->
            <!--            <input id="productNameInput" placeholder="Enter product name" class="form-control">-->
            <!--        </div>-->

            <div class="smallVerticalSpacer"></div>
            <button class="btn btn-success pull-right footerButton" id="submitButton"><span class="glyphicon glyphicon-save"></span> Save</button>
            <a href="landing.php" class="btn btn-warning pull-right footerButton"><span class="glyphicon glyphicon-ban-circle"></span> Cancel</a>
        </form>
        <form id="imageForm">
            <input type="hidden" name="productId" id="productId" value="<%=model.get('productId')%>">
            <input type="file" name="file_upload" id="file_upload">
        </form>
    </script>

    <script type="text/template" id="imageLoaded_template">
        <div class="thumbnailDiv center">
            <image src="../<%=model.get('thumbnail')%>" class="img-rounded">
            <div class="captionArea">
                <input type="text" placeholder="Title..." class="form-control" id="titleInput" value="<%=model.get('imageTitle')%>">
                <textarea id="captionTxt" placeholder="Enter you caption here..." class="form-control"><%=model.get('caption')%></textarea>
            </div>
            <a href="#" id="removeImageLink">Remove</a>
        </div>
    </script>

    <script type="text/template" id="categorylist_template">
        <%=model.get('name')%>
    </script>

    <script type="text/template" id="productdetail_template">
        <li type="1">
            <input type="text" class="productDetail inline form-control" data-productdetailitemid="<%=model.get('productDetailItemId')%>"
            data-ordernumber="<%=model.get('orderNumber')%>" value="<%=model.get('description')%>">
            <button type="button" class="close removeDetail" aria-hidden="true">&times;</button>
        </input></li>
    </script>


    <script type="text/template" id="prices_template">
        <div class="price">
            <div class="container">
                <div class="row">
                    <div class="col-md-3">
                        <div class="input-group">
                            <span class="input-group-addon">$</span>
                            <input class="productPrice form-control" placeholder="Amount in dollars" value="<%=model.get('price')%>">
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="checkbox">
                            <label>Price from?
                                <input type="checkbox" class="priceFrom">
                            </label>
                        </div>
                    </div>
                    <div class="col-md-1">OR</div>
                    <div class="col-md-3">
                        <div class="checkbox">
                            <label for="productPrice">Product Price on request?
                                <input type="checkbox" class="priceOnRequestChk">
                            </label>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-8">
                        <input class="priceDiscriminator form-control" placeholder="Enter if price conditional" value="<%=model.get('priceDiscriminator')%>">
                    </div>
                </div>
            </div>
            <a href="#" class="removePrice">Remove</a>
       </div>
    </script>
</section>




    <script language="Javascript" src="../js/libraries/jquery2.0.3.js"></script>
    <script language="JavaScript" src="../js/libraries/underscore-1.5.2-min.js"></script>
    <script language="Javascript" src="../bootstrap/js/bootstrap.js"></script>
    <script language="JavaScript" src="../js/libraries/backbone-1.1.0-min.js"></script>
    <script language="JavaScript" src="js/basiccollectionsmodels.js"></script>
    <script language="JavaScript" src="js/editproduct/categoryOptions_view.js"></script>
    <script language="JavaScript" src="js/editproduct/productEdit_view.js"></script>
    <script language="JavaScript" src="js/editproduct/productEdit_app.js"></script>
    <script language="Javascript" src="../ckeditor4/ckeditor.js"></script>
    <script>
        var categories;

        $(document).ready(function() {
            var productId = <?=$productId?>;
            var newProduct = <?= $newProduct === true ? 'true' :  'false'?>;
            categories = new ablefutures.cadmedical.collections.categories();
            categories.reset(<?=json_encode($categories)?>);

            ablefutures.cadmedical.app.newproduct.init(newProduct, productId, categories);
        });
    </script>

</body>
</html>