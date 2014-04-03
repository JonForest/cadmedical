<?php
/**
 * @author: Jonathan Hollingsworth
 * @description: Product
 */

// Required files
require $_SERVER["DOCUMENT_ROOT"]."/cadmedical/api/common/dbconnection.php";
require $_SERVER["DOCUMENT_ROOT"]."/cadmedical/api/classes/helper/category.helper.php";

$categoryId = isset($_GET['c']) ? $_GET['c'] : 0;

//Prepare the categories object for bootstrapping into the page
$categoryHelper = new CategoryHelper($con);
$categories = $categoryHelper->getAllCategories();

?>

<!DOCTYPE html>
<html>
<head>
    <title></title>
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="bootstrap/css/bootstrap-theme.css">
    <link rel="stylesheet" type="text/css" href="css/site_old.css">
    <link rel="stylesheet" type="text/css" href="css/site.css">
</head>
<body>

<div class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container-fluid">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.php">CADMEDICAL<br>IMAGING</a></a>
                <span class="hidden-xs hidden-sm hidden-md logo">'Quality Radiation Protection'</span>

                <div class="hidden-lg categoriesDropDown" id="categoriesListSmall">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">Categories <b class="caret"></b></a>
                </div>
            </div>
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav navbar-right">

                    <li><a href="content.php?r=about"><span class="glyphicon glyphicon-question-sign hidden-xs hidden-sm"></span><br>About</a></li>
                    <li><a href="content.php?r=contact"><span class="glyphicon glyphicon-earphone hidden-xs hidden-sm"></span><br>Contact Us</a></li>
                    <li class="hidden-xs hidden-sm"><form class="navbar-form navbar-left search" role="search">
                        <div class="form-group">
                            <input type="text" class="form-control" placeholder="Search">
                        </div>
                        <button type="submit" class="btn btn-default">Submit</button>
                    </form></li>
                </ul>

                    <div class="nav navbar-nav navbar-left hidden-xs hidden-sm hidden-md" id="categoriesList"></div>
            </div>
    </div>
</div>

<section class="hero-home">
    <div>A <span class="stand-out">difference</span> in medical imaging</div>
    <div class="subText">World class products at world beating value</div>
</section>


<div class="body">

    <div id="wrap">

    <div class="container main">
        <div class="row">
            <div class="col-md-6 col-md-offset-2">
                <p>Aotearoa medical imaging company. Clinical and academic diagnostic imaging is our specialty. We provide quality radiographic equipment to New Zealand.</p>

            </div>
            <div class="col-md-2 col-md-offset-1">
                <div class="thumbnail">
                    <img src="images/maxx10.jpg" alt="Maxx 10 Eyewear">
                    <div class="caption">
                        <h4>Maxx 10</h4>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-2 col-md-offset-2">
                <div class="thumbnail">
                    <img src="images/525_harmony.jpg" alt="Harmony Thyroid Shield">
                    <div class="caption">
                        <h4>Harmony</h4>
                    </div>
                </div>
            </div>
            <div class="col-md-6 col-md-offset-1">
                <p>We bring to you the highest quality engineered goods, and the most advanced world leading technologies, all at excellent value. We provide lightweight materials to protect you from prolonged weight bearing injury, without compromising radiation protection.</p>
            </div>

        </div>

        <div class="row">
            <div class="col-md-6 col-md-offset-2">
                <p>We welcome you to expedite our friendly teams extensive imaging knowledge, giving you accurate and up to date advice with helpful instruction. Our aim is to provide New Zealand with a excellent service, at world beating value!</p>
            </div>
            <div class="col-md-2 col-md-offset-1">
                <div class="thumbnail">
                    <img src="images/optima.jpg" alt="Optima Partial Overlap">
                    <div class="caption">
                        <h4>Optima Partial Overlap</h4>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
</div>

<section id="footer" class="navbar navbar-inverse">
    <div class="col-md-8 col-md-offset-2 col-lg-6 col-lg-offset-3 col-xs-12 col-sm-12">
        <ul class="nav navbar-nav">
            <li><a href="content.php?r=about"><span class="glyphicon glyphicon-question-sign"></span> About</a></li>
            <li><a href="content.php?r=contact"><span class="glyphicon glyphicon-earphone"></span> Contact Us</a></li>
            <li><a href="content.php?r=returns"><span class="glyphicon glyphicon-repeat"></span> Returns Policy</a></li>
            <li><a href="content.php?r=legal"><span class="glyphicon glyphicon-pencil"></span> Company Info / Legal</a></li>
        </ul>
    </div>
</section>


<section id="templates">
    <script type="text/template" id="categoriesNav_template">
        <li <%=model.get('selected')%>><a href="product.php?c=<%=model.get('categoryId')%>">
            <%=model.get('name').toUpperCase()%>
        </a></li>
    </script>
</section>


<script language="javascript" src="js/libraries/jquery2.0.3.js"></script>
<script language="JavaScript" src="js/libraries/underscore-1.5.2-min.js"></script>
<script language="javascript" src="bootstrap/js/bootstrap.js"></script>
<script language="JavaScript" src="js/libraries/backbone-1.1.0-min.js"></script>
<script language="JavaScript" src="admin/js/basiccollectionsmodels.js"></script>
<script language="JavaScript" src="js/navigation/categoriesNav_view.js"></script>
<script language="JavaScript" src="js/navigation/categoriesNavSmall_view.js"></script>
<script language="JavaScript" src="js/site.js"></script>
<script>
$(document).ready(function() {
    var categories = new ablefutures.cadmedical.collections.categories();
    categories.reset(<?=json_encode($categories)?>);
    var categoryId = <?= $categoryId?>;

    var categoriesNavView =  new ablefutures.cadmedical.views.categoriesNav(
        {collection : categories,
            categoryId : categoryId});
    $('#categoriesList').append(categoriesNavView.render().el);

    var categoriesNavViewSmall =  new ablefutures.cadmedical.views.categoriesNavSmall(
        {collection : categories,
            categoryId : categoryId});
    $('#categoriesListSmall').append(categoriesNavViewSmall.render().el);


})
</script>

</body>
</html>