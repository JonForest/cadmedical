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

$categoryId = $_REQUEST['c'];
$isNewCategory = false;
if (!isset($categoryId)) {
    //CategoryId has not been set, so must be a new category
    $isNewCategory = true;
}




?>

<html>
<head>
    <title></title>
    <link rel="stylesheet" type="text/css" href="../bootstrap/3.0.3/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="../bootstrap/3.0.3/css/bootstrap-theme.css">
    <link rel="stylesheet" type="text/css" href="../bootstrap/3.0.3/css/bootstrap-switch.min.css">
    <link rel="stylesheet" type="text/css" href="../css/site.css">
    <link rel="stylesheet" type="text/css" href="css/admin.css">
</head>
<body>

<h1>Add/Edit Category - <?=$categoryId?></h1>

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
    <script type="text/template" id="categoryedit_template">
        <form role="form" class="form-horizontal" id="editProductForm">
            <div class="form-group">
                <label for="categoryNameInput">Category Name</label>
                <input type="text" id="categoryNameInput" class="form-control" value="<%=model.get('name')%>">
            </div>
            <div class="form-group">
                <label for="heroTextTxt">HeroText</label>
                <textarea id="heroTextTxt" class="form-control" ><%=model.get('heroText')%></textarea>
            </div>
            <div class="form-group">
                <label for="heroTextPreview">HeroText Preview:</label>
                <div id="heroTextPreview" class="hero-edit">
                    <%=model.get('heroText')%>
                </div>
            </div>

            <div class="form-group">
                <label for="details">Category Details:</label>
                <textarea id="details" class="form-control"><%=model.get('details')%></textarea>
            </div>
            <div class="form-group">
                <label for="detailsPreview">Category Details Preview:</label>
                <div id="detailsPreview" class="">
                    <%=model.get('details')%>
                </div>
            </div>

            <!--<div class="form-group">-->
                <!--<ul id="commonDetails">-->
                <!--</ul>-->
            <!--</div>-->

            <!--<div class="form-group" >-->
                <!--<ul id="previewCommonDetails">-->
                <!--</ul>-->
                <!--<button class="btn btn-primary" id="addDetailsButton"><span class="glyphicon glyphicon-plus"></span> Add</button>-->
            <!--</div>-->

            <div class="form-group">
                <label for="sizingRequiredChk">Does this page require sizing information?  </label>
                <input type="checkbox" id="sizingRequiredChk" data-size="small" data-on-text="YES" data-off-text="NO">
            </div>

            <div id="sizingInfo" class="hidden">
                <div class="form-group">
                    <label for="sizingTxt">Sizing information</label>
                    <textarea id="sizingTxt" class="form-control"><%=model.get('sizingHtml')%></textarea>
                </div>
                <div class="form-group">
                    <label for="sizingPreview">Sizing Information Preview:</label>
                    <div id="sizingPreview"><%=model.get('sizingHtml')%></div>
                </div>
            </div>


            <button class="btn btn-success pull-right footerButton" id="submitButton"><span class="glyphicon glyphicon-save"></span> Save</button>
            <a href="landing.php" class="btn btn-warning pull-right footerButton"><span class="glyphicon glyphicon-ban-circle"></span> Cancel</a>
        </form>



    </script>


    <script type="text/template" id="commonDetails_template">
        <li type="1">
            <input type="text" class="categoryDetail inline form-control" data-categorydetailitemid="<%=model.get('productDetailItemId')%>"
                   data-ordernumber="<%=model.get('orderNumber')%>" value="<%=model.get('description')%>">
                <button type="button" class="close removeDetail" aria-hidden="true">&times;</button>

        </input></li>
    </script>

    <script type="text/template" id="previewCommonDetails_template">

    </script>
</section>




<script language="Javascript" src="../js/libraries/jquery2.0.3.js"></script>
<script language="JavaScript" src="../js/libraries/underscore-1.5.2-min.js"></script>
<script language="Javascript" src="../bootstrap/3.0.3/js/bootstrap.js"></script>
<script language="Javascript" src="../bootstrap/3.0.3/js/bootstrap-switch.min.js"></script>
<script language="JavaScript" src="../js/libraries/backbone-1.1.0-min.js"></script>
<script language="JavaScript" src="js/basiccollectionsmodels.js"></script>
<script language="JavaScript" src="js/editcategory/categoryEdit_view.js"></script>
<script language="JavaScript" src="js/editcategory/categoryEdit_app.js"></script>
<script language="Javascript" src="../ckeditor4/ckeditor.js"></script>
<script>
    var categories;

    $(document).ready(function() {
        var isNewCategory= <?= $isNewCategory === true ? 'true' :  'false'?>;
        categories = new ablefutures.cadmedical.collections.categories();
        categories.reset(<?=json_encode($categories)?>, {parse : true});

        ablefutures.cadmedical.app.categoryEdit.init(isNewCategory, categories.get(<?=$categoryId?>));

        $('#sizingRequiredChk').bootstrapSwitch();
    });
</script>

</body>
</html>


