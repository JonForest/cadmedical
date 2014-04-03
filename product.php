<?php
/**
 * @author: Jonathan Hollingsworth
 * @description: Product
 */

// Required files
require $_SERVER["DOCUMENT_ROOT"]."/cadmedical/api/common/dbconnection.php";
require $_SERVER["DOCUMENT_ROOT"]."/cadmedical/api/classes/helper/category.helper.php";
require $_SERVER["DOCUMENT_ROOT"]."/cadmedical/api/classes/helper/product.helper.php";

$categoryId = isset($_GET['c']) ? $_GET['c'] : 0;

//Prepare the categories object for bootstrapping into the page
$categoryHelper = new CategoryHelper($con);
$categories = $categoryHelper->getAllCategories();

$productHelper = new ProductHelper($con);
$products = $productHelper->getProducts($categoryId);

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

<div id="wrap">
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
                            <button type="submit" class="btn btn-primary">Submit</button>
                        </form></li>
                </ul>

                <div class="nav navbar-nav navbar-left hidden-xs hidden-sm hidden-md" id="categoriesList"></div>
            </div>
        </div>
    </div>

<!--    <section class="hero-home" id="heroText">-->
<!--    <!--    <div>A <span class="stand-out">difference</span> in medical imaging</div>-->-->
<!--    <!--    <div class="subText">World class products at world beating value</div>-->-->
<!--    </section>-->
    <section id="categoryCommon" class="container">

    </section>



    <section class="bodyproduct">

        <div class="container main">
            <div class="row">
                <div class="col-lg-2 hidden-xs hidden-sm hidden-md">
                    <div class="list-group navbar" id="mynav">
                        <ul class="nav" id="productNavItems">

                        </ul>
                    </div>
                </div>


                <div class="col-md-8 col-lg-8 col-lg-offset-1" id="products">


                </div>
            </div>
        </div>

    </section>

</div> <!-- wrap -->





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

    <script type="text/template" id="categoryHeroText_template">
        <div class="hero-home row">
            <%=model.get('heroText')%>
        </div>
        <%if (model.get('details')) {%>
            <div class="row" id="detailsDiv">
                <div class="col-md-2 hidden-xs hidden-sm"></div>
                <div class="col-md-8">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-2 hidden-xs hidden-sm"></div>
                            <div class="col-md-8 col-sm-12 col-xs-12 categoryDetails">
                                <%=model.get('details')%>
                            </div>
                            <div class="col-md-2 hidden-xs hidden-sm"></div>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 hidden-xs hidden-sm"></div>
            </div>
        <% } %>

    </script>


    <script type="text/template" id="product_template">
        <div class="well">
        <div class="row">
            <div class="col-md-12">
                <h2><%=model.get('name')%></h2>
                 <div class="cost">Cost:</div>
                 <div class="prices">
                 </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-7">
                <div class="productDetails">
                    <div class="productHeader">Details:</div>
                    <div id="productDetailsList">
                    </div>
                </div>
            </div>
            <div class="col-md-5" id="productImage">

            </div>
        </div>
            </div>
    </script>

    <script type="text/template"  id="imageview_template">
        <div class="thumbnail">
            <img src="images/common/<%=model.get('imagePath')%>" alt="<%=model.get('imageTitle')%>">
            <div class="caption">
                <h4><%=model.get('imageTitle')%></h4>
                <p><%=model.get('caption')%></p>
            </div>
        </div>
    </script>

    <script type="text/template"  id="productsNav_template">
        <a href="#<%=model.get('productId')%>" class="list-group-item">
            <%=model.get('name')%>
        </a>
    </script>

    <script type="text/template" id="price_template">

            <%if (model.get('priceOnRequest')) {%>
                <div class="costAmount">Price on request</div>
            <%} else {%>
                <%=model.get('priceFrom') ? 'From ' : '' %><div class="costAmount">$<%=model.get('price')%></div>
            <% } %>
            <% if (model.get('priceDiscriminator')) { %>
                - <%=model.get('priceDiscriminator')%>
            <% } %>
        </div>
    </script>

    <script type="text/template" id="categoryDetail_template">
        <li><%=model.get('description')%></li>
    </script>

    <script type="text/template" id="productModal_template">
        <div class="modal fade" id="productModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title" id="productModalTitle">Sizing Information</h4>
                    </div>
                    <div class="modal-body" id="productModalBody">
                        <%=model.get('sizingHtml')%>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-success" data-dismiss="modal">Close</button>
                    </div>
                </div>
         </div>
      </div>
    </script>

</section>


<script language="javascript" src="js/libraries/jquery2.0.3.js"></script>
<script language="JavaScript" src="js/libraries/underscore-1.5.2-min.js"></script>
<script language="javascript" src="bootstrap/js/bootstrap.js"></script>
<script language="JavaScript" src="js/libraries/backbone-1.1.0-min.js"></script>
<script language="JavaScript" src="admin/js/basiccollectionsmodels.js"></script>
<script language="JavaScript" src="js/navigation/categoriesNav_view.js"></script>
<script language="JavaScript" src="js/navigation/categoriesNavSmall_view.js"></script>
<script language="JavaScript" src="js/navigation/productsNav_view.js"></script>
<script language="JavaScript" src="js/product/categoriesCommon_view.js"></script>
<script language="JavaScript" src="js/product/image_view.js"></script>
<script language="JavaScript" src="js/product/detail_view.js"></script>
<script language="JavaScript" src="js/product/details_view.js"></script>
<script language="JavaScript" src="js/product/price_view.js"></script>
<script language="JavaScript" src="js/product/prices_view.js"></script>
<script language="JavaScript" src="js/product/product_view.js"></script>

<!--<script language="JavaScript" src="js/site.js"></script>-->
<script language="JavaScript">
    $(document).ready(function() {
        var categories = new ablefutures.cadmedical.collections.categories();
        categories.reset(<?=json_encode($categories)?>, {parse : true});
        var categoryId = <?= $categoryId?>;

        var categoriesNavView =  new ablefutures.cadmedical.views.categoriesNav(
            {collection : categories,
            categoryId : categoryId});
        $('#categoriesList').append(categoriesNavView.render().el);

        var categoriesNavViewSmall =  new ablefutures.cadmedical.views.categoriesNavSmall(
            {collection : categories,
                categoryId : categoryId});
        $('#categoriesListSmall').append(categoriesNavViewSmall.render().el);

        var catModel;
        catModel = null;

        categories.each(function(model) {
            if (parseInt(model.get('categoryId')) === parseInt(categoryId)) {
                catModel = model;
            }
        });

        var heroTextView = new ablefutures.cadmedical.views.categoriesCommon({model:catModel});
        $('#categoryCommon').append(heroTextView.render().el);

        var $products = $('#products');
        var $productNavItems = $('#productNavItems');
        $products.empty();
        //$productNavItems.empty();
        var products = new ablefutures.cadmedical.collections.products();
        products.fetch({
            data : {categoryId : categoryId},
            success: function(collection, response, options) {
                collection.each(function(model) {
                    var productView = new ablefutures.cadmedical.views.product({model:model});
                    $products.append(productView.render().$el);

                    var productsNav = new ablefutures.cadmedical.views.productsNav({model : model});
                    $productNavItems.append(productsNav.render().$el);
                });

                $('body').scrollspy({ target: '#mynav' });
                $('#mynav').affix(
                    {
                        offset: {
                            top: 200 + $('#detailsDiv').height() //$('#categoryDetailsList').closest('.wellCategoryCommon').parent().height()
                        }
                    }
                );
            },

            error : function() {
                console.log('Failed to retrieve product');
            }
        });


    })
</script>

</body>
</html>