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
        $chargesCommunsManager = new ChargesCommunsManager($pdo);
        //
        if(isset($_GET['idSociete']) and 
        ($_GET['idSociete'] >=1 and $_GET['idSociete'] <= $societeManager->getLastId()) ) {
            $idSociete = $_GET['idSociete'];
            $chargesCommuns = $chargesCommunsManager->getChargesCommunsBySociete($idSociete);
            $projets = $projetManager->getProjetsByIdSociete($idSociete);
            $societes = $societeManager->getSocietes();
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
                            Gestion des charges communs - Societe : <strong><?= $societe->raisonSociale() ?></strong>
                        </h3>
                        <ul class="breadcrumb">
                            <li>
                                <i class="icon-dashboard"></i>
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
                                <a>Gestion des charges communs</a>
                            </li>
                        </ul>
                        <!-- END PAGE TITLE & BREADCRUMB-->
                    </div>
                </div>
                <!-- END PAGE HEADER-->
                <div class="row-fluid">
                    <div class="span12">
                        <div id="addCharge" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                <h3>Ajouter une nouvelle charge </h3>
                            </div>
                            <div class="modal-body">
                                <form class="form-horizontal" action="controller/ChargesCommunsActionController.php" method="post" enctype="multipart/form-data">
                                    <div class="control-group">
                                        <label class="control-label">Date Opération</label>
                                        <div class="controls date date-picker" data-date="" data-date-format="yyyy-mm-dd">
                                            <input name="dateOperation" id="dateOperation" class="m-wrap m-ctrl-small date-picker" type="text" value="<?= date('Y-m-d') ?>" />
                                            <span class="add-on"><i class="icon-calendar"></i></span>
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
                                            <select name="idProjet">
                                                <?php
                                                foreach ( $projets as $projet ) {
                                                ?>
                                                <option value="<?= $projet->id() ?>"><?= $projet->nom() ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>        
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Bénéficiaire</label>
                                        <div class="controls">
                                            <input type="text" name="beneficiaire" value="" />
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Numéro Chèque</label>
                                        <div class="controls">
                                            <input type="text" name="numeroCheque" value="" />
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Montant</label>
                                        <div class="controls">
                                            <input type="text" name="montant" value="" />
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <div class="controls">
                                            <input type="hidden" name="action" value="add" />
                                            <input type="hidden" name="idSociete" value="<?= $idSociete ?>" />
                                            <button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
                                            <button type="submit" class="btn red" aria-hidden="true">Oui</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- addCharge box end -->
                        <!--**************************** CHARGES COMMUNS BEGIN ****************************-->
                        <!-- printCharge box begin-->
                        <div id="printCharges" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                <h3>Imprimer Liste des Charges </h3>
                            </div>
                            <div class="modal-body">
                                <form class="form-horizontal" action="controller/ChargesCommunsPrintController.php" method="post" enctype="multipart/form-data">
                                    
                                    <div class="control-group">
                                        <div class="controls date date-picker" data-date="" data-date-format="yyyy-mm-dd">
                                           <input style="width:100px" name="dateFrom" id="dateFrom" class="m-wrap m-ctrl-small date-picker" type="text" value="<?= date('Y-m-d') ?>" />
                                           &nbsp;-&nbsp;
                                           <input style="width:100px" name="dateTo" id="dateTo" class="m-wrap m-ctrl-small date-picker" type="text" value="<?= date('Y-m-d') ?>" />
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <div class="controls">
                                            <input type="hidden" name="idSociete" value="<?= $idSociete ?>" /> 
                                            <button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
                                            <button type="submit" class="btn red" aria-hidden="true">Oui</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- printCharge box end -->
                        <!-- BEGIN Terrain TABLE PORTLET-->
                        <?php 
                        if ( isset($_SESSION['chargescommuns-action-message'])   
                             and 
                             isset($_SESSION['chargescommuns-type-message']) ) {
                                 $actionMessage = $_SESSION['chargescommuns-action-message'];
                                 $typeMessage = $_SESSION['chargescommuns-type-message'];   
                        ?>
                            <div class="alert alert-<?= $typeMessage ?>">
                                <button class="close" data-dismiss="alert"></button>
                                <?= $actionMessage ?>      
                            </div>
                         <?php } 
                            unset($_SESSION['chargescommuns-action-message']);
                            unset($_SESSION['chargescommuns-type-message']);
                         ?>
                        <!--table class="table table-striped table-bordered table-advance table-hover">
                            <thead>
                                <tr>
                                    <th><strong>Total des charges communs</strong></th>
                                    <th><a><strong><?php //number_format($chargesCommunsManager->getTotalByIdSociete($idSociete), 2, ',', ' ') ?>&nbsp;DH</strong></a></th>
                                </tr>
                            </thead>
                        </table-->
                        <div class="portlet box grey charges">
                            <div class="portlet-title">
                                <h4>Les charges communs</h4>
                                <div class="tools">
                                    <a href="javascript:;" class="collapse"></a>
                                    <a href="javascript:;" class="remove"></a>
                                </div>
                            </div>
                            <div class="portlet-body">
                                <div class="clearfix">
                                    <div class="btn-group pull-left">
                                        <a target="_blank" href="#printCharges" class="btn black" data-toggle="modal">
                                            <i class="icon-print"></i>&nbsp;Les Charges
                                        </a>
                                    </div>
                                    <div class="btn-group pull-right">
                                        <?php
                                        if ( 
                                            $_SESSION['userMerlaTrav']->profil() == "admin" ||
                                            $_SESSION['userMerlaTrav']->profil() == "manager"
                                            ) { 
                                        ?>   
                                        <a href="#addCharge" data-toggle="modal" class="btn green pull-right">
                                            Nouvelle Charge <i class="icon-plus-sign "></i>
                                        </a>
                                        <?php
                                        } 
                                        ?>   
                                    </div>
                                </div>
                                <table class="table table-striped table-bordered table-hover" id="sample_1">
                                    <thead>
                                        <tr>
                                            <th class="hidden"></th>
                                            <th style="width:15%" class="hidden-phone">Date Opération</th>
                                            <th style="width:15%" class="hidden-phone">Projet</th>
                                            <th style="width:20%" class="hidden-phone">Désignation</th>
                                            <th style="width:15%" class="hidden-phone">Bénéficiaire</th>
                                            <th style="width:15%" class="hidden-phone">Numéro Chèque</th>
                                            <th style="width:10%" class="hidden-phone">Montant</th>
                                            <th style="width:10%" class="hidden-phone">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach($chargesCommuns as $charges){
                                        ?>      
                                        <tr class="charges">
                                            <td class="hidden"></td>
                                            <td><?= date('d/m/Y', strtotime($charges->dateOperation())) ?></td>
                                            <td class="hidden-phone"><?= $projetManager->getProjetById($charges->idProjet())->nom() ?></td>
                                            <td class="hidden-phone"><?= $charges->designation() ?></td>
                                            <td class="hidden-phone"><?= $charges->beneficiaire() ?></td>
                                            <td class="hidden-phone"><?= $charges->numeroCheque() ?></td>
                                            <td class="hidden-phone"><?= number_format($charges->montant(), 2, ',', ' ') ?></td>
                                            <td>             
                                                <?php
                                                if ( 
                                                    $_SESSION['userMerlaTrav']->profil() == "admin" ||
                                                    $_SESSION['userMerlaTrav']->profil() == "manager"
                                                    ) { 
                                                ?>                                                  
                                                <a class="btn mini green" title="Modifier" href="#updateCharge<?= $charges->id();?>" data-toggle="modal" data-id="<?= $charges->id(); ?>">
                                                    <i class="icon-refresh"></i>    
                                                </a>
                                                <?php
                                                }
                                                if ( $_SESSION['userMerlaTrav']->profil() == "admin" ) { 
                                                ?>   
                                                <a class="btn mini red" title="Supprimer" href="#deleteCharge<?= $charges->id() ?>" data-toggle="modal" data-id="<?= $charges->id() ?>">
                                                    <i class="icon-remove"></i>
                                                </a>
                                                <?php
                                                } 
                                                ?>   
                                            </td>
                                        </tr>
                                        <!-- updateCharge box begin-->
                                        <div id="updateCharge<?= $charges->id() ?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                <h3>Modifier Info Charge commune </h3>
                                            </div>
                                            <div class="modal-body">
                                                <form class="form-horizontal" action="controller/ChargesCommunsActionController.php" method="post">
                                                    <div class="control-group">
                                                        <label class="control-label">Date Opération</label>
                                                        <div class="controls date date-picker" data-date="" data-date-format="yyyy-mm-dd">
                                                            <input name="dateOperation" id="dateOperation" class="m-wrap m-ctrl-small date-picker" type="text" value="<?= $charges->dateOperation() ?>" />
                                                            <span class="add-on"><i class="icon-calendar"></i></span>
                                                         </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <label class="control-label">Désignation</label>
                                                        <div class="controls">
                                                            <input type="text" name="designation" value="<?= $charges->designation() ?>" />
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <label class="control-label">Projet</label>
                                                        <div class="controls">
                                                            <select name="idProjet">
                                                                <option value="<?= $charges->idProjet() ?>"><?= $projetManager->getProjetById($charges->idProjet())->nom() ?></option>
                                                                <?php
                                                                foreach ( $projets as $projet ) {
                                                                ?>
                                                                <option value="<?= $projet->id() ?>"><?= $projet->nom() ?></option>
                                                                <?php
                                                                }
                                                                ?>
                                                            </select>        
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <label class="control-label">Bénéficiaire</label>
                                                        <div class="controls">
                                                            <input type="text" name="beneficiaire" value="<?= $charges->beneficiaire() ?>" />
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <label class="control-label">Numéro Chèque</label>
                                                        <div class="controls">
                                                            <input type="text" name="numeroCheque" value="<?= $charges->numeroCheque() ?>" />
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <label class="control-label">Montant</label>
                                                        <div class="controls">
                                                            <input type="text" name="montant" value="<?= $charges->montant() ?>" />
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <input type="hidden" name="action" value="update" />
                                                        <input type="hidden" name="idChargesCommuns" value="<?= $charges->id() ?>" />
                                                        <input type="hidden" name="idSociete" value="<?= $idSociete ?>" />
                                                        <div class="controls">  
                                                            <button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
                                                            <button type="submit" class="btn red" aria-hidden="true">Oui</button>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <!-- updateChargeTerrain box end -->            
                                        <!-- deleteChargeTerrain box begin-->
                                        <div id="deleteCharge<?= $charges->id() ?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                <h3>Supprimer la charge commune </h3>
                                            </div>
                                            <div class="modal-body">
                                                <form class="form-horizontal loginFrm" action="controller/ChargesCommunsActionController.php" method="post">
                                                    <p>Êtes-vous sûr de vouloir supprimer cette charge commune <strong><?= $charges->designation() ?></strong> ?</p>
                                                    <div class="control-group">
                                                        <label class="right-label"></label>
                                                        <input type="hidden" name="action" value="delete" />
                                                        <input type="hidden" name="idChargesCommuns" value="<?= $charges->id() ?>" />
                                                        <input type="hidden" name="idSociete" value="<?= $idSociete ?>" />
                                                        <button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
                                                        <button type="submit" class="btn red" aria-hidden="true">Oui</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <!-- deleteChargeCommuns box end -->    
                                        <?php
                                        }//end of loop
                                        ?>
                                        </tbody>
                                </table>
                                <table class="table table-striped table-bordered table-hover">
                                    <tbody>
                                        <tr>
                                            <td style="width:75%"><strong>Total des charges communs</strong></td>
                                            <td style="width:25%"><strong><a><?= number_format($chargesCommunsManager->getTotalByIdSociete($idSociete), 2, ',', ' ') ?>&nbsp;DH</a></strong></td>
                                        </tr>
                                    </tbody>
                                </table>
                                <!--/div>< END DIV SCROLLER --> 
                            </div>
                        </div>
                        <!-- END CHARGES COMMUNS TABLE PORTLET-->
                        <!--**************************** CHARGES COMMUNS END ****************************-->
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
            App.setPage("table_managed");
            App.init();
        });
        $('.charges').show();
        $('#designation').keyup(function(){
            $('.charges').hide();
           var txt = $('#designation').val();
           $('.charges').each(function(){
               if($(this).text().toUpperCase().indexOf(txt.toUpperCase()) != -1){
                   $(this).show();
               }
            });
        }); 
        $('#beneficiaire').keyup(function(){
            $('.charges').hide();
           var txt = $('#beneficiaire').val();
           $('.charges').each(function(){
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