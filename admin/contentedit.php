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
require $_SERVER["DOCUMENT_ROOT"]. $path . "/api/common/dbconnection.php";
require $_SERVER["DOCUMENT_ROOT"]. $path . "/api/common/checkpermissions.php";
require $_SERVER["DOCUMENT_ROOT"]. $path . "/api/classes/helper/page.helper.php";


$pageId = $_REQUEST['p'];
if (isset($pageId)) {
    //Prepare the pages object for bootstrapping into the page
    $pageHelper = new pageHelper();
    $page = $pageHelper->getPage($pageId);
}

?>

<html>
<head>
    <title></title>
    <link rel="stylesheet" type="text/css" href="../bootstrap/css/bootstrap.css">
    <link rel="stylesheet" type="text/css" href="../bootstrap/css/bootstrap-theme.css">
    <link rel="stylesheet" type="text/css" href="../bootstrap/css/bootstrap-switch.min.css">
    <link rel="stylesheet" type="text/css" href="../css/site_old.css">
    <link rel="stylesheet" type="text/css" href="../css/site.css">
    <link rel="stylesheet" type="text/css" href="css/admin.css">
</head>
<body>

<h1>Edit Content - </h1>

<section>
    <div class="container">
        <div class="row">
            <div class="col-md-2"></div>
            <div class="col-md-8" id="body">


                <ul class="nav nav-tabs">
                    <li class="active"><a href="#edit" data-toggle="tab">Edit</a></li>
                    <li><a href="#preview" data-toggle="tab">Preview</a></li>
                </ul>

              <div id="tabContent">

              </div>

            </div>
            <div class="col-md-2"></div>
        </div>
    </div>


</section>





<section id="templates">
    <script type="text/template" id="contentEdit_template">
        <div class="tab-content">
            <div class="tab-pane active" id="edit">
                <form class="form-horizontal">
                    <div class="form-group">
                        <label for="pageName">Name of Page</label>
                        <input type="text" id="pageName" class="form-control" value="<%=model.get('title')%>">
                    </div>
                    <div class="form-group">
                        <label for="reference">Reference (no spaces)</label>
                        <input type="text" id="reference" class="form-control" value="<%=model.get('reference')%>">
                    </div>

                    <div class="form-group">
                        <label for="heroText">HeroText</label>
                        <textarea id="heroText" class="form-control"><%=model.get('heroText')%></textarea>
                    </div>

                    <pre class="aceEditor" id="pageContent"></pre>
                </form>

            </div>
            <div class="tab-pane" id="preview">
                <h1 id="pageNamePreview"></h1>
                <h3 id="referencePreview"></h3>

                <div class="form-group">
                    <div id="heroTextPreview" class="hero-edit">
                    <%=model.get('heroText')%>
                </div>


                <div id="pagePreview" class="aceEditor main">

                </div>
            </div>
        </div>

        <button class="btn btn-success pull-right footerButton" id="submitButton"><span class="glyphicon glyphicon-save"></span> Save</button>
        <a href="landing.php?a=content" class="btn btn-warning pull-right footerButton"><span class="glyphicon glyphicon-ban-circle"></span> Cancel</a>
    </script>

</section>




<script language="Javascript" src="../js/libraries/jquery2.0.3.js"></script>
<script language="JavaScript" src="../js/libraries/underscore-1.5.2-min.js"></script>
<script language="Javascript" src="../bootstrap/js/bootstrap.js"></script>
<script language="Javascript" src="../bootstrap/js/bootstrap-switch.min.js"></script>
<script language="JavaScript" src="../js/libraries/backbone-1.1.0-min.js"></script>
<script language="JavaScript" src="js/basiccollectionsmodels.js"></script>
<script language="JavaScript" src="js/editcontent/pageEdit_view.js"></script>
<!--<script language="JavaScript" src="js/editcontent/categoryEdit_view.js"></script>-->
<script src="../src-min/ace.js" type="text/javascript" charset="utf-8"></script>
<script>
    var page;
    var editor;
    var contentView;




    var editorEvents = function() {
        var syncHtml;

        editor.getSession().on('change', function(){
            syncHtml();
        });

        syncHtml = function() {
            $('#pagePreview').html(editor.getSession().getValue());
        };

        return {
            syncHtml : syncHtml
        }
    };



    $(document).ready(function() {
        page = new ablefutures.cadmedical.models.page(<?=json_encode($page)?>, {parse : true});
        contentView = new ablefutures.cadmedical.views.pageEdit(
            {model : page,
            el : '#tabContent'}
        );

        contentView.render();

        editor = ace.edit("pageContent");
        editor.setTheme("ace/theme/twilight");
        editor.getSession().setMode("ace/mode/html");
        editor.session.setValue(page.get('content').get('html'));

        editorEvents();
        editorEvents().syncHtml();

    });
</script>

</body>
</html>


