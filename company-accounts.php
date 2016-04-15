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
    	$societeManager = new SocieteManager($pdo);
    	if(isset($_GET['idSociete']) and 
    	($_GET['idSociete'] >=1 and $_GET['idSociete'] <= $societeManager->getLastId()) ){
	    	$idSociete = $_GET['idSociete'];
	    	$projetManager = new ProjetManager($pdo);
			$compteBancaireManager = new CompteBancaireManager($pdo);
			$projets = $projetManager->getProjetsByIdSociete($idSociete);
			$comptesBancaires = $compteBancaireManager->getCompteBancairesByIdSociete($idSociete);
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
							Gestion des comptes bancaires - Société : <strong><?= $societeManager->getSocieteById($idSociete)->raisonSociale() ?></strong> 
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
								<i class="icon-money"></i>
								<a>Gestion des comptes bancaires</a>
							</li>
						</ul>
						<!-- END PAGE TITLE & BREADCRUMB-->
					</div>
				</div>
				<!-- END PAGE HEADER-->
				<div class="row-fluid">
					<div class="span12">
						<!-- addSocieteCompte box begin-->
						<div id="addSocieteCompteBancaire" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
								<h3>Ajouter un nouveau compte bancaire</h3>
							</div>
							<div class="modal-body">
							<form class="form-horizontal" action="controller/CompteBancaireActionController.php" method="post" enctype="multipart/form-data">
									<p>Ajouter un compte bancaire pour la société <strong><?= $societeManager->getSocieteById($idSociete)->raisonSociale() ?></strong></p>
									<div class="control-group">
										<label class="control-label">Numéro du compte</label>
										<div class="controls">
											<input type="text" name="numeroCompte">
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
											<input type="hidden" name="idSociete" value="<?= $idSociete?>" />
											<input type="hidden" name="action" value="add" />
											<button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
											<button type="submit" class="btn red" aria-hidden="true">Oui</button>
										</div>
									</div>
								</form>
							</div>
						</div>
						<!-- addSocieteCompte box end -->
						<!-- BEGIN Terrain TABLE PORTLET-->
						<?php if(isset($_SESSION['bien-action-message'])){ ?>
							<div class="alert alert-success">
								<button class="close" data-dismiss="alert"></button>
								<?= $_SESSION['bien-action-message'] ?>		
							</div>
						 <?php } 
							unset($_SESSION['bien-action-message']);
						 ?>
						<div class="portlet box light-grey" id="history">
                            <div class="portlet-title">
                                <h4>Liste des comptes</h4>
                                <div class="tools">
                                    <a href="javascript:;" class="reload"></a>
                                </div>
                            </div>
                            <div class="portlet-body">
                                <div class="clearfix">
                                    <?php
                                    if ( 
                                        $_SESSION['userMerlaTrav']->profil() == "admin" ||
                                        $_SESSION['userMerlaTrav']->profil() == "manager"
                                        ) { 
                                    ?> 
                                    <div class="btn-group pull-right">
                                        <a class="btn green" href="#addSocieteCompteBancaire" data-toggle="modal">
                                            Nouveau Compte Bancaire <i class="icon-plus-sign m-icon-white"></i>
                                        </a>
                                    </div>
                                    <?php
                                    } 
                                    ?>
                                </div>
								<table class="table table-bordered table-hover" id="sample_1">
									<thead>
										<tr>
										    <th class="hidden"></th>
											<th style="width:50%">Numéro compte</th>
											<th style="width:40%">Date création</th>
											<th style="width:10%">Actions</th>
										</tr>
									</thead>
									<tbody>
										<?php
										foreach($comptesBancaires as $compte){
										?>		
										<tr>
										    <td class="hidden"></td>
											<td><?= $compte->numero() ?></td>
											<td><?= date('d/m/Y', strtotime($compte->dateCreation())) ?></td>
											<td>
											<?php
                                            if ( 
                                                $_SESSION['userMerlaTrav']->profil() == "admin"
                                                ) { 
                                            ?>                                      
                                            <a title="Modifier" class="btn mini green" href="#updateCompte<?= $compte->id();?>" data-toggle="modal" data-id="<?= $compte->id(); ?>">
                                                <i class="icon-refresh"></i>    
                                            </a>
                                            <a title="Supprimer" class="btn mini red" href="#deleteCompte<?= $compte->id() ?>" data-toggle="modal" data-id="<?= $compte->id() ?>">
                                                <i class="icon-remove"></i>
                                            </a>
                                            <?php 
                                            } 
                                            ?>
                                            </td>
										</tr>
										<!-- updateCompte box begin-->
										<div id="updateCompte<?= $compte->id() ?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
												<h3>Modifier les informations du compte bancaire</h3>
											</div>
											<div class="modal-body">
												<form class="form-horizontal" action="controller/CompteBancaireActionController.php" method="post" enctype="multipart/form-data">
													<div class="control-group">
														<label class="control-label">Numéro Compte</label>
														<div class="controls">
															<input type="text" name="numeroCompte" value="<?= $compte->numero() ?>" />
														</div>
													</div>
													<div class="control-group">
														<label class="control-label">Date Création</label>
														<div class="controls date date-picker" data-date="" data-date-format="yyyy-mm-dd">
						                                    <input name="dateCreation" id="dateCreation" class="m-wrap m-ctrl-small date-picker" type="text" value="<?= $compte->dateCreation() ?>" />
						                                    <span class="add-on"><i class="icon-calendar"></i></span>
						                                 </div>
													</div>
													<div class="control-group">
														<div class="controls">
															<input type="hidden" name="idSociete" value="<?= $idSociete ?>" />
															<input type="hidden" name="idCompte" value="<?= $compte->id() ?>">
															<input type="hidden" name="action" value="update" />
															<button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
															<button type="submit" class="btn red" aria-hidden="true">Oui</button>
														</div>
													</div>
												</form>
											</div>
										</div>
										<!-- updateCompte box end -->	
										<!-- delete box begin-->
										<div id="deleteCompte<?= $compte->id() ?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
												<h3>Supprimer le compte bancaire</h3>
											</div>
											<div class="modal-body">
												<form class="form-horizontal loginFrm" action="controller/CompteBancaireActionController.php" method="post">
													<p>Êtes-vous sûr de vouloir supprimer le compte bancaire <strong>N°<?= $compte->numero() ?></strong> ?</p>
													<div class="control-group">
														<label class="right-label"></label>
														<input type="hidden" name="idSociete" value="<?= $idSociete ?>" />
														<input type="hidden" name="idCompte" value="<?= $compte->id() ?>" />
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
		2015 &copy; MerlaTravERP. Management Application.
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
	<script src="assets/js/app.js"></script>
	<script type="text/javascript" src="script.js"></script>		
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