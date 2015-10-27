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
    	$societeManager = new SocieteManager($pdo);
    	if(isset($_GET['idSociete']) and 
    	($_GET['idSociete'] >=1 and $_GET['idSociete'] <= $societeManager->getLastId()) ){
    	$idSociete = $_GET['idSociete'];
    	$projetManager = new ProjetManager($pdo);
		$projets = $projetManager->getProjets();
    	$projetManager = new projetManager($pdo);
		$projetNumber = $projetManager->getProjetsNumber();
		if($projetNumber!=0){
			$projetPerPage = 10;
	        $pageNumber = ceil($projetNumber/$projetPerPage);
	        $p = 1;
	        if(isset($_GET['p']) and ($_GET['p']>0 and $_GET['p']<=$pageNumber)){
	            $p = $_GET['p'];
	        }
	        else{
	            $p = 1;
	        }
	        $begin = ($p - 1) * $projetPerPage;
	        $pagination = paginate('company-projets.php?idSociete='.$idSociete, '&p=', $pageNumber, $p);
			$projets = $projetManager->getProjetsByIdSocieteByLimits($idSociete, $begin, $projetPerPage);	 
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
							Gestion des projets de la societe <?= $societeManager->getSocieteById($idSociete)->raisonSociale() ?>
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
							<li>
								<a>Liste des projets de la société <?= $societeManager->getSocieteById($idSociete)->raisonSociale() ?></a>
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
								<a href="companies.php" class="btn green">
									<i class="m-icon-swapleft m-icon-white"></i>&nbsp;Retours vers Liste des sociétés
								</a>
							</div>
						</div>
						
						<!-- addprojet box begin-->
						<!--div id="addprojet" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
								<h3>Ajouter une nouvelle livraison </h3>
							</div>
							<div class="modal-body">
								<form class="form-horizontal" action="controller/projetAddController.php" method="post" enctype="multipart/form-data">
									<div class="control-group">
										<label class="control-label">Projet</label>
										<div class="controls">
											<select name="idProjet">
                                            	<?php foreach($projets as $projet){ ?>
                                            	<option value="<?= $projet->id() ?>"><?= $projet->nom() ?></option>
                                            	<?php } ?>
                                            </select>
										</div>
									</div>
									<div class="control-group">
										<label class="control-label">Numéro projet</label>
										<div class="controls">
											<input type="text" name="numeroprojet" value="" />
										</div>
									</div>
									<div class="control-group">
										<label class="control-label">Montant</label>
										<div class="controls">
											<input type="text" name="montant" value="" />
										</div>
									</div>
									<div class="control-group">
										<label class="control-label">Date</label>
										<div class="controls date date-picker" data-date="" data-date-format="yyyy-mm-dd">
		                                    <input name="dateprojet" id="dateprojet" class="m-wrap m-ctrl-small date-picker" type="text" value="<?= date('Y-m-d') ?>" />
		                                    <span class="add-on"><i class="icon-calendar"></i></span>
		                                 </div>
									</div>
									<div class="control-group">
										<label class="control-label">Désignation</label>
										<div class="controls">
											<input class="span5" type="text" name="designationSociete" placeholder="Société" />
											<input class="span5" type="text" name="designationPersonne" placeholder="Personne" />
										</div>
									</div>
									<div class="control-group">
										<label class="control-label">Statut</label>
										<div class="controls">
											<select name="statut">
                                            	<option value="En cours">En cours</option>
                                            	<option value="Déposé">Déposé</option>
                                            	<option value="Annulé">Annulé</option>
                                            </select>
										</div>
									</div>
									<div class="control-group">
		                              	<label class="control-label">Copie projet</label>
		                              	<div class="controls">
		                              		<input type="file" name="urlprojet" />
		                              	</div>
		                           	</div>
									<div class="control-group">
										<div class="controls">
											<button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
											<button type="submit" class="btn red" aria-hidden="true">Oui</button>
										</div>
									</div>
								</form>
							</div>
						</div-->
						<!-- addprojet box end -->
						<!--div class="row-fluid">
							<form action="" method="post">
							    <div class="input-box autocomplet_container">
									<input class="m-wrap" name="recherche" id="nomFournisseur" type="text" onkeyup="autocompletFournisseur()" placeholder="Chercher un fournisseur...">
										<ul id="fournisseurList"></ul>
									</input>
									<input class="m-wrap" name="projet" id="nomProjet" type="text" onkeyup="autocompletProjet()" placeholder="Projet">
										<ul id="projetList"></ul>
									</input>
									<input name="idFournisseur" id="idFournisseur" type="hidden" />
									<input name="idProjet" id="idProjet" type="hidden" />
									<button type="submit" class="btn red"><i class="icon-search"></i></button>
							    </div>
							</form>
						</div-->
						<!-- BEGIN Terrain TABLE PORTLET-->
						<?php if(isset($_SESSION['projet-add-success'])){ ?>
							<div class="alert alert-success">
								<button class="close" data-dismiss="alert"></button>
								<?= $_SESSION['projet-add-success'] ?>		
							</div>
						 <?php } 
							unset($_SESSION['projet-add-success']);
						 ?>
						 <?php if(isset($_SESSION['projet-add-error'])){ ?>
							<div class="alert alert-error">
								<button class="close" data-dismiss="alert"></button>
								<?= $_SESSION['projet-add-error'] ?>		
							</div>
						 <?php } 
							unset($_SESSION['projet-add-error']);
						 ?>
						 <?php if(isset($_SESSION['projet-update-success'])){ ?>
							<div class="alert alert-success">
								<button class="close" data-dismiss="alert"></button>
								<?= $_SESSION['projet-update-success'] ?>		
							</div>
						 <?php } 
							unset($_SESSION['projet-update-success']);
						 ?>
						 <?php if(isset($_SESSION['projet-update-error'])){ ?>
							<div class="alert alert-error">
								<button class="close" data-dismiss="alert"></button>
								<?= $_SESSION['projet-update-error'] ?>		
							</div>
						 <?php } 
							unset($_SESSION['projet-update-error']);
						 ?>
						 <?php if(isset($_SESSION['projet-delete-success'])){ ?>
							<div class="alert alert-success">
								<button class="close" data-dismiss="alert"></button>
								<?= $_SESSION['projet-delete-success'] ?>		
							</div>
						 <?php } 
							unset($_SESSION['projet-delete-success']);
						 ?>
						<div class="portlet">
							<div class="portlet-title">
								<h4>Liste des projets</h4>
								<div class="tools">
									<a href="javascript:;" class="collapse"></a>
									<a href="javascript:;" class="remove"></a>
								</div>
							</div>
							<div class="portlet-body">
								<table class="table table-bordered table-advance table-hover">
									<thead>
										<tr>
											<th>Nom Projet</th>
											<th class="hidden-phone">Numéro Titre</th>
											<th class="hidden-phone">Emplacement</th>
											<th class="hidden-phone">Supérficie</th>
											<th class="hidden-phone">Description</th>
											<th class="hidden-phone">Date création</th>
										</tr>
									</thead>
									<tbody>
										<?php
										if($projetNumber != 0){
										foreach($projets as $projet){
										?>		
										<tr>
											<td>
												<div class="btn-group">
												    <a style="width: 100px" class="btn mini dropdown-toggle" href="#" data-toggle="dropdown">
												    	<?= $projet->nom() ?> 
												        <i class="icon-angle-down"></i>
												    </a>
												    <!--ul class="dropdown-menu">
												        <li>																
												        	<a href="#updateprojet<?= $projet->id();?>" data-toggle="modal" data-id="<?= $projet->id(); ?>">
																Modifier
															</a>
															<a href="#deleteprojet<?= $projet->id() ?>" data-toggle="modal" data-id="<?= $projet->id() ?>">
																Supprimer
															</a>
												        </li>
												    </ul-->
												</div>
											</td>
											<td class="hidden-phone"><?= $projet->numeroTitre() ?></td>
											<td class="hidden-phone"><?= $projet->emplacement() ?></td>
											<td class="hidden-phone"><?= $projet->superficie() ?></td>
											<td class="hidden-phone"><?= $projet->description() ?></td>
											<td class="hidden-phone"><?= date('d/m/Y', strtotime($projet->dateCreation())) ?></td>
										</tr>
										<!-- updateprojet box begin-->
										<div id="updateProjet<?= $projet->id() ?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
												<h3>Modifier les informations du projet</h3>
											</div>
											<div class="modal-body">
												<form class="form-horizontal" action="controller/ProjetUpdateController.php" method="post" enctype="multipart/form-data">
													
													<div class="control-group">
														<div class="controls">
															<input type="hidden" name="idprojet" value="<?= $projet->id() ?>">
															<button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
															<button type="submit" class="btn red" aria-hidden="true">Oui</button>
														</div>
													</div>
												</form>
											</div>
										</div>
										<!-- updateLivraison box end -->			
										<!-- delete box begin-->
										<div id="deleteProjet<?= $projet->id() ?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
												<h3>Supprimer le projet </h3>
											</div>
											<div class="modal-body">
												<form class="form-horizontal loginFrm" action="controller/ProjetDeleteController.php" method="post">
													<p>Êtes-vous sûr de vouloir supprimer le projet <strong><?= $projet->nom() ?></strong> ?</p>
													<div class="control-group">
														<label class="right-label"></label>
														<input type="hidden" name="idprojet" value="<?= $projet->id() ?>" />
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
									if($projetNumber != 0){
										echo $pagination;	
									}
									?>
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
					<strong>Erreur système : </strong>Cette société n'existe pas sur votre système. Pour plus d'informations consulter votre administrateur.		
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
			//App.setPage("table_editable");
			App.init();
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