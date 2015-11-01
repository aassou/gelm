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
    include('lib/pagination.php');
    //classes loading end
    session_start();
    if(isset($_SESSION['userMerlaTrav']) and $_SESSION['userMerlaTrav']->profil()=="admin"){
        //class managers
        $projetManager = new ProjetManager($pdo);
        $caisseDetailsManager = new CaisseDetailsManager($pdo);
        $caisseManager = new CaisseManager($pdo);
        //objects
        $projets = $projetManager->getProjets();
        $idCaisse = $_GET['idCaisse'];
        $entrees = $caisseDetailsManager->getCaisseDetailsByIdCaisse($idCaisse);
        $caisse = $caisseManager->getCaisseById($idCaisse);
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
                            Détails de la caisse : <strong><?= $caisse->nom() ?></strong>
                        </h3>
                        <ul class="breadcrumb">
                            <li>
                                <i class="icon-home"></i>
                                <a href="dashboard.php">Accueil</a> 
                                <i class="icon-angle-right"></i>
                            </li>
                            <li>
                                <i class="icon-bar-chart"></i>
                                <a href="caisses.php">Gestion de la caisse</a>
                                <i class="icon-angle-right"></i>
                            </li>
                            <li>
                                <a>Détails de caisse</a>
                            </li>
                        </ul>
                        <!-- END PAGE TITLE & BREADCRUMB-->
                    </div>
                </div>
                <!-- END PAGE HEADER-->
                <!-- BEGIN PAGE CONTENT-->
                <div class="row-fluid">
                    <a class="btn green pull-right" data-toggle="modal" href="#addCaisseDetails">
                        <i class="icon-plus-sign"></i>
                        Nouvelle Opération                                  
                    </a>
                    <a href="#printCaisseDetails" class="btn blue pull-left" data-toggle="modal">
                        <i class="icon-print"></i>&nbsp;Détails de Caisse
                    </a>
                </div>
                <!-- printCaisseDetails box begin-->
                <div id="printCaisseDetails" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                        <h3>Imprimer Détails de Caisse <?= $caisse->nom() ?> </h3>
                    </div>
                    <div class="modal-body">
                        <form class="form-horizontal" action="controller/CaisseDetailsPrintController.php" method="post" enctype="multipart/form-data">
                            <div class="control-group">
                                <label class="control-label">Mode Impression</label>
                                <div class="controls">
                                    <label class="radio">
                                        <input type="radio" class="duree" name="duree" value="all" checked/>
                                        Tous les détails
                                    </label>
                                    <label class="radio">
                                        <input type="radio" class="duree" name="duree" value="date" />
                                        Par date
                                    </label>
                                </div>
                            </div>
                            <div class="control-group" id="dateRange" style="display: none">
                                <div class="controls date date-picker" data-date="" data-date-format="yyyy-mm-dd">
                                   <input style="width:100px" name="dateFrom" id="dateFrom" class="m-wrap m-ctrl-small date-picker" type="text" value="<?= date('Y-m-d') ?>" />
                                   &nbsp;-&nbsp;
                                   <input style="width:100px" name="dateTo" id="dateTo" class="m-wrap m-ctrl-small date-picker" type="text" value="<?= date('Y-m-d') ?>" />
                                </div>
                            </div>
                            <div class="control-group">
                                <div class="controls">
                                    <input type="hidden" name="idCaisse" value="<?= $caisse->id() ?>" />    
                                    <button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
                                    <button type="submit" class="btn red" aria-hidden="true">Oui</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- printCaisseDetails box end -->
                <!-- addCaisseDetails box begin-->
                <div id="addCaisseDetails" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                        <h3>Nouvelle opération de caisse </h3>
                    </div>
                    <div class="modal-body">
                        <form class="form-horizontal" action="controller/CaisseDetailsActionController.php" method="post">
                            <div class="control-group">
                                <label class="control-label">Date Opération</label>
                                <div class="controls date date-picker" data-date="" data-date-format="yyyy-mm-dd">
                                    <input name="dateOperation" id="dateOperation" class="m-wrap m-ctrl-small date-picker" type="text" value="" />
                                    <span class="add-on"><i class="icon-calendar"></i></span>
                                 </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Personne</label>
                                <div class="controls">
                                    <input type="text" name="personne" value="" />
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Désignation</label>
                                <div class="controls">
                                    <input type="text" name="designation" value="" />
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Projet</label>
                                <div class="controls">
                                    <select name="projet">
                                        <?php foreach($projets as $projet){ ?>
                                        <option value="<?= $projet->nom() ?>"><?= $projet->nom() ?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Type Opération</label>
                                <div class="controls">
                                    <label class="radio">
                                        <input type="radio" name="typeOperation" value="Entrée" checked/>
                                        Entrée
                                    </label>
                                    <label class="radio">
                                        <input type="radio" name="typeOperation" value="Sortie" />
                                        Sortie
                                    </label>
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Montant</label>
                                <div class="controls">
                                    <input type="text" name="montant" value="" />
                                </div>
                            </div>
                            <div class="control-group">
                                <label class="control-label">Commentaire</label>
                                <div class="controls">
                                    <input type="text" name="commentaire" value="" />
                                </div>
                            </div>
                            <div class="control-group">
                                <input type="hidden" name="idCaisse" value="<?= $caisse->id() ?>" />
                                <input type="hidden" name="action" value="add" />
                                <div class="controls">  
                                    <button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
                                    <button type="submit" class="btn red" aria-hidden="true">Oui</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <!-- addCaisseDetails box end -->
                <br>
                <div class="row-fluid">
                    <div class="span12">
                        <div class="tab-pane active" id="tab_1">
                            <?php if(isset($_SESSION['caisse-details-action-message'])){ ?>
                            <div class="alert alert-<?= $_SESSION['caisse-details-type-message'] ?>">
                                <button class="close" data-dismiss="alert"></button>
                                <?= $_SESSION['caisse-details-action-message'] ?>     
                            </div>
                             <?php } 
                                unset($_SESSION['caisse-details-action-message']);
                             ?>
                           <div class="portlet box grey">
                              <div class="portlet-title">
                                 <h4><i class="icon-bar-chart"></i>Liste détaillée de la Caisse <?= $caisse->nom() ?></h4>
                                 <div class="tools">
                                    <a href="javascript:;" class="collapse"></a>
                                    <a href="javascript:;" class="remove"></a>
                                 </div>
                              </div>
                              <div class="portlet-body">
                                 <!-- BEGIN FORM-->
                                 <div class="scroller" data-height="500px" data-always-visible="1"><!-- BEGIN DIV SCROLLER -->
                                <table class="table table-striped table-bordered table-advance table-hover">
                                    <thead>
                                        <tr>
                                            <th style="width:10%">Date</th>
                                            <th style="width:10%">Personne</th>
                                            <th style="width:20%">Désignation</th>
                                            <th style="width:10%">Projet</th>
                                            <th style="width:10%">Entrée</th>
                                            <th style="width:10%">Sortie</th>
                                            <th style="width:10%">Reste</th>
                                            <th style="width:20%">Commentaire</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach($entrees as $entree){
                                            $montantEntree = 0;
                                            $montantSortie = 0;
                                            $entreeChecked = "";
                                            $sortieChecked = "";
                                            
                                            if($entree->type()=="Sortie"){
                                                $montantEntree = 0;
                                                $montantSortie = $entree->montant();
                                                $sortieChecked = "checked";
                                                $entreeChecked = "";    
                                            }
                                            else{
                                                $montantEntree = $entree->montant();
                                                $montantSortie = 0;
                                                $sortieChecked = "";
                                                $entreeChecked = "checked";
                                            }
                                        ?>      
                                        <tr>
                                            <td>
                                                <div class="btn-group">
                                                    <a class="btn mini black dropdown-toggle" href="#" data-toggle="dropdown">
                                                        <?= date('d/m/Y', strtotime($entree->dateOperation())) ?> 
                                                        <i class="icon-angle-down"></i>
                                                    </a>
                                                    <ul class="dropdown-menu">
                                                        <li>
                                                            <a href="#updateCaisseDetails<?= $entree->id();?>" data-toggle="modal" data-id="<?= $entree->id(); ?>">
                                                                Modifier
                                                            </a>
                                                            <a href="#deleteCaisseDetails<?= $entree->id();?>" data-toggle="modal" data-id="<?= $entree->id(); ?>">
                                                                Supprimer
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </div>
                                            </td>
                                            <td><?= $entree->personne() ?></td>
                                            <td><?= $entree->designation() ?></td>
                                            <td><?= $entree->projet() ?></td>
                                            <td><?= number_format($montantEntree, 2, ',', ' ') ?></td>
                                            <td><?= number_format($montantSortie, 2, ',', ' ') ?></td>
                                            <td><?= number_format(0, 2, ',', ' ') ?></td>
                                            <td><?= $entree->commentaire() ?></td>
                                        </tr>   
                                        <!-- updateCaisseDetails box begin-->
                                        <div id="updateCaisseDetails<?= $entree->id() ?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                <h3>Modifier les informations de l'entrée de caisse </h3>
                                            </div>
                                            <div class="modal-body">
                                                <form class="form-horizontal" action="controller/CaisseDetailsActionController.php" method="post">
                                                    <p>Êtes-vous sûr de vouloir modifier l'entrée de caisse <strong>N°<?= $entree->id() ?></strong>  ?</p>
                                                    <div class="control-group">
                                                        <label class="control-label">Date Opération</label>
                                                        <div class="controls date date-picker" data-date="" data-date-format="yyyy-mm-dd">
                                                            <input name="dateOperation" id="dateOperation" class="m-wrap m-ctrl-small date-picker" type="text" value="<?= $entree->dateOperation() ?>" />
                                                            <span class="add-on"><i class="icon-calendar"></i></span>
                                                         </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <label class="control-label">Personne</label>
                                                        <div class="controls">
                                                            <input type="text" name="personne" value="<?= $entree->personne() ?>" />
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <label class="control-label">Désignation</label>
                                                        <div class="controls">
                                                            <input type="text" name="designation" value="<?= $entree->designation() ?>" />
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <label class="control-label">Projet</label>
                                                        <div class="controls">
                                                            <select name="projet">
                                                                <option value="<?= $entree->projet() ?>"><?= $entree->projet() ?></option>
                                                                <option disabled="disabled">-----------</option>
                                                                <?php foreach($projets as $projet){ ?>
                                                                <option value="<?= $projet->nom() ?>"><?= $projet->nom() ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <label class="control-label">Type Opération</label>
                                                        <div class="controls">
                                                            <label class="radio">
                                                                <input type="radio" name="typeOperation" value="Entrée" <?= $entreeChecked ?>/>
                                                                Entrée
                                                            </label>
                                                            <label class="radio">
                                                                <input type="radio" name="typeOperation" value="Sortie" <?= $sortieChecked ?> />
                                                                Sortie
                                                            </label>
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <label class="control-label">Montant</label>
                                                        <div class="controls">
                                                            <input type="text" name="montant" value="<?= $entree->montant() ?>" />
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <label class="control-label">Commentaire</label>
                                                        <div class="controls">
                                                            <input type="text" name="commentaire" value="<?= $entree->commentaire() ?>" />
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <input type="hidden" name="idCaisse" value="<?= $caisse->id() ?>" />
                                                        <input type="hidden" name="idCaisseDetails" value="<?= $entree->id() ?>" />
                                                        <input type="hidden" name="action" value="update" />
                                                        <div class="controls">  
                                                            <button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
                                                            <button type="submit" class="btn red" aria-hidden="true">Oui</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <!-- updateCaisseDetails box end -->           
                                        <!-- deleteCaisseDetails box begin-->
                                        <div id="deleteCaisseDetails<?= $entree->id() ?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                <h3>Supprimer l'entrée de la caisse </h3>
                                            </div>
                                            <div class="modal-body">
                                                <form class="form-horizontal loginFrm" action="controller/CaisseDetailsActionController.php" method="post">
                                                    <p>Êtes-vous sûr de vouloir supprimer cette entrée de caisse <strong>N°<?= $entree->id() ?></strong> ?</p>
                                                    <div class="control-group">
                                                        <label class="right-label"></label>
                                                        <input type="hidden" name="idCaisse" value="<?= $caisse->id() ?>" />
                                                        <input type="hidden" name="idCaisseDetails" value="<?= $entree->id() ?>" />
                                                        <input type="hidden" name="action" value="delete" />
                                                        <button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
                                                        <button type="submit" class="btn red" aria-hidden="true">Oui</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <!-- deleteCaisseDetails box end -->
                                        <?php
                                        }//end of loop
                                        ?>
                                    </tbody>
                                </table>
                                </div><!-- END DIV SCROLLER -->
                              </div>
                           </div>
                            <!-- END Charges TABLE PORTLET-->
                                 <!-- END FORM--> 
                              </div>
                           </div>
                        </div>
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
    <script src="assets/fancybox/source/jquery.fancybox.pack.js"></script>
    <script src="assets/jquery-ui/jquery-ui-1.10.1.custom.min.js"></script>
    <script src="assets/jquery-slimscroll/jquery.slimscroll.min.js"></script>
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
        $('.duree').on('change',function(){
            if( $(this).val()==="date"){
                $("#dateRange").show()
            }
            else{
                $("#dateRange").hide()
            }
        });
    </script>
</body>
<!-- END BODY -->
</html>
<?php
}
else if(isset($_SESSION['userMerlaTrav']) and $_SESSION->profil()!="admin"){
    header('Location:dashboard.php');
}
else{
    header('Location:index.php');    
}
?>