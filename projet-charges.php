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
		$chargesTerrainManager = new ChargesTerrainManager($pdo);
		$chargesConstructionManager = new ChargesConstructionManager($pdo);
		$chargesFinitionManager = new ChargesFinitionManager($pdo);
		//
		if(isset($_GET['idProjet']) and 
    	($_GET['idProjet'] >=1 and $_GET['idProjet'] <= $projetManager->getLastId()) ){
    		$idProjet = $_GET['idProjet'];
            $idSociete = $_GET['idSociete'];
            $type = $_GET['type'];
    		$chargesTerrain = $chargesTerrainManager->getChargesTerrainsByIdProjet($idProjet);
    		$chargesConstruction = $chargesConstructionManager->getChargesConstructionsByIdProjet($idProjet);
			$chargesFinition = $chargesFinitionManager->getChargesFinitionsByIdProjet($idProjet);
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
							Gestion des charges <?= $type ?> - Projet : <strong><?= $projetManager->getProjetById($idProjet)->nom() ?></strong>
						</h3>
						<ul class="breadcrumb">
							<li>
                                <i class="icon-dashboard"></i>
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
                            <li>
                                <i class="icon-bar-chart"></i>
                                <a href="projets-charges-categories.php?idProjet=<?= $idProjet ?>&idSociete=<?= $idSociete ?>">Gestion des charges</a>
                                <i class="icon-angle-right"></i> 
                            </li>
							<li>
							    <a>Charges <strong><?= ucfirst($type) ?></strong></a>
						    </li>
						</ul>
						<!-- END PAGE TITLE & BREADCRUMB-->
					</div>
				</div>
				<!-- END PAGE HEADER-->
				<div class="row-fluid">
					<div class="span12">
						<!--div class="row-fluid add-portfolio">
							<div class="pull-right">
								<a href="#addCharge" data-toggle="modal" class="btn green">
									Nouvelle Charge <i class="icon-plus-sign "></i>
								</a>
							</div>
						</div-->
						<!-- addCharge box begin-->
						<div id="addCharge" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
								<h3>Ajouter une nouvelle charge </h3>
							</div>
							<div class="modal-body">
								<form class="form-horizontal" action="controller/ChargeAddController.php" method="post" enctype="multipart/form-data">
									<div class="control-group">
										<label class="control-label">Type Charge</label>
										<div class="controls">
											<select name="typeCharge">
												<option value="terrain">Charges Terrain</option>
                                            	<option value="construction">Charges Construction</option>
                                            	<option value="finition">Charges Finition</option>
                                            </select>
										</div>
									</div>
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
											<input type="hidden" name="idProjet" value="<?= $idProjet ?>" />
											<input type="hidden" name="idSociete" value="<?= $idSociete ?>" />
											<input type="hidden" name="type" value="<?= $type ?>" />	
											<button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
											<button type="submit" class="btn red" aria-hidden="true">Oui</button>
										</div>
									</div>
								</form>
							</div>
						</div>
						<!-- addCharge box end -->
						<!--**************************** CHARGES TERRAIN BEGIN ****************************-->
						<div class="row-fluid">
						    <div class="input-box autocomplet_container">
								<input class="m-wrap" name="designation" id="designation" type="text" placeholder="Désignation..." />
								<input class="m-wrap" name="beneficiaire" id="beneficiaire" type="text" placeholder="Bénéficiaire..." />
								<a target="_blank" href="#printCharges" class="btn black" data-toggle="modal">
									<i class="icon-print"></i>&nbsp;Les Charges
								</a>
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
						<!-- printCharge box begin-->
						<div id="printCharges" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
								<h3>Imprimer Liste des Charges </h3>
							</div>
							<div class="modal-body">
								<form class="form-horizontal" action="controller/ChargePrintController.php" method="post" enctype="multipart/form-data">
									<p><strong>Séléctionner les charges à imprimer</strong></p>
									<div class="control-group">
										<div class="controls">
											<input type="checkbox" name="terrain" id="terrain">Terrain
											<input type="checkbox" name="construction">Construction
											<input type="checkbox" name="finition">Finition
										</div>
									</div>
									<div class="control-group">
										<div class="controls date date-picker" data-date="" data-date-format="yyyy-mm-dd">
		                                   <input style="width:100px" name="dateFrom" id="dateFrom" class="m-wrap m-ctrl-small date-picker" type="text" value="<?= date('Y-m-d') ?>" />
		                                   &nbsp;-&nbsp;
		                                   <input style="width:100px" name="dateTo" id="dateTo" class="m-wrap m-ctrl-small date-picker" type="text" value="<?= date('Y-m-d') ?>" />
		                                </div>
		                            </div>
									<div class="control-group">
										<div class="controls">
											<input type="hidden" name="idProjet" value="<?= $idProjet ?>" />
											<input type="hidden" name="idSociete" value="<?= $idSociete ?>" />
                                            <input type="hidden" name="type" value="<?= $type ?>" />	
											<button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
											<button type="submit" class="btn red" aria-hidden="true">Oui</button>
										</div>
									</div>
								</form>
							</div>
						</div>
						<!-- printCharge box end -->
						<!-- BEGIN Terrain TABLE PORTLET-->
						<?php if(isset($_SESSION['charge-add-success'])){ ?>
							<div class="alert alert-success">
								<button class="close" data-dismiss="alert"></button>
								<?= $_SESSION['charge-add-success'] ?>		
							</div>
						 <?php } 
							unset($_SESSION['charge-add-success']);
						 ?>
						 <?php if(isset($_SESSION['charge-add-error'])){ ?>
							<div class="alert alert-error">
								<button class="close" data-dismiss="alert"></button>
								<?= $_SESSION['charge-add-error'] ?>		
							</div>
						 <?php } 
							unset($_SESSION['charge-add-error']);
						 ?>
						 <?php if(isset($_SESSION['charge-update-success'])){ ?>
							<div class="alert alert-success">
								<button class="close" data-dismiss="alert"></button>
								<?= $_SESSION['charge-update-success'] ?>		
							</div>
						 <?php } 
							unset($_SESSION['charge-update-success']);
						 ?>
						 <?php if(isset($_SESSION['charge-update-error'])){ ?>
							<div class="alert alert-error">
								<button class="close" data-dismiss="alert"></button>
								<?= $_SESSION['charge-update-error'] ?>		
							</div>
						 <?php } 
							unset($_SESSION['charge-update-error']);
						 ?>
						 <?php if(isset($_SESSION['charge-delete-success'])){ ?>
							<div class="alert alert-success">
								<button class="close" data-dismiss="alert"></button>
								<?= $_SESSION['charge-delete-success'] ?>		
							</div>
						 <?php } 
							unset($_SESSION['charge-delete-success']);
						 ?>
						<table class="table table-striped table-bordered table-advance table-hover">
							<thead>
								<tr>
									<th><strong>Terrain</strong></th>
									<th><a><strong><?= number_format($chargesTerrainManager->getTotalByIdProjet($idProjet), 2, ',', ' ') ?>&nbsp;DH</strong></a></th>
									<th><strong>Construction</strong></th>
									<th><a><strong><?= number_format($chargesConstructionManager->getTotalByIdProjet($idProjet), 2, ',', ' ') ?>&nbsp;DH</strong></a></th>
									<th><strong>Finition</strong></th>
									<th><a><strong><?= number_format($chargesFinitionManager->getTotalByIdProjet($idProjet), 2, ',', ' ') ?>&nbsp;DH</strong></a></th>
									<th><strong>Grand Total</strong></th>
									<th><a><strong><?= number_format($chargesTerrainManager->getTotalByIdProjet($idProjet)+$chargesConstructionManager->getTotalByIdProjet($idProjet)+$chargesFinitionManager->getTotalByIdProjet($idProjet), 2, ',', ' ') ?>&nbsp;DH</strong></a></th>
								</tr>
							</thead>
						</table>
						<?php if($type=="terrain"){ ?>
						<div class="portlet box green charges">
							<div class="portlet-title">
								<h4>Les charges du Terrain</h4>
								<div class="tools">
									<a href="javascript:;" class="collapse"></a>
									<a href="javascript:;" class="remove"></a>
								</div>
							</div>
							<div class="portlet-body">
								<!--div class="scroller" data-height="500px" data-always-visible="1">< BEGIN DIV SCROLLER -->
								<table class="table table-striped table-bordered table-hover" <?php if ($type == "terrain") { echo 'id="sample_1"'; } ?> >
                                    <thead>
                                        <tr>
                                            <th class="hidden"></th>
                                            <th style="width:20%" class="hidden-phone">Date Opération</th>
                                            <th style="width:20%" class="hidden-phone">Désignation</th>
                                            <th style="width:20%" class="hidden-phone">Bénéficiaire</th>
                                            <th style="width:15%" class="hidden-phone">Numéro Chèque</th>
                                            <th style="width:15%" class="hidden-phone">Montant</th>
                                            <th style="width:10%" class="hidden-phone">Actions</th>
										</tr>
									</thead>
									<tbody>
										<?php
										foreach($chargesTerrain as $terrain){
										?>		
										<tr class="charges">
										    <td class="hidden"></td>
											<td><?= date('d/m/Y', strtotime($terrain->dateOperation())) ?></td>
											<td class="hidden-phone"><?= $terrain->designation() ?></td>
											<td class="hidden-phone"><?= $terrain->beneficiaire() ?></td>
											<td class="hidden-phone"><?= $terrain->numeroCheque() ?></td>
											<td class="hidden-phone"><?= $terrain->montant() ?></td>
											<td>             
                                                <?php
                                                if ( 
                                                    $_SESSION['userMerlaTrav']->profil() == "admin" ||
                                                    $_SESSION['userMerlaTrav']->profil() == "manager"
                                                    ) { 
                                                ?>                                                  
                                                <a class="btn mini green" title="Modifier" href="#updateChargeTerrain<?= $terrain->id();?>" data-toggle="modal" data-id="<?= $terrain->id(); ?>">
                                                    <i class="icon-refresh"></i>    
                                                </a>
                                                <?php
                                                }
                                                if ( $_SESSION['userMerlaTrav']->profil() == "admin" ) { 
                                                ?>   
                                                <a class="btn mini red" title="Supprimer" href="#deleteChargeTerrain<?= $terrain->id() ?>" data-toggle="modal" data-id="<?= $terrain->id() ?>">
                                                    <i class="icon-remove"></i>
                                                </a>
                                                <?php
                                                } 
                                                ?>   
                                            </td>
										</tr>
										<!-- updateChargeTerrain box begin-->
										<div id="updateChargeTerrain<?= $terrain->id() ?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
												<h3>Modifier Info Charge du terrain </h3>
											</div>
											<div class="modal-body">
												<form class="form-horizontal" action="controller/ChargeUpdateController.php" method="post">
													<div class="control-group">
														<label class="control-label">Date Opération</label>
														<div class="controls date date-picker" data-date="" data-date-format="yyyy-mm-dd">
						                                    <input name="dateOperation" id="dateOperation" class="m-wrap m-ctrl-small date-picker" type="text" value="<?= $terrain->dateOperation() ?>" />
						                                    <span class="add-on"><i class="icon-calendar"></i></span>
						                                 </div>
													</div>
													<div class="control-group">
														<label class="control-label">Désignation</label>
														<div class="controls">
															<input type="text" name="designation" value="<?= $terrain->designation() ?>" />
														</div>
													</div>
													<div class="control-group">
														<label class="control-label">Bénéficiaire</label>
														<div class="controls">
															<input type="text" name="beneficiaire" value="<?= $terrain->beneficiaire() ?>" />
														</div>
													</div>
													<div class="control-group">
														<label class="control-label">Numéro Chèque</label>
														<div class="controls">
															<input type="text" name="numeroCheque" value="<?= $terrain->numeroCheque() ?>" />
														</div>
													</div>
													<div class="control-group">
														<label class="control-label">Montant</label>
														<div class="controls">
															<input type="text" name="montant" value="<?= $terrain->montant() ?>" />
														</div>
													</div>
													<div class="control-group">
														<input type="hidden" name="idCharge" value="<?= $terrain->id() ?>" />
														<input type="hidden" name="idProjet" value="<?= $idProjet ?>" />
														<input type="hidden" name="idSociete" value="<?= $idSociete ?>" />
                                                        <input type="hidden" name="type" value="<?= $type ?>" />
														<input type="hidden" name="typeCharge" value="terrain" />
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
										<div id="deleteChargeTerrain<?= $terrain->id() ?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
												<h3>Supprimer la charge du terrain </h3>
											</div>
											<div class="modal-body">
												<form class="form-horizontal loginFrm" action="controller/ChargeDeleteController.php" method="post">
													<p>Êtes-vous sûr de vouloir supprimer la charge du terrain <strong><?= $terrain->designation() ?></strong> ?</p>
													<div class="control-group">
														<label class="right-label"></label>
														<input type="hidden" name="idCharge" value="<?= $terrain->id() ?>" />
														<input type="hidden" name="idProjet" value="<?= $idProjet ?>" />
														<input type="hidden" name="idSociete" value="<?= $idSociete ?>" />
                                                        <input type="hidden" name="type" value="<?= $type ?>" />
														<input type="hidden" name="typeCharge" value="terrain" />
														<button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
														<button type="submit" class="btn red" aria-hidden="true">Oui</button>
													</div>
												</form>
											</div>
										</div>
										<!-- deleteChargeTerrain box end -->	
										<?php
										}//end of loop
										?>
										</tbody>
                                </table>
                                <table class="table table-striped table-bordered table-hover">
                                    <tbody>
										<tr>
											<td style="width:75%"><strong>Total Terrain</strong></td>
											<td style="width:25%"><strong><a><?= number_format($chargesTerrainManager->getTotalByIdProjet($idProjet), 2, ',', ' ') ?>&nbsp;DH</a></strong></td>
										</tr>
									</tbody>
								</table>
								<!--/div>< END DIV SCROLLER -->	
							</div>
						</div>
						<?php } ?>
						<!-- END Terrain TABLE PORTLET-->
						<!--**************************** CHARGES TERRAIN END ****************************-->
						<!--**************************** CHARGES CONSTRUCTION BEGIN ****************************-->
						<!-- BEGIN Construction TABLE PORTLET-->
						<?php if($type=="construction"){ ?>
						<div class="portlet box red charges">
							<div class="portlet-title">
								<h4>Les charges de Construction</h4>
								<div class="tools">
									<a href="javascript:;" class="collapse"></a>
									<a href="javascript:;" class="remove"></a>
								</div>
							</div>
							<div class="portlet-body">
								<!--div class="scroller" data-height="500px" data-always-visible="1">< BEGIN DIV SCROLLER -->
								<table class="table table-striped table-bordered table-hover" <?php if ($type == "construction") { echo 'id="sample_1"'; } ?> >
									<thead>
										<tr>
											<th class="hidden"></th>
                                            <th style="width:20%" class="hidden-phone">Date Opération</th>
                                            <th style="width:20%" class="hidden-phone">Désignation</th>
                                            <th style="width:20%" class="hidden-phone">Bénéficiaire</th>
                                            <th style="width:15%" class="hidden-phone">Numéro Chèque</th>
                                            <th style="width:15%" class="hidden-phone">Montant</th>
                                            <th style="width:10%" class="hidden-phone">Actions</th>
										</tr>
									</thead>
									<tbody>
										<?php
										foreach($chargesConstruction as $construction){
										?>		
										<tr class="charges">
										    <td class="hidden"></td>
											<td><?= date('d/m/Y', strtotime($construction->dateOperation())) ?></td>
											<td class="hidden-phone"><?= $construction->designation() ?></td>
											<td class="hidden-phone"><?= $construction->beneficiaire() ?></td>
											<td class="hidden-phone"><?= $construction->numeroCheque() ?></td>
											<td class="hidden-phone"><?= $construction->montant() ?></td>
											<td>                 
                                                <?php
                                                if ( 
                                                    $_SESSION['userMerlaTrav']->profil() == "admin" ||
                                                    $_SESSION['userMerlaTrav']->profil() == "manager"
                                                    ) { 
                                                ?>                                              
                                                <a class="btn mini green" title="Modifier" href="#updateChargeConstruction<?= $construction->id();?>" data-toggle="modal" data-id="<?= $construction->id(); ?>">
                                                    <i class="icon-refresh"></i>    
                                                </a>
                                                <?php
                                                }
                                                if ( $_SESSION['userMerlaTrav']->profil() == "admin" ) { 
                                                ?>   
                                                <a class="btn mini red" title="Supprimer" href="#deleteChargeConstruction<?= $construction->id() ?>" data-toggle="modal" data-id="<?= $construction->id() ?>">
                                                    <i class="icon-remove"></i>
                                                </a>
                                                <?php
                                                }
                                                ?>   
                                            </td>
										</tr>
										<!-- updateChargeConstruction box begin-->
										<div id="updateChargeConstruction<?= $construction->id() ?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
												<h3>Modifier Info Charge de Construction </h3>
											</div>
											<div class="modal-body">
												<form class="form-horizontal" action="controller/ChargeUpdateController.php" method="post">
													<div class="control-group">
														<label class="control-label">Date Opération</label>
														<div class="controls date date-picker" data-date="" data-date-format="yyyy-mm-dd">
						                                    <input name="dateOperation" id="dateOperation" class="m-wrap m-ctrl-small date-picker" type="text" value="<?= $construction->dateOperation() ?>" />
						                                    <span class="add-on"><i class="icon-calendar"></i></span>
						                                 </div>
													</div>
													<div class="control-group">
														<label class="control-label">Désignation</label>
														<div class="controls">
															<input type="text" name="designation" value="<?= $construction->designation() ?>" />
														</div>
													</div>
													<div class="control-group">
														<label class="control-label">Bénéficiaire</label>
														<div class="controls">
															<input type="text" name="beneficiaire" value="<?= $construction->beneficiaire() ?>" />
														</div>
													</div>
													<div class="control-group">
														<label class="control-label">Numéro Chèque</label>
														<div class="controls">
															<input type="text" name="numeroCheque" value="<?= $construction->numeroCheque() ?>" />
														</div>
													</div>
													<div class="control-group">
														<label class="control-label">Montant</label>
														<div class="controls">
															<input type="text" name="montant" value="<?= $construction->montant() ?>" />
														</div>
													</div>
													<div class="control-group">
														<input type="hidden" name="idCharge" value="<?= $construction->id() ?>" />
														<input type="hidden" name="idProjet" value="<?= $idProjet ?>" />
														<input type="hidden" name="idSociete" value="<?= $idSociete ?>" />
                                                        <input type="hidden" name="type" value="<?= $type ?>" />
														<input type="hidden" name="typeCharge" value="construction" />
														<div class="controls">	
															<button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
															<button type="submit" class="btn red" aria-hidden="true">Oui</button>
														</div>
													</div>
												</form>
											</div>
										</div>
										<!-- updateChargeConstruction box end -->			
										<!-- deleteChargeConstruction box begin-->
										<div id="deleteChargeConstruction<?= $construction->id() ?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
												<h3>Supprimer la charge de construction </h3>
											</div>
											<div class="modal-body">
												<form class="form-horizontal loginFrm" action="controller/ChargeDeleteController.php" method="post">
													<p>Êtes-vous sûr de vouloir supprimer la charge de construction <strong><?= $construction->designation() ?></strong> ?</p>
													<div class="control-group">
														<label class="right-label"></label>
														<input type="hidden" name="idCharge" value="<?= $construction->id() ?>" />
														<input type="hidden" name="idProjet" value="<?= $idProjet ?>" />
														<input type="hidden" name="idSociete" value="<?= $idSociete ?>" />
                                                        <input type="hidden" name="type" value="<?= $type ?>" />
														<input type="hidden" name="typeCharge" value="construction" />
														<button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
														<button type="submit" class="btn red" aria-hidden="true">Oui</button>
													</div>
												</form>
											</div>
										</div>
										<!-- deleteChargeConstruction box end -->	
										<?php
										}//end of loop
										?>
						          </tbody>
                              </table>
		                      <table class="table table-striped table-bordered table-hover">
		                          <tbody>
										<tr>
											<td style="width:75%"><strong>Total Construction</strong></td>
											<td style="width:25%"><strong><a><?= number_format($chargesConstructionManager->getTotalByIdProjet($idProjet), 2, ',', ' ') ?>&nbsp;DH</a></strong></td>
										</tr>
										<tr>
											<td style="width:75%"><strong>Total Terrain+Construction</strong></td>
											<td style="width:25%"><strong><a><?= number_format($chargesTerrainManager->getTotalByIdProjet($idProjet)+$chargesConstructionManager->getTotalByIdProjet($idProjet), 2, ',', ' ') ?>&nbsp;DH</a></strong></td>
										</tr>
									</tbody>
								</table>
								<!--/div>< END DIV SCROLLER -->
							</div>
						</div>
						<?php } ?>
						<!-- END Construction TABLE PORTLET-->
						<!--**************************** CHARGES CONSTRUCTION END ****************************-->
						<!--**************************** CHARGES FINITION BEGIN ****************************-->
						<!-- BEGIN Finition TABLE PORTLET-->
						<?php if($type=="finition"){ ?>
						<div class="portlet box blue charges">
							<div class="portlet-title">
								<h4>Les charges de Finition</h4>
								<div class="tools">
									<a href="javascript:;" class="collapse"></a>
									<a href="javascript:;" class="remove"></a>
								</div>
							</div>
							<div class="portlet-body">
								<!--div class="scroller" data-height="500px" data-always-visible="1">< BEGIN DIV SCROLLER -->
								<table class="table table-striped table-bordered table-hover" <?php if ($type == "finition") { echo 'id="sample_1"'; } ?> >
									<thead>
										<tr>
										    <th class="hidden"></th>
											<th style="width:20%" class="hidden-phone">Date Opération</th>
											<th style="width:20%" class="hidden-phone">Désignation</th>
											<th style="width:20%" class="hidden-phone">Bénéficiaire</th>
											<th style="width:15%" class="hidden-phone">Numéro Chèque</th>
											<th style="width:15%" class="hidden-phone">Montant</th>
											<th style="width:10%" class="hidden-phone">Actions</th>
										</tr>
									</thead>
									<tbody>
										<?php
										foreach($chargesFinition as $finition){
										?>		
										<tr class="charges">
										    <td class="hidden"></td>
											<td class="hidden-phone"><?= date('d/m/Y', strtotime($finition->dateOperation())) ?></td>
											<td class="hidden-phone"><?= $finition->designation() ?></td>
											<td class="hidden-phone"><?= $finition->beneficiaire() ?></td>
											<td class="hidden-phone"><?= $finition->numeroCheque() ?></td>
											<td class="hidden-phone"><?= $finition->montant() ?></td>
											<td>             
                                                <?php
                                                if ( 
                                                    $_SESSION['userMerlaTrav']->profil() == "admin" ||
                                                    $_SESSION['userMerlaTrav']->profil() == "manager"
                                                    ) { 
                                                ?>                                                  
                                                <a class="btn mini green" title="Modifier" href="#updateChargeFinition<?= $finition->id();?>" data-toggle="modal" data-id="<?= $finition->id(); ?>">
                                                    <i class="icon-refresh"></i>    
                                                </a>
                                                <?php
                                                }
                                                if ( $_SESSION['userMerlaTrav']->profil() == "admin" ) { 
                                                ?>   
                                                <a class="btn mini red" title="Supprimer" href="#deleteChargeFinition<?= $finition->id() ?>" data-toggle="modal" data-id="<?= $finition->id() ?>">
                                                    <i class="icon-remove"></i>
                                                </a>
                                                <?php
                                                } 
                                                ?>   
                                            </td>
										</tr>
										<!-- updateChargeFinition box begin-->
										<div id="updateChargeFinition<?= $finition->id() ?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
												<h3>Modifier Info Charge Fintion </h3>
											</div>
											<div class="modal-body">
												<form class="form-horizontal" action="controller/ChargeUpdateController.php" method="post">
													<div class="control-group">
														<label class="control-label">Date Opération</label>
														<div class="controls date date-picker" data-date="" data-date-format="yyyy-mm-dd">
						                                    <input name="dateOperation" id="dateOperation" class="m-wrap m-ctrl-small date-picker" type="text" value="<?= $finition->dateOperation() ?>" />
						                                    <span class="add-on"><i class="icon-calendar"></i></span>
						                                 </div>
													</div>
													<div class="control-group">
														<label class="control-label">Désignation</label>
														<div class="controls">
															<input type="text" name="designation" value="<?= $finition->designation() ?>" />
														</div>
													</div>
													<div class="control-group">
														<label class="control-label">Bénéficiaire</label>
														<div class="controls">
															<input type="text" name="beneficiaire" value="<?= $finition->beneficiaire() ?>" />
														</div>
													</div>
													<div class="control-group">
														<label class="control-label">Numéro Chèque</label>
														<div class="controls">
															<input type="text" name="numeroCheque" value="<?= $finition->numeroCheque() ?>" />
														</div>
													</div>
													<div class="control-group">
														<label class="control-label">Montant</label>
														<div class="controls">
															<input type="text" name="montant" value="<?= $finition->montant() ?>" />
														</div>
													</div>
													<div class="control-group">
														<input type="hidden" name="idCharge" value="<?= $finition->id() ?>" />
														<input type="hidden" name="idProjet" value="<?= $idProjet ?>" />
														<input type="hidden" name="idSociete" value="<?= $idSociete ?>" />
                                                        <input type="hidden" name="type" value="<?= $type ?>" />
														<input type="hidden" name="typeCharge" value="finition" />
														<div class="controls">	
															<button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
															<button type="submit" class="btn red" aria-hidden="true">Oui</button>
														</div>
													</div>
												</form>
											</div>
										</div>
										<!-- updateChargeFinition box end -->			
										<!-- deleteChargeFinition box begin-->
										<div id="deleteChargeFinition<?= $finition->id() ?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
												<h3>Supprimer la charge de Finition </h3>
											</div>
											<div class="modal-body">
												<form class="form-horizontal" action="controller/ChargeDeleteController.php" method="post">
													<p>Êtes-vous sûr de vouloir supprimer la charge de finition <strong><?= $finition->designation() ?></strong> ?</p>
													<div class="control-group">
														<label class="right-label"></label>
														<input type="hidden" name="idCharge" value="<?= $finition->id() ?>" />
														<input type="hidden" name="idProjet" value="<?= $idProjet ?>" />
														<input type="hidden" name="idSociete" value="<?= $idSociete ?>" />
                                                        <input type="hidden" name="type" value="<?= $type ?>" />
														<input type="hidden" name="typeCharge" value="finition" />
														<button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
														<button type="submit" class="btn red" aria-hidden="true">Oui</button>
													</div>
												</form>
											</div>
										</div>
										<!-- deleteChargeTerrain box end -->	
										<?php
										}//end of loop
										?>
									</tbody>
								</table>
								<table class="table table-striped table-bordered table-hover">
								    <tbody>
								        <tr>
                                            <td style="width:75%" class="hidden-phone"><strong>Total Finition</strong></td>
                                            <td style="width:25%" class="hidden-phone"><a><strong><?= number_format($chargesFinitionManager->getTotalByIdProjet($idProjet), 2, ',', ' ') ?>&nbsp;DH</strong></a></td>
                                        </tr>
                                        <tr>
                                            <td style="width:75%" class="hidden-phone"><strong>Total Terrain+Construction+Finition</strong></td>
                                            <td style="width:25%" class="hidden-phone"><a><strong><?= number_format($chargesTerrainManager->getTotalByIdProjet($idProjet)+$chargesConstructionManager->getTotalByIdProjet($idProjet)+$chargesFinitionManager->getTotalByIdProjet($idProjet), 2, ',', ' ') ?>&nbsp;DH</strong></a></td>
                                        </tr>
                                    </tbody>
                                </table>
								<!--/div>< END DIV SCROLLER -->
							</div>
						</div>
						<?php } ?>
						<!-- END Finition TABLE PORTLET-->
						<!--**************************** CHARGES FINITION END ****************************-->
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