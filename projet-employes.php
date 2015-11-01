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
    	//les sources
    	$idProjet = 0;
    	$projetManager = new ProjetManager($pdo);
		$employeManager = new EmployeManager($pdo);
		$paiementManager = new PaiementEmployeManager($pdo);
		if(isset($_GET['idProjet']) and ($_GET['idProjet'])>0 and $_GET['idProjet']<=$projetManager->getLastId()){
			$idProjet = $_GET['idProjet'];
			$projet = $projetManager->getProjetById($idProjet);
			$employes = $employeManager->getEmployes();
			$paiementNumber = $paiementManager->getPaiementEmployeNumberByIdProjet($idProjet);
			if($paiementNumber != 0){
				$paiements = $paiementManager->getPaiementsByIdProjet($idProjet);	
			}		
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
							Gestion des contrats des employés
						</h3>
						<ul class="breadcrumb">
							<li>
								<i class="icon-home"></i>
								<a>Accueil</a> 
								<i class="icon-angle-right"></i>
							</li>
							<li>
								<i class="icon-briefcase"></i>
								<a>Gestion des projets</a>
								<i class="icon-angle-right"></i>
							</li>
							<li><a>Liste des contrats des employés</a></li>
						</ul>
						<!-- END PAGE TITLE & BREADCRUMB-->
					</div>
				</div>
				<!-- END PAGE HEADER-->
				<div class="row-fluid">
					<div class="span12">
						<div class="row-fluid add-portfolio">
							<div class="pull-left">
								<a href="projets.php" class="btn icn-only green"><i class="m-icon-swapleft m-icon-white"></i> Retour vers Liste des projets</a>
							</div>
							<div class="pull-right">
								<a href="#addEmploye" data-toggle="modal" class="btn icn-only blue">Nouveau Employé <i class="icon-plus-sign"></i></a>
								<a href="#addPaiement" data-toggle="modal" class="btn icn-only black">Nouveau Paiement <i class="icon-plus-sign"></i></a>
							</div>
						</div>
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
											<button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
											<button type="submit" class="btn red" aria-hidden="true">Oui</button>
										</div>
									</div>
								</form>
							</div>
						</div>
						<!-- addEmploye box end -->
						<!-- addPaiement box begin-->
						<div id="addPaiement" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
								<h3>Ajouter un nouveau paiement </h3>
							</div>
							<div class="modal-body">
								<form class="form-horizontal" action="controller/PaiementAddController.php" method="post">
									<div class="control-group">
										<label class="control-label">Employé</label>
										<div class="controls">
											<select name="idEmploye">
												<?php foreach($employes as $employe){ ?>
												<option value="<?= $employe->id() ?>"><?= $employe->nom() ?></option>
												<?php } ?>
											</select>
										</div>
									</div>
									<div class="control-group">
										<label class="control-label">Date Opération</label>
										<div class="controls">
											<div class="input-append date date-picker" data-date="" data-date-format="yyyy-mm-dd">
												<input name="dateOperation" id="dateOperation" class="m-wrap m-ctrl-small date-picker" type="text" value="<?= date('Y-m-d') ?>" />
												<span class="add-on"><i class="icon-calendar"></i></span>
											</div>
										 </div>
									</div>
									<div class="control-group">
										<label class="control-label">Montant</label>
										<div class="controls">
											<input type="text" name="montant" value="" />
										</div>
									</div>
									<div class="control-group">
										<label class="control-label">Numéro Chèque</label>
										<div class="controls">
											<input type="text" name="numeroCheque" value="" />
										</div>
									</div>
									<div class="control-group">
										<div class="controls">	
											<input type="hidden" name="idProjet" value="<?= $idProjet ?>" />
											<button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
											<button type="submit" class="btn red" aria-hidden="true">Oui</button>
										</div>
									</div>
								</form>
							</div>
						</div>
						<!-- addPaiement box end -->
						<!-- BEGIN Terrain TABLE PORTLET-->
						<?php if(isset($_SESSION['employe-add-error'])){ ?>
							<div class="alert alert-error">
								<button class="close" data-dismiss="alert"></button>
								<?= $_SESSION['employe-add-error'] ?>		
							</div>
						 <?php } 
							unset($_SESSION['employe-add-error']);
						 ?>
						 <?php if(isset($_SESSION['employe-add-success'])){ ?>
							<div class="alert alert-success">
								<button class="close" data-dismiss="alert"></button>
								<?= $_SESSION['employe-add-success'] ?>		
							</div>
						 <?php } 
							unset($_SESSION['employe-add-success']);
						 ?>
						<?php if(isset($_SESSION['paiement-add-success'])){ ?>
							<div class="alert alert-success">
								<button class="close" data-dismiss="alert"></button>
								<?= $_SESSION['paiement-add-success'] ?>		
							</div>
						 <?php } 
							unset($_SESSION['paiement-add-success']);
						 ?>
						<?php if(isset($_SESSION['paiement-add-error'])){ ?>
							<div class="alert alert-error">
								<button class="close" data-dismiss="alert"></button>
								<?= $_SESSION['paiement-add-error'] ?>		
							</div>
						 <?php } 
							unset($_SESSION['paiement-add-error']);
						 ?>
						 <?php if(isset($_SESSION['paiement-update-success'])){ ?>
							<div class="alert alert-success">
								<button class="close" data-dismiss="alert"></button>
								<?= $_SESSION['paiement-update-success'] ?>		
							</div>
						 <?php } 
							unset($_SESSION['paiement-update-success']);
						 ?>
						 <?php if(isset($_SESSION['paiement-update-error'])){ ?>
							<div class="alert alert-error">
								<button class="close" data-dismiss="alert"></button>
								<?= $_SESSION['paiement-update-error'] ?>		
							</div>
						 <?php } 
							unset($_SESSION['paiement-update-error']);
						 ?>
						 <?php if(isset($_SESSION['paiement-delete-success'])){ ?>
							<div class="alert alert-success">
								<button class="close" data-dismiss="alert"></button>
								<?= $_SESSION['paiement-delete-success'] ?>		
							</div>
						 <?php } 
							unset($_SESSION['paiement-delete-success']);
						 ?>
						 <div class="row-fluid">
							    <div class="input-box autocomplet_container">
									<input class="m-wrap" name="nomEmploye" id="nomEmploye" type="text" placeholder="Chercher Employé..." />
							    </div>
							</div>
						<div class="portlet box purple">
							<div class="portlet-title">
								<h4>Liste des Contrats Employés du Projet : <strong><?= $projet->nom() ?></strong></h4>
								<div class="tools">
									<a href="javascript:;" class="collapse"></a>
									<a href="javascript:;" class="remove"></a>
								</div>
							</div>
							<div class="portlet-body">
								<div class="scroller" data-height="500px" data-always-visible="1"><!-- BEGIN DIV SCROLLER -->
								<table class="table table-striped table-bordered table-advance table-hover">
									<thead>
										<tr>
											<th style="width:20%">Employé</th>
											<th style="width:20%" class="hidden-phone">Date Paiement</th>
											<th style="width:20%" class="hidden-phone">Montant Payé</th>
											<th style="width:20%" class="hidden-phone">Total Paiement</th>
											<th style="width:20%" class="hidden-phone">Numéro chèque</th>
										</tr>
									</thead>
									<tbody>
										<?php
										if($paiementNumber != 0){
										foreach($paiements as $contrat){
										?>		
										<tr class="clients">
											<td>
												<div class="btn-group">
												    <a style="width: 200px" class="btn mini dropdown-toggle" href="#" data-toggle="dropdown">
												    	<?= $employeManager->getEmployeById($contrat->idEmploye())->nom() ?> 
												        <i class="icon-angle-down"></i>
												    </a>
												    <ul class="dropdown-menu">
												        <li>
												        	<a target="_blank" href="controller/PaiementEmployePrintController.php?idContrat=<?= $contrat->id() ?>">
												        		Imprimer Contrat
												        	</a>
															<a href="#updatePaiement<?= $contrat->id() ?>" data-toggle="modal" data-id="<?= $contrat->id() ?>">
												        		Modifier
												        	</a>
												        	<a href="#deletePaiement<?= $contrat->id() ?>" data-toggle="modal" data-id="<?= $contrat->id() ?>">
												        		Supprimer
												        	</a>
												        </li>
												    </ul>
												</div>
											</td>
											<td class="hidden-phone"><?= $contrat->dateOperation() ?></td>
											<td class="hidden-phone"><?= number_format($contrat->montant(), 2, ',', ' ') ?></td>
											<td class="hidden-phone"><?= number_format($paiementManager->getTotalPaiementsByIdProjetByIdEmploye($contrat->idProjet(), $contrat->idEmploye()), 2, ',', ' ') ?></td>
											<td class="hidden-phone"><?= $contrat->numeroCheque() ?></td>
										</tr>
										<!-- updatePaiement box begin -->
										<div id="updatePaiement<?= $contrat->id();?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
												<h3>Modifier Paiement pour l'employé <?= $employeManager->getEmployeById($contrat->idEmploye())->nom() ?></h3>
											</div>
											<div class="modal-body">
												<form class="form-horizontal loginFrm" action="controller/PaiementUpdateController.php" method="post">
													<div class="control-group">
														<label class="control-label">Employé</label>
														<div class="controls">
															<select name="idEmploye">
																<option value="<?= $contrat->idEmploye() ?>"><?= $employeManager->getEmployeById($contrat->idEmploye())->nom() ?></option>
																<option disabled="disabled">-----------------</option>
																<?php foreach($employes as $employe){ ?>
																<option value="<?= $employe->id() ?>"><?= $employe->nom() ?></option>
																<?php } ?>
															</select>
														</div>
													</div>
													<div class="control-group">
														<label class="control-label">Date Opération</label>
														<div class="controls">
															<div class="input-append date date-picker" data-date="" data-date-format="yyyy-mm-dd">
																<input name="dateOperation" id="dateOperation" class="m-wrap m-ctrl-small date-picker" type="text" value="<?= $contrat->dateOperation() ?>" />
																<span class="add-on"><i class="icon-calendar"></i></span>
															</div>
														 </div>
													</div>
													<div class="control-group">
														<label class="control-label">Montant</label>
														<div class="controls">
															<input type="text" name="montant" value="<?= $contrat->montant() ?>" />
														</div>
													</div>
													<div class="control-group">
														<label class="control-label">Numéro Chèque</label>
														<div class="controls">
															<input type="text" name="numeroCheque" value="<?= $contrat->numeroCheque() ?>" />
														</div>
													</div>
													<div class="control-group">
														<input type="hidden" name="idPaiement" value="<?= $contrat->id() ?>" />
														<input type="hidden" name="idProjet" value="<?= $projet->id() ?>" />
														<button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
														<button type="submit" class="btn red" aria-hidden="true">Oui</button>
													</div>
												</form>
											</div>
										</div>
										<!-- updatePaiementContrat box end -->		
										<!-- delete box begin-->
										<div id="deletePaiement<?= $contrat->id();?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
												<h3>Supprimer Paiement <?= $contrat->id() ?></h3>
											</div>
											<div class="modal-body">
												<form class="form-horizontal loginFrm" action="controller/PaiementDeleteController.php" method="post">
													<p>Êtes-vous sûr de vouloir supprimer ce paiement <strong><?= $contrat->id() ?></strong> ?</p>
													<div class="control-group">
														<label class="right-label"></label>
														<input type="hidden" name="idPaiement" value="<?= $contrat->id() ?>" />
														<input type="hidden" name="idProjet" value="<?= $projet->id() ?>" />
														<button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
														<button type="submit" class="btn red" aria-hidden="true">Oui</button>
													</div>
												</form>
											</div>
										</div>
										<!-- delete box end -->		
										<?php
										}//end of loop
										}//end of if
										?>
									</tbody>
								</table>
								</div><!-- END SCROLL DIV -->
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
			//App.setPage("table_editable");
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