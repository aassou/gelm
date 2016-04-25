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
    	$projetManager = new ProjetManager($pdo);
        $societeManager = new SocieteManager($pdo);
		$clientManager = new ClientManager($pdo);
		$contratManager = new ContratManager($pdo);
		$operationManager = new OperationManager($pdo);
		$locauxManager = new LocauxManager($pdo);
		$maisonManager = new MaisonManager($pdo);
		$terrainManager = new TerrainManager($pdo);
		$appartementManager = new AppartementManager($pdo);
		if(isset($_GET['idProjet']) and ($_GET['idProjet'])>0 and $_GET['idProjet']<=$projetManager->getLastId()){
			$idProjet = $_GET['idProjet'];
            $idSociete = $_GET['idSociete'];
            $societe = $societeManager->getSocieteById($idSociete);
			$projet = $projetManager->getProjetById($idProjet);
			$contratNumber = $contratManager->getContratsNumberByIdProjet($idProjet);
			if($contratNumber != 0){
                $contrats = $contratManager->getContratsActifsByIdProjet($idProjet);
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
							Gestion des Contrats des Clients - Projet : <?= $projet->nom() ?>
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
							<li><a>Liste des Contrats Clients</a></li>
						</ul>
						<!-- END PAGE TITLE & BREADCRUMB-->
					</div>
				</div>
				<!-- END PAGE HEADER-->
				<div class="row-fluid">
					<div class="span12">
						<!--div class="row-fluid add-portfolio">
							<div class="pull-left">
								<a href="projets.php" class="btn icn-only green"><i class="m-icon-swapleft m-icon-white"></i> Retour vers Liste des projets</a>
							</div>
							<div class="pull-right">
								<a href="contrats-add.php?idProjet=<?= $idProjet ?>" class="btn icn-only blue">Nouveau Contrat Client <i class="icon-plus-sign"></i></a>
							</div>
						</div-->
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
						<div class="portlet box grey">
							<div class="portlet-title">
								<h4>Liste des Contrats Clients</h4>
								<div class="tools">
									<a href="javascript:;" class="collapse"></a>
									<a href="javascript:;" class="remove"></a>
								</div>
							</div>
							<div class="portlet-body">
                                <div class="clearfix">
                                    <div class="btn-group pull-right">
                                        <a class="btn blue " href="controller/ClientsSituationsPrintController.php?idProjet=<?= $idProjet ?>">
                                            <i class="icon-print"></i>
                                             Version Imprimable
                                        </a>
                                    </div>
                                    <div class="btn-group pull-left">
                                        <a class="btn green" href="contrats-add.php?idProjet=<?= $idProjet ?>&idSociete=<?= $idSociete ?>">
                                            Nouveau Contrat Client <i class="icon-plus-sign"></i>
                                        </a>
                                    </div>
                                </div>
                                <!--div class="scroller" data-height="500px" data-always-visible="1"--><!-- BEGIN DIV SCROLLER -->
                                <table class="table table-bordered table-hover" id="sample_1">
									<thead>
										<tr>
										    <th class="hidden"></th>
											<th style="width:10%">Client</th>
											<th style="width:10%">Dates</th>
											<th style="width:10%" class="hidden-phone">Type</th>
											<th style="width:8%" class="hidden-phone">Prix</th>
											<th style="width:8%" class="hidden-phone">Taille</th>
											<th style="width:8%" class="hidden-phone">Payé</th>
											<th style="width:10%" class="hidden-phone">Reste</th>
											<th style="width:11%" class="hidden-phone">Note</th>
											<th style="width:12%" class="hidden-phone">Status</th>
											<th style="width:13%" class="hidden-phone">Actions</th>
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
                                            //status colors preferences
                                            $colorRow = "";
                                            if ( $contrat->status() == "actif" ) {
                                                $colorRow = 'style="background-color:#d2ffca"';
                                            }
                                            else {
                                                $colorRow = 'style="background-color:#ffcac1"';  
                                            }  
                                            //status bien color conf
                                            $statusBienColor = "";
                                            $statusBienLink = "";
                                            if ( $bien->status() ==  "Vendu" ) {
                                                $statusBienColor = "red";
                                                $statusBienLink = "#changeBienStatus".$bien->id();
                                            }
                                            else if ( $bien->status() == "Disponible" ) {
                                                $statusBienColor = "green";
                                                $statusBienLink = "";
                                            } 
                                            else {
                                                $statusBienColor = "blue";
                                                $statusBienLink = "#changeBienStatus".$bien->id();
                                            }
										?>		
										<tr <?= $colorRow ?> class="clients">
										    <td class="hidden"></td>
											<td><?= $contrat->nomClient() ?></td>
											<td><?= date('d/m/Y', strtotime($contrat->dateCreation())) ?>-<br/><?= date('d/m/Y', strtotime($contrat->dateRetour())) ?></td>
											<td class="hidden-phone"><?= $typeBien."-".$bien->nom() ?></td>
											<td class="hidden-phone"><?= number_format($contrat->prixVente(), 2, ',', ' ') ?></td>
											<td class="hidden-phone"><?= number_format($contrat->taille(), 2, ',', ' ') ?></td>
											<td class="hidden-phone">
											    <?php
                                                if ( 
                                                    $_SESSION['userMerlaTrav']->profil() == "admin" ||
                                                    $_SESSION['userMerlaTrav']->profil() == "manager"
                                                    ) { 
                                                ?>
												<a href="#updatePaiementContrat<?= $contrat->id() ?>" data-toggle="modal" data-id="<?= $contrat->id() ?>">
													<?= number_format($contrat->avance(), 2, ',', ' ') ?></td>
												</a>
												<?php
                                                }
                                                else {
                                                ?>
                                                <a>
                                                    <?= number_format($contrat->avance(), 2, ',', ' ') ?></td>
                                                </a>
                                                <?php    
                                                }     
                                                ?>
											<td class="hidden-phone"><?= number_format($contrat->prixVente()-$contrat->avance(), 2, ',', ' ') ?></td>
											</td>
											<td class="hidden-phone"><?= $contrat->note() ?></td>
											<td class="hidden-phone"><a href="<?= $statusBienLink ?>" data-toggle="modal" data-id="<?= $bien->id() ?>" class="btn mini <?= $statusBienColor ?>"><?= $bien->status() ?></a></td>
											<td>
											    <a title="Imprimer Contrat" class="btn mini blue" target="_blank" href="controller/ContratPrintController.php?idContrat=<?= $contrat->id() ?>">
                                                    <i class="icon-print"></i>
                                                </a>
                                                <?php 
                                                if ( $_SESSION['userMerlaTrav']->profil()=="admin" ) {
                                                    if ( $contrat->status()=="actif" ) {
                                                ?>
                                                        <a title="Désister" class="btn mini black" href="#desisterContrat<?= $contrat->id() ?>" data-toggle="modal" data-id="<?= $contrat->id() ?>">
                                                            <i class="icon-minus-sign"></i>    
                                                        </a>
                                                    <?php 
                                                    }
                                                    else{
                                                    ?>  
                                                        <a title="Activer" class="btn mini purple" href="#activerContrat<?= $contrat->id() ?>" data-toggle="modal" data-id="<?= $contrat->id() ?>">
                                                            <i class="icon-plus-sign"></i>
                                                        </a>    
                                                    <?php   
                                                    }
                                                    ?>
                                                    <a title="Modifier" class="btn mini green" href="contrats-update.php?idContrat=<?= $contrat->id() ?>&idProjet=<?= $idProjet ?>&idSociete=<?= $idSociete ?>" data-toggle="modal" data-id="<?= $contrat->id() ?>">
                                                        <i class="icon-refresh"></i>
                                                    </a>
                                                    <a title="Supprimer" class="btn mini red" href="#deleteContrat<?= $contrat->id() ?>" data-toggle="modal" data-id="<?= $contrat->id() ?>">
                                                        <i class="icon-remove"></i>
                                                    </a>
                                                <?php  
                                                }
                                                ?>
                                                <?php if(isset($_SESSION['print-quittance']) and $operationsNumber>=1){ ?>
                                                    <a title="Imprimer Quittance" class="btn mini grey" href="controller/OperationPrintController.php?idOperation=<?= $operationManager->getLastIdByIdContrat($contrat->id()) ?>"> 
                                                        <i class="m-icon-white icon-print"></i>
                                                    </a>
                                                <?php } ?>
                                            </td>
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
														<input type="hidden" name="idSociete" value="<?= $idSociete ?>" />
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
														<input type="hidden" name="idSociete" value="<?= $idSociete ?>" />
														<button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
														<button type="submit" class="btn red" aria-hidden="true">Oui</button>
													</div>
												</form>
											</div>
										</div>
										<!-- delete box end -->		
										<!-- changeBienStatus box begin-->
                                        <div id="changeBienStatus<?= $bien->id() ?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                <h3>Changer status du bien </h3>
                                            </div>
                                            <div class="modal-body">
                                                <form class="form-horizontal loginFrm" action="controller/ChangeBienStatusController.php" method="post">
                                                    <p>Êtes-vous sûr de vouloir changer le status du bien ?</p>
                                                    <div class="control-group">
                                                        <label class="control-label">Status</label>
                                                        <div class="controls">
                                                            <select name="status">
                                                                <option value="<?= $bien->status() ?>" id="<?= $bien->status() ?>"><?= $bien->status() ?></option>
                                                                <option disabled="disabled">-----------------------</option>
                                                                <option value="Vendu" id="Vendu">Vendu</option>
                                                                <option value="Promesse de Vente" id="Promesse de Vente">Promesse de Vente</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                    <div class="control-group">
                                                        <label class="right-label"></label>
                                                        <input type="hidden" name="typeBien" value="<?= $contrat->typeBien() ?>" />
                                                        <input type="hidden" name="idBien" value="<?= $bien->id() ?>" />
                                                        <input type="hidden" name="idContrat" value="<?= $contrat->id() ?>" />
                                                        <input type="hidden" name="idProjet" value="<?= $projet->id() ?>" />
                                                        <input type="hidden" name="idSociete" value="<?= $idSociete ?>" />
                                                        <button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
                                                        <button type="submit" class="btn red" aria-hidden="true">Oui</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                        <!-- changeBienStatus box end --> 
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
                                                        <label class="control-label">Status</label>
                                                        <div class="controls">
                                                            <select name="status">
                                                                <option value="Vendu" id="Vendu">Vendu</option>
                                                                <option value="Promesse de Vente" id="Promesse de Vente">Promesse de Vente</option>
                                                            </select>
                                                        </div>
                                                    </div>
													<div class="control-group">
														<label class="right-label"></label>
														<input type="hidden" name="idContrat" value="<?= $contrat->id() ?>" />
														<input type="hidden" name="idProjet" value="<?= $projet->id() ?>" />
														<input type="hidden" name="idSociete" value="<?= $idSociete ?>" />
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
														<input type="hidden" name="idSociete" value="<?= $idSociete ?>" />
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