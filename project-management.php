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
    if ( isset($_SESSION['userMerlaTrav']) ){
        //les sources
        $projetsManager = new ProjetManager($pdo);
        $societeManager = new SocieteManager($pdo);
        $societes = $societeManager->getSocietes();
        if(isset($_GET['idSociete']) and 
        ($_GET['idSociete'] >=1 and $_GET['idSociete'] <= $societeManager->getLastId()) ){
            $idSociete = $_GET['idSociete'];
            $idProjet = $_GET['idProjet'];
            $projet = $projetsManager->getProjetById($idProjet);
            $projetNumber = ($projetsManager->getProjetsNumberByIdSociete($idSociete));
            $societe = $societeManager->getSocieteById($idSociete);
        }
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
    <link rel="stylesheet" type="text/css" href="assets/bootstrap-datepicker/css/datepicker.css" />
    <link rel="stylesheet" type="text/css" href="assets/chosen-bootstrap/chosen/chosen.css" />
    <link rel="stylesheet" href="assets/data-tables/DT_bootstrap.css" />
    <link rel="stylesheet" type="text/css" href="assets/uniform/css/uniform.default.css" />
    <link rel="stylesheet" type="text/css" href="assets/gritter/css/jquery.gritter.css" />
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
                            Gestion du projet <?= $projet->nom() ?> - Société : <strong><?= strtoupper($societeManager->getSocieteById($idSociete)->raisonSociale()) ?></strong>
                        </h3>
                        <ul class="breadcrumb">
                            <li>
                                <i class="icon-home"></i>
                                <a href="dashboard.php">Accueil</a> 
                                <i class="icon-angle-right"></i>
                            </li>
                            <li>
                                <i class="icon-sitemap"></i>
                                <a href="companies.php">Gestion des sociétés</a> 
                                <i class="icon-angle-right"></i>
                            </li>
                            <li>
                                <a href="company.php?idSociete=<?= $societe->id() ?>"><strong>Société <?= $societe->raisonSociale() ?></strong></a> 
                                <i class="icon-angle-right"></i>
                            </li>
                            <li>
                                <i class="icon-briefcase"></i>
                                <a href="projects-by-company.php?idSociete=<?= $idSociete ?>">Gestion des projets</a>
                                <i class="icon-angle-right"></i>
                            </li>
                            <li>
                                <a>Projet <strong><?= $projet->nom() ?></strong></a>
                            </li>
                        </ul>
                        <!-- END PAGE TITLE & BREADCRUMB-->
                    </div>
                </div>
                <!-- END PAGE HEADER-->
                <!-- BEGIN PAGE CONTENT-->
                <div class="row-fluid">
                    <div class="span12">
                        <?php if(isset($_SESSION['projet-add-success'])){ ?>
                            <div class="alert alert-success">
                                <button class="close" data-dismiss="alert"></button>
                                <?= $_SESSION['projet-add-success'] ?>      
                            </div>
                         <?php } 
                            unset($_SESSION['projet-add-success']);
                         ?>
                         <?php if(isset($_SESSION['projet-add-error'])){ ?>
                            <div class="alert alert-error">
                                <button class="close" data-dismiss="alert"></button>
                                <?= $_SESSION['projet-add-error'] ?>        
                            </div>
                         <?php } 
                            unset($_SESSION['projet-add-error']);
                         ?>
                         <?php if(isset($_SESSION['projet-update-success'])){ ?>
                            <div class="alert alert-success">
                                <button class="close" data-dismiss="alert"></button>
                                <?= $_SESSION['projet-update-success'] ?>       
                            </div>
                         <?php } 
                            unset($_SESSION['projet-update-success']);
                         ?>
                         <?php if(isset($_SESSION['projet-status-update-success'])){ ?>
                            <div class="alert alert-success">
                                <button class="close" data-dismiss="alert"></button>
                                <?= $_SESSION['projet-status-update-success'] ?>        
                            </div>
                         <?php } 
                            unset($_SESSION['projet-status-update-success']);
                         ?>
                         <?php if(isset($_SESSION['projet-update-error'])){ ?>
                            <div class="alert alert-error">
                                <button class="close" data-dismiss="alert"></button>
                                <?= $_SESSION['projet-update-error'] ?>     
                            </div>
                         <?php } 
                            unset($_SESSION['projet-update-error']);
                         ?>
                        <?php if(isset($_SESSION['projet-delete-success'])){ ?>
                            <div class="alert alert-info">
                                <button class="close" data-dismiss="alert"></button>
                                <?= $_SESSION['projet-delete-success'] ?>       
                            </div>
                         <?php } 
                            unset($_SESSION['projet-delete-success']);
                         ?>
                        <!-- BEGIN EXAMPLE TABLE PORTLET-->
                        <div class="tab-pane" id="tab_1_4">
                            <!-- addSociete box end -->
                            <?php if(isset($_SESSION['pieces-add-success'])){ ?>
                                <div class="alert alert-success">
                                    <button class="close" data-dismiss="alert"></button>
                                    <?= $_SESSION['pieces-add-success'] ?>      
                                </div>
                             <?php } 
                                unset($_SESSION['pieces-add-success']);
                             ?>
                             <?php if(isset($_SESSION['pieces-add-error'])){ ?>
                                <div class="alert alert-error">
                                    <button class="close" data-dismiss="alert"></button>
                                    <?= $_SESSION['pieces-add-error'] ?>        
                                </div>
                             <?php } 
                                unset($_SESSION['pieces-add-error']);
                             ?>
                            <div class="row-fluid">
                            </div>
                            <br><br>
                            <?php
                            //foreach($projets as $projet){
                            ?>
                            <!--div class="row-fluid portfolio-block projets" id="<?= $projet->id() ?>"-->
                            <div style="background-color: #f7f7f7;border: 1px solid #27A9E3;  margin-bottom: 30px" class="row-fluid projets" id="<?= $projet->id() ?>">
                                <div class="span3">
                                    <div class="">
                                        <div class="btn-group">
                                            <?php
                                            $link = "projet-details.php?idProjet=".$projet->id();
                                            if(isset($_GET['p'])){
                                                $link = "projet-details.php?idProjet=".$projet->id()."&p=".$_GET['p'];  
                                            }
                                            $btnColor = "";
                                            if($projet->status()=="En cours"){
                                                $btnColor = "blue";
                                            }
                                            else{
                                                $btnColor = "red";
                                            }
                                            ?>
                                            <a style="width:250px" class="btn <?= $btnColor ?> big">
                                                <strong><?= ucfirst($projet->nom()) ?></strong> - <?= $projet->status() ?>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <!-- addProjetDocs box begin-->
                                <div id="addProjetDocs<?= $projet->id() ?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h3>Ajouter des documents </h3>
                                    </div>
                                    <div class="modal-body">
                                    <form class="form-horizontal" action="controller/ProjetPiecesAddController.php" method="post" enctype="multipart/form-data">
                                            <p>Ajouter un document pour le projet <strong><?= $projet->nom() ?></strong></p>
                                            <div class="control-group">
                                              <label class="control-label">Document</label>
                                              <div class="controls">
                                                <input type="file" name="urlPieceProjet" />
                                              </div>
                                           </div>
                                            <div class="control-group">
                                                <label class="control-label">Description</label>
                                                <div class="controls">
                                                    <textarea name="descriptionProjet" ></textarea>
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <div class="controls">  
                                                    <input type="hidden" name="idProjet" value="<?= $projet->id() ?>" />
                                                    <input type="hidden" name="idSociete" value="<?= $idSociete ?>" />
                                                    <button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
                                                    <button type="submit" class="btn red" aria-hidden="true">Oui</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <!-- addSocieteDocs box end -->
                                <!-- updateStatusProjet box begin-->
                                <div id="updateStatusProjet<?= $projet->id() ?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h3>Changer Status Projet </h3>
                                    </div>
                                    <div class="modal-body">
                                        <form class="form-horizontal" action="controller/ProjetUpdateStatusController.php" method="post">
                                            <p>Êtes-vous sûr de vouloir changer le status du projet <strong><?= $projet->nom() ?></strong> ?</p>
                                            <div class="control-group">
                                                <label class="control-label">Status</label>
                                                <div class="controls">
                                                    <select name="status">
                                                        <option value="<?= $projet->status() ?>">
                                                            <?= $projet->status() ?>
                                                        </option>
                                                        <option disabled="disabled">----------------</option>
                                                        <option value="En cours">En cours</option>
                                                        <option value="Terminé">Terminé</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <div class="controls">  
                                                    <input type="hidden" name="idProjet" value="<?= $projet->id() ?>" />
                                                    <input type="hidden" name="idSociete" value="<?= $idSociete ?>" />
                                                    <button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
                                                    <button type="submit" class="btn red" aria-hidden="true">Oui</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <!-- updateStatusProjet box end -->
                                <!-- updateProjet box begin-->
                                <div id="updateProjet<?= $projet->id() ?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h3>Modifier Projet </h3>
                                    </div>
                                    <div class="modal-body">
                                        <form class="form-horizontal" action="controller/ProjetUpdateController.php" method="post">
                                            <p>Êtes-vous sûr de vouloir modifier le projet <strong><?= $projet->nom() ?></strong> ?</p>
                                            <div class="control-group">
                                                <label class="control-label">Société</label>
                                                <div class="controls">
                                                    <select name="idSociete">
                                                        <option value="<?= $projet->idSociete() ?>">
                                                            <?= $societeManager->getSocieteById($projet->idSociete())->raisonSociale() ?>
                                                        </option>
                                                        <option disabled="disabled">----------------</option>
                                                        <?php foreach($societes as $societe){ ?>
                                                        <option value="<?= $societe->id() ?>"><?= $societe->raisonSociale() ?></option>
                                                        <?php } ?>
                                                    </select>
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <label class="control-label">Nom</label>
                                                <div class="controls">
                                                    <input type="text" name="nom" value="<?= $projet->nom() ?>" />
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <label class="control-label">Numéro Titre</label>
                                                <div class="controls">
                                                    <input type="text" name="numeroTitre" value="<?= $projet->numeroTitre() ?>" />
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <label class="control-label">Emplacement</label>
                                                <div class="controls">
                                                    <input type="text" name="emplacement" value="<?= $projet->emplacement() ?>" />
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <label class="control-label">Superficie</label>
                                                <div class="controls">
                                                    <input type="text" name="superficie" value="<?= $projet->superficie() ?>" />
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <label class="control-label">Description</label>
                                                <div class="controls">
                                                    <input type="text" name="description" value="<?= $projet->description() ?>" />
                                                </div>
                                            </div>
                                            <div class="control-group">
                                                <label class="control-label">Date de création</label>
                                                <div class="controls date date-picker" data-date="" data-date-format="yyyy-mm-dd">
                                                    <input name="dateCreation" id="dateCreation" class="m-wrap m-ctrl-small date-picker" type="text" value="<?= $societe->dateCreation() ?>" />
                                                    <span class="add-on"><i class="icon-calendar"></i></span>
                                                 </div>
                                            </div>
                                            <div class="control-group">
                                                <div class="controls">  
                                                    <input type="hidden" name="idProjet" value="<?= $projet->id() ?>" />
                                                    <input type="hidden" name="idSociete" value="<?= $idSociete ?>" />
                                                    <button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
                                                    <button type="submit" class="btn red" aria-hidden="true">Oui</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <!-- updateProjet box end -->
                                <!-- delete box begin-->
                                <div id="deleteProjet<?php echo $projet->id();?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
                                    <div class="modal-header">
                                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                        <h3>Supprimer Projet <?= $projet->nom() ?></h3>
                                    </div>
                                    <div class="modal-body">
                                        <form class="form-horizontal loginFrm" action="controller/ProjetDeleteController.php" method="post">
                                            <p>Êtes-vous sûr de vouloir supprimer ce projet <strong><?= $projet->nom() ?></strong> ?</p>
                                            <div class="control-group">
                                                <label class="right-label"></label>
                                                <input type="hidden" name="idProjet" value="<?= $projet->id() ?>" />
                                                <input type="hidden" name="idSociete" value="<?= $idSociete ?>" />
                                                <button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
                                                <button type="submit" class="btn red" aria-hidden="true">Oui</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                                <!-- delete box end -->     
                                <div class="span9" style="overflow:hidden;">
                                    <div class="portfolio-info">
                                        <a href="projet-livraisons.php?idProjet=<?= $projet->id() ?>&idSociete=<?= $idSociete ?>" class="btn green fixed-size">Gestion des livraisons</a>
                                    </div>
                                    <div class="portfolio-info">
                                        <a href="biens-by-projects.php?idProjet=<?= $projet->id() ?>&idSociete=<?= $idSociete ?>" class="btn purple fixed-size">Gestion Immobilière</a>
                                        <!--div class="btn-group">
                                            <a class="btn purple fixed-size dropdown-toggle" href="projet-biens.php?idProjet=<?= $projet->id() ?>" data-toggle="dropdown">
                                                <i class="icon-angle-down"></i>
                                                Gestion Immobilière
                                            </a>
                                            
                                            <ul class="dropdown-menu">
                                                <li>
                                                    <a href="projet-biens.php?idProjet=<?= $projet->id() ?>&type=appartements&idSociete=<?= $idSociete ?>" data-toggle="modal" data-id="<?= $projet->id(); ?>">
                                                        Appartements
                                                    </a>
                                                    <a href="projet-biens.php?idProjet=<?= $projet->id() ?>&type=maisons&idSociete=<?= $idSociete ?>" data-toggle="modal" data-id="<?= $projet->id(); ?>">
                                                        Maisons
                                                    </a>
                                                    <a href="projet-biens.php?idProjet=<?= $projet->id() ?>&type=locaux&idSociete=<?= $idSociete ?>" data-toggle="modal" data-id="<?= $projet->id(); ?>">
                                                        Locaux Commerciaux
                                                    </a>
                                                    <a href="projet-biens.php?idProjet=<?= $projet->id() ?>&type=terrains&idSociete=<?= $idSociete ?>" data-toggle="modal" data-id="<?= $projet->id(); ?>">
                                                        Terrains
                                                    </a>
                                                </li>
                                            </ul>
                                        </div-->
                                    </div>
                                    <div class="portfolio-info">
                                        <a href="projets-charges-categories.php?idProjet=<?= $projet->id() ?>&idSociete=<?= $idSociete ?>" class="btn black fixed-size">Gestion des charges</a>
                                        <!--a href="appartements.php?idProjet=<?= $projet->id() ?>" class="btn blue fixed-size">Appartements</a-->
                                    </div>
                                    <div class="portfolio-info">
                                        <a href="projet-contrat-employe.php?idProjet=<?= $projet->id() ?>&idSociete=<?= $idSociete ?>" class="btn fixed-size">Gestion des contrats</a>
                                    </div>
                                    <div class="portfolio-info">
                                        <a href="contrats-list.php?idProjet=<?= $projet->id() ?>&idSociete=<?= $idSociete ?>" class="btn red fixed-size">Gestion des Clients</a>
                                    </div>
                                    <div class="portfolio-info">
                                        <a href="projet-details.php?idProjet=<?= $projet->id() ?>&idSociete=<?= $idSociete ?>" class="btn yellow fixed-size">Gestion des documents</a>
                                    </div>
                                    <div class="portfolio-info">
                                        <a href="projet-statistique.php?idProjet=<?= $projet->id() ?>&idSociete=<?= $idSociete ?>" class="btn blue fixed-size">Statistiques</a>
                                    </div>
                                </div>
                            </div>
                            <?php //}//end foreach loop for projets elements ?>
                        </div>
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
    <!-- ie8 fixes -->
    <!--[if lt IE 9]>
    <script src="assets/js/excanvas.js"></script>
    <script src="assets/js/respond.js"></script>
    <![endif]-->
    <script type="text/javascript" src="assets/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
    <script type="text/javascript" src="assets/bootstrap-daterangepicker/date.js"></script> 
    <script type="text/javascript" src="assets/uniform/jquery.uniform.min.js"></script>
    <script type="text/javascript" src="assets/data-tables/jquery.dataTables.js"></script>
    <script type="text/javascript" src="assets/data-tables/DT_bootstrap.js"></script>
    <script type="text/javascript" src="assets/js/jquery.pulsate.min.js"></script>
    <script src="assets/js/app.js"></script>        
    <script>
        jQuery(document).ready(function() {         
            // initiate layout and plugins
            //App.setPage("table_editable");
            App.init();
        });
        //search jquery
        $('.projets').show();
        $('#filterProjet').keyup(function(){
            $('.projets').hide();
           var txt = $('#filterProjet').val();
           $('.projets').each(function(){
               if($(this).text().toUpperCase().indexOf(txt.toUpperCase()) != -1){
                   $(this).show();
               }
            });
        });
        $('#status').keyup(function(){
           $('.projets').hide();
           var txt = $('#status').val();
           $('.projets').each(function(){
               if($(this).text().toUpperCase().indexOf(txt.toUpperCase()) != -1){
                   $(this).show();
               }
            });
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