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
    if ( isset($_SESSION['userMerlaTrav']) ){
        //classManagers
        $projetManager = new ProjetManager($pdo);
        $societeManager = new SocieteManager($pdo);
        $fournisseurManager = new FournisseurManager($pdo);
        $livraisonManager = new LivraisonManager($pdo);
        $livraisonDetailManager = new LivraisonDetailManager($pdo);
        $reglementsFournisseurManager = new ReglementFournisseurManager($pdo);
        //classes and vars
        $projets = $projetManager->getProjets();
        $fournisseurs = $fournisseurManager->getFournisseurs();
        $projet = $projetManager->getProjets();
        $livraisonNumber = 0;
        $totalReglement = 0;
        $totalLivraison = 0;
        $titreLivraison ="Liste de toutes les livraisons";
        $hrefLivraisonBilanPrintController = "controller/LivraisonBilanPrintController.php";
        $idSociete = $_GET['idSociete'];
        $idFournisseur = $_GET['idFournisseur'];
        $societe = $societeManager->getSocieteById($idSociete);
        $livraisons = "";
        if(isset($_GET['idProjet']) and 
        ($_GET['idProjet'] >=1 and $_GET['idProjet'] <= $projetManager->getLastId()) ){
            $idProjet = $_GET['idProjet'];
            $fournisseur = $fournisseurManager->getFournisseurById($idFournisseur);
            $livraisons = $livraisonManager->getLivraisonsPayesByIdFournisseurByProjet($idFournisseur, $idProjet);
            //print_r($livraisons);
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
                            Gestion des livraisons - Projet : <strong><?= $projetManager->getProjetById($idProjet)->nom() ?></strong>
                        </h3>
                        <ul class="breadcrumb">
                            <li>
                                <i class="icon-home"></i>
                                <a href="dashboard.php">Accueil</a> 
                                <i class="icon-angle-right"></i>
                            </li>
                            <li>
                                <i class="icon-sitemap"></i>
                                <a href="companies-group.php">Gestion des sociétés</a>
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
                                <a href="project-management.php?idProjet=<?= $idProjet ?>&idSociete=<?= $idSociete ?>">Projet <strong><?= $projetManager->getProjetById($idProjet)->nom() ?></strong></a>
                                <i class="icon-angle-right"></i>
                            </li>
                            <li>
                                <i class="icon-truck"></i>
                                <a href="projet-livraisons.php?idProjet=<?= $idProjet ?>&idSociete=<?= $idSociete ?>">Gestion des livraisons</a>
                                <i class="icon-angle-right"></i>
                            </li>
                            <li>
                                <i class="icon-check"></i>
                                <a>Livraisons payées</a>
                            </li>
                        </ul>
                        <!-- END PAGE TITLE & BREADCRUMB-->
                    </div>
                </div>
                <!-- END PAGE HEADER-->
                <div class="row-fluid">
                    <div class="span12">
                        <!-- BEGIN Terrain TABLE PORTLET-->
                        <div class="portlet box blue">
                            <div class="portlet-title">
                                <h4>Liste des livraisons payées : <?= $fournisseur->nom() ?></h4>
                                <div class="tools">
                                    <a href="javascript:;" class="collapse"></a>
                                    <a href="javascript:;" class="remove"></a>
                                </div>
                            </div>
                            <div class="portlet-body">
                                <form method="post" action="controller/LivraisonsPayeesInvalidateController.php" class="horizontal-form">
                                    <div class="row-fluid">
                                        <?php
                                        //$sommeLivraisons = 0;
                                        //$sommeLivraisonsNonPaye = 0;
                                        foreach($livraisons as $livraison){
                                            //$sommeLivraisons += $livraisonDetailManager->getTotalLivraisonByIdLivraison($livraison->id());
                                            /*if ( $livraison->status() == utf8_decode("Non Pay&eacute;")) {
                                                $sommeLivraisonsNonPaye += $livraisonDetailManager->getTotalLivraisonByIdLivraison($livraison->id());
                                            }*/
                                        ?>
                                                <input type="checkbox" name="id_livraison[]" value="<?= $livraison->id() ?>">
                                                N°BL : <?= $livraison->libelle() ?>
                                                <a class="btn mini green">
                                                    <?= $livraison->status() ?>
                                                </a>
                                        <?php
                                        }//end of loop
                                        ?>
                                    </div>    
                                    <br>
                                    <div class="row-fluid">
                                        <input type="hidden" name="idSociete" value="<?= $idSociete ?>" />
                                        <input type="hidden" name="idProjet" value="<?= $idProjet ?>" />
                                        <input type="hidden" name="idFournisseur" value="<?= $idFournisseur ?>" />
                                        <input type="submit" class="btn primary red get-down" value="Invalider" />
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- END Terrain TABLE PORTLET-->
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
    <!-- ie8 fixes -->
    <!--[if lt IE 9]>
    <script src="assets/js/excanvas.js"></script>
    <script src="assets/js/respond.js"></script>
    <![endif]-->    
    <script type="text/javascript" src="assets/uniform/jquery.uniform.min.js"></script>
    <script type="text/javascript" src="assets/data-tables/jquery.dataTables.js"></script>
    <script type="text/javascript" src="assets/data-tables/DT_bootstrap.js"></script>
    <script src="assets/jquery-ui/jquery-ui-1.10.1.custom.min.js"></script>
    <script src="assets/jquery-slimscroll/jquery.slimscroll.min.js"></script>
    <script type="text/javascript" src="assets/bootstrap-datepicker/js/bootstrap-datepicker.js"></script>
    <script type="text/javascript" src="assets/bootstrap-daterangepicker/date.js"></script>
    <script src="assets/js/app.js"></script>
    <script type="text/javascript" src="script.js"></script>        
    <script>
        jQuery(document).ready(function() {         
            // initiate layout and plugins
            //App.setPage("table_managed");
            App.init();
        });
        $('#modePaiement').on('change',function(){
            if( $(this).val()==="Cheque"){
            $("#numeroCheque").show()
            }
            else{
            $("#numeroCheque").hide()
            }
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