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
        $idProjet = 0;
        $idSociete = $_GET['idSociete'];
        $projetManager = new ProjetManager($pdo);
        $societeManager = new SocieteManager($pdo);
        $contratEmployeManager = new ContratEmployeManager($pdo);
        $contratDetaislManager = new ContratDetailsManager($pdo);
        $employesManager = new EmployeManager($pdo);
        $societe = $societeManager->getSocieteById($idSociete);
        if(isset($_GET['idProjet']) and ($_GET['idProjet'])>0 and $_GET['idProjet']<=$projetManager->getLastId()){
            $idProjet = $_GET['idProjet'];
            $projet = $projetManager->getProjetById($idProjet);
            $contratEmployes = $contratEmployeManager->getContratEmployesByIdProjet($idProjet);
            $employes = $employesManager->getEmployes();
            //} 
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
                            Gestion des contrats des employés - Projet : <strong><?= $projetManager->getProjetById($idProjet)->nom() ?></strong>
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
                                <a href="project-management.php?idProjet=<?= $idProjet ?>&idSociete=<?= $idSociete ?>">Projet <strong><?= $projetManager->getProjetById($idProjet)->nom() ?></strong></a>
                                <i class="icon-angle-right"></i>
                            </li>
                            <li>
                                <i class="icon-group"></i>
                                <a>Gestion des Contrats Employés</a>
                            </li>
                        </ul>
                        <!-- END PAGE TITLE & BREADCRUMB-->
                    </div>
                </div>
                <!-- END PAGE HEADER-->
                <div class="row-fluid">
                    <div class="span12">
                        <!-- addEmploye box begin-->
                        <div id="addEmploye" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                <h3>Ajouter un nouveau employé </h3>
                            </div>
                            <div class="modal-body">
                                <form class="form-horizontal" action="controller/EmployeAddController.php" method="post">
                                    <div class="control-group">
                                        <label class="control-label">Nom</label>
                                        <div class="controls">
                                            <input type="text" name="nom" value="" />
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">CIN</label>
                                        <div class="controls">
                                            <input type="text" name="cin" value="" />
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Adresse</label>
                                        <div class="controls">
                                            <input type="text" name="adresse" value="" />
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Téléphone</label>
                                        <div class="controls">
                                            <input type="text" name="telephone" value="" />
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <div class="controls">  
                                            <input type="hidden" name="idProjet" value="<?= $idProjet ?>" />
                                            <input type="hidden" name="idSociete" value="<?= $idSociete ?>" />
                                            <button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
                                            <button type="submit" class="btn red" aria-hidden="true">Oui</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- addEmploye box end -->
                        <!-- addContratEmploye box begin-->
                        <div id="addContratEmploye" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                <h3>Ajouter un nouveau contrat employé </h3>
                            </div>
                            <div class="modal-body">
                                <form class="form-horizontal" action="controller/ContratEmployeActionController.php" method="post">
                                    <div class="control-group">
                                        <label class="control-label">Employé</label>
                                        <div class="controls">
                                            <select name="employe">
                                                <?php foreach($employes as $employe){ ?>
                                                <option value="<?= $employe->nom() ?>"><?= $employe->nom() ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Date Contrat</label>
                                        <div class="controls">
                                            <div class="input-append date date-picker" data-date="" data-date-format="yyyy-mm-dd">
                                                <input name="dateContrat" id="dateContrat" class="m-wrap m-ctrl-small date-picker" type="text" value="<?= date('Y-m-d') ?>" />
                                                <span class="add-on"><i class="icon-calendar"></i></span>
                                            </div>
                                         </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Prix/Unité</label>
                                        <div class="controls">
                                            <input type="text" name="prixUnitaire" id="prixUnitaire" value="" />
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Nombre Unités</label>
                                        <div class="controls">
                                            <input type="text" name="nombreUnites" id="nombreUnites" value="" />
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <label class="control-label">Total</label>
                                        <div class="controls">
                                            <input type="text" name="total" id="total" value="" />
                                        </div>
                                    </div>
                                    <div class="control-group">
                                        <div class="controls">  
                                            <input type="hidden" name="idProjet" value="<?= $idProjet ?>" />
                                            <input type="hidden" name="idSociete" value="<?= $idSociete ?>" />
                                            <input type="hidden" name="action" value="add" />
                                            <button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
                                            <button type="submit" class="btn red" aria-hidden="true">Oui</button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <!-- addPaiement box end -->
                        <!-- BEGIN Terrain TABLE PORTLET-->
                        <?php if(isset($_SESSION['contratEmploye-action-message'])){ ?>
                            <div class="alert alert-<?= $_SESSION['contratEmploye-type-message'] ?>">
                                <button class="close" data-dismiss="alert"></button>
                                <?= $_SESSION['contratEmploye-action-message'] ?>       
                            </div>
                         <?php } 
                            unset($_SESSION['contratEmploye-action-message']);
                         ?>
                         <!--div class="row-fluid">
                            <div class="input-box autocomplet_container">
                                <input class="m-wrap" name="nomEmploye" id="nomEmploye" type="text" placeholder="Chercher Employé..." />
                            </div>
                        </div-->
                        <div class="portlet box blue">
                            <div class="portlet-title">
                                <h4>Liste des Contrats Employés</h4>
                                <div class="tools">
                                    <a href="javascript:;" class="collapse"></a>
                                    <a href="javascript:;" class="remove"></a>
                                </div>
                            </div>
                            <div class="portlet-body">
                                <?php
                                if ( 
                                    $_SESSION['userMerlaTrav']->profil() == "admin" ||
                                    $_SESSION['userMerlaTrav']->profil() == "manager"
                                    ) { 
                                ?>  
                                <div class="clearfix">
                                    <div class="btn-group pull-right">
                                        <div>
                                            <div class="pull-right">
                                                <a href="#addContratEmploye" data-toggle="modal" class="btn icn-only green">Nouveau Contrat Employé <i class="icon-plus-sign"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <?php
                                } 
                                ?>
                                <!--div class="scroller" data-height="500px" data-always-visible="1"--><!-- BEGIN DIV SCROLLER -->
                                <table class="table table-striped table-bordered table-hover" id="sample_1">
                                    <thead>
                                        <tr>
                                            <th class="hidden"></th>
                                            <th style="width:15%">Employé</th>
                                            <th style="width:10%">Date Contrat</th>
                                            <th style="width:10%">Prix/Unité</th>
                                            <th style="width:10%">Nombre Unités</th>
                                            <th style="width:15%">Total Paiements</th>
                                            <th style="width:15%">Total à Payer</th>
                                            <th style="width:15%">Reste</th>
                                            <th style="width:10%">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach($contratEmployes as $contrat){
                                        ?>      
                                        <tr class="clients">
                                            <td class="hidden"></td>
                                            <td><?= $contrat->employe() ?></td>
                                            <td class="hidden-phone"><?= date('d/m/Y', strtotime($contrat->dateContrat()) ) ?></td>
                                            <td><?= number_format($contrat->prixUnitaire(), 2, ',', ' ') ?></td>
                                            <td><?= $contrat->nombreUnites() ?></td>
                                            <td><?= number_format($contratDetaislManager->getContratDetailsTotalByIdContratEmploye($contrat->id()), 2, ',', ' ') ?></td>
                                            <td><?= number_format($contrat->total(), 2, ',', ' ') ?></td>
                                            <td><?= number_format($contrat->total()-$contratDetaislManager->getContratDetailsTotalByIdContratEmploye($contrat->id()), 2, ',', ' ') ?></td>
                                            <td>
                                                <a class="btn mini" title="Voir Détails Contrat" href="contrat-employe-detail.php?idContratEmploye=<?= $contrat->id() ?>&idProjet=<?= $projet->id() ?>&idSociete=<?= $idSociete ?>">
                                                    <i class="icon-eye-open"></i>    
                                                </a>
                                                <?php
                                                if ( 
                                                    $_SESSION['userMerlaTrav']->profil() == "admin" ||
                                                    $_SESSION['userMerlaTrav']->profil() == "manager"
                                                    ) { 
                                                ?>
                                                <a class="btn mini green" title="Modifier" href="#updateContrat<?= $contrat->id() ?>" data-toggle="modal" data-id="<?= $contrat->id() ?>">
                                                    <i class="icon-refresh"></i>
                                                </a>
                                                <?php
                                                } 
                                                if ( $_SESSION['userMerlaTrav']->profil() == "admin" ) { 
                                                ?>
                                                <a class="btn mini red" title="Supprimer" href="#deleteContrat<?= $contrat->id() ?>" data-toggle="modal" data-id="<?= $contrat->id() ?>">
                                                    <i class="icon-remove"></i>
                                                </a>
                                                <?php 
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                        <!-- updatePaiement box begin -->
                                        <div id="updateContrat<?= $contrat->id();?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                <h3>Modifier Contrat de  <?= $contrat->employe() ?></h3>
                                            </div>
                                            <div class="modal-body">
                                                <form class="form-horizontal loginFrm" action="controller/ContratEmployeActionController.php" method="post">
                                                    <div class="control-group">
                                                        <label class="control-label">Employé</label>
                                                        <div class="controls">
                                                            <select name="employe">
                                                                <option value="<?= $contrat->employe() ?>"><?= $contrat->employe() ?></option>
                                                                <option disabled="disabled">-----------------</option>
                                                                <?php foreach($employes as $employe){ ?>
                                                                <option value="<?= $employe->nom() ?>"><?= $employe->nom() ?></option>
                                                                <?php } ?>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <label class="control-label">Date Opération</label>
                                                        <div class="controls">
                                                            <div class="input-append date date-picker" data-date="" data-date-format="yyyy-mm-dd">
                                                                <input name="dateContrat" id="dateContrat" class="m-wrap m-ctrl-small date-picker" type="text" value="<?= $contrat->dateContrat() ?>" />
                                                                <span class="add-on"><i class="icon-calendar"></i></span>
                                                            </div>
                                                         </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <label class="control-label">Prix/Unité</label>
                                                        <div class="controls">
                                                            <input type="text" name="prixUnitaire" id="prixUnitaireUpdate" value="<?= $contrat->prixUnitaire() ?>" />
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <label class="control-label">Nombre Unités</label>
                                                        <div class="controls">
                                                            <input type="text" name="nombreUnites" id="nombreUnitesUpdate" value="<?= $contrat->nombreUnites() ?>" />
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <label class="control-label">Total à payer</label>
                                                        <div class="controls">
                                                            <input type="text" name="total" id="totalUpdate" value="<?= $contrat->total() ?>" />
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <input type="hidden" name="idContratEmploye" value="<?= $contrat->id() ?>" />
                                                        <input type="hidden" name="idProjet" value="<?= $projet->id() ?>" />
                                                        <input type="hidden" name="idSociete" value="<?= $idSociete ?>" />
                                                        <input type="hidden" name="action" value="update" />
                                                        <button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
                                                        <button type="submit" class="btn red" aria-hidden="true">Oui</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <!-- updatePaiementContrat box end -->      
                                        <!-- delete box begin-->
                                        <div id="deleteContrat<?= $contrat->id();?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                <h3>Supprimer Contrat <?= $contrat->employe() ?></h3>
                                            </div>
                                            <div class="modal-body">
                                                <form class="form-horizontal loginFrm" action="controller/ContratEmployeActionController.php" method="post">
                                                    <p>Êtes-vous sûr de vouloir supprimer contrat <strong><?= $contrat->employe() ?></strong> ?</p>
                                                    <div class="control-group">
                                                        <label class="right-label"></label>
                                                        <input type="hidden" name="idContratEmploye" value="<?= $contrat->id() ?>" />
                                                        <input type="hidden" name="idProjet" value="<?= $projet->id() ?>" />
                                                        <input type="hidden" name="idSociete" value="<?= $idSociete ?>" />
                                                        <input type="hidden" name="action" value="delete" />
                                                        <button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
                                                        <button type="submit" class="btn red" aria-hidden="true">Oui</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <!-- delete box end -->     
                                        <?php
                                        }//end of loop
                                        ?>
                                    </tbody>
                                </table>
                                <!--/div--><!-- END SCROLL DIV -->
                            </div>
                        </div>
                        <!-- END Terrain TABLE PORTLET-->
                    </div>
                </div>
                <?php 
                }
                else{
                ?>
                <div class="alert alert-error">
                    <button class="close" data-dismiss="alert"></button>
                    <strong>Erreur système : </strong>Ce projet n'existe pas sur votre système. Pour plus d'informations consulter votre administrateur.        
                </div>
                <?php
                }
                ?>
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
    <script src="script.js"></script>       
    <script>
        jQuery(document).ready(function() {         
            // initiate layout and plugins
            App.setPage("table_managed");
            App.init();
        });
        $('.clients').show();
        $('#nomClient').keyup(function(){
            $('.clients').hide();
           var txt = $('#nomClient').val();
           $('.clients').each(function(){
               if($(this).text().toUpperCase().indexOf(txt.toUpperCase()) != -1){
                   $(this).show();
               }
            });
        });
        $('#nombreUnites, #prixUnitaire').change(function(){
            var nombreUnites = $('#nombreUnites').val();
            var prixUnitaire = $('#prixUnitaire').val();
            var total = nombreUnites * prixUnitaire;
            $('#total').val(total); 
        });
        $('#nombreUnitesUpdate, #prixUnitaireUpdate').change(function(){
            var nombreUnites = $('#nombreUnitesUpdate').val();
            var prixUnitaire = $('#prixUnitaireUpdate').val();
            var total = nombreUnites * prixUnitaire;
            $('#totalUpdate').val(total); 
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