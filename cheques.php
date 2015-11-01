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
		$projets = $projetManager->getProjets();
    	$chequeManager = new ChequeManager($pdo);
		$chequeNumber = $chequeManager->getChequeNumbers();
		if($chequeNumber!=0){
			$chequePerPage = 100;
	        $pageNumber = ceil($chequeNumber/$chequePerPage);
	        $p = 1;
	        if(isset($_GET['p']) and ($_GET['p']>0 and $_GET['p']<=$pageNumber)){
	            $p = $_GET['p'];
	        }
	        else{
	            $p = 1;
	        }
	        $begin = ($p - 1) * $chequePerPage;
	        $pagination = paginate('cheques.php', '?p=', $pageNumber, $p);
			$cheques = $chequeManager->getChequesByLimits($begin, $chequePerPage);	 
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
							Gestion des chèques
						</h3>
						<ul class="breadcrumb">
							<li>
								<i class="icon-home"></i>
								<a>Accueil</a> 
								<i class="icon-angle-right"></i>
							</li>
							<li>
								<i class="icon-money"></i>
								<a>Gestion des chèques</a>
							</li>
						</ul>
						<!-- END PAGE TITLE & BREADCRUMB-->
					</div>
				</div>
				<!-- END PAGE HEADER-->
				<div class="row-fluid">
					<div class="span12">
						<div class="row-fluid add-portfolio">
							<div class="pull-right">
								<a href="#addCheque" data-toggle="modal" class="btn green">
									Nouveau Chèque <i class="icon-plus-sign "></i>
								</a>
							</div>
						</div>
						
						<!-- addCheque box begin-->
						<div id="addCheque" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
								<h3>Ajouter une nouvelle livraison </h3>
							</div>
							<div class="modal-body">
								<form class="form-horizontal" action="controller/ChequeAddController.php" method="post" enctype="multipart/form-data">
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
										<label class="control-label">Date</label>
										<div class="controls date date-picker" data-date="" data-date-format="yyyy-mm-dd">
		                                    <input name="dateCheque" id="dateCheque" class="m-wrap m-ctrl-small date-picker" type="text" value="<?= date('Y-m-d') ?>" />
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
                                            	<option value="Déposé+TVA">Déposé+TVA</option>
                                            	<option value="Annulé">Annulé</option>
                                            </select>
										</div>
									</div>
									<div class="control-group">
		                              	<label class="control-label">Copie Chèque</label>
		                              	<div class="controls">
		                              		<input type="file" name="urlCheque" />
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
						</div>
						<!-- addCheque box end -->
						<div class="row-fluid">
							<form action="" method="post">
							    <div class="input-box autocomplet_container">
									<input class="m-wrap" name="societe" id="nomSociete" type="text" onkeyup="autocompletSociete()" placeholder="Société...">
										<ul id="societeList"></ul>
									</input>
									<input class="m-wrap" name="projet" id="nomProjet" type="text" onkeyup="autocompletProjet()" placeholder="Projet...">
										<ul id="projetList"></ul>
									</input>
									<input name="idFournisseur" id="idFournisseur" type="hidden" />
									<input name="idProjet" id="idProjet" type="hidden" />
									<button type="submit" class="btn red"><i class="icon-search"></i></button>
							    </div>
							</form>
						</div>
						<!-- BEGIN Terrain TABLE PORTLET-->
						<?php if(isset($_SESSION['cheque-add-success'])){ ?>
							<div class="alert alert-success">
								<button class="close" data-dismiss="alert"></button>
								<?= $_SESSION['cheque-add-success'] ?>		
							</div>
						 <?php } 
							unset($_SESSION['cheque-add-success']);
						 ?>
						 <?php if(isset($_SESSION['cheque-add-error'])){ ?>
							<div class="alert alert-error">
								<button class="close" data-dismiss="alert"></button>
								<?= $_SESSION['cheque-add-error'] ?>		
							</div>
						 <?php } 
							unset($_SESSION['cheque-add-error']);
						 ?>
						 <?php if(isset($_SESSION['cheque-update-success'])){ ?>
							<div class="alert alert-success">
								<button class="close" data-dismiss="alert"></button>
								<?= $_SESSION['cheque-update-success'] ?>		
							</div>
						 <?php } 
							unset($_SESSION['cheque-update-success']);
						 ?>
						 <?php if(isset($_SESSION['cheque-update-error'])){ ?>
							<div class="alert alert-error">
								<button class="close" data-dismiss="alert"></button>
								<?= $_SESSION['cheque-update-error'] ?>		
							</div>
						 <?php } 
							unset($_SESSION['cheque-update-error']);
						 ?>
						 <?php if(isset($_SESSION['cheque-copie-update-success'])){ ?>
							<div class="alert alert-success">
								<button class="close" data-dismiss="alert"></button>
								<?= $_SESSION['cheque-copie-update-success'] ?>		
							</div>
						 <?php } 
							unset($_SESSION['cheque-copie-update-success']);
						 ?>
						 <?php if(isset($_SESSION['cheque-delete-success'])){ ?>
							<div class="alert alert-success">
								<button class="close" data-dismiss="alert"></button>
								<?= $_SESSION['cheque-delete-success'] ?>		
							</div>
						 <?php } 
							unset($_SESSION['cheque-delete-success']);
						 ?>
						<div class="portlet">
							<div class="portlet-title">
								<h4>Liste des chèques</h4>
								<div class="tools">
									<a href="javascript:;" class="collapse"></a>
									<a href="javascript:;" class="remove"></a>
								</div>
							</div>
							<div class="portlet-body">
								<table class="table table-bordered table-advance table-hover">
									<thead>
										<tr>
											<th>Numéro chèque</th>
											<th class="hidden-phone">Projet</th>
											<th class="hidden-phone">Date</th>
											<th class="hidden-phone">Désignation</th>
											<th class="hidden-phone">Montant</th>
											<th class="hidden-phone">Statut</th>
											<th class="hidden-phone">Copie</th>
										</tr>
									</thead>
									<tbody>
										<?php
										if($chequeNumber != 0){
										foreach($cheques as $cheque){
											$colorRow = "";
											$btnColor = "";
											if($cheque->statut()==utf8_decode("D&eacute;pos&eacute;")){
												$colorRow = 'style="background-color:#d2ffca"';
												$btnColor = "green";	
											}
											else if($cheque->statut()==utf8_decode("D&eacute;pos&eacute;+TVA")){
												$colorRow = 'style="background-color:#d9edf7"';
												$btnColor = "blue";	
											}
											else if($cheque->statut()=="Annul&eacute;"){
												$colorRow = 'style="background-color:#ffcac1"';
												$btnColor = "red";	
											} 
										?>		
										<tr <?= $colorRow ?>>
											<td>
												<div class="btn-group">
												    <a style="width: 100px" class="btn black mini dropdown-toggle" href="#" data-toggle="dropdown">
												    	<?= $cheque->numero() ?> 
												        <i class="icon-angle-down"></i>
												    </a>
												    <ul class="dropdown-menu">
												        <li>																
												        	<a href="#updateCheque<?= $cheque->id();?>" data-toggle="modal" data-id="<?= $cheque->id(); ?>">
																Modifier
															</a>
															<a href="#deleteCheque<?= $cheque->id() ?>" data-toggle="modal" data-id="<?= $cheque->id() ?>">
																Supprimer
															</a>
												        </li>
												    </ul>
												</div>
											</td>
											<td class="hidden-phone"><?= $projetManager->getProjetById($cheque->idProjet())->nom() ?></td>
											<td class="hidden-phone"><?= date('d/m/Y', strtotime($cheque->dateCheque())) ?></td>
											<td class="hidden-phone"><?= $cheque->designationSociete().' - '.$cheque->designationPersonne() ?></td>
											<td class="hidden-phone"><?= number_format($cheque->montant(), 2, ',', ' ') ?></td>
											<td class="hidden-phone">
												<a class="btn mini <?= $btnColor ?> " href="#updateStatut<?= $cheque->id();?>" data-toggle="modal" data-id="<?= $cheque->id(); ?>">
													<?= $cheque->statut() ?>
												</a>	
											</td>
											<td>
												<a class="fancybox-button btn mini" data-rel="fancybox-button" title="<?= $cheque->numero() ?>" href="<?= $cheque->url() ?>">
													<i class="icon-zoom-in"></i>	
												</a>
												<a class="btn mini blue" href="#updateCopieCheque<?= $cheque->id();?>" data-toggle="modal" data-id="<?= $cheque->id(); ?>">
													<i class=" icon-refresh"></i>	
												</a>
											</td>
										</tr>
										<!-- updateCheque box begin-->
										<div id="updateStatut<?= $cheque->id() ?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
												<h3>Modifier le statut du chèque</h3>
											</div>
											<div class="modal-body">
												<form class="form-horizontal" action="controller/ChequeStatutUpdateController.php" method="post" enctype="multipart/form-data">
													<div class="control-group">
														<label class="control-label">Statut</label>
														<div class="controls">
															<select name="statut">
																<option value="<?= $cheque->statut() ?>"><?= $cheque->statut() ?></option>
																<option disabled="disabled">----------</option>
				                                            	<option value="En cours">En cours</option>
				                                            	<option value="Déposé">Déposé</option>
				                                            	<option value="Déposé+TVA">Déposé+TVA</option>
				                                            	<option value="Annulé">Annulé</option>
				                                            </select>
														</div>
													</div>
													<div class="control-group">
														<div class="controls">
															<input type="hidden" name="idCheque" value="<?= $cheque->id() ?>">
															<button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
															<button type="submit" class="btn red" aria-hidden="true">Oui</button>
														</div>
													</div>
												</form>
											</div>
										</div>
										<!-- updateStatut box end -->
										<!-- updateCheque box begin-->
										<div id="updateCheque<?= $cheque->id() ?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
												<h3>Modifier les informations du chèque</h3>
											</div>
											<div class="modal-body">
												<form class="form-horizontal" action="controller/ChequeUpdateController.php" method="post" enctype="multipart/form-data">
													<div class="control-group">
														<label class="control-label">Projet</label>
														<div class="controls">
															<select name="idProjet">
																<option value="<?= $cheque->idProjet() ?>"><?= $projetManager->getProjetById($cheque->idProjet())->nom() ?></option>
																<option disabled="disabled">-----------</option>
				                                            	<?php foreach($projets as $projet){ ?>
				                                            	<option value="<?= $projet->id() ?>"><?= $projet->nom() ?></option>
				                                            	<?php } ?>
				                                            </select>
														</div>
													</div>
													<div class="control-group">
														<label class="control-label">Numéro Chèque</label>
														<div class="controls">
															<input type="text" name="numeroCheque" value="<?= $cheque->numero() ?>" />
														</div>
													</div>
													<div class="control-group">
														<label class="control-label">Montant</label>
														<div class="controls">
															<input type="text" name="montant" value="<?= $cheque->montant() ?>" />
														</div>
													</div>
													<div class="control-group">
														<label class="control-label">Date</label>
														<div class="controls date date-picker" data-date="" data-date-format="yyyy-mm-dd">
						                                    <input name="dateCheque" id="dateCheque" class="m-wrap m-ctrl-small date-picker" type="text" value="<?= $cheque->dateCheque() ?>" />
						                                    <span class="add-on"><i class="icon-calendar"></i></span>
						                                 </div>
													</div>
													<div class="control-group">
														<label class="control-label">Désignation</label>
														<div class="controls">
															<input class="span5" type="text" name="designationSociete" value="<?= $cheque->designationSociete() ?>" />
															<input class="span5" type="text" name="designationPersonne" value="<?= $cheque->designationPersonne() ?>" />
														</div>
													</div>
													<div class="control-group">
														<label class="control-label">Statut</label>
														<div class="controls">
															<select name="statut">
																<option value="<?= $cheque->statut() ?>"><?= $cheque->statut() ?></option>
																<option disabled="disabled">----------</option>
				                                            	<option value="En cours">En cours</option>
				                                            	<option value="Déposé">Déposé</option>
				                                            	<option value="Déposé+TVA">Déposé+TVA</option>
				                                            	<option value="Annulé">Annulé</option>
				                                            </select>
														</div>
													</div>
													<div class="control-group">
														<div class="controls">
															<input type="hidden" name="idCheque" value="<?= $cheque->id() ?>">
															<button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
															<button type="submit" class="btn red" aria-hidden="true">Oui</button>
														</div>
													</div>
												</form>
											</div>
										</div>
										<!-- updateCheque box end -->
										<!-- updateCopieCheque box begin-->
										<div id="updateCopieCheque<?= $cheque->id() ?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
												<h3>Modifier la copie du chèque </h3>
											</div>
											<div class="modal-body">
												<form class="form-horizontal loginFrm" action="controller/ChequeCopieUpdateController.php" method="post" enctype="multipart/form-data">
													<p>Êtes-vous sûr de vouloir modifier la copie du chèque <strong>N°<?= $cheque->numero() ?></strong> ?</p>
													<div class="control-group">
														<label class="right-label"></label>
														<div class="control-group">
							                              	<label class="control-label">Copie Chèque</label>
							                              	<div class="controls">
							                              		<input type="file" name="urlCopieCheque" />
							                              	</div>
							                           	</div>
														<input type="hidden" name="idCheque" value="<?= $cheque->id() ?>" />
														<button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
														<button type="submit" class="btn red" aria-hidden="true">Oui</button>
													</div>
												</form>
											</div>
										</div>
										<!-- updateCopieCheque box end -->			
										<!-- delete box begin-->
										<div id="deleteCheque<?= $cheque->id() ?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
												<h3>Supprimer le chèque </h3>
											</div>
											<div class="modal-body">
												<form class="form-horizontal loginFrm" action="controller/ChequeDeleteController.php" method="post">
													<p>Êtes-vous sûr de vouloir supprimer le chèque <strong>N°<?= $cheque->numero() ?></strong> ?</p>
													<div class="control-group">
														<label class="right-label"></label>
														<input type="hidden" name="idCheque" value="<?= $cheque->id() ?>" />
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
									if($chequeNumber != 0){
										echo $pagination;	
									}
									?>
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