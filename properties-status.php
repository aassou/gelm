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
    if( isset($_SESSION['userMerlaTrav']) ){
        //les sources
        $projetManager = new ProjetManager($pdo);
        $contratManager = new ContratManager($pdo);
        $clientManager = new ClientManager($pdo);
        $biensDiponible = 0;
        $biensVendu = 0;
        $biensPromesseVente = 0;
        $biens = 0;
        //begin process
        $type = $_GET['type'];
        if ( $type ==  "appartements" ) {
            $appartementManager = new AppartementManager($pdo);
            $appartements = $appartementManager->getAppartementsNonVendu();
            $biens = $appartementManager->getNumberBiens();
            $biensDiponible = $appartementManager->getNumberBienDisbonible();
            $biensVendu = $appartementManager->getNumberBienVendu();
            $biensPromesseVente = $appartementManager->getNumberBienPromesseVente();
        }
        else if ( $type ==  "locaux" ) {
            $locauxManager = new LocauxManager($pdo);
            $locaux = $locauxManager->getLocauxNonVendu();
            $biens = $locauxManager->getNumberBiens();
            $biensDiponible = $locauxManager->getNumberBienDisbonible();
            $biensVendu = $locauxManager->getNumberBienVendu();
            $biensPromesseVente = $locauxManager->getNumberBienPromesseVente();
        }
        else if ( $type ==  "maisons" ) {
            $maisonManager = new MaisonManager($pdo);
            $maisons = $maisonManager->getMaisonsNonVendu();
            $biens = $maisonManager->getNumberBiens();
            $biensDiponible = $maisonManager->getNumberBienDisbonible();
            $biensVendu = $maisonManager->getNumberBienVendu();
            $biensPromesseVente = $maisonManager->getNumberBienPromesseVente();
        }
        else if ( $type ==  "terrains" ) {
            $terrainManager = new TerrainManager($pdo);
            $terrains = $terrainManager->getTerrainsNonVendu();
            $biens = $terrainManager->getNumberBiens();
            $biensDiponible = $terrainManager->getNumberBienDisbonible();
            $biensVendu = $terrainManager->getNumberBienVendu();
            $biensPromesseVente = $terrainManager->getNumberBienPromesseVente();
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
                            Liste des biens immobiliers disponibles
                        </h3>
                        <ul class="breadcrumb">
                            <li>
                                <i class="icon-home"></i>
                                <a href="dashboard.php">Accueil</a> 
                                <i class="icon-angle-right"></i>
                            </li>
                            <li>
                                <i class="icon-bar-chart"></i>
                                <a href="status.php">Les états</a>
                                <i class="icon-angle-right"></i>
                            </li>
                            <li>
                                <i class="icon-home"></i>
                                <a href="properties-status-types.php">Etats Immobilière</a>
                                <i class="icon-angle-right"></i>
                            </li>
                            <li>
                                <a>Etats des <strong><?= ucfirst($type) ?></strong></a>
                            </li>
                        </ul>
                        <!-- END PAGE TITLE & BREADCRUMB-->
                    </div>
                </div>
                <!-- END PAGE HEADER-->
                <!-- BEGIN PAGE CONTENT-->
                <div class="row-fluid"> 
                    <div class="span12">
                        <!--div class="get-down">
                            <input class="m-wrap" name="criteria" id="criteria" type="text" placeholder="Chercher Par Code, Status..." />
                        </div-->
                        <!-- BEGIN APPARTEMENTS TABLE PORTLET-->
                        <?php if ( $type ==  "appartements" ) { ?>
                        <div class="portlet box grey">
                            <div class="portlet-title">
                                <h4>Liste des appartements : <?= $biensDiponible ?> Disponilbe - <?= $biensPromesseVente ?> Promesse de vente - <?= $biensVendu ?> Vendu - <?= $biens ?> Total</h4>
                                <div class="tools">
                                    <a href="javascript:;" class="collapse"></a>
                                    <a href="javascript:;" class="remove"></a>
                                </div>
                            </div>
                            <div class="portlet-body">
                                <table class="table table-bordered table-hover" id="sample_1">
                                    <thead>
                                        <tr>
                                            <th style="width: 5%">Code</th>
                                            <th style="width: 10%">Projet</th>
                                            <th style="width: 5%">Niveau</th>
                                            <!--th style="width: 10%">Prix&nbsp;DH</th-->
                                            <th style="width: 10%">Superficie</th>
                                            <th style="width: 5%">Façade</th>
                                            <th style="width: 25%">Nbr.Pièces</th>
                                            <th style="width: 5%">Cave</th>
                                            <th style="width: 10%">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach($appartements as $appartement){
                                        ?>      
                                        <tr class="appartements">
                                            <td><?= $appartement->nom() ?></td>
                                            <td class="hidden-phone"><?= $projetManager->getProjetById($appartement->idProjet())->nom() ?></td>
                                            <td class="hidden-phone"><?= $appartement->niveau() ?></td>
                                            <!--td><a></a></td-->
                                            <td><?= $appartement->superficie() ?> m<sup>2</sup></td>
                                            <td class="hidden-phone"><?= $appartement->facade() ?></td>
                                            <td class="hidden-phone"><?= $appartement->nombrePiece() ?> pièces</td>
                                            <td class="hidden-phone">
                                                <?php if($appartement->cave()=="Sans"){ ?><a class="btn mini black">Sans</a><?php } ?>
                                                <?php if($appartement->cave()=="Avec"){ ?><a class="btn mini blue">Avec</a><?php } ?>
                                            </td>
                                            <td>
                                                <?php
                                                if ( $appartement->status()=="Disponible" ) {
                                                ?>
                                                    <a class="btn mini green">
                                                        Disponible
                                                    </a>
                                                <?php        
                                                }    
                                                ?>
                                            </td>
                                        </tr>
                                        <?php
                                        }//end of loop
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <?php } ?>
                        <!-- END APPARTEMENTS TABLE PORTLET-->
                        <!-- BEGIN LOCAUX TABLE PORTLET-->
                        <?php if ( $type ==  "locaux" ) { ?>
                        <div class="portlet box grey">
                            <div class="portlet-title">
                                <h4>Liste des locaux commerciaux : <?= $biensDiponible ?> Disponilbe - <?= $biensPromesseVente ?> Promesse de vente - <?= $biensVendu ?> Vendu - <?= $biens ?> Total</h4>
                                <div class="tools">
                                    <a href="javascript:;" class="collapse"></a>
                                    <a href="javascript:;" class="remove"></a>
                                </div>
                            </div>
                            <div class="portlet-body">
                                <table class="table table-bordered table-hover" id="sample_1">
                                    <thead>
                                        <tr>
                                            <th>Code</th>
                                            <th>Projet</th>
                                            <th>Superficie</th>
                                            <th>Façade</th>
                                            <th>Mezzanine</th>
                                            <th>Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach($locaux as $locau){
                                        ?>      
                                        <tr class="locaux">
                                            <td><?= $locau->nom() ?></td>
                                            <td class="hidden-phone"><?= $projetManager->getProjetById($locau->idProjet())->nom() ?></td>
                                            <td><?= $locau->superficie() ?></td>
                                            <td class="hidden-phone"><?= $locau->facade() ?></td>
                                            <td class="hidden-phone">
                                                <?php if($locau->mezzanine()=="Sans"){ ?><a class="btn mini black"><?= $locau->mezzanine() ?></a><?php } ?>
                                                <?php if($locau->mezzanine()=="Avec"){ ?><a class="btn mini blue"><?= $locau->mezzanine() ?></a><?php } ?>
                                            </td>
                                            <td>
                                                <?php 
                                                if ( $locau->status()=="Disponible" ) {  
                                                ?>
                                                    <a class="btn mini green">Disponible</a>
                                                <?php
                                                }         
                                                ?>
                                            </td>
                                        </tr>
                                        <?php
                                        }//end of loop
                                        ?>
                                        </tbody>
                                </table>
                            </div>
                        </div>
                        <?php } ?>
                        <!-- END LOCAUX TABLE PORTLET-->
                        <!-- BEGIN MAISONS TABLE PORTLET-->
                        <?php if ( $type ==  "maisons" ) { ?>
                        <div class="portlet box grey">
                            <div class="portlet-title">
                                <h4>Liste des maisons : <?= $biensDiponible ?> Disponilbe - <?= $biensPromesseVente ?> Promesse de vente - <?= $biensVendu ?> Vendu - <?= $biens ?> Total</h4>
                                <div class="tools">
                                    <a href="javascript:;" class="collapse"></a>
                                    <a href="javascript:;" class="remove"></a>
                                </div>
                            </div>
                            <div class="portlet-body">
                                <table class="table table-bordered table-hover" id="sample_1">
                                    <thead>
                                        <tr>
                                            <th style="width: 10%">Code</th>
                                            <th style="width: 15%">Projet</th>
                                            <th style="width: 5%">N.Etages</th>
                                            <th style="width: 10%">Superficie</th>
                                            <th style="width: 40%">Emplacement</th>
                                            <th style="width: 20%">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach($maisons as $maison){
                                        ?>      
                                        <tr class="terrains">
                                            <td><?= $maison->nom() ?></td>
                                            <td class="hidden-phone"><?= $projetManager->getProjetById($maison->idProjet())->nom() ?></td>
                                            <td class="hidden-phone"><?= $maison->nombreEtage() ?></td>
                                            <!--td><a></a></td-->
                                            <td><?= $maison->superficie() ?> m<sup>2</sup></td>
                                            <td class="hidden-phone"><?= $maison->emplacement() ?></td>
                                            <td>
                                                <?php
                                                if ( $maison->status()=="Disponible" ) {
                                                ?>
                                                    <a class="btn mini green">
                                                        Disponible
                                                    </a>
                                                <?php        
                                                }    
                                                ?>
                                            </td>
                                        </tr>
                                        <?php
                                        }//end of loop
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <?php } ?>
                        <!-- END MAISONS TABLE PORTLET-->
                        <!-- BEGIN TERRAINS TABLE PORTLET-->
                        <?php if ( $type ==  "terrains" ) { ?>
                        <div class="portlet box grey">
                            <div class="portlet-title">
                                <h4>Liste des terrains : <?= $biensDiponible ?> Disponilbe - <?= $biensPromesseVente ?> Promesse de vente - <?= $biensVendu ?> Vendu - <?= $biens ?> Total</h4>
                                <div class="tools">
                                    <a href="javascript:;" class="collapse"></a>
                                    <a href="javascript:;" class="remove"></a>
                                </div>
                            </div>
                            <div class="portlet-body">
                                <table class="table table-bordered table-hover" id="sample_1">
                                    <thead>
                                        <tr>
                                            <th style="width: 10%">Code</th>
                                            <th style="width: 15%">Projet</th>
                                            <th style="width: 10%">Superficie</th>
                                            <th style="width: 40%">Emplacement</th>
                                            <th style="width: 20%">Status</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach($terrains as $terrain){
                                        ?>      
                                        <tr class="terrains">
                                            <td><?= $terrain->nom() ?></td>
                                            <td class="hidden-phone"><?= $projetManager->getProjetById($terrain->idProjet())->nom() ?></td>
                                            <!--td><a></a></td-->
                                            <td><?= $terrain->superficie() ?> m<sup>2</sup></td>
                                            <td class="hidden-phone"><?= $terrain->emplacement() ?></td>
                                            <td>
                                                <?php
                                                if ( $terrain->status()=="Disponible" ) {
                                                ?>
                                                    <a class="btn mini green">
                                                        Disponible
                                                    </a>
                                                <?php        
                                                }    
                                                ?>
                                            </td>
                                        </tr>
                                        <?php
                                        }//end of loop
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <?php } ?>
                        <!-- END TERRAINS TABLE PORTLET-->
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
    <script src="assets/jquery-ui/jquery-ui-1.10.1.custom.min.js"></script>
    <script src="assets/jquery-slimscroll/jquery.slimscroll.min.js"></script>   
    <script type="text/javascript" src="assets/uniform/jquery.uniform.min.js"></script>
    <script type="text/javascript" src="assets/data-tables/jquery.dataTables.js"></script>
    <script type="text/javascript" src="assets/data-tables/DT_bootstrap.js"></script>
    <script src="assets/js/app.js"></script>
    <script>
        jQuery(document).ready(function() {         
            // initiate layout and plugins
            App.setPage("table_managed");
            App.init();
        });
        $('#status').on('change',function(){
            if( $(this).val()!=="Disponible"){
            $("#par").show()
            }
            else{
            $("#par").hide()
            }
        });
    </script>   
</body>
<!-- END BODY -->
</html>
<?php
}
/*else if(isset($_SESSION['userMerlaTrav']) and $_SESSION->profil()!="admin"){
    header('Location:dashboard.php');
}*/
else{
    header('Location:index.php');    
}
?>