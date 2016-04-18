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
    if ( isset($_SESSION['userMerlaTrav']) ) {
    	//les sources
    	$idSociete = 0;
    	$societeManager = new SocieteManager($pdo);
		if(isset($_GET['idSociete']) and 
		($_GET['idSociete'])>0 and $_GET['idSociete'] <= $societeManager->getLastId()){
			$idSociete = $_GET['idSociete'];
			$societe = $societeManager->getSocieteById($idSociete);
			$piecesSocieteManager = new PiecesSocieteManager($pdo);
			$piecesSociete = $piecesSocieteManager->getPiecesSocietesByIdSociete($idSociete);
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
							Liste des documents - Société : <strong><?= $societe->raisonSociale() ?></strong>
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
							    <a>Liste des documents</a>
							</li>
						</ul>
						<!-- END PAGE TITLE & BREADCRUMB-->
					</div>
				</div>
				<!-- END PAGE HEADER-->
				<!-- BEGIN PAGE CONTENT-->
				<?php if($idSociete!=0){ ?>
				<div class="row-fluid"> 
					<div class="span12">
						<!-- BEGIN Terrain TABLE PORTLET-->
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
                         <?php if(isset($_SESSION['pieces-delete-success'])){ ?>
                         	<div class="alert alert-info">
								<button class="close" data-dismiss="alert"></button>
								<?= $_SESSION['pieces-delete-success'] ?>		
							</div>
                         <?php } 
                         	unset($_SESSION['pieces-delete-success']);
                         ?>
						<!-- END Terrain TABLE PORTLET-->
						<!-- BEGIN PicesTerrain GALLERY PORTLET-->
						<div class="row-fluid">
							<div class="span12">
								<div class="portlet">
									<div class="portlet-title">
										<div class="tools">
											<a href="javascript:;" class="collapse"></a>
											<a href="javascript:;" class="remove"></a>
										</div>
									</div>
									<?php
                                    if ( 
                                        $_SESSION['userMerlaTrav']->profil() == "admin" ||
                                        $_SESSION['userMerlaTrav']->profil() == "manager"
                                        ) { 
                                    ?> 
									<a href="#addSocieteDocs<?= $societe->id() ?>" class="btn green" data-toggle="modal" data-id="<?= $societe->id(); ?>">
										<i class="icon-paper-clip"></i> Ajouter un document
									</a>
									<?php
                                    } 
                                    ?> 
									<br><br>
									<!-- addSocieteDocs box begin-->
									<div id="addSocieteDocs<?= $societe->id() ?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
										<div class="modal-header">
											<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
											<h3>Ajouter des documents </h3>
										</div>
										<div class="modal-body">
										<form class="form-horizontal" action="controller/SocieteDocumentAddController.php?source=2" method="post" enctype="multipart/form-data">
												<p>Ajouter un document pour la société <strong><?= $societe->raisonSociale() ?></strong></p>
												<div class="control-group">
					                              <label class="control-label">Document</label>
					                              <div class="controls">
					                              	<input type="file" name="urlPieceSociete" />
					                              </div>
					                           </div>
												<div class="control-group">
													<label class="control-label">Description</label>
													<div class="controls">
														<textarea name="descriptionSociete" ></textarea>
													</div>
												</div>
												<div class="control-group">
													<div class="controls">	
														<input type="hidden" name="idSociete" value="<?= $societe->id() ?>" />
														<button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
														<button type="submit" class="btn red" aria-hidden="true">Oui</button>
													</div>
												</div>
											</form>
										</div>
									</div>
									<!-- addSocieteDocs box end -->
									<div class="portlet-body">
										<?php
										foreach($piecesSociete as $pieces){
										?>
										<div class="span3">
											<div class="item">
												<a class="fancybox-button" data-rel="fancybox-button" title="<?= $pieces->description() ?>" href="<?= $pieces->url() ?>">
													<div class="zoom">
														<img style="height: 100px; width: 200px" src="<?= $pieces->url() ?>" alt="<?= $pieces->description() ?>" />							
														<div class="zoom-icon"></div>
													</div>
												</a>
											</div>
											<?php if($_SESSION['userMerlaTrav']->profil()=="admin"){ ?>
											<a class="btn mini red" href="#deletePiece<?= $pieces->id() ?>" data-toggle="modal" data-id="<?= $pieces->id() ?>">
												Supprimer
											</a>
											<?php } ?>
											<br><br>	
										</div>
										<!-- delete box begin-->
										<div id="deletePiece<?= $pieces->id();?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
												<h3>Supprimer Document</h3>
											</div>
											<div class="modal-body">
												<form class="form-horizontal loginFrm" action="controller/SocietePiecesDeleteController.php" method="post">
													<p>Êtes-vous sûr de vouloir supprimer ce document ?</p>
													<div class="control-group">
														<label class="right-label"></label>
														<input type="hidden" name="idPiece" value="<?= $pieces->id() ?>" />
														<input type="hidden" name="idSociete" value="<?= $idSociete ?>" />
														<button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
														<button type="submit" class="btn red" aria-hidden="true">Oui</button>
													</div>
												</form>
											</div>
										</div>
										<!-- delete box end -->	
										<?php		
												}//end of loop : piecesSociete
										?>
									</div>
								</div>
							</div>
						</div>
						<!-- END PicesTerrain GALLERY PORTLET-->
					</div>
				</div>
				<?php }
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
	<script src="assets/js/app.js"></script>		
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
else{
    header('Location:index.php');    
}
?>