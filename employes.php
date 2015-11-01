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
    	$employesManager = new employeManager($pdo);
		$employeNumber = $employesManager->getEmployeNumbers();
		$employes = $employesManager->getEmployes();
		/*
		if($employeNumber!=0){
			$employePerPage = 20;
	        $pageNumber = ceil($employeNumber/$employePerPage);
	        $p = 1;
	        if(isset($_GET['p']) and ($_GET['p']>0 and $_GET['p']<=$pageNumber)){
	            $p = $_GET['p'];
	        }
	        else{
	            $p = 1;
	        }
	        $begin = ($p - 1) * $employePerPage;
	        $pagination = paginate('employes.php', '?p=', $pageNumber, $p);
			$employes = $employesManager->getemployesByLimits($begin, $employePerPage);	 
		}
		*/
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
							Gestion des employés
						</h3>
						<ul class="breadcrumb">
							<li>
								<i class="icon-home"></i>
								<a href="dashboard.php">Accueil</a> 
								<i class="icon-angle-right"></i>
							</li>
							<li>
								<i class="icon-truck"></i>
								<a>Gestion des employés</a>
							</li>
						</ul>
						<!-- END PAGE TITLE & BREADCRUMB-->
					</div>
				</div>
				<!-- END PAGE HEADER-->
				<!-- BEGIN PAGE CONTENT-->
				<div class="row-fluid">
					<div class="span12">
						<div class="row-fluid">
							<div class="pull-right">
								<!--a href="livraison-add.php" class="btn icn-only blue"-->
								<a href="#addemploye" data-toggle="modal" class="btn blue">
									Ajouter Nouveau Employé <i class="icon-plus-sign "></i>
								</a>
							</div>
						</div>
						<!-- addemploye box begin-->
						<div id="addemploye" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
							<div class="modal-header">
								<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
								<h3>Ajouter un nouveau employe </h3>
							</div>
							<div class="modal-body">
								<form class="form-horizontal" action="controller/EmployeAddController.php?source=100" method="post">
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
											<button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
											<button type="submit" class="btn red" aria-hidden="true">Oui</button>
										</div>
									</div>
								</form>
							</div>
						</div>
						<!-- addemploye box end -->
						<!-- BEGIN EXAMPLE TABLE PORTLET-->
						<?php if(isset($_SESSION['employe-delete-success'])){ ?>
                         	<div class="alert alert-success">
								<button class="close" data-dismiss="alert"></button>
								<?= $_SESSION['employe-delete-success'] ?>		
							</div>
                         <?php } 
                         	unset($_SESSION['employe-delete-success']);
                         ?>
                         <?php if(isset($_SESSION['employe-update-success'])){ ?>
                         	<div class="alert alert-success">
								<button class="close" data-dismiss="alert"></button>
								<?= $_SESSION['employe-update-success'] ?>		
							</div>
                         <?php } 
                         	unset($_SESSION['employe-update-success']);
                         ?>
						 <?php if(isset($_SESSION['employe-update-error'])){ ?>
                         	<div class="alert alert-success">
								<button class="close" data-dismiss="alert"></button>
								<?= $_SESSION['employe-update-error'] ?>		
							</div>
                         <?php } 
                         	unset($_SESSION['employe-update-error']);
                         ?>
                         <!-- END EXAMPLE TABLE PORTLET-->
						 <?php if(isset($_SESSION['employe-add-success'])){ ?>
                         	<div class="alert alert-success">
								<button class="close" data-dismiss="alert"></button>
								<?= $_SESSION['employe-add-success'] ?>		
							</div>
                         <?php } 
                         	unset($_SESSION['employe-add-success']);
                         ?>
                         <?php if(isset($_SESSION['employe-add-error'])){ ?>
                         	<div class="alert alert-error">
								<button class="close" data-dismiss="alert"></button>
								<?= $_SESSION['employe-add-error'] ?>		
							</div>
                         <?php } 
                         	unset($_SESSION['employe-add-error']);
                         ?>
                         <div class="row-fluid">
							<input class="m-wrap" name="employe" id="employe" type="text" placeholder="employe..." />
						</div>
						</div>
						<div class="portlet box green" id="listemployes">
							<div class="portlet-title">
								<h4>Les employes</h4>
								<div class="tools">
									<a href="javascript:;" class="collapse"></a>
									<a href="javascript:;" class="remove"></a>
								</div>
							</div>
							<div class="portlet-body">
								<div class="scroller" data-height="500px" data-always-visible="1"><!-- BEGIN DIV SCROLLER -->
								<table class="table table-striped table-bordered table-advance table-hover" id="sample_editable_1">
									<thead>
										<tr>
											<th style="width:25%">Nom</th>
											<th style="width:25%" class="hidden-phone">CIN</th>
											<th style="width:25%" class="hidden-phone">Adresse</th>
											<th style="width:25%" class="hidden-phone">Téléphone</th>
										</tr>
									</thead>
									<tbody>
										<?php 
										if($employeNumber!=0){
										foreach ($employes as $employe) {
										?>	
										<tr class="employes">
											<td>
												<div class="btn-group">
												    <a style="width: 200px" class="btn mini black dropdown-toggle" href="#" data-toggle="dropdown">
												    	<?= $employe->nom()?> 
												        <i class="icon-angle-down"></i>
												    </a>
												    <ul class="dropdown-menu">
												        <li>
												        	<a href="#update<?= $employe->id();?>" data-toggle="modal" data-id="<?= $employe->id(); ?>">
																Modifier
															</a>
															<a href="#delete<?= $employe->id();?>" data-toggle="modal" data-id="<?= $employe->id(); ?>">
																Supprimer
															</a>
												        </li>
												    </ul>
												</div>
											</td>
											<td class="hidden-phone"><?= $employe->cin() ?></td>
											<td class="hidden-phone"><?= $employe->adresse()?></td>
											<td class="hidden-phone"><?= $employe->telephone() ?></td>
										</tr>
										<!-- updateEmploye box begin-->
										<div id="update<?= $employe->id() ?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
												<h3>Modifier Informations Employé </h3>
											</div>
											<div class="modal-body">
												<form class="form-horizontal" action="controller/EmployeUpdateController.php" method="post">
													<div class="control-group">
														<label class="control-label">Nom</label>
														<div class="controls">
															<input type="text" name="nom" value="<?= $employe->nom() ?>" />
														</div>
													</div>
													<div class="control-group">
														<label class="control-label">CIN</label>
														<div class="controls">
															<input type="text" name="cin" value="<?= $employe->cin() ?>" />
														</div>
													</div>
													<div class="control-group">
														<label class="control-label">Adresse</label>
														<div class="controls">
															<input type="text" name="adresse" value="<?= $employe->adresse() ?>" />
														</div>
													</div>
													<div class="control-group">
														<label class="control-label">Téléphone</label>
														<div class="controls">
															<input type="text" name="telephone" value="<?= $employe->telephone() ?>" />
														</div>
													</div>
													<div class="control-group">
														<div class="controls">	
															<input type="hidden" name="idEmploye" value="<?= $employe->id() ?>" />
															<button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
															<button type="submit" class="btn red" aria-hidden="true">Oui</button>
														</div>
													</div>
												</form>
											</div>
										</div>
										<!-- updateEmploye box end -->
										<!-- delete box begin-->
										<div id="delete<?= $employe->id() ?>" class="modal hide fade in" tabindex="-1" role="dialog" aria-labelledby="login" aria-hidden="false" >
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
												<h3>Supprimer Employé</h3>
											</div>
											<div class="modal-body">
												<form class="form-horizontal loginFrm" action="controller/EmployeDeleteController.php" method="post">
													<p>Êtes-vous sûr de vouloir supprimer cet employe <?= $employe->nom() ?> ?</p>
													<div class="control-group">
														<label class="right-label"></label>
														<input type="hidden" name="idEmploye" value="<?= $employe->id() ?>" />
														<button class="btn" data-dismiss="modal"aria-hidden="true">Non</button>
														<button type="submit" class="btn red" aria-hidden="true">Oui</button>
													</div>
												</form>
											</div>
										</div>
										<!-- delete box end -->				
										<?php }
										} ?>
									</tbody>
								</table>
								</div><!-- END SCROLL DIV -->
							</div>
						</div>
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
	<script type="text/javascript" src="script.js"></script>		
	<script>
		jQuery(document).ready(function() {			
			// initiate layout and plugins
			//App.setPage("table_editable");
			App.init();
		});
		$('.employes').show();
		$('#employe').keyup(function(){
		    $('.employes').hide();
		   var txt = $('#employe').val();
		   $('.employes').each(function(){
		       if($(this).text().toUpperCase().indexOf(txt.toUpperCase()) != -1){
		           $(this).show();
		       }
		    });
		});
		$('#nature').keyup(function(){
		    $('.employes').hide();
		   var txt = $('#nature').val();
		   $('.employes').each(function(){
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
