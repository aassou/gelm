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
        //les sources
        $mois = $_GET['mois'];
        $annee = $_GET['annee'];
        $idProjet = 0;
        $projetManager = new ProjetManager($pdo);
        $societeManager = new SocieteManager($pdo);
        $contratManager = new ContratManager($pdo);
        $locauxManager = new LocauxManager($pdo);
        $maisonManager = new MaisonManager($pdo);
        $terrainManager = new TerrainManager($pdo);
        $appartementManager = new AppartementManager($pdo);
        $contrats = $contratManager->getContratByMonthYear($mois, $annee);
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
                            Archive des Contrats des Clients - <?= $mois."/".$annee ?>
                        </h3>
                        <ul class="breadcrumb">
                            <li>
                                <i class="icon-home"></i>
                                <a href="dashboard.php">Accueil</a> 
                                <i class="icon-angle-right"></i>
                            </li>
                            <li>
                                <i class="icon-wrench"></i>
                                <a href="configuration.php">Paramètrages</a> 
                                <i class="icon-angle-right"></i>
                            </li>
                            <li>
                                <a href="clients-archive-group.php">Archive des clients</a>
                                <i class="icon-angle-right"></i>
                            </li>
                            <li><a><strong><?= $mois."/".$annee ?></strong></a></li>
                        </ul>
                        <!-- END PAGE TITLE & BREADCRUMB-->
                    </div>
                </div>
                <!-- END PAGE HEADER-->
                <div class="row-fluid">
                    <div class="span12">
                        <!-- BEGIN Terrain TABLE PORTLET-->
                        <div class="portlet box grey">
                            <div class="portlet-title">
                                <h4>Archive des Contrats Clients</h4>
                                <div class="tools">
                                    <a href="javascript:;" class="collapse"></a>
                                    <a href="javascript:;" class="remove"></a>
                                </div>
                            </div>
                            <div class="portlet-body">
                                <div class="clearfix">
                                    <div class="btn-group pull-right">
                                        <a class="btn blue " href="controller/ClientArchivePrintController.php?mois=<?= $mois ?>&annee=<?= $annee ?>">
                                            <i class="icon-print"></i>
                                             Version Imprimable
                                        </a>
                                    </div>
                                    <!--div class="btn-group pull-left">
                                        <a class="btn green" href="contrats-add.php?idProjet=<?php //$idProjet ?>&idSociete=<?php //$idSociete ?>">
                                            Nouveau Contrat Client <i class="icon-plus-sign"></i>
                                        </a>
                                    </div-->
                                </div>
                                <!--div class="scroller" data-height="500px" data-always-visible="1"--><!-- BEGIN DIV SCROLLER -->
                                <table class="table table-bordered table-hover" id="sample_1">
                                    <thead>
                                        <tr>
                                            <th class="hidden"></th>
                                            <th style="width:10%">Client</th>
                                            <th style="width:10%">Dates</th>
                                            <th style="width:10%" class="hidden-phone">Type</th>
                                            <th style="width:10%" class="hidden-phone">Prix</th>
                                            <th style="width:10%" class="hidden-phone">Taille</th>
                                            <th style="width:10%" class="hidden-phone">Payé</th>
                                            <th style="width:10%" class="hidden-phone">Reste</th>
                                            <th style="width:15%" class="hidden-phone">Note</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach($contrats as $contrat){
                                            $bien = "";
                                            $typeBien = "";
                                            if($contrat->typeBien()=="appartement"){
                                                $bien = $appartementManager->getAppartementById($contrat->idBien());
                                                $typeBien = "Appartement";
                                            }
                                            else if($contrat->typeBien()=="localCommercial"){
                                                $bien = $locauxManager->getLocauxById($contrat->idBien());
                                                $typeBien = "Local Commercial";
                                            }
                                            else if($contrat->typeBien()=="terrain"){
                                                $bien = $terrainManager->getTerrainById($contrat->idBien());
                                                $typeBien = "Terrain";
                                            }
                                            else if($contrat->typeBien()=="maison"){
                                                $bien = $maisonManager->getMaisonById($contrat->idBien());
                                                $typeBien = "Maison";
                                            }
                                            //status colors preferences
                                            $colorRow = "";
                                            if($contrat->status()=="actif"){
                                                $colorRow = 'style="background-color:#d2ffca"';
                                            }
                                            else{
                                                $colorRow = 'style="background-color:#ffcac1"';  
                                            }  
                                        ?>      
                                        <tr <?= $colorRow ?> class="clients">
                                            <td class="hidden"></td>
                                            <td><?= $contrat->nomClient() ?></td>
                                            <td><?= date('d/m/Y', strtotime($contrat->dateCreation())) ?>-<br/><?= date('d/m/Y', strtotime($contrat->dateRetour())) ?></td>
                                            <td class="hidden-phone"><?= $typeBien."-".$bien->nom() ?></td>
                                            <td class="hidden-phone"><?= number_format($contrat->prixVente(), 2, ',', ' ') ?></td>
                                            <td class="hidden-phone"><?= number_format($contrat->taille(), 2, ',', ' ') ?></td>
                                            <td class="hidden-phone"><?= number_format($contrat->avance(), 2, ',', ' ') ?></td>
                                            <td class="hidden-phone"><?= number_format($contrat->prixVente()-$contrat->avance(), 2, ',', ' ') ?></td>
                                            <td class="hidden-phone"><?= $contrat->note() ?></td>
                                        </tr>  
                                        <?php
                                        }//end of loop
                                        ?>
                                    </tbody>
                                </table>
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
    <script src="assets/jquery-ui/jquery-ui-1.10.1.custom.min.js"></script>
    <script src="assets/jquery-slimscroll/jquery.slimscroll.min.js"></script>
    <script src="assets/js/app.js"></script>
    <script src="script.js"></script>       
    <script>
        jQuery(document).ready(function() {         
            // initiate layout and plugins
            App.setPage("table_managed");
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