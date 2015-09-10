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
		$clientManager = new ClientManager($pdo);
		$contratManager = new ContratManager($pdo);
		$operationManager = new OperationManager($pdo);
		$locauxManager = new LocauxManager($pdo);
		$maisonManager = new MaisonManager($pdo);
		$terrainManager = new TerrainManager($pdo);
		$appartementManager = new AppartementManager($pdo);
		if(isset($_GET['idProjet']) and ($_GET['idProjet'])>0 and $_GET['idProjet']<=$projetManager->getLastId()){
			$idProjet = $_GET['idProjet'];
			$projet = $projetManager->getProjetById($idProjet);
			/*if(isset($_POST['idClient']) and $_POST['idClient']>0){
				$idClient = $_POST['idClient'];
				$contrats = $contratManager->getContratsByIdClientByIdProjet($idClient, $idProjet);
				$contratNumber = -1;
			}
			else{*/
				$contratNumber = $contratManager->getContratsNumberByIdProjet($idProjet);
				if($contratNumber != 0){
					$contratPerPage = 1000;
			        $pageNumber = ceil($contratNumber/$contratPerPage);
			        $p = 1;
			        if(isset($_GET['p']) and ($_GET['p']>0 and $_GET['p']<=$pageNumber)){
			            $p = $_GET['p'];
			        }
			        else{
			            $p = 1;
			        }
			        $begin = ($p - 1) * $contratPerPage;
			        $pagination = paginate('contrats-list.php?idProjet='.$idProjet, '&p=', $pageNumber, $p);
					$contrats = $contratManager->getContratsByIdProjet($idProjet, $begin, $contratPerPage);	
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
	<div class="page-container row-fluid">
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
							Gestion des Contrats des Clients
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
							<li><a>Liste des Contrats Clients</a></li>
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
								<a href="contrats-add.php?idProjet=<?= $idProjet ?>" class="btn icn-only blue">Nouveau Contrat Client <i class="icon-plus-sign"></i></a>
							</div>
						</div>
						<!-- BEGIN Terrain TABLE PORTLET-->
						<?php if(isset($_SESSION['operation-add-error'])){ ?>
							<div class="alert alert-error">
								<button class="close" data-dismiss="alert"></button>
								<?= $_SESSION['operation-add-error'] ?>		
							</div>
						 <?php } 
							unset($_SESSION['operation-add-error']);
						 ?>
						 <?php if(isset($_SESSION['operation-add-success'])){ ?>
							<div class="alert alert-success">
								<button class="close" data-dismiss="alert"></button>
								<?= $_SESSION['operation-add-success'] ?>		
							</div>
						 <?php } 
							unset($_SESSION['operation-add-success']);
						 ?>
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
						 <?php if(isset($_SESSION['contrat-delete-success'])){ ?>
							<div class="alert alert-success">
								<button class="close" data-dismiss="alert"></button>
								<?= $_SESSION['contrat-delete-success'] ?>		
							</div>
						 <?php } 
							unset($_SESSION['contrat-delete-success']);
						 ?>
						 <?php if(isset($_SESSION['contrat-desister-success'])){ ?>
							<div class="alert alert-success">
								<button class="close" data-dismiss="alert"></button>
								<?= $_SESSION['contrat-desister-success'] ?>		
							</div>
						 <?php } 
							unset($_SESSION['contrat-desister-success']);
						 ?>
						 <?php if(isset($_SESSION['contrat-activation-success'])){ ?>
							<div class="alert alert-success">
								<button class="close" data-dismiss="alert"></button>
								<?= $_SESSION['contrat-activation-success'] ?>		
							</div>
						 <?php } 
							unset($_SESSION['contrat-activation-success']);
						 ?>
						 <?php if(isset($_SESSION['contrat-activation-error'])){ ?>
							<div class="alert alert-error">
								<button class="close" data-dismiss="alert"></button>
								<?= $_SESSION['contrat-activation-error'] ?>		
							</div>
						 <?php } 
							unset($_SESSION['contrat-activation-error']);
						 ?>
						 <?php if(isset($_SESSION['contrat-update-success'])){ ?>
							<div class="alert alert-success">
								<button class="close" data-dismiss="alert"></button>
								<?= $_SESSION['contrat-update-success'] ?>		
							</div>
						 <?php } 
							unset($_SESSION['contrat-update-success']);
						 ?>
						 <div class="row-fluid">
							    <div class="input-box autocomplet_container">
									<input class="m-wrap" name="nomClient" id="nomClient" type="text" placeholder="Chercher un client..." />
									<input name="idClient" id="idClient" type="hidden" />
							    </div>
							</div>
						<div class="portlet box grey">
							<div class="portlet-title">
								<h4>Liste des Contrats Clients du Projet : <strong><?= $projet->nom() ?></strong></h4>
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
											<th style="width:10%">Client</th>
											<th style="width:10%" class="hidden-phone">Type</th>
											<th style="width:5%">Bien</th>
											<th style="width:10%" class="hidden-phone">Prix</th>
											<th style="width:10%" class="hidden-phone">Payé</th>
											<th style="width:10%" class="hidden-phone">Reste</th>
											<th style="width:20%" class="hidden-phone">Note</th>
											<th style="width:5%" class="hidden-phone">Status</th>
											<?php if(isset($_SESSION['print-quittance'])){ ?>
												<th>Quittance</th>
											<?php 
											} ?>
										</tr>
									</thead>
									<tbody>
										<?php
										if($contratNumber != 0){
										foreach($contrats as $contrat){
											$operationsNumber = $operationManager->getOpertaionsNumberByIdContrat($contrat->id());
											$sommeOperations = $operationManager->sommeOperations($contrat->id());
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
										?>		
										<tr class="clients">
											<td>
												<div class="btn-group">
												    <a style="width: 200px" class="btn mini dropdown-toggle" href="#" data-toggle="dropdown">
												    	<?= $contrat->nomClient() ?> 
												        <i class="icon-angle-down"></i>
												    </a>
												    <ul class="dropdown-menu">
												        <li>
												        	<a target="_blank" href="controller/ContratPrintController.php?idContrat=<?= $contrat->id() ?>">
												        		Imprimer Contrat
												        	</a>
												        	<a target="_blank" href="controller/ClientFichePrintController.php?idContrat=<?= $contrat->id() ?>">
												        		Imprimer Fiche Client
												        	</a>
												        	<?php if($contrat->status()=="actif"){
														?>
														<a style="color:red" href="#desisterContrat<?= $contrat->id() ?>" data-toggle="modal" data-id="<?= $contrat->id() ?>">
															Désister
														</a>
														<?php 
														}
														else{
														?>	
														<a style="color:green" href="#activerContrat<?= $contrat->id() ?>" data-toggle="modal" data-id="<?= $contrat->id() ?>">
															Activer
														</a>	
														<?php	
														}
														?>
														<a href="contrats-update.php?idContrat=<?= $contrat->id() ?>&idProjet=<?= $idProjet ?>" data-toggle="modal" data-id="<?= $contrat->id() ?>">
												        		Modifier
												        	</a>
												        	<a href="#deleteContrat<?= $contrat->id() ?>" data-toggle="modal" data-id="<?= $contrat->id() ?>">
												        		Supprimer
												        	</a>
												        </li>
												    </ul>
												</div>
											</td>
											<td class="hidden-phone"><?= $typeBien ?></td>
											<td><?= $bien->nom() ?></td>
											<td class="hidden-phone"><?= number_format($contrat->prixVente(), 2, ',', ' ') ?></td>
											<td class="hidden-phone">
												<a href="#updatePaiementContrat<?= $contrat->id() ?>" data-toggle="modal" data-id="<?= $contrat->id() ?>">
													<?= number_format($contrat->avance(), 2, ',', ' ') ?></td>
												</a>
											<td class="hidden-phone"><?= number_format($contrat->prixVente()-$contrat->avance(), 2, ',', ' ') ?></td>
											</td>
											<td class="hidden-phone"><?= $contrat->note() ?></td>
											<td class="hidden-phone">
												<?php if($contrat->status()=="actif"){
													$status = "<a class=\"btn mini green\">Actif</a>";	
												}
												else{
													$status = "<a class=\"btn mini red\">Désisté</a>";	
												}
												echo $status;
												?>	
											</td>
											<?php if(isset($_SESSION['print-quittance']) and $operationsNumber>=1){ ?>
												<td>
													<a class="btn mini blue" href="controller/OperationPrintController.php?idOperation=<?= $operationManager->getLastIdByIdContrat($contrat->id()) ?>"> 
														<i class="m-icon-white icon-print"></i> Imprimer
													</a>
												</td>
											<?php 
											} ?>
										</tr>
										<!-- updatePaiementContrat box begin -->
										<div id="updatePaiementContrat<?= $contrat->id();?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
												<h3>Modifier Montant Payé pour le Contrat <?= $contrat->id() ?></h3>
											</div>
											<div class="modal-body">
												<form class="form-horizontal loginFrm" action="controller/ContratUpdatePaiementController.php" method="post">
													<div class="control-group">
														<label class="right-label">Montant Payé</label>
														<input type="text" name="paye" value="<?= $contrat->avance() ?>" />
													</div>
													<div class="control-group">
														<input type="hidden" name="idContrat" value="<?= $contrat->id() ?>" />
														<input type="hidden" name="idProjet" value="<?= $projet->id() ?>" />
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
												<h3>Supprimer Contrat <?= $contrat->id() ?></h3>
											</div>
											<div class="modal-body">
												<form class="form-horizontal loginFrm" action="controller/ContratDeleteController.php" method="post">
													<p>Êtes-vous sûr de vouloir supprimer ce contrat <strong><?= $contrat->id() ?></strong> ?</p>
													<div class="control-group">
														<label class="right-label"></label>
														<input type="hidden" name="idContrat" value="<?= $contrat->id() ?>" />
														<input type="hidden" name="idProjet" value="<?= $projet->id() ?>" />
														<button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
														<button type="submit" class="btn red" aria-hidden="true">Oui</button>
													</div>
												</form>
											</div>
										</div>
										<!-- delete box end -->		
										<!-- activation box begin-->
										<div id="activerContrat<?= $contrat->id() ?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
												<h3>Activer le contrat </h3>
											</div>
											<div class="modal-body">
												<form class="form-horizontal loginFrm" action="controller/ContratActivationController.php" method="post">
													<p>Êtes-vous sûr de vouloir activer le contrat <strong>N°<?= $contrat->id() ?></strong> ?</p>
													<div class="control-group">
														<label class="right-label"></label>
														<input type="hidden" name="idContrat" value="<?= $contrat->id() ?>" />
														<input type="hidden" name="idProjet" value="<?= $projet->id() ?>" />
														<button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
														<button type="submit" class="btn red" aria-hidden="true">Oui</button>
													</div>
												</form>
											</div>
										</div>
										<!-- activation box end -->	
										<!-- desister box begin-->
										<div id="desisterContrat<?= $contrat->id() ?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
												<h3>Désister le contrat </h3>
											</div>
											<div class="modal-body">
												<form class="form-horizontal loginFrm" action="controller/ContratDesistementController.php" method="post">
													<p>Êtes-vous sûr de vouloir désister le contrat <strong>N°<?= $contrat->id() ?></strong> ?</p>
													<div class="control-group">
														<label class="right-label"></label>
														<input type="hidden" name="idContrat" value="<?= $contrat->id() ?>" />
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
									<?php
									if($contratNumber != 0 and $contratNumber!=-1){
										echo $pagination;	
									}
									?>
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