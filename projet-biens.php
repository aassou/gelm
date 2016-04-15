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
		$appartementManager = new AppartementManager($pdo);
		$locauxManager = new LocauxManager($pdo);
		$maisonManager = new MaisonManager($pdo);
		$terrainManager = new TerrainManager($pdo);
		$contratManager = new ContratManager($pdo);
		//
		$type = "";
		if(isset($_GET['idProjet']) and 
    	($_GET['idProjet'] >=1 and $_GET['idProjet'] <= $projetManager->getLastId()) ){
    		$idProjet = $_GET['idProjet'];
            $idSociete = $_GET['idSociete'];
    		$appartements = $appartementManager->getAppartementsByIdProjet($idProjet);
			$locaux = $locauxManager->getLocauxByIdProjet($idProjet);
			$maisons = $maisonManager->getMaisonsByIdProjet($idProjet);
			$terrains = $terrainManager->getTerrainsByIdProjet($idProjet);
			//Get Biens Number
			$appartementNumber = $appartementManager->getNumberBienByIdProjet($idProjet);
			$locauxNumber = $locauxManager->getNumberBienByIdProjet($idProjet);
			$maisonNumber = $maisonManager->getNumberBienByIdProjet($idProjet);
			$terrainNumber = $terrainManager->getNumberBienByIdProjet($idProjet);
			//GET biens number
			//appartements
			$appartementDisponibleNumber = $appartementManager->getNumberBienDisbonibleByIdProjet($idProjet);
			$appartementVenduNumber = $appartementManager->getNumberBienVenduByIdProjet($idProjet);
			$appartementPromesseVenteNumber = $appartementManager->getNumberBienPromesseVenteByIdProjet($idProjet);
			//maisons
			$maisonDisponibleNumber = $maisonManager->getNumberBienDisbonibleByIdProjet($idProjet);
			$maisonVenduNumber = $maisonManager->getNumberBienVenduByIdProjet($idProjet);
			$maisonPromesseVenteNumber = $maisonManager->getNumberBienPromesseVenteByIdProjet($idProjet);
			//locaux
			$locauxDisponibleNumber = $locauxManager->getNumberBienDisbonibleByIdProjet($idProjet);
			$locauxVenduNumber = $locauxManager->getNumberBienVenduByIdProjet($idProjet);
			$locauxPromesseVenteNumber = $locauxManager->getNumberBienPromesseVenteByIdProjet($idProjet);
            //Get Bien Type
            $type = $_GET['type'];
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
							Gestion Immobilière - Projet : <strong><?= $projetManager->getProjetById($idProjet)->nom() ?></strong>
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
							    <a href="biens-by-projects.php?idProjet=<?= $idProjet ?>&idSociete=<?= $idSociete ?>">Gestion Immobilière</a>
							     <i class="icon-angle-right"></i>    
					       </li>
					       <li>
                                <a>Liste des <?= $type ?></a>    
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
									Nouveau Bien Immobilière <i class="icon-plus-sign "></i>
								</a>
							</div>
						</div-->
						<!-- addCharge box begin-->
						<div id="addCharge" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
								<h3>Ajouter Nouvelle Bien Immobilière</h3>
							</div>
							<div class="modal-body">
								<form class="form-horizontal" action="controller/BienAddController.php" method="post" enctype="multipart/form-data">
									<div class="control-group">
										<label class="control-label">Type Immobilière</label>
										<div class="controls">
											<select name="typeImmobiliere" id="typeImmobiliere">
												<option value="appartement" id="appartement">Appartement</option>
                                            	<option value="local" id="local">Local Commercial</option>
                                            	<option value="maison" id="maison">Maison</option>
                                            	<option value="terrain" id="terrain">Terrain</option>
                                            </select>
										</div>
									</div>
									<div class="control-group">
										<label class="control-label">Numéro Titre</label>
										<div class="controls">
											<input type="text" name="numeroTitre" value="" />
										</div>
									</div>
									<div class="control-group">
										<label class="control-label">Code</label>
										<div class="controls">
											<input type="text" name="nom" value="" />
										</div>
									</div>
									<div class="control-group">
										<label class="control-label">Superficie</label>
										<div class="controls">
											<input type="text" name="superficie" value="" />
										</div>
									</div>
									<div class="control-group">
                                        <label class="control-label">Superficie avec surplan</label>
                                        <div class="controls">
                                            <input type="text" name="surplan" value="" />
                                        </div>
                                    </div>
									<div class="control-group" id="niveau">
										<label class="control-label">Niveau</label>
										<div class="controls">
											<select name="niveau">
												<option value="RC">RC</option>
                                            	<option value="Mezzanince">Mezzanince</option>
                                            	<option value="1ér">1ér</option>
                                            	<option value="2éme">2éme</option>
                                            	<option value="3éme">3éme</option>
                                            	<option value="4éme">4éme</option>
                                            	<option value="5éme">5éme</option>
                                            	<option value="6éme">6éme</option>
                                            </select>
										</div>
									</div>
									<div class="control-group" id="nombreEtage">
										<label class="control-label">Nombre Etage</label>
										<div class="controls">
											<select name="nombreEtage">
												<option value="RC+1">RC+1</option>
                                            	<option value="RC+2">RC+2</option>
                                            	<option value="RC+3">RC+3</option>
                                            	<option value="RC+4">RC+4</option>
                                            	<option value="RC+5">RC+5</option>
                                            </select>
										</div>
									</div>
									<div class="control-group" id="facade">
										<label class="control-label">Façade</label>
										<div class="controls">
											<input type="text" name="facade" value="" />
										</div>
									</div>
									<div class="control-group" id="emplacement">
										<label class="control-label">Emplacement</label>
										<div class="controls">
											<input type="text" name="emplacement" value="" />
										</div>
									</div>
									<div class="control-group">
										<label class="control-label">Prix</label>
										<div class="controls">
											<input type="text" name="prix" value="" />
										</div>
									</div>
									<div class="control-group" id="nombrePiece">
										<label class="control-label">Nombre Pièces</label>
										<div class="controls">
											<input type="text" name="nombrePiece" value="" />
										</div>
									</div>
									<div class="control-group" id="cave">
										<label class="control-label">Cave</label>
										<div class="controls">
											<select name="cave">
												<option value="Avec">Avec</option>
                                            	<option value="Sans">Sans</option>
                                            </select>
										</div>
									</div>
									<div class="control-group" id="mezzanine">
										<label class="control-label">Mezzanine</label>
										<div class="controls">
											<select name="mezzanine">
												<option value="Avec">Avec</option>
                                            	<option value="Sans">Sans</option>
                                            </select>
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
						<!--**************************** TERRAIN BEGIN ****************************-->
						<!-- BEGIN Terrain TABLE PORTLET-->
						<?php if(isset($_SESSION['bien-add-success'])){ ?>
							<div class="alert alert-success">
								<button class="close" data-dismiss="alert"></button>
								<?= $_SESSION['bien-add-success'] ?>		
							</div>
						 <?php } 
							unset($_SESSION['bien-add-success']);
						 ?>
						 <?php if(isset($_SESSION['bien-add-error'])){ ?>
							<div class="alert alert-error">
								<button class="close" data-dismiss="alert"></button>
								<?= $_SESSION['bien-add-error'] ?>		
							</div>
						 <?php } 
							unset($_SESSION['bien-add-error']);
						 ?>
						 <?php if(isset($_SESSION['bien-update-success'])){ ?>
							<div class="alert alert-success">
								<button class="close" data-dismiss="alert"></button>
								<?= $_SESSION['bien-update-success'] ?>		
							</div>
						 <?php } 
							unset($_SESSION['bien-update-success']);
						 ?>
						 <?php if(isset($_SESSION['bien-update-error'])){ ?>
							<div class="alert alert-error">
								<button class="close" data-dismiss="alert"></button>
								<?= $_SESSION['bien-update-error'] ?>		
							</div>
						 <?php } 
							unset($_SESSION['bien-update-error']);
						 ?>
						 <?php if(isset($_SESSION['bien-delete-success'])){ ?>
							<div class="alert alert-success">
								<button class="close" data-dismiss="alert"></button>
								<?= $_SESSION['bien-delete-success'] ?>		
							</div>
						 <?php } 
							unset($_SESSION['bien-delete-success']);
						 ?>
						<div class="row-fluid">
						    <div class="pull-right">
						        <?php
                                if ( 
                                    $_SESSION['userMerlaTrav']->profil() == "admin" ||
                                    $_SESSION['userMerlaTrav']->profil() == "manager"
                                    ) { 
                                ?> 
                                <a href="#addCharge" data-toggle="modal" class="btn green">
                                    Nouveau Bien Immobilière <i class="icon-plus-sign "></i>
                                </a>
                                <?php
                                } 
                                ?>
                                <a href="controller/BienBilanPrintController.php?idProjet=<?= $idProjet ?>&idSociete=<?= $idSociete ?>&type=<?= $type ?>" data-toggle="modal" class="btn blue">
                                    <i class="icon-print"></i> Imprimer Liste
                                </a>
                            </div>
						    <div class="input-box autocomplet_container">
								<input class="m-wrap" name="code" id="code" type="text" placeholder="Code..." />
								<input class="m-wrap" name="titre" id="titre" type="text" placeholder="Titre..." />
						    </div>
						</div>
						<?php if($type == "terrains"){ ?>
						<div class="portlet box yellow biens">
							<div class="portlet-title">
								<h4>Les Terrains</h4>
								<div class="tools">
									<a href="javascript:;" class="collapse"></a>
									<a href="javascript:;" class="remove"></a>
								</div>
							</div>
							<div class="portlet-body">
								<!--div class="scroller" data-height="500px" data-always-visible="1">< BEGIN DIV SCROLLER -->
								<table class="table table-striped table-bordered table-hover" <?php if ($type == "terrains") { echo 'id="sample_1"'; } ?> >
										<thead>
											<tr>
											    <th class="hidden"></th>
												<th class="hidden-phone">Code</th>
												<th class="hidden-phone">Titre</th>
												<th class="hidden-phone">Prix</th>
												<th class="hidden-phone">Superficie</th>
												<th class="hidden-phone">Surplan</th>
												<th class="hidden-phone">Emplacement</th>
												<th class="hidden-phone">Status</th>
												<th class="hidden-phone">Actions</th>
											</tr>
										</thead>
										<tbody>
											<?php
											foreach($terrains as $terrain){
											?>		
											<tr class="biens">
											    <td class="hidden"></td>
												<td><?= $terrain->nom() ?></td>
												<td class="hidden-phone"><?= $terrain->numeroTitre() ?></td>
												<td class="hidden-phone"><?= number_format($terrain->prix(), 2, ',' , ' ') ?></td>
												<td class="hidden-phone"><?= $terrain->superficie() ?></td>
												<td class="hidden-phone"><?= $terrain->surplan() ?></td>
												<td class="hidden-phone"><?= $terrain->emplacement() ?></td>
												<td class="hidden-phone"><a class="btn mini green"><?= $terrain->status() ?></a></td>
												<td>            
                                                    <?php
                                                    if ( 
                                                        $_SESSION['userMerlaTrav']->profil() == "admin" ||
                                                        $_SESSION['userMerlaTrav']->profil() == "manager"
                                                        ) { 
                                                    ?>                                                  
                                                    <a class="btn mini green" href="#updateTerrain<?= $terrain->id();?>" data-toggle="modal" data-id="<?= $terrain->id(); ?>">
                                                        <i class="icon-refresh"></i>
                                                    </a>
                                                    <?php
                                                    }
                                                    if ( $_SESSION['userMerlaTrav']->profil() == "admin" ) { 
                                                    ?>
                                                    <a class="btn mini red" href="#deleteTerrain<?= $terrain->id() ?>" data-toggle="modal" data-id="<?= $terrain->id() ?>">
                                                        <i class="icon-remove"></i>    
                                                    </a>
                                                    <?php
                                                    }
                                                    ?>
                                                </td>
											</tr>
											<!-- updateTerrainStatus box begin-->
											<div id="updateTerrainStatus<?= $terrain->id() ?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
												<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
													<h3>Modifier Status Terrain </h3>
												</div>
												<div class="modal-body">
													<form class="form-horizontal" action="controller/BienUpdateStatusController.php" method="post">
														<div class="control-group">
															<label class="control-label">Staus</label>
															<div class="controls">
																<select name="status">
																	<option value="<?= $terrain->status() ?>"><?= $terrain->status() ?></option>
																	<option disabled="disabled">---------------------</option>
																	<option value="Disponible">Disponible</option>
																	<option value="Promesse de Vente">Promesse de Vente</option>
					                                            	<option value="Vendu">Vendu</option>				
					                                            </select>
															</div>
														</div>
														<div class="control-group">
															<input type="hidden" name="id" value="<?= $terrain->id() ?>" />
															<input type="hidden" name="idProjet" value="<?= $idProjet ?>" />
															<input type="hidden" name="typeImmobiliere" value="terrain" />
															<input type="hidden" name="idSociete" value="<?= $idSociete ?>" />
															<input type="hidden" name="type" value="<?= $type ?>" />
															<div class="controls">	
																<button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
																<button type="submit" class="btn red" aria-hidden="true">Oui</button>
															</div>
														</div>
													</form>
												</div>
											</div>
											<!-- updateTerrainStatus box end -->
											<!-- updateTerrain box begin-->
											<div id="updateTerrain<?= $terrain->id() ?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
												<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
													<h3>Modifier Info Terrain </h3>
												</div>
												<div class="modal-body">
													<form class="form-horizontal" action="controller/BienUpdateController.php" method="post">
														<div class="control-group">
															<label class="control-label">Numéro Titre</label>
															<div class="controls">
																<input type="text" name="numeroTitre" value="<?= $terrain->numeroTitre() ?>" />
															</div>
														</div>
														<div class="control-group">
															<label class="control-label">Code</label>
															<div class="controls">
																<input type="text" name="nom" value="<?= $terrain->nom() ?>" />
															</div>
														</div>
														<div class="control-group">
															<label class="control-label">Superficie</label>
															<div class="controls">
																<input type="text" name="superficie" value="<?= $terrain->superficie() ?>" />
															</div>
														</div>
														<div class="control-group">
                                                            <label class="control-label">Superficie avec surplan</label>
                                                            <div class="controls">
                                                                <input type="text" name="surplan" value="<?= $terrain->surplan() ?>" />
                                                            </div>
                                                        </div>
														<div class="control-group">
															<label class="control-label">Emplacement</label>
															<div class="controls">
																<input type="text" name="emplacement" value="<?= $terrain->emplacement() ?>" />
															</div>
														</div>
														<div class="control-group">
															<label class="control-label">Prix</label>
															<div class="controls">
																<input type="text" name="prix" value="<?= $terrain->prix() ?>" />
															</div>
														</div>
														<div class="control-group">
															<input type="hidden" name="id" value="<?= $terrain->id() ?>" />
															<input type="hidden" name="idProjet" value="<?= $idProjet ?>" />
															<input type="hidden" name="typeImmobiliere" value="terrain" />
															<input type="hidden" name="idSociete" value="<?= $idSociete ?>" />
															<input type="hidden" name="type" value="<?= $type ?>" />
															<div class="controls">	
																<button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
																<button type="submit" class="btn red" aria-hidden="true">Oui</button>
															</div>
														</div>
													</form>
												</div>
											</div>
											<!-- updateTerrain box end -->			
											<!-- deleteTerrain box begin-->
											<div id="deleteTerrain<?= $terrain->id() ?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
												<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
													<h3>Supprimer le Terrain </h3>
												</div>
												<div class="modal-body">
													<form class="form-horizontal loginFrm" action="controller/BienDeleteController.php" method="post">
														<p>Êtes-vous sûr de vouloir supprimer ce Terrain <strong><?= $terrain->numeroTitre() ?></strong> ?</p>
														<div class="control-group">
															<label class="right-label"></label>
															<input type="hidden" name="id" value="<?= $terrain->id() ?>" />
															<input type="hidden" name="idProjet" value="<?= $idProjet ?>" />
															<input type="hidden" name="typeImmobiliere" value="terrain" />
															<input type="hidden" name="idSociete" value="<?= $idSociete ?>" />
															<input type="hidden" name="type" value="<?= $type ?>" />
															<button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
															<button type="submit" class="btn red" aria-hidden="true">Oui</button>
														</div>
													</form>
												</div>
											</div>
											<!-- deleteTerrain box end -->	
											<?php
											}//end of loop
											?>
										</tbody>
									</table>
								<!--/div>< END DIV SCROLLER -->	
							</div>
						</div>
						<?php } ?>
						<!-- END Terrain TABLE PORTLET-->
						<!--**************************** TERRAIN END ****************************-->
						<!--**************************** APPARTEMENTS BEGIN ****************************-->
						<!-- BEGIN APPARTEMENTS TABLE PORTLET-->
						<?php if($type == "appartements"){ ?>
						<div class="portlet box red biens">
							<div class="portlet-title">
								<h4>Les Appartements : 
									Nb Appt <?= $appartementNumber ?>
									, Disponible <?= $appartementDisponibleNumber ?>
									, Promesse de vente <?= $appartementPromesseVenteNumber ?>
									, Vendu <?= $appartementVenduNumber ?></h4>
								<div class="tools">
									<a href="javascript:;" class="collapse"></a>
									<a href="javascript:;" class="remove"></a>
								</div>
							</div>
							<div class="portlet-body">
								<!--div class="scroller" data-height="500px" data-always-visible="1">< BEGIN DIV SCROLLER -->
								<table class="table table-striped table-bordered table-hover" <?php if ($type == "appartements") { echo 'id="sample_1"'; } ?> >
									<thead>
										<tr>
										    <th class="hidden"></th>
											<th class="hidden-phone">Code</th>
											<th class="hidden-phone"></th>
											<th class="hidden-phone">Titre</th>
											<th class="hidden-phone">Prix</th>
											<th class="hidden-phone">Superficie</th>
											<th class="hidden-phone">Surplan</th>
											<th class="hidden-phone">DateFin</th>
											<th class="hidden-phone">Niveau</th>
											<th class="hidden-phone">Façade</th>
											<th class="hidden-phone">Nombre Pièces</th>
											<th class="hidden-phone">Status</th>
											<th class="hidden-phone">Actions</th>
										</tr>
									</thead>
									<tbody>
										<?php
										foreach($appartements as $appartement){
											$client = "";
											$status = "";
											$dateRetour = "";
											if($appartement->status()=="Disponible"){ 
												$status ='<a href="#updateAppartementStatus'.$appartement->id().'" data-toggle="modal" data-id="'.$appartement->id().'" class="btn mini green">'.$appartement->status().'</a>';
											}
											else if($appartement->status()=="Vendu"){
												$contratNumber = $contratManager->getContratNumberByIdBienByTypeBien($appartement->id(), 'appartement');
												if ( $contratNumber > 0 ) {
													$contrat = $contratManager->getContratByIdBienByTypeBien($appartement->id(), 'appartement');
													$client = '<a target="_blank" href="controller/ContratPrintController.php?idContrat='.$contrat->id().'">'.$contrat->nomClient();
													$dateRetour = $contrat->dateRetour();
												}
												$status = '<a href="#updateAppartementStatus'.$appartement->id().'" data-toggle="modal" data-id="'.$appartement->id().'" class="btn mini red">'.$appartement->status().'</a>';
											}
											else{
												$contratNumber = $contratManager->getContratNumberByIdBienByTypeBien($appartement->id(), 'appartement');
												if ( $contratNumber > 0 ) {
													$contrat = $contratManager->getContratByIdBienByTypeBien($appartement->id(), 'appartement');
													$client = '<a target="_blank" href="controller/ContratPrintController.php?idContrat='.$contrat->id().'">'.$contrat->nomClient();
													$dateRetour = $contrat->dateRetour();
												}
												$status = '<a href="#updateAppartementStatus'.$appartement->id().'" data-toggle="modal" data-id="'.$appartement->id().'" class="btn mini blue">'.$appartement->status().'</a>';
											}
										?>		
										<tr class="biens">
										    <td class="hidden"></td>
											<td><?= $appartement->nom() ?></td>
											<td class="hidden-phone"><?= $client ?></td>
											<td class="hidden-phone"><?= $appartement->numeroTitre() ?></td>
											<td class="hidden-phone"><?= number_format($appartement->prix(), 2, ',', ' ') ?></td>
											<td class="hidden-phone"><?= $appartement->superficie() ?></td>
											<td class="hidden-phone"><?= $appartement->surplan() ?></td>
											<td class="hidden-phone"><?= $dateRetour ?></td>
											<td class="hidden-phone"><?= $appartement->niveau() ?></td>
											<td class="hidden-phone"><?= $appartement->facade() ?></td>
											<td class="hidden-phone"><?= $appartement->nombrePiece() ?></td>
											<td class="hidden-phone">
											    <?php 
											    if ( $appartement->status() =="Disponible" ) {
											    ?>
											    <a class="btn mini green"><?= $appartement->status() ?></a>
											    <?php     
											    }
                                                else if ( $appartement->status() =="Vendu" ){
											    ?>
											    <a class="btn mini red"><?= $appartement->status() ?></a>
											    <?php     
                                                }
                                                else {
                                                ?>
                                                <a class="btn mini blue"><?= $appartement->status() ?></a>
                                                <?php     
                                                }
                                                ?>
										    </td>
										    <td>                                      
                                                <?php
                                                if ( 
                                                    $_SESSION['userMerlaTrav']->profil() == "admin" ||
                                                    $_SESSION['userMerlaTrav']->profil() == "manager"
                                                    ) { 
                                                ?>                              
                                                <a class="btn mini green" href="#updateAppartement<?= $appartement->id();?>" data-toggle="modal" data-id="<?= $appartement->id(); ?>">
                                                    <i class="icon-refresh"></i>
                                                </a>
                                                <?php
                                                }
                                                if ( $_SESSION['userMerlaTrav']->profil() == "admin" ) { 
                                                ?>
                                                <a class="btn mini red" href="#deleteAppartement<?= $appartement->id() ?>" data-toggle="modal" data-id="<?= $appartement->id() ?>">
                                                    <i class="icon-remove"></i>    
                                                </a>
                                                <?php
                                                }
                                                ?>
                                            </td>
										</tr>
										<!-- updateAppartementStatus box begin-->
											<div id="updateAppartementStatus<?= $appartement->id() ?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
												<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
													<h3>Modifier Status Appartement </h3>
												</div>
												<div class="modal-body">
													<form class="form-horizontal" action="controller/BienUpdateStatusController.php" method="post">
														<div class="control-group">
															<label class="control-label">Staus</label>
															<div class="controls">
																<select name="status">
																	<option value="<?= $appartement->status() ?>"><?= $appartement->status() ?></option>
																	<option disabled="disabled">---------------------</option>
																	<option value="Disponible">Disponible</option>
																	<option value="Promesse de Vente">Promesse de Vente</option>
					                                            	<option value="Vendu">Vendu</option>				
					                                            </select>
															</div>
														</div>
														<div class="control-group">
															<input type="hidden" name="id" value="<?= $appartement->id() ?>" />
															<input type="hidden" name="idProjet" value="<?= $idProjet ?>" />
															<input type="hidden" name="typeImmobiliere" value="appartement" />
															<input type="hidden" name="idSociete" value="<?= $idSociete ?>" />
															<input type="hidden" name="type" value="<?= $type ?>" />
															<div class="controls">	
																<button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
																<button type="submit" class="btn red" aria-hidden="true">Oui</button>
															</div>
														</div>
													</form>
												</div>
											</div>
											<!-- updateAppartementStatus box end -->
										<!-- updateAppartement box begin-->
										<div id="updateAppartement<?= $appartement->id() ?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
												<h3>Modifier Info Appartement </h3>
											</div>
											<div class="modal-body">
												<form class="form-horizontal" action="controller/BienUpdateController.php" method="post">
													<div class="control-group">
														<label class="control-label">Niveau</label>
														<div class="controls">
															<select name="niveau">
																<option value="<?= $appartement->niveau() ?>"><?= $appartement->niveau() ?></option>
																<option disabled="disabled">---------------------</option>
																<option value="RC">RC</option>
				                                            	<option value="Mezzanince">Mezzanince</option>
				                                            	<option value="1ér">1ér</option>
				                                            	<option value="2éme">2éme</option>
				                                            	<option value="3éme">3éme</option>
				                                            	<option value="4éme">4éme</option>
				                                            	<option value="5éme">5éme</option>
				                                            	<option value="6éme">6éme</option>
				                                            </select>
														</div>
													</div>
													<div class="control-group">
														<label class="control-label">Numéro Titre</label>
														<div class="controls">
															<input type="text" name="numeroTitre" value="<?= $appartement->numeroTitre() ?>" />
														</div>
													</div>
													<div class="control-group">
														<label class="control-label">Code</label>
														<div class="controls">
															<input type="text" name="nom" value="<?= $appartement->nom() ?>" />
														</div>
													</div>
													<div class="control-group">
														<label class="control-label">Superficie</label>
														<div class="controls">
															<input type="text" name="superficie" value="<?= $appartement->superficie() ?>" />
														</div>
													</div>
													<div class="control-group">
                                                        <label class="control-label">Superficie avec surplan</label>
                                                        <div class="controls">
                                                            <input type="text" name="surplan" value="<?= $appartement->surplan() ?>" />
                                                        </div>
                                                    </div>
													<div class="control-group">
														<label class="control-label">Façade</label>
														<div class="controls">
															<input type="text" name="facade" value="<?= $appartement->facade() ?>" />
														</div>
													</div>
													<div class="control-group">
														<label class="control-label">Prix</label>
														<div class="controls">
															<input type="text" name="prix" value="<?= $appartement->prix() ?>" />
														</div>
													</div>
													<div class="control-group">
														<label class="control-label">Nombre Pièces</label>
														<div class="controls">
															<input type="text" name="nombrePiece" value="<?= $appartement->nombrePiece() ?>" />
														</div>
													</div>
													<div class="control-group">
														<label class="control-label">Cave</label>
														<div class="controls">
															<select name="cave">
																<option value="<?= $appartement->cave() ?>"><?= $appartement->cave() ?></option>
																<option disabled="disabled">---------------------</option>
																<option value="Avec">Avec</option>
				                                            	<option value="Sans">Sans</option>
				                                            </select>
														</div>
													</div>
													<div class="control-group">
														<input type="hidden" name="id" value="<?= $appartement->id() ?>" />
														<input type="hidden" name="idProjet" value="<?= $idProjet ?>" />
														<input type="hidden" name="typeImmobiliere" value="appartement" />
														<input type="hidden" name="idSociete" value="<?= $idSociete ?>" />
														<input type="hidden" name="type" value="<?= $type ?>" />
														<div class="controls">	
															<button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
															<button type="submit" class="btn red" aria-hidden="true">Oui</button>
														</div>
													</div>
												</form>
											</div>
										</div>
										<!-- updateAppartement box end -->			
										<!-- deleteAppartement box begin-->
										<div id="deleteAppartement<?= $appartement->id() ?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
												<h3>Supprimer l'Appartement </h3>
											</div>
											<div class="modal-body">
												<form class="form-horizontal loginFrm" action="controller/BienDeleteController.php" method="post">
													<p>Êtes-vous sûr de vouloir supprimer cet Appartement <strong><?= $appartement->numeroTitre() ?></strong> ?</p>
													<div class="control-group">
														<label class="right-label"></label>
														<input type="hidden" name="id" value="<?= $appartement->id() ?>" />
														<input type="hidden" name="idProjet" value="<?= $idProjet ?>" />
														<input type="hidden" name="typeImmobiliere" value="appartement" />
														<input type="hidden" name="idSociete" value="<?= $idSociete ?>" />
														<input type="hidden" name="type" value="<?= $type ?>" />
														<button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
														<button type="submit" class="btn red" aria-hidden="true">Oui</button>
													</div>
												</form>
											</div>
										</div>
										<!-- deleteAppartement box end -->	
										<?php
										}//end of loop
										?>
									</tbody>
								</table>
								<!--/div>< END DIV SCROLLER -->
							</div>
						</div>
						<?php } ?>
						<!-- END APPARTEMENTS TABLE PORTLET-->
						<!--**************************** APPARTEMENTS END ****************************-->
						<!--**************************** LOCAUX COMMERCIAUX BEGIN ****************************-->
						<!-- BEGIN Finition TABLE PORTLET-->
						<?php if($type == "locaux"){ ?>
						<div class="portlet box blue biens">
							<div class="portlet-title">
								<h4>Les Locaux Commerciaux : Nb Locaux <?= $locauxNumber ?>
									, Disponible <?= $locauxDisponibleNumber ?>
									, Promesse de vente <?= $locauxPromesseVenteNumber ?>
									, Vendu <?= $locauxVenduNumber ?></h4>
								<div class="tools">
									<a href="javascript:;" class="collapse"></a>
									<a href="javascript:;" class="remove"></a>
								</div>
							</div>
							<div class="portlet-body">
								<!--div class="scroller" data-height="500px" data-always-visible="1">< BEGIN DIV SCROLLER -->
									<table class="table table-striped table-bordered table-hover" <?php if ($type == "locaux") { echo 'id="sample_1"'; } ?> >
										<thead>
											<tr>
											    <th class="hidden"></th>
												<th class="hidden-phone">Code</th>
												<th class="hidden-phone"></th>
												<th class="hidden-phone">Titre</th>
												<th class="hidden-phone">Prix</th>
												<th class="hidden-phone">Superficie</th>
												<th class="hidden-phone">Surplan</th>
												<th class="hidden-phone">DateFin</th>
												<th class="hidden-phone">Façade</th>
												<th class="hidden-phone">Mezzanine</th>
												<th class="hidden-phone">Status</th>
												<th class="hidden-phone">Actions</th>
											</tr>
										</thead>
										<tbody>
											<?php
											foreach($locaux as $local){
												$client = "";
												$status = "";
												$dateRetour = "";
												if($local->status()=="Disponible"){ 
													$status ='<a href="#updateLocalStatus'.$local->id().'" data-toggle="modal" data-id="'.$local->id().'" class="btn mini green">'.$local->status().'</a>';
												}
												else if($local->status()=="Vendu"){
													$contratNumber = $contratManager->getContratNumberByIdBienByTypeBien($local->id(), 'localCommercial');
													if ( $contratNumber > 0 ) {
														$contrat = $contratManager->getContratByIdBienByTypeBien($local->id(), 'localCommercial');
														$client = '<a target="_blank" href="controller/ContratPrintController.php?idContrat='.$contrat->id().'">'.$contrat->nomClient();
														$dateRetour = $contrat->dateRetour();
													}
													$status = '<a href="#updateLocalStatus'.$local->id().'" data-toggle="modal" data-id="'.$local->id().'" class="btn mini red">'.$local->status().'</a>';
												}
												else{
													$contratNumber = $contratManager->getContratNumberByIdBienByTypeBien($local->id(), 'localCommercial');
													if ( $contratNumber > 0 ) {
														$contrat = $contratManager->getContratByIdBienByTypeBien($local->id(), 'localCommercial');
														$client = '<a target="_blank" href="controller/ContratPrintController.php?idContrat='.$contrat->id().'">'.$contrat->nomClient();
														$dateRetour = $contrat->dateRetour();
													}
													$status = '<a href="#updateLocalStatus'.$local->id().'" data-toggle="modal" data-id="'.$local->id().'" class="btn mini blue">'.$local->status().'</a>';
												}
											?>		
											<tr class="biens">
											    <td class="hidden"></td>
												<td><?= $local->nom() ?></td>
												<td class="hidden-phone"><?= $client ?></td>
												<td class="hidden-phone"><?= $local->numeroTitre() ?></td>
												<td class="hidden-phone"><?= number_format($local->prix(), 2, ',' , ' ') ?></td>
												<td class="hidden-phone"><?= $local->superficie() ?></td>
												<td class="hidden-phone"><?= $local->surplan() ?></td>
												<td class="hidden-phone"><?= $dateRetour ?></td>
												<td class="hidden-phone"><?= $local->facade() ?></td>
												<td class="hidden-phone"><?= $local->mezzanine() ?></td>
												<td class="hidden-phone">
                                                <?php 
                                                if ( $local->status() =="Disponible" ) {
                                                ?>
                                                <a class="btn mini green"><?= $local->status() ?></a>
                                                <?php     
                                                }
                                                else if ( $local->status() =="Vendu" ){
                                                ?>
                                                <a class="btn mini red"><?= $local->status() ?></a>
                                                <?php     
                                                }
                                                else {
                                                ?>
                                                <a class="btn mini blue"><?= $local->status() ?></a>
                                                <?php     
                                                }
                                                ?>
                                                </td>
                                                <td>
                                                <?php
                                                    if ( 
                                                        $_SESSION['userMerlaTrav']->profil() == "admin" ||
                                                        $_SESSION['userMerlaTrav']->profil() == "manager"
                                                        ) { 
                                                    ?>                                          
                                                    <a class="btn mini green" href="#updateLocal<?= $local->id();?>" data-toggle="modal" data-id="<?= $local->id(); ?>">
                                                        <i class="icon-refresh"></i>
                                                    </a>
                                                    <?php
                                                    }
                                                    if ( $_SESSION['userMerlaTrav']->profil() == "admin" ) { 
                                                    ?>   
                                                    <a class="btn mini red" href="#deleteLocal<?= $local->id() ?>" data-toggle="modal" data-id="<?= $local->id() ?>">
                                                        <i class="icon-remove"></i>
                                                    </a>
                                                    <?php
                                                    }
                                                    ?>
                                                </td>
											</tr>
											<!-- updateLocalStatus box begin-->
											<div id="updateLocalStatus<?= $local->id() ?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
												<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
													<h3>Modifier Status Local Commercial </h3>
												</div>
												<div class="modal-body">
													<form class="form-horizontal" action="controller/BienUpdateStatusController.php" method="post">
														<div class="control-group">
															<label class="control-label">Staus</label>
															<div class="controls">
																<select name="status">
																	<option value="<?= $local->status() ?>"><?= $local->status() ?></option>
																	<option disabled="disabled">---------------------</option>
																	<option value="Disponible">Disponible</option>
																	<option value="Promesse de Vente">Promesse de Vente</option>
					                                            	<option value="Vendu">Vendu</option>				
					                                            </select>
															</div>
														</div>
														<div class="control-group">
															<input type="hidden" name="id" value="<?= $local->id() ?>" />
															<input type="hidden" name="idProjet" value="<?= $idProjet ?>" />
															<input type="hidden" name="typeImmobiliere" value="local" />
															<input type="hidden" name="idSociete" value="<?= $idSociete ?>" />
															<input type="hidden" name="type" value="<?= $type ?>" />
															<div class="controls">	
																<button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
																<button type="submit" class="btn red" aria-hidden="true">Oui</button>
															</div>
														</div>
													</form>
												</div>
											</div>
											<!-- updateLocalStatus box end -->
											<!-- updateLocal box begin-->
											<div id="updateLocal<?= $local->id() ?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
												<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
													<h3>Modifier Info Local Commercial </h3>
												</div>
												<div class="modal-body">
													<form class="form-horizontal" action="controller/BienUpdateController.php" method="post">
														<div class="control-group">
															<label class="control-label">Numéro Titre</label>
															<div class="controls">
																<input type="text" name="numeroTitre" value="<?= $local->numeroTitre() ?>" />
															</div>
														</div>
														<div class="control-group">
															<label class="control-label">Code</label>
															<div class="controls">
																<input type="text" name="nom" value="<?= $local->nom() ?>" />
															</div>
														</div>
														<div class="control-group">
															<label class="control-label">Superficie</label>
															<div class="controls">
																<input type="text" name="superficie" value="<?= $local->superficie() ?>" />
															</div>
														</div>
														<div class="control-group">
                                                            <label class="control-label">Superficie avec surplan</label>
                                                            <div class="controls">
                                                                <input type="text" name="surplan" value="<?= $local->surplan() ?>" />
                                                            </div>
                                                        </div>
														<div class="control-group">
															<label class="control-label">Façade</label>
															<div class="controls">
																<input type="text" name="facade" value="<?= $local->facade() ?>" />
															</div>
														</div>
														<div class="control-group">
															<label class="control-label">Prix</label>
															<div class="controls">
																<input type="text" name="prix" value="<?= $local->prix() ?>" />
															</div>
														</div>
														<div class="control-group">
															<label class="control-label">Mezzanine</label>
															<div class="controls">
																<select name="status">
																	<option value="<?= $local->mezzanine() ?>"><?= $local->mezzanine() ?></option>
																	<option disabled="disabled">---------------------</option>
																	<option value="Avec">Avec</option>
					                                            	<option value="Sans">Sans</option>
					                                            </select>
															</div>
														</div>
														<div class="control-group">
															<input type="hidden" name="id" value="<?= $local->id() ?>" />
															<input type="hidden" name="idProjet" value="<?= $idProjet ?>" />
															<input type="hidden" name="typeImmobiliere" value="local" />
															<input type="hidden" name="idSociete" value="<?= $idSociete ?>" />
															<input type="hidden" name="type" value="<?= $type ?>" />
															<div class="controls">	
																<button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
																<button type="submit" class="btn red" aria-hidden="true">Oui</button>
															</div>
														</div>
													</form>
												</div>
											</div>
											<!-- updateLocal box end -->			
											<!-- deleteLocal box begin-->
											<div id="deleteLocal<?= $local->id() ?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
												<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
													<h3>Supprimer le local commercial </h3>
												</div>
												<div class="modal-body">
													<form class="form-horizontal loginFrm" action="controller/BienDeleteController.php" method="post">
														<p>Êtes-vous sûr de vouloir supprimer ce Local Commercial <strong><?= $local->numeroTitre() ?></strong> ?</p>
														<div class="control-group">
															<label class="right-label"></label>
															<input type="hidden" name="id" value="<?= $local->id() ?>" />
															<input type="hidden" name="idProjet" value="<?= $idProjet ?>" />
															<input type="hidden" name="typeImmobiliere" value="local" />
															<input type="hidden" name="idSociete" value="<?= $idSociete ?>" />
															<input type="hidden" name="type" value="<?= $type ?>" />
															<button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
															<button type="submit" class="btn red" aria-hidden="true">Oui</button>
														</div>
													</form>
												</div>
											</div>
											<!-- deleteLocal box end -->	
											<?php
											}//end of loop
											?>
										</tbody>
									</table>
								<!--/div>< END DIV SCROLLER -->
							</div>
						</div>
						<?php } ?>
						<!-- END LOCAUX COMMERCIAUX TABLE PORTLET-->
						<!--**************************** LOCAUX COMMERCIAUX END ****************************-->
						<!--**************************** MAISONS BEGIN ****************************-->
						<!-- BEGIN MAISONS TABLE PORTLET-->
						<?php if($type == "maisons"){ ?>
						<div class="portlet box green biens">
							<div class="portlet-title">
								<h4>Les Maisons : Nb Maisons <?= $maisonNumber ?>
									, Disponible <?= $maisonDisponibleNumber ?>
									, Promesse de vente <?= $maisonPromesseVenteNumber ?>
									, Vendu <?= $maisonVenduNumber ?></h4>
								<div class="tools">
									<a href="javascript:;" class="collapse"></a>
									<a href="javascript:;" class="remove"></a>
								</div>
							</div>
							<div class="portlet-body">
								<!--div class="scroller" data-height="500px" data-always-visible="1">< BEGIN DIV SCROLLER -->
									<table class="table table-striped table-bordered table-hover" <?php if ($type == "maisons") { echo 'id="sample_1"'; } ?> >
										<thead>
											<tr>
											    <th class="hidden"></th>
                                                <th class="hidden-phone">Code</th>
												<th class="hidden-phone"></th>
                                                <th class="hidden-phone">Titre</th>
												<th class="hidden-phone">Prix</th>
												<th class="hidden-phone">Superficie</th>
												<th class="hidden-phone">Surplan</th>
												<th class="hidden-phone">DateFin</th>
												<th class="hidden-phone">Etages</th>
												<th class="hidden-phone">Emplacement</th>
												<th class="hidden-phone">Status</th>
												<th class="hidden-phone">Actions</th>
											</tr>
										</thead>
										<tbody>
											<?php
											foreach($maisons as $maison){
												$client = "";
												$status = "";
												$dateRetour = "";
												if($maison->status()=="Disponible"){ 
													$status ='<a href="#updateMaisonStatus'.$maison->id().'" data-toggle="modal" data-id="'.$maison->id().'" class="btn mini green">'.$maison->status().'</a>';
												}
												else if($maison->status()=="Vendu"){
													$contratNumber = $contratManager->getContratNumberByIdBienByTypeBien($maison->id(), 'maison');
													if ( $contratNumber > 0 ) {
														$contrat = $contratManager->getContratByIdBienByTypeBien($maison->id(), 'maison');
														$client = '<a target="_blank" href="controller/ContratPrintController.php?idContrat='.$contrat->id().'">'.$contrat->nomClient();
														$dateRetour = $contrat->dateRetour();
													}
													$status = '<a href="#updateMaisonStatus'.$maison->id().'" data-toggle="modal" data-id="'.$maison->id().'" class="btn mini red">'.$maison->status().'</a>';
												}
												else{
													$contratNumber = $contratManager->getContratNumberByIdBienByTypeBien($maison->id(), 'maison');
													if ( $contratNumber > 0 ) {
														$contrat = $contratManager->getContratByIdBienByTypeBien($maison->id(), 'maison');
														$client = '<a target="_blank" href="controller/ContratPrintController.php?idContrat='.$contrat->id().'">'.$contrat->nomClient();
														$dateRetour = $contrat->dateRetour();
													}
													$status = '<a href="#updateMaisonStatus'.$maison->id().'" data-toggle="modal" data-id="'.$maison->id().'" class="btn mini blue">'.$maison->status().'</a>';
												}
											?>		
											<tr class="biens">
											    <td class="hidden"></td>
												<td><?= $maison->nom() ?></td>
												<td class="hidden-phone"><?= $client ?></td>
												<td class="hidden-phone"><?= $maison->numeroTitre() ?></td>
												<td class="hidden-phone"><?= number_format($maison->prix(), 2, ',' , ' ') ?></td>
												<td class="hidden-phone"><?= $maison->superficie() ?></td>
												<td class="hidden-phone"><?= $maison->surplan() ?></td>
												<td class="hidden-phone"><?= $dateRetour ?></td>
												<td class="hidden-phone"><?= $maison->nombreEtage() ?></td>
												<td class="hidden-phone"><?= $maison->emplacement() ?></td>
												<td class="hidden-phone">
												<?php 
                                                if ( $maison->status() =="Disponible" ) {
                                                ?>
                                                <a class="btn mini green"><?= $maison->status() ?></a>
                                                <?php     
                                                }
                                                else if ( $maison->status() =="Vendu" ){
                                                ?>
                                                <a class="btn mini red"><?= $maison->status() ?></a>
                                                <?php     
                                                }
                                                else {
                                                ?>
                                                <a class="btn mini blue"><?= $maison->status() ?></a>
                                                <?php     
                                                }
                                                ?>
												</td>
												<td>
												<?php
                                                if ( 
                                                    $_SESSION['userMerlaTrav']->profil() == "admin" ||
                                                    $_SESSION['userMerlaTrav']->profil() == "manager"
                                                    ) { 
                                                ?>                                                  
                                                <a class="btn mini green" href="#updateMaison<?= $maison->id();?>" data-toggle="modal" data-id="<?= $maison->id(); ?>">
                                                    <i class="icon-refresh"></i>
                                                </a>
                                                <?php
                                                }
                                                if ( $_SESSION['userMerlaTrav']->profil() == "admin" ) { 
                                                ?>   
                                                <a class="btn mini red" href="#deleteMaison<?= $maison->id() ?>" data-toggle="modal" data-id="<?= $maison->id() ?>">
                                                    <i class="icon-remove"></i>    
                                                </a>
                                                <?php
                                                }
                                                ?>   
                                                </td>
											</tr>
											<!-- updateMaisonStatus box begin-->
											<div id="updateMaisonStatus<?= $maison->id() ?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
												<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
													<h3>Modifier Status Maison </h3>
												</div>
												<div class="modal-body">
													<form class="form-horizontal" action="controller/BienUpdateStatusController.php" method="post">
														<div class="control-group">
															<label class="control-label">Staus</label>
															<div class="controls">
																<select name="status">
																	<option value="<?= $maison->status() ?>"><?= $maison->status() ?></option>
																	<option disabled="disabled">---------------------</option>
																	<option value="Disponible">Disponible</option>
																	<option value="Promesse de Vente">Promesse de Vente</option>
					                                            	<option value="Vendu">Vendu</option>				
					                                            </select>
															</div>
														</div>
														<div class="control-group">
															<input type="hidden" name="id" value="<?= $maison->id() ?>" />
															<input type="hidden" name="idProjet" value="<?= $idProjet ?>" />
															<input type="hidden" name="typeImmobiliere" value="maison" />
															<input type="hidden" name="idSociete" value="<?= $idSociete ?>" />
															<input type="hidden" name="type" value="<?= $type ?>" />
															<div class="controls">	
																<button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
																<button type="submit" class="btn red" aria-hidden="true">Oui</button>
															</div>
														</div>
													</form>
												</div>
											</div>
											<!-- updateMaisonStatus box end -->
											<!-- updateMaison box begin-->
											<div id="updateMaison<?= $maison->id() ?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
												<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
													<h3>Modifier Info Maison </h3>
												</div>
												<div class="modal-body">
													<form class="form-horizontal" action="controller/BienUpdateController.php" method="post">
														<div class="control-group">
															<label class="control-label">Numéro Titre</label>
															<div class="controls">
																<input type="text" name="numeroTitre" value="<?= $maison->numeroTitre() ?>" />
															</div>
														</div>
														<div class="control-group">
															<label class="control-label">Code</label>
															<div class="controls">
																<input type="text" name="nom" value="<?= $maison->nom() ?>" />
															</div>
														</div>
														<div class="control-group">
															<label class="control-label">Superficie</label>
															<div class="controls">
																<input type="text" name="superficie" value="<?= $maison->superficie() ?>" />
															</div>
														</div>
														<div class="control-group">
                                                            <label class="control-label">Superficie avec surplan</label>
                                                            <div class="controls">
                                                                <input type="text" name="surplan" value="<?= $maison->surplan() ?>" />
                                                            </div>
                                                        </div>
														<div class="control-group">
															<label class="control-label">Nombre Etages</label>
															<div class="controls">
																<select name="nombreEtage">
																	<option value="<?= $maison->nombreEtage() ?>"><?= $maison->nombreEtage() ?></option>
																	<option disabled="disabled">---------------------</option>
																	<option value="RC+1">RC+1</option>
					                                            	<option value="RC+2">RC+2</option>
					                                            	<option value="RC+3">RC+3</option>
					                                            	<option value="RC+4">RC+4</option>
					                                            	<option value="RC+5">RC+5</option>					
					                                            </select>
															</div>
														</div>
														<div class="control-group">
															<label class="control-label">Emplacement</label>
															<div class="controls">
																<input type="text" name="emplacement" value="<?= $maison->emplacement() ?>" />
															</div>
														</div>
														<div class="control-group">
															<label class="control-label">Prix</label>
															<div class="controls">
																<input type="text" name="prix" value="<?= $maison->prix() ?>" />
															</div>
														</div>
														<div class="control-group">
															<input type="hidden" name="id" value="<?= $maison->id() ?>" />
															<input type="hidden" name="idProjet" value="<?= $idProjet ?>" />
															<input type="hidden" name="typeImmobiliere" value="maison" />
															<input type="hidden" name="idSociete" value="<?= $idSociete ?>" />
															<input type="hidden" name="type" value="<?= $type ?>" />
															<div class="controls">	
																<button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
																<button type="submit" class="btn red" aria-hidden="true">Oui</button>
															</div>
														</div>
													</form>
												</div>
											</div>
											<!-- updateMaison box end -->			
											<!-- deleteMaison box begin-->
											<div id="deleteMaison<?= $maison->id() ?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
												<div class="modal-header">
													<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
													<h3>Supprimer la Maison </h3>
												</div>
												<div class="modal-body">
													<form class="form-horizontal loginFrm" action="controller/BienDeleteController.php" method="post">
														<p>Êtes-vous sûr de vouloir supprimer cette Maison <strong><?= $maison->numeroTitre() ?></strong> ?</p>
														<div class="control-group">
															<label class="right-label"></label>
															<input type="hidden" name="id" value="<?= $maison->id() ?>" />
															<input type="hidden" name="idProjet" value="<?= $idProjet ?>" />
															<input type="hidden" name="typeImmobiliere" value="maison" />
															<input type="hidden" name="idSociete" value="<?= $idSociete ?>" />
															<input type="hidden" name="type" value="<?= $type ?>" />
															<button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
															<button type="submit" class="btn red" aria-hidden="true">Oui</button>
														</div>
													</form>
												</div>
											</div>
											<!-- deleteMaison box end -->	
											<?php
											}//end of loop
											?>
										</tbody>
									</table>
								<!--/div>< END DIV SCROLLER -->
							</div>
						</div>
						<?php } ?>
						<!-- END MAISONS TABLE PORTLET-->
						<!--**************************** MAISONS END ****************************-->
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
			$("#mezzanine").hide();
			$("#emplacement").hide();
			$("#nombreEtage").hide();
	        $("#cave").show();
	        $("#facade").show();
	        $("#niveau").show();
	        $("#nombrePiece").show();
		});
		$('#typeImmobiliere').on('change',function(){
	        if( $(this).val()==="local"){
		        $("#mezzanine").show();
		        $("#cave").hide();
		        $("#niveau").hide();
		        $("#nombrePiece").hide();
		        $("#facade").show();
		        $("#emplacement").hide();
				$("#nombreEtage").hide();
	        }
	        else if( $(this).val()==="maison"){
		        $("#mezzanine").hide();
		        $("#cave").hide();
		        $("#niveau").hide();
		        $("#nombrePiece").hide();
		        $("#facade").hide();
		        $("#emplacement").show();
				$("#nombreEtage").show();
	        }
	        else if( $(this).val()==="terrain" ){
		        $("#mezzanine").hide();
		        $("#cave").hide();
		        $("#niveau").hide();
		        $("#nombrePiece").hide();
		        $("#facade").hide();
		        $("#nombreEtage").hide();
		        $("#emplacement").show();
	        }
	        else if( $(this).val()==="appartement" ){
		        $("#mezzanine").hide();
				$("#emplacement").hide();
				$("#nombreEtage").hide();
		        $("#cave").show();
		        $("#facade").show();
		        $("#niveau").show();
		        $("#nombrePiece").show();
	        }
	    });
		$('.biens').show();
		$('#code').keyup(function(){
		    $('.biens').hide();
		   var txt = $('#code').val();
		   $('.biens').each(function(){
		       if($(this).text().toUpperCase().indexOf(txt.toUpperCase()) != -1){
		           $(this).show();
		       }
		    });
		});	
		$('#titre').keyup(function(){
		   $('.biens').hide();
		   var txt = $('#titre').val();
		   $('.biens').each(function(){
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