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
    	//classManagers
    	$projetManager = new ProjetManager($pdo);
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
		if(isset($_GET['idProjet']) and 
    	($_GET['idProjet'] >=1 and $_GET['idProjet'] <= $projetManager->getLastId()) ){
    		$idProjet = $_GET['idProjet'];
    		if( isset($_POST['idFournisseur']) and 
			$fournisseurManager->getOneFournisseurBySearch($_POST['idFournisseur']>=1)){
				$fournisseur = $fournisseurManager->getOneFournisseurBySearch(htmlentities($_POST['idFournisseur']));
				$livraisonNumber = $livraisonManager->getLivraisonsNumberByIdFournisseur($fournisseur);
				if($livraisonNumber != 0){
					/*
					$livraisonPerPage = 10;
			        $pageNumber = ceil($livraisonNumber/$livraisonPerPage);
			        $p = 1;
			        if(isset($_GET['p']) and ($_GET['p']>0 and $_GET['p']<=$pageNumber)){
			            $p = $_GET['p'];
			        }
			        else{
			            $p = 1;
			        }
			        $begin = ($p - 1) * $livraisonPerPage;
			        $pagination = paginate('projet-livraisons.php', '?p=', $pageNumber, $p);
					$livraisons = $livraisonManager->getLivraisonsByIdFournisseurByLimits($fournisseur, $begin, $livraisonPerPage);
					*/
					$livraisons = $livraisonManager->getLivraisonsByIdFournisseur($fournisseur);
					$titreLivraison ="Liste des livraisons du fournisseur <strong>".$fournisseurManager->getFournisseurById($fournisseur)->nom()."</strong>";
					//get the sum of livraisons details using livraisons ids (idFournisseur)
					$livraisonsIds = $livraisonManager->getLivraisonIdsByIdFournisseur($fournisseur);
					$sommeDetailsLivraisons = 0;
					foreach($livraisonsIds as $idl){
						$sommeDetailsLivraisons += $livraisonDetailManager->getTotalLivraisonByIdLivraison($idl);
					}	
					$totalReglement = $reglementsFournisseurManager->sommeReglementFournisseursByIdFournisseur($fournisseur);
					$totalLivraison = 
					$livraisonManager->getTotalLivraisonsIdFournisseur($fournisseur)+
					$sommeDetailsLivraisons;
					$hrefLivraisonBilanPrintController = "controller/LivraisonBilanPrintController.php?idProjet=".$idProjet;
				}
			}
			else {
				$livraisonNumber = $livraisonManager->getLivraisonNumberByIdProjet($idProjet);
				if($livraisonNumber != 0){
					/*
					$livraisonPerPage = 10;
			        $pageNumber = ceil($livraisonNumber/$livraisonPerPage);
			        $p = 1;
			        if(isset($_GET['p']) and ($_GET['p']>0 and $_GET['p']<=$pageNumber)){
			            $p = $_GET['p'];
			        }
			        else{
			            $p = 1;
			        }
			        $begin = ($p - 1) * $livraisonPerPage;
			        $pagination = paginate('projet-livraisons.php', '?p=', $pageNumber, $p);
					$livraisons = $livraisonManager->getLivraisonsByIdProjetByLimit($idProjet,$begin, $livraisonPerPage);
					*/
					$livraisons = $livraisonManager->getLivraisonsByIdProjet($idProjet);
					$titreLivraison ="Liste de toutes les livraisons";
					$totalReglement = $reglementsFournisseurManager->getTotalReglement();
					$totalLivraison = 
					$livraisonManager->getTotalLivraisons() + $livraisonDetailManager->getTotalLivraison();	
					$hrefLivraisonBilanPrintController = "controller/LivraisonBilanPrintController.php";
				}	
			}	
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
                                <a href="companies.php">Gestion des sociétés</a>
                                <i class="icon-angle-right"></i>
                            </li>
                            <li>
                                <i class="icon-briefcase"></i>
                                <a href="projects-by-company.php?idSociete=<?= $idSociete ?>">Gestion des projets</a> 
                                <i class="icon-angle-right"></i>
                            </li>
                            <li>
                                <a href="project-management.php?idProjet=<?= $idProjet ?>&idSociete=<?= $idSociete ?>">Gestion du projet <strong><?= $projetManager->getProjetById($idProjet)->nom() ?></strong></a>
                                <i class="icon-angle-right"></i>
                            </li>
							<li>
								<i class="icon-truck"></i>
								<a>Gestion des livraisons</a>
							</li>
						</ul>
						<!-- END PAGE TITLE & BREADCRUMB-->
					</div>
				</div>
				<!-- END PAGE HEADER-->
				<div class="row-fluid">
					<div class="span12">
						<div class="row-fluid add-portfolio">
							<div class="pull-left">
								<!--a href="livraison-add.php" class="btn icn-only blue"-->
								<a href="#addFournisseur" data-toggle="modal" class="btn blue">
									Ajouter Nouveau Fournisseur <i class="icon-plus-sign "></i>
								</a>
							</div>
							<div class="pull-right">
								<a href="#addLivraison" data-toggle="modal" class="btn green">
									Ajouter Nouvelle Livraison <i class="icon-plus-sign "></i>
								</a>
							</div>
						</div>
						<!-- addFournisseur box begin-->
						<div id="addFournisseur" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
								<h3>Ajouter un nouveau fournisseur </h3>
							</div>
							<div class="modal-body">
								<form class="form-horizontal" action="controller/FournisseurAddController.php?source=1" method="post">
									<div class="control-group">
										<label class="control-label">Nom</label>
										<div class="controls">
											<input type="text" name="nom" value="" />
										</div>
									</div>
									<div class="control-group">
										<label class="control-label">Adresse</label>
										<div class="controls">
											<input type="text" name="adresse" value="" />
										</div>
									</div>
									<div class="control-group">
										<label class="control-label">Tél.1</label>
										<div class="controls">
											<input type="text" name="telephone1" value="" />
										</div>
									</div>
									<div class="control-group">
										<label class="control-label">Fax</label>
										<div class="controls">
											<input type="text" name="fax" value="" />
										</div>
									</div>
									<div class="control-group">
										<label class="control-label">Email</label>
										<div class="controls">
											<input type="text" name="email" value="" />
										</div>	
									</div>
									<div class="control-group">
										<label class="control-label">Nature des matériaux</label>
										<div class="controls">
											<textarea name="nature"></textarea>
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
						<!-- addFournisseur box end -->
						<!-- addLivraison box begin-->
						<div id="addLivraison" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
								<h3>Ajouter une nouvelle livraison </h3>
							</div>
							<div class="modal-body">
								<form class="form-horizontal" action="controller/LivraisonAddController.php?p=99" method="post" enctype="multipart/form-data">
									<div class="control-group">
										<label class="control-label">Fournisseur</label>
										<div class="controls">
											<select name="idFournisseur">
                                            	<?php foreach($fournisseurs as $fournisseur){ ?>
                                            	<option value="<?= $fournisseur->id() ?>"><?= $fournisseur->nom() ?></option>
                                            	<?php } ?>
                                            </select>
										</div>
									</div>
									<div class="control-group">
										<label class="control-label">Date Livraison</label>
										<div class="controls date date-picker" data-date="" data-date-format="yyyy-mm-dd">
		                                    <input name="dateLivraison" id="dateLivraison" class="m-wrap m-ctrl-small date-picker" type="text" value="<?= date('Y-m-d') ?>" />
		                                    <span class="add-on"><i class="icon-calendar"></i></span>
		                                 </div>
									</div>
									<div class="control-group">
										<label class="control-label">Libelle</label>
										<div class="controls">
											<input type="text" name="libelle" value="" />
										</div>
									</div>
									<div class="control-group">
										<label class="control-label">Status</label>
										<div class="controls">
											<select name="status">
												<option value="Non Payé">Non Payé</option>
                                            	<option value="Payé">Payé</option>
                                            	<option value="Payé+TVA">Payé+TVA</option>
                                            </select>
										</div>
									</div>
									<div class="control-group">
										<label class="control-label">Mode Paiement</label>
										<div class="controls">
											<select name="modePaiement">
												<option value="Espèce">Espèce</option>
                                            	<option value="Chèque">Chèque</option>
                                            </select>
										</div>
									</div>
									<div class="control-group">
		                              	<label class="control-label">Copie BL</label>
		                              	<div class="controls">
		                              		<input type="file" name="urlBL" />
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
						<!-- addLivraison box end -->
						<div class="row-fluid">
							<form action="" method="post">
							    <div class="input-box autocomplet_container">
							    	<input class="m-wrap" name="recherche" id="nomFournisseur" type="text" onkeyup="autocompletFournisseur()" placeholder="Chercher un fournisseur...">
										<ul id="fournisseurList"></ul>
									</input>
									<!--input class="m-wrap" name="fournisseur" id="fournisseur" type="text" placeholder="Fournisseur..." /-->
									<input class="m-wrap" name="libelle" id="libelle" type="text" placeholder="Libelle..." />
									<input class="m-wrap" name="status" id="status" type="text" placeholder="Status..." />
									<input name="idFournisseur" id="idFournisseur" type="hidden" />
									<!--button type="submit" class="btn red"><i class="icon-search"></i></button-->
									<a href="#printLivraisonList" data-toggle="modal" class="btn black"><i class="icon-print"></i>&nbsp;Liste des Livraisons</a>
							    </div>
							</form>
						</div>
						<!-- printLivraisonList box begin-->
						<div id="printLivraisonList" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
								<h3>Imprimer Liste des Livraisons </h3>
							</div>
							<div class="modal-body">
								<form class="form-horizontal" action="controller/LivraisonBilanPrintController.php" method="post" enctype="multipart/form-data">
									<p>Séléctionner le fournisseur</p>
									<div class="control-group">
										<div class="controls">
											<select name="idFournisseur">
                                            	<?php foreach($fournisseurs as $fournisseur){ ?>
                                            	<option value="<?= $fournisseur->id() ?>"><?= $fournisseur->nom() ?></option>
                                            	<?php } ?>
                                            </select>
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
						<!-- printLivraisonList box end -->
						<!-- BEGIN Terrain TABLE PORTLET-->
						<?php if(isset($_SESSION['fournisseur-add-success'])){ ?>
							<div class="alert alert-success">
								<button class="close" data-dismiss="alert"></button>
								<?= $_SESSION['fournisseur-add-success'] ?>		
							</div>
						 <?php } 
							unset($_SESSION['fournisseur-add-success']);
						 ?>
						 <?php if(isset($_SESSION['fournisseur-add-error'])){ ?>
							<div class="alert alert-error">
								<button class="close" data-dismiss="alert"></button>
								<?= $_SESSION['fournisseur-add-error'] ?>		
							</div>
						 <?php } 
							unset($_SESSION['fournisseur-add-error']);
						 ?>
						 <?php if(isset($_SESSION['livraison-add-success'])){ ?>
							<div class="alert alert-success">
								<button class="close" data-dismiss="alert"></button>
								<?= $_SESSION['livraison-add-success'] ?>		
							</div>
						 <?php } 
							unset($_SESSION['livraison-add-success']);
						 ?>
						 <?php if(isset($_SESSION['livraison-update-success'])){ ?>
							<div class="alert alert-success">
								<button class="close" data-dismiss="alert"></button>
								<?= $_SESSION['livraison-update-success'] ?>		
							</div>
						 <?php } 
							unset($_SESSION['livraison-update-success']);
						 ?>
						 <?php if(isset($_SESSION['livraison-update-error'])){ ?>
							<div class="alert alert-error">
								<button class="close" data-dismiss="alert"></button>
								<?= $_SESSION['livraison-update-error'] ?>		
							</div>
						 <?php } 
							unset($_SESSION['livraison-update-error']);
						 ?>
						 <?php if(isset($_SESSION['livraison-add-error'])){ ?>
							<div class="alert alert-error">
								<button class="close" data-dismiss="alert"></button>
								<?= $_SESSION['livraison-add-error'] ?>		
							</div>
						 <?php } 
							unset($_SESSION['livraison-add-error']);
						 ?>
						 <?php if(isset($_SESSION['reglement-add-success'])){ ?>
							<div class="alert alert-success">
								<button class="close" data-dismiss="alert"></button>
								<?= $_SESSION['reglement-add-success'] ?>		
							</div>
						 <?php } 
							unset($_SESSION['reglement-add-success']);
						 ?>
						 <?php if(isset($_SESSION['reglement-add-error'])){ ?>
							<div class="alert alert-error">
								<button class="close" data-dismiss="alert"></button>
								<?= $_SESSION['reglement-add-error'] ?>		
							</div>
						 <?php } 
							unset($_SESSION['reglement-add-error']);
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
						 <?php if(isset($_SESSION['livraison-delete-success'])){ ?>
							<div class="alert alert-success">
								<button class="close" data-dismiss="alert"></button>
								<?= $_SESSION['livraison-delete-success'] ?>		
							</div>
						 <?php } 
							unset($_SESSION['livraison-delete-success']);
						 ?>
						<div class="portlet box blue">
							<div class="portlet-title">
								<h4><?= $titreLivraison ?></h4>
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
											<th>Fournisseur</th>
											<th class="hidden-phone">Date Livraison</th>
											<th class="hidden-phone">Libelle</th>
											<th class="hidden-phone">Nombre d'articles</th>
											<th class="hidden-phone">Total</th>
											<th class="hidden-phone">Status</th>
											<th class="hidden-phone">Copie BL</th>
										</tr>
									</thead>
									<tbody>
										<?php
										$sommeLivraisons = 0;
										if($livraisonNumber != 0){
										foreach($livraisons as $livraison){
										    $sommeLivraisons += $livraisonDetailManager->getTotalLivraisonByIdLivraison($livraison->id());
											$btnColor = "";
											if($livraison->status()==utf8_decode("Pay&eacute;")){
												$colorRow = 'style="background-color:#d2ffca"';
												$btnColor = "green";	
											}
											else if($livraison->status()==utf8_decode("Pay&eacute;+TVA")){
												$colorRow = 'style="background-color:#d9edf7"';
												$btnColor = "blue";	
											}
											else if($livraison->status()=="Non Pay&eacute;"){
												$colorRow = 'style="background-color:#ffcac1"';
												$btnColor = "red";	
											} 
										?>		
										<tr class="livraisons">
											<td>
												<div class="btn-group">
												    <a style="width: 100px" class="btn mini dropdown-toggle" href="#" data-toggle="dropdown">
												    	<?= $fournisseurManager->getFournisseurById($livraison->idFournisseur())->nom() ?> 
												        <i class="icon-angle-down"></i>
												    </a>
												    <ul class="dropdown-menu">
												        <li>
												        	<a href="livraisons-details.php?codeLivraison=<?= $livraison->code() ?>&idProjet=<?= $idProjet ?>&idSociete=<?= $idSociete ?>">
												        		Détails Livraison
												        	</a>
												        	<a href="controller/LivraisonDetailPrintController.php?idLivraison=<?= $livraison->id() ?>" target="_blank">
												        		Imprimer Détails Livraison
												        	</a>											
												        	<a href="#updateLivraison<?= $livraison->id();?>" data-toggle="modal" data-id="<?= $livraison->id(); ?>">
																Modifier
															</a>
															<a href="#deleteLivraison<?= $livraison->id() ?>" data-toggle="modal" data-id="<?= $livraison->id() ?>">
																Supprimer
															</a>
												        </li>
												    </ul>
												</div>
											</td>
											<td class="hidden-phone"><?= date('d/m/Y', strtotime($livraison->dateLivraison())) ?></td>
											<td class="hidden-phone"><?= $livraison->libelle() ?></td>
											<td class="hidden-phone"><?= $livraisonDetailManager->getNombreArticleLivraisonByIdLivraison($livraison->id()) ?></td>
											<td class="hidden-phone"><?= number_format($livraisonDetailManager->getTotalLivraisonByIdLivraison($livraison->id()), 2, ',', ' ') ?></td>
											<td class="hidden-phone">
												<a class="btn mini <?= $btnColor ?> " href="#updateStatus<?= $livraison->id();?>" data-toggle="modal" data-id="<?= $livraison->id(); ?>">
													<?= $livraison->status() ?>
												</a>	
											</td>
											<td>
												<a class="fancybox-button btn mini" data-rel="fancybox-button" title="<?= $livraison->libelle() ?>" href="<?= $livraison->url() ?>">
													<i class="icon-zoom-in"></i>	
												</a>
												<a class="btn mini blue" href="#updateCopieBL<?= $livraison->id();?>" data-toggle="modal" data-id="<?= $livraison->id(); ?>">
													<i class=" icon-refresh"></i>	
												</a>
											</td>
										</tr>
										<!-- updateStatus box begin-->
										<div id="updateStatus<?= $livraison->id() ?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
												<h3>Modifier le status de la livraison</h3>
											</div>
											<div class="modal-body">
												<form class="form-horizontal" action="controller/LivraisonStatusUpdateController.php" method="post" enctype="multipart/form-data">
													<div class="control-group">
														<label class="control-label">Status</label>
														<div class="controls">
															<select name="status">
																<option value="<?= $livraison->status() ?>"><?= $livraison->status() ?></option>
																<option disabled="disabled">----------</option>
				                                            	<option value="Non Payé">Non Payé</option>
				                                            	<option value="Payé">Payé</option>
				                                            	<option value="Payé+TVA">Payé+TVA</option>
				                                            </select>
														</div>
													</div>
													<div class="control-group">
														<div class="controls">
															<input type="hidden" name="idProjet" value="<?= $idProjet ?>" />
															<input type="hidden" name="idSociete" value="<?= $idSociete ?>" />
															<input type="hidden" name="idLivraison" value="<?= $livraison->id() ?>">
															<button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
															<button type="submit" class="btn red" aria-hidden="true">Oui</button>
														</div>
													</div>
												</form>
											</div>
										</div>
										<!-- updateStatus box end -->
										<!-- updateCopieBL box begin-->
										<div id="updateCopieBL<?= $livraison->id() ?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
												<h3>Modifier la copie du BL </h3>
											</div>
											<div class="modal-body">
												<form class="form-horizontal loginFrm" action="controller/LivraisonCopieBLUpdateController.php" method="post" enctype="multipart/form-data">
													<p>Êtes-vous sûr de vouloir modifier la copie du BL <strong>N°&nbsp;<?= $livraison->libelle() ?></strong> ?</p>
													<div class="control-group">
														<label class="right-label"></label>
														<div class="control-group">
							                              	<label class="control-label">Copie BL</label>
							                              	<div class="controls">
							                              		<input type="file" name="urlBL" />
							                              	</div>
							                           	</div>
							                           	<input type="hidden" name="idProjet" value="<?= $idProjet ?>" />
							                           	<input type="hidden" name="idSociete" value="<?= $idSociete ?>" />
														<input type="hidden" name="idLivraison" value="<?= $livraison->id() ?>" />
														<button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
														<button type="submit" class="btn red" aria-hidden="true">Oui</button>
													</div>
												</form>
											</div>
										</div>
										<!-- updateCopieBL box end -->			
										<!-- add file box begin-->
										<div id="addPieces<?= $livraison->id() ?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
												<h3>Ajouter des pièces pour cette livraison</h3>
											</div>
											<div class="modal-body">
												<form class="form-horizontal" action="controller/LivraisonPiecesAddController.php" method="post" enctype="multipart/form-data">
													<p>Êtes-vous sûr de vouloir ajouter des pièces pour cette livraison ?</p>
													<div class="control-group">
														<label class="right-label">Nom Pièce</label>
														<input type="text" name="nom" />
														<label class="right-label">Lien</label>
														<input type="file" name="url" />
														<input type="hidden" name="idSociete" value="<?= $idSociete ?>" />
														<input type="hidden" name="idLivraison" value="<?= $livraison->id() ?>" />
														<label class="right-label"></label>
														<button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
														<button type="submit" class="btn red" aria-hidden="true">Oui</button>
													</div>
												</form>
											</div>
										</div>
										<!-- add files box end -->
										<!-- updateLivraison box begin-->
										<div id="updateLivraison<?= $livraison->id() ?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
												<h3>Modifier les informations de la livraison </h3>
											</div>
											<div class="modal-body">
												<form class="form-horizontal" action="controller/LivraisonUpdateController.php" method="post">
													<p>Êtes-vous sûr de vouloir modifier la livraison <strong>N°<?= $livraison->id() ?></strong>  ?</p>
													<div class="control-group">
														<label class="control-label">Date Livraison</label>
														<div class="controls date date-picker" data-date="" data-date-format="yyyy-mm-dd">
						                                    <input name="dateLivraison" id="dateLivraison" class="m-wrap m-ctrl-small date-picker" type="text" value="<?= $livraison->dateLivraison() ?>" />
						                                    <span class="add-on"><i class="icon-calendar"></i></span>
						                                 </div>
													</div>
													<div class="control-group">
														<label class="control-label">Libelle</label>
														<div class="controls">
															<input type="text" name="libelle" value="<?= $livraison->libelle() ?>" />
														</div>
													</div>
													<div class="control-group">
														<input type="hidden" name="idLivraison" value="<?= $livraison->id() ?>" />
														<input type="hidden" name="idSociete" value="<?= $idSociete ?>" />
														<input type="hidden" name="idProjet" value="<?= $idProjet ?>" />
														<div class="controls">	
															<button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
															<button type="submit" class="btn red" aria-hidden="true">Oui</button>
														</div>
													</div>
												</form>
											</div>
										</div>
										<!-- updateLivraison box end -->			
										<!-- delete box begin-->
										<div id="deleteLivraison<?= $livraison->id() ?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
												<h3>Supprimer la livraison </h3>
											</div>
											<div class="modal-body">
												<form class="form-horizontal loginFrm" action="controller/LivraisonDeleteController.php" method="post">
													<p>Êtes-vous sûr de vouloir supprimer la livraison <strong>N°<?= $livraison->id() ?></strong> ?</p>
													<div class="control-group">
														<label class="right-label"></label>
														<input type="hidden" name="idLivraison" value="<?= $livraison->id() ?>" />
														<input type="hidden" name="idProjet" value="<?= $idProjet ?>" />
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
								<table class="table table-striped table-bordered table-advance table-hover">
									<thead>
										<tr>
											<th><strong>Total Livraisons</strong></th>
											<td><strong><a><?= number_format($sommeLivraisons, 2, ',', ' ') ?></a>&nbsp;DH</strong></td>
										</tr>		
									</thead>
								</table>	
							</div>
							</div><!-- END SCROLL DIV -->
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
		  015 &copy; GELM. Management Application.
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
			//App.setPage("table_editable");
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
	    $('.livraisons').show();
		$('#nomFournisseur').keyup(function(){
		    $('.livraisons').hide();
		   var txt = $('#nomFournisseur').val();
		   $('.livraisons').each(function(){
		       if($(this).text().toUpperCase().indexOf(txt.toUpperCase()) != -1){
		           $(this).show();
		       }
		    });
		});
		$('#libelle').keyup(function(){
		    $('.livraisons').hide();
		   var txt = $('#libelle').val();
		   $('.livraisons').each(function(){
		       if($(this).text().toUpperCase().indexOf(txt.toUpperCase()) != -1){
		           $(this).show();
		       }
		    });
		});
		$('#status').keyup(function(){
		    $('.livraisons').hide();
		   var txt = $('#status').val();
		   $('.livraisons').each(function(){
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