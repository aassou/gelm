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
    //classes loading end
    session_start();
    if(isset($_SESSION['userMerlaTrav'])){
    	//classes managers
		$usersManager = new UserManager($pdo);
		$mailsManager = new MailManager($pdo);
		//$notesClientsManager = new NotesClientManager($pdo);
		$projetManager = new ProjetManager($pdo);
		$contratManager = new ContratManager($pdo);
		$clientManager = new ClientManager($pdo);
		$livraisonsManager = new LivraisonManager($pdo);
		$fournisseursManager = new FournisseurManager($pdo);
		$caisseEntreesManager = new CaisseEntreesManager($pdo);
		$caisseSortiesManager = new CaisseSortiesManager($pdo);
		$contratManager = new ContratManager($pdo);		
	    $operationsManager = new OperationManager($pdo);
        $chequeManager = new ChequeManager($pdo);
		//classes and vars
		//users number
		$projetNumber = ($projetManager->getProjetsNumber());
		$usersNumber = $usersManager->getUsersNumber();
		//$fournisseurNumber = $fournisseursManager->getFournisseurNumbers();
		$mailsNumberToday = $mailsManager->getMailsNumberToday();
		$mailsToday = $mailsManager->getMailsToday();
		$contrats = $contratManager->getContratByNote();
		$contratsMonth = $contratManager->getContratMonth();
        $chequesWeek = $chequeManager->getChequesWeek();
        $chequesMonth = $chequeManager->getChequesMonth();
		//$clientNumberWeek = $clientManager->getClientsNumberWeek();
		//$livraisonsNumber = $livraisonsManager->getLivraisonNumber();
		$livraisonsWeek = $livraisonsManager->getLivraisonsWeek();
		//$livraisonsNumberWeek = $livraisonsManager->getLivraisonsNumberWeek();
		//$operationsNumberWeek = $operationsManager->getOperationNumberWeek();
?>
<!DOCTYPE html>
<!--[if IE 8]> <html lang="en" class="ie8"> <![endif]-->
<!--[if IE 9]> <html lang="en" class="ie9"> <![endif]-->
<!--[if !IE]><!--> <html lang="en"> <!--<![endif]-->
<!-- BEGIN HEAD -->
<head>
	<meta charset="UTF-8" />
	<title>GELM - Management Application</title>
	<meta content="width=device-width, initial-scale=1.0" name="viewport" />
	<meta content="" name="description" />
	<meta content="" name="author" />
	<link href="assets/bootstrap/css/bootstrap.min.css" rel="stylesheet" />
	<link href="assets/css/metro.css" rel="stylesheet" />
	<link href="assets/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet" />
	<link href="assets/font-awesome/css/font-awesome.css" rel="stylesheet" />
	<link href="assets/fullcalendar/fullcalendar/bootstrap-fullcalendar.css" rel="stylesheet" />
	<link href="assets/css/style.css" rel="stylesheet" />
	<link href="assets/css/style_responsive.css" rel="stylesheet" />
	<link href="assets/css/style_default.css" rel="stylesheet" id="style_color" />
	<link rel="stylesheet" type="text/css" href="assets/chosen-bootstrap/chosen/chosen.css" />
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
							Tableau de bord
						</h3>
						<!-- END PAGE TITLE & BREADCRUMB-->
					</div>
				</div>
				<!--      BEGIN TILES      -->
				<div class="row-fluid">
					<div class="span12">
						<h4 class="breadcrumb"><i class="icon-hand-right"></i> Raccourcis</h4>
						<div class="tiles">
							<a href="companies.php">
							<div class="tile bg-green">
								<div class="tile-body">
									<i class="icon-sitemap"></i>
								</div>
								<div class="tile-object">
									<div class="name">
										Gestion Sociétés
									</div>
									<div class="number">
										
									</div>
								</div>
							</div>
							</a>
							<a href="fournisseurs.php">
							<div class="tile bg-blue">
								<div class="corner"></div>
								<div class="tile-body">
									<i class="icon-truck"></i>
								</div>
								<div class="tile-object">
									<div class="name">
										Fournisseurs
									</div>
									<!--div class="number">
										<?php //$livraisonsNumber ?>
									</div-->
								</div>
							</div>
							</a>
							<?php if($_SESSION['userMerlaTrav']->login()=="abdessamad"){ ?>
							<a href="caisses.php">
							<div class="tile bg-grey">
								<div class="tile-body">
									<i class="icon-bar-chart"></i>
								</div>
								<div class="tile-object">
									<div class="name">
										Les caisses
									</div>
									<div class="number">
									</div>
								</div>
							</div>
							</a>
							<?php } ?>
							<a href="releve-bancaire.php">
                            <div class="tile bg-purple">
                                <div class="tile-body">
                                    <i class="icon-envelope"></i>
                                </div>
                                <div class="tile-object">
                                    <div class="name">
                                        Relevé Bancaire
                                    </div>
                                    <div class="number">
                                        
                                    </div>
                                </div>
                            </div>
                            </a>
							<a href="employes.php">
                            <div class="tile bg-yellow">
                                <div class="corner"></div>
                                <div class="tile-body">
                                    <i class="icon-group"></i>
                                </div>
                                <div class="tile-object">
                                    <div class="name">
                                        Employés
                                    </div>
                                    <div class="number">
                                    </div>
                                </div>
                            </div>
                            </a>
							<a href="configuration.php">
							<div class="tile bg-red">
								<div class="corner"></div>
								<div class="tile-body">
									<i class="icon-wrench"></i>
								</div>
								<div class="tile-object">
									<div class="name">
										Paramètrages
									</div>
									<div class="number">
									</div>
								</div>
							</div>
							</a>
						</div>
					</div>
				</div>
				<!--      BEGIN TILES      -->
				<!-- BEGIN DASHBOARD STATS -->
				<!--h4><i class="icon-table"></i> Bilans et Statistiques Pour Cette Semaine</h4-->
				<!--hr class="line">
				<div class="row-fluid">
					
					<div class="span3 responsive" data-tablet="span6" data-desktop="span3">
						<div class="dashboard-stat green">
							<div class="visual">
								<i class="icon-shopping-cart"></i>
							</div>
							<div class="details">
								<div class="number"></div>
								<div class="desc">Livraisons</div>
							</div>					
						</div>
					</div>
					<div class="span3 responsive" data-tablet="span6" data-desktop="span3">
						<div class="dashboard-stat blue">
							<div class="visual">
								<i class="icon-group"></i>
							</div>
							<div class="details">
								<div class="number"></div>
								<div class="desc">Clients</div>
							</div>			
						</div>
					</div>	
					<div class="span3 responsive" data-tablet="span6" data-desktop="span3">
						<a class="more" href="caisse.php">
						<div class="dashboard-stat purple">
							<div class="visual">
								<i class="icon-money"></i>
							</div>
							<div class="details">
								<div class="number">
									DH
								</div>
								<div class="desc">Bilan de la caisse</div>
							</div>					
						</div>
						</a>
					</div>	
				</div-->
				<!-- END DASHBOARD STATS -->
				<!-- BEGIN DASHBOARD FEEDS -->
				<!-- ------------------------------------------------------ -->
				<div class="row-fluid">
				<div class="span12">
					<!-- BEGIN PORTLET-->
					<h4 class="breadcrumb"><i class="icon-bell"></i> Nouveautés</h4>
					<div class="portlet paddingless">
						<div class="portlet-body">
							<!--BEGIN TABS-->
							<div class="tabbable tabbable-custom">
								<ul class="nav nav-tabs">
									<li class="active"><a href="#tab_1_1" data-toggle="tab">Les livraisons de la semaine</a></li>
									<li><a href="#tab_1_2" data-toggle="tab">Les clients du Mois</a></li>
									<li><a href="#tab_1_3" data-toggle="tab">Notes des clients</a></li>
									<li><a href="#tab_1_4" data-toggle="tab">Les chèques de la Semaine</a></li>
								</ul>
								<div class="tab-content">
									<div class="tab-pane active" id="tab_1_1">
										<div class="scroller" data-height="420px" data-always-visible="1" data-rail-visible1="1">
											<ul class="feeds">
												<?php
												foreach($livraisonsWeek as $livraison){
													$idSociete = $projetManager->getProjetById($livraison->idProjet())->idSociete();
												?>
												<li>
													<div class="col1">
														<div class="cont">
															<div class="cont-col1">
																<div class="desc">	
																	<strong>Fournisseur</strong> : <?php echo $fournisseursManager->getFournisseurById($livraison->idFournisseur())->nom() ?><br>
																	<strong>Projet</strong> : <?php echo $projetName = $projetManager->getProjetById($livraison->idProjet())->nom(); ?><br>
																	<a href="livraisons-details.php?codeLivraison=<?php echo $livraison->code() ?>&idProjet=<?= $livraison->idProjet()?>&idSociete=<?= $idSociete ?>" target="_blank">
																		<strong>Livraison</strong> : <?php echo $livraison->libelle() ?>
																	</a>
																	<br>
																</div>
															</div>
														</div>
													</div>
													<div class="col2">
														<div class="date">
															<?php echo $livraison->dateLivraison() ?>
														</div>
													</div>
												</li>
												<hr>
												<?php 
												}
												?>
											</ul>
										</div>
									</div>
									<div class="tab-pane" id="tab_1_2">
										<div class="scroller" data-height="290px" data-always-visible="1" data-rail-visible1="1">
											<ul class="feeds">
												<?php
												foreach($contratsMonth as $contrat){
												?>
												<li>
													<div class="col1">
														<div class="cont">
															<div class="cont-col1">
																<div class="desc">	
																	<strong>Client</strong> : <?php echo $contrat->nomClient() ?><br>
																	<a href="controller/ContratPrintController.php?idContrat=<?= $contrat->id() ?>" target="_blank">
																		<strong>Contrat</strong> : <?php echo $contrat->id() ?>
																	</a><br>
																	<strong>Projet</strong> : <?php echo $projetName = $projetManager->getProjetById($contrat->idProjet())->nom(); ?>
																	<br>
																</div>
															</div>
														</div>
													</div>
													<div class="col2">
														<div class="date">
															<?php echo $contrat->dateCreation() ?>
														</div>
													</div>
												</li>
												<hr>
												<?php 
											     }
												?>
											</ul>
										</div>
									</div>
									<div class="tab-pane" id="tab_1_3">
										<div class="scroller" data-height="290px" data-always-visible="1" data-rail-visible1="1">
											<ul class="feeds">
												<?php
												//$notesClient = $notesClientsManager->getNotes();
												foreach($contrats as $contrat){
													$nomBien = "";
													$typeBien = "";
													if($contrat->typeBien()=="maison"){
														$maisonManager = new MaisonManager($pdo);
														$typeBien = "Maison";
														$nomBien = $maisonManager->getMaisonById($contrat->idBien())->nom();
													}
													else if($contrat->typeBien()=="localCommercial"){
														$locauxManager = new LocauxManager($pdo);
														$typeBien = "Local Commercial";
														$nomBien = $locauxManager->getLocauxById($contrat->idBien())->nom();
													}
													else if($contrat->typeBien()=="appartement"){
														$appartementManager = new AppartementManager($pdo);
														$typeBien = "Appartement";
														$nomBien = $appartementManager->getAppartementById($contrat->idBien())->nom();
													}
													else if($contrat->typeBien()=="terrain"){
														$terrainManager = new TerrainManager($pdo);
														$typeBien = "Terrain";
														$nomBien = $terrainManager->getTerrainById($contrat->idBien())->nom();
													}
												?>
												<li>
													<div class="col1">
														<div class="cont">
															<div class="cont-col1">
																<div class="label label-success">								
																	<i class="icon-bell"></i>
																</div>
															</div>
															<div class="cont-col2">
																<div class="desc">	
																	<strong>Note</strong> : <a href="#updateNote<?= $contrat->id() ?>" data-toggle="modal" data-id="<?= $contrat->id() ?>"><?= $contrat->note() ?></a><br>
																	<strong>Client</strong> : <?= $contrat->nomClient() ?><br>
																	<strong>Bien</strong> : <?= $typeBien ?>&nbsp;-&nbsp;<?= $nomBien ?><br> 
																	<strong>Projet</strong> : <?= $projetManager->getProjetById($contrat->idProjet())->nom() ?>
																</div>
															</div>
														</div>
													</div>
													<!-- updateNotebox begin-->
                                                    <div id="updateNote<?= $contrat->id() ?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
                                                        <div class="modal-header">
                                                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
                                                            <h3>Modifier Note Client</h3>
                                                        </div>
                                                        <div class="modal-body">
                                                            <form class="form-horizontal" action="controller/NoteUpdateController.php" method="post">
                                                                <p>Êtes-vous sûr de vouloir modifier la note du client <strong><?= $contrat->nomClient() ?></strong> ?</p>
                                                                <div class="control-group">
                                                                    <label class="control-label">Note</label>
                                                                    <div class="controls">
                                                                        <textarea name="note"><?= $contrat->note() ?></textarea>
                                                                    </div>
                                                                </div>
                                                                <div class="control-group">
                                                                    <div class="controls">  
                                                                        <input type="hidden" name="idContrat" value="<?= $contrat->id() ?>" />
                                                                        <button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
                                                                        <button type="submit" class="btn red" aria-hidden="true">Oui</button>
                                                                    </div>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                    <!-- updateStatusProjet box end -->
												</li>
												<hr>
												<?php 
												}
												?>
											</ul>
										</div>
									</div>
									<div class="tab-pane" id="tab_1_4">
										<div class="scroller" data-height="290px" data-always-visible="1" data-rail-visible1="1">
											<?php
											foreach($chequesWeek as $cheque){
												$projet = $projetManager->getProjetById($cheque->idProjet());
											?>
											<div class="row-fluid">
												<div class="span6 user-info">
													<div class="details">
														<div>
															
														</div>
														<div>
														    <strong>N°&nbsp;Chèque : </strong><a><?= $cheque->numero() ?></a><br> 
															<strong>Projet : </strong><a><?= $projet->nom() ?></a><br> 
														    <strong>Compte Bancaire : </strong><a><?= $cheque->compteBancaire() ?></a><br>
															<strong>Date : </strong><a><?= date('d/m/Y', strtotime($cheque->dateCheque())) ?></a><br>
															<strong>Désignation : </strong><a><?= $cheque->designationSociete() ?> / <?= $cheque->designationPersonne() ?></a><br>
															<strong>Montant : </strong><a><?= number_format($cheque->montant(), '2', ',', ' ') ?>&nbsp;DH</a><br>
															<strong>Status : </strong><a><?= $cheque->statut() ?></a><br>
														</div>
													</div>
												</div>
											</div>
											<hr>
											<?php
											}
											?>
										</div>
									</div>
								</div>
							</div>
							<!--END TABS-->
						</div>
					</div>
					<!-- END PORTLET-->
				</div>
				</div>
				<!-- ------------------------------------------------------ -->
				<!-- END DASHBOARD FEEDS -->
				<!-- END PAGE HEADER-->
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
	<script src="assets/jquery-slimscroll/jquery-ui-1.9.2.custom.min.js"></script>	
	<script src="assets/jquery-slimscroll/jquery.slimscroll.min.js"></script>
	<script src="assets/bootstrap/js/bootstrap.min.js"></script>
	<script src="assets/js/jquery.blockui.js"></script>
	<script src="assets/js/jquery.cookie.js"></script>
	<script src="assets/fullcalendar/fullcalendar/fullcalendar.min.js"></script>	
	<script type="text/javascript" src="assets/uniform/jquery.uniform.min.js"></script>
	<script type="text/javascript" src="assets/chosen-bootstrap/chosen/chosen.jquery.min.js"></script>
	<script src="assets/jquery-knob/js/jquery.knob.js"></script>
	<script src="assets/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js"></script>
	<script type="text/javascript" src="assets/gritter/js/jquery.gritter.js"></script>
	<script type="text/javascript" src="assets/js/jquery.pulsate.min.js"></script>
	<!-- ie8 fixes -->
	<!--[if lt IE 9]>
	<script src="assets/js/excanvas.js"></script>
	<script src="assets/js/respond.js"></script>
	<![endif]-->
	<script src="assets/js/app.js"></script>		
	<script>
		jQuery(document).ready(function() {			
			// initiate layout and plugins
			App.setPage("sliders");  // set current page
			App.init();
		});
	</script>
	<!-- END JAVASCRIPTS -->
</body>
<!-- END BODY -->
</html>
<?php
}
else{
    header('Location:index.php');    
}
?>