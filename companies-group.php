<?php
//classes loading begin
    function classLoad ($myClass) {
        if(file_exists('model/'.$myClass.'.php')){
            include('model/'.$myClass.'.php');
        }
        elseif(file_exists('controller/'.$myClass.'.php')){
            include('controller/'.$myClass.'.php');
        }
    }
    spl_autoload_register("classLoad"); 
    include('config.php');  
    include ('lib/pagination.php');
    //classes loading end
    session_start();
    if( isset($_SESSION['userMerlaTrav']) ){
        //les sources
        $societesManager = new SocieteManager($pdo);
        $societes = $societesManager->getSocietes();
        $societeNumber = $societesManager->getSocietesNumber();
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
    <meta charset="utf-8" />
    <title>GELM - Management Application</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport" />
    <meta content="" name="description" />
    <meta content="" name="author" />
    <link href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
    <link href="assets/css/metro.css" rel="stylesheet" />
    <link href="assets/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" />
    <link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
    <link href="assets/css/style.css" rel="stylesheet" />
    <link href="assets/css/style_responsive.css" rel="stylesheet" />
    <link href="assets/css/style_default.css" rel="stylesheet" id="style_color" />
    <link href="assets/fancybox/source/jquery.fancybox.css" rel="stylesheet" />
    <link rel="stylesheet" type="text/css" href="assets/uniform/css/uniform.default.css" />
    <link rel="stylesheet" type="text/css" href="assets/chosen-bootstrap/chosen/chosen.css" />
    <link rel="stylesheet" type="text/css" href="assets/bootstrap-datepicker/css/datepicker.css" />
    <link rel="stylesheet" href="assets/data-tables/DT_bootstrap.css" />
    <link rel="stylesheet" type="text/css" href="assets/uniform/css/uniform.default.css" />
    <link rel="shortcut icon" href="favicon.ico" />
</head>
<!-- END HEAD -->
<!-- BEGIN BODY -->
<body class="fixed-top">
    <!-- BEGIN HEADER -->
    <div class="header navbar navbar-inverse navbar-fixed-top">
        <!-- BEGIN TOP NAVIGATION BAR -->
        <?php include("include/top-menu.php"); ?>   
        <!-- END TOP NAVIGATION BAR -->
    </div>
    <!-- END HEADER -->
    <!-- BEGIN CONTAINER -->
    <div class="page-container row-fluid sidebar-closed">
        <!-- BEGIN SIDEBAR -->
        <?php include("include/sidebar.php"); ?>
        <!-- END SIDEBAR -->
        <!-- BEGIN PAGE -->
        <div class="page-content">
            <!-- BEGIN PAGE CONTAINER-->            
            <div class="container-fluid">
                <!-- BEGIN PAGE HEADER-->
                <div class="row-fluid">
                    <div class="span12">
                        <!-- BEGIN PAGE TITLE & BREADCRUMB-->           
                        <h3 class="page-title">
                            Gestion des sociétés
                        </h3>
                        <ul class="breadcrumb">
                            <li>
                                <i class="icon-home"></i>
                                <a href="dashboard.php">Accueil</a> 
                                <i class="icon-angle-right"></i>
                            </li>
                            <li>
                                <i class="icon-sitemap"></i>
                                <a>Gestion des sociétés</a>
                            </li>
                        </ul>
                        <!-- END PAGE TITLE & BREADCRUMB-->
                    </div>
                </div>
                <!-- END PAGE HEADER-->
                <!-- BEGIN PAGE CONTENT-->
                <div class="row-fluid">
                    <div class="span12">
                        <?php if(isset($_SESSION['company-add-success'])){ ?>
                            <div class="alert alert-success">
                                <button class="close" data-dismiss="alert"></button>
                                <?= $_SESSION['company-add-success'] ?>     
                            </div>
                         <?php } 
                            unset($_SESSION['company-add-success']);
                         ?>
                         <?php if(isset($_SESSION['company-add-error'])){ ?>
                            <div class="alert alert-error">
                                <button class="close" data-dismiss="alert"></button>
                                <?= $_SESSION['company-add-error'] ?>       
                            </div>
                         <?php } 
                            unset($_SESSION['company-add-error']);
                         ?>
                         <?php if(isset($_SESSION['company-update-success'])){ ?>
                            <div class="alert alert-success">
                                <button class="close" data-dismiss="alert"></button>
                                <?= $_SESSION['company-update-success'] ?>      
                            </div>
                         <?php } 
                            unset($_SESSION['company-update-success']);
                         ?>
                        <?php if(isset($_SESSION['company-update-error'])){ ?>
                            <div class="alert alert-error">
                                <button class="close" data-dismiss="alert"></button>
                                <?= $_SESSION['company-update-error'] ?>        
                            </div>
                         <?php } 
                            unset($_SESSION['company-update-error']);
                         ?> 
                        <?php if(isset($_SESSION['company-delete-success'])){ ?>
                            <div class="alert alert-success">
                                <button class="close" data-dismiss="alert"></button>
                                <?= $_SESSION['company-delete-success'] ?>      
                            </div>
                         <?php } 
                            unset($_SESSION['company-delete-success']);
                         ?>
                        <!-- BEGIN EXAMPLE TABLE PORTLET-->
                        <!--div class="span12"-->
                            <div class="add-portfolio">
                                <div class="pull-left">
                                    <span><?= $societeNumber ?> Sociétés en Total</span>
                                </div>
                                <?php
                                if ( $_SESSION['userMerlaTrav']->profil() == "admin" ) { 
                                ?>
                                <div class="pull-right">
                                    <a href="#addSociete" data-toggle="modal" class="btn icn-only green">Ajouter une société <i class="icon-plus-sign m-icon-white"></i></a>                                    
                                </div>
                                <?php
                                } 
                                ?>
                            </div>
                            <!--end add-portfolio-->
                            <!-- addSociete box begin-->
                            <div id="addSociete" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
                                <div class="modal-header">
                                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                    <h3>Nouvelle Société </h3>
                                </div>
                                <div class="modal-body">
                                    <form class="form-horizontal" action="controller/SocieteAddController.php" method="post">
                                        <div class="control-group">
                                            <label class="control-label">Raison Sociale</label>
                                            <div class="controls">
                                                <input type="text" name="raisonSociale" value="" />
                                            </div>
                                        </div>
                                        <div class="control-group">
                                            <label class="control-label">Date de création</label>
                                            <div class="controls date date-picker" data-date="" data-date-format="yyyy-mm-dd">
                                                <input name="dateCreation" id="dateCreation" class="m-wrap m-ctrl-small date-picker" type="text" value="<?= date('Y-m-d') ?>" />
                                                <span class="add-on"><i class="icon-calendar"></i></span>
                                             </div>
                                        </div>
                                        <div class="control-group">
                                            <div class="controls">  
                                                <button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
                                                <button type="submit" class="btn red" aria-hidden="true">Oui</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <!-- addSociete box end -->
                            <!--div class="row-fluid"-->
                                <?php
                                foreach($societes as $societe){
                                ?>
                                <div class="span4 get-down">
                                    <a href="company.php?idSociete=<?= $societe->id() ?>" class="btn green big fixed-size-xl">
                                        Société <strong><?= ucfirst($societe->raisonSociale()) ?></strong>
                                    </a>
                                </div> 
                                <?php }//end foreach loop for projets elements ?>
                            <!--/div-->
                        <!--/div-->
                        <!-- END EXAMPLE TABLE PORTLET-->
                    </div>
                </div>
                <!-- END PAGE CONTENT -->
            </div>
            <!-- END PAGE CONTAINER-->
        </div>
        <!-- END PAGE -->
    </div>
    <!-- END CONTAINER -->
    <!-- BEGIN FOOTER -->
    <div class="footer">
        2015 &copy; GELM. Management Application.
        <div class="span pull-right">
            <span class="go-top"><i class="icon-angle-up"></i></span>
        </div>
    </div>
    <!-- END FOOTER -->
    <!-- BEGIN JAVASCRIPTS -->
    <!-- Load javascripts at bottom, this will reduce page load time -->
    <script src="assets/js/jquery-1.8.3.min.js"></script>   
    <script src="assets/breakpoints/breakpoints.js"></script>   
    <script src="assets/bootstrap/js/bootstrap.min.js"></script>        
    <script src="assets/js/jquery.blockui.js"></script>
    <script src="assets/js/jquery.cookie.js"></script>
    <script type="text/javascript" src="assets/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
    <script type="text/javascript" src="assets/bootstrap-daterangepicker/date.js"></script>
    <!-- ie8 fixes -->
    <!--[if lt IE 9]>
    <script src="assets/js/excanvas.js"></script>
    <script src="assets/js/respond.js"></script>
    <![endif]-->    
    <script type="text/javascript" src="assets/uniform/jquery.uniform.min.js"></script>
    <script type="text/javascript" src="assets/data-tables/jquery.dataTables.js"></script>
    <script type="text/javascript" src="assets/data-tables/DT_bootstrap.js"></script>
    <script src="assets/js/app.js"></script>        
    <script>
        jQuery(document).ready(function() {         
            // initiate layout and plugins
            //App.setPage("table_editable");
            App.init();
        });
    </script>
</body>
<!-- END BODY -->
</html>
<?php
}
else{
    header('Location:index.php');    
}
?>