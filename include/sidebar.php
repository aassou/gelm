<?php
    $currentPage = basename($_SERVER['PHP_SELF']);
?>
<div class="page-sidebar nav-collapse collapse">
			<!-- BEGIN SIDEBAR MENU -->        	
			<ul>
				<li>
					<!-- BEGIN SIDEBAR TOGGLER BUTTON -->
					<div class="sidebar-toggler hidden-phone"></div>
					<!-- BEGIN SIDEBAR TOGGLER BUTTON -->
				</li>
				<li>
				</li>
				<!---------------------------- Dashboard Begin  -------------------------------------------->
				<li class="start <?php if($currentPage=="dashboard.php" 
				or $currentPage=="recherches.php"
				or $currentPage=="livraisons-group.php"
				or $currentPage=="livraisons-fournisseur-mois.php"
				or $currentPage=="livraisons-fournisseur-mois-list.php"
				or $currentPage=="livraisons-details-archive.php"
				or $currentPage=="conges.php"
				or $currentPage=="status.php"
				or $currentPage=="contrat-status.php"
				or $currentPage=="properties-status.php"
				or $currentPage=="properties-status-types.php"
				or $currentPage=="statistiques.php"
				or $currentPage=="releve-bancaire.php"
				or $currentPage=="messages.php"
				or $currentPage=="user-profil.php"
				or $currentPage=="clients-search.php"
				or $currentPage=="fournisseurs-search.php"
				or $currentPage=="employes-projet-search.php"
				){echo "active ";} ?>">
					<a href="dashboard.php">
					<i class="icon-dashboard"></i> 
					<span class="title">Accueil</span>
					</a>
				</li>
				<!---------------------------- Dashboard End    -------------------------------------------->
				<!---------------------------- Gestion des sociétés Begin  -------------------------------------------->
				<li class="start <?php if($currentPage=="company.php"
				or $currentPage=="companies.php"
				or $currentPage=="company.php"
				or $currentPage=="companies-group.php"
				or $currentPage=="company-pieces.php"
				or $currentPage=="company-projets.php"
				or $currentPage=="company-cheques.php"
				or $currentPage=="company-accounts.php"
				or $currentPage=="charges-communs.php"
				){echo "active ";} ?>">
					<a href="companies-group.php">
					<i class="icon-sitemap"></i> 
					<span class="title">Gestion des sociétés</span>
					</a>
				</li>
				<!---------------------------- Gestion des sociétés End    -------------------------------------------->
				<!---------------------------- Gestion des Projets Begin  -------------------------------------------->
				<li class="start <?php if($currentPage=="projets.php"
				or $currentPage=="projet-details.php"
				or $currentPage=="projet-livraisons.php"
				or $currentPage=="livraisons-validate.php"
				or $currentPage=="livraisons-invalidate.php"
				or $currentPage=="projet-charges.php"
				or $currentPage=="projet-biens.php"
				or $currentPage=="livraisons-details.php"
				or $currentPage=="contrats-list.php"
				or $currentPage=="contrats-add.php"
				or $currentPage=="contrats-update.php"
				or $currentPage=="clients-add.php"
				or $currentPage=="projet-employes.php"
				or $currentPage=="projet-contrat-employe.php"
				or $currentPage=="contrat-employe-detail.php"
				or $currentPage=="projects-by-company.php"
				or $currentPage=="biens-by-projects.php"
				or $currentPage=="projets-charges-categories.php"
				or $currentPage=="project-management.php"
				or $currentPage=="projet-statistique.php"
				){echo "active ";} ?>">
					<a>
					<i class="icon-briefcase"></i> 
					<span class="title">Gestion des projets</span>
					</a>
				</li>
				<!---------------------------- Gestion des Cheques End    -------------------------------------------->
				<!--li class="start <?php //if($currentPage=="cheques.php"
				//){echo "active ";} ?>">
					<a href="cheques.php">
					<i class="icon-money"></i> 
					<span class="title">Gestion des chèques</span>
					</a>
				</li-->
				<!---------------------------- Gestion des Cheques End    -------------------------------------------->
				<!---------------------------- Gestion des Fournisseurs Begin  -------------------------------------------->
				<li class="start <?php if($currentPage=="fournisseurs.php"
				){echo "active ";} ?>">
					<a href="fournisseurs.php">
					<i class="icon-truck"></i> 
					<span class="title">Gestion des fournisseurs</span>
					</a>
				</li>
				<!---------------------------- Gestion des Fournisseurs End    -------------------------------------------->
				<!---------------------------- Gestion des Employes Begin  -------------------------------------------->
				<li class="start <?php if($currentPage=="employes.php"
				){echo "active ";} ?>">
					<a href="employes.php">
					<i class="icon-group"></i> 
					<span class="title">Gestion des employés</span>
					</a>
				</li>
				<!---------------------------- Gestion des Employes End    -------------------------------------------->
				<?php if($_SESSION['userMerlaTrav']->login()=="abdessamad"){ ?>
				<!---------------------------- Gestion de la caisse Begin  -------------------------------------------->
				<li class="start <?php if($currentPage=="caisse.php"
				or $currentPage=="caisse-entrees.php"
				or $currentPage=="caisse-sorties.php"
				or $currentPage=="caisses.php"
				or $currentPage=="caisse-details.php"
				){echo "active ";} ?>">
					<a href="caisses.php">
					<i class="icon-bar-chart"></i> 
					<span class="title">Gestion des caisses</span>
					</a>
				</li>
				<!---------------------------- Gestion des Caisses End    -------------------------------------------->
				<?php } ?>
				<!---------------------------- Gestion des Employes Begin  -------------------------------------------->
                <li class="start <?php if($currentPage=="configuration.php"
                or $currentPage=="users.php"
                or $currentPage=="clients-archive-group.php"
                or $currentPage=="clients-archive.php"
                or $currentPage=="history-group.php"
                or $currentPage=="history.php"
                ){echo "active ";} ?>">
                    <a href="configuration.php">
                    <i class="icon-wrench"></i> 
                    <span class="title">Paramètrages</span>
                    </a>
                </li>
                <!---------------------------- Gestion des Employes End    -------------------------------------------->
			</ul>
			<!-- END SIDEBAR MENU -->
		</div>