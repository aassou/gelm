<?php
    //classes loading begin
    function classLoad ($myClass) {
        if(file_exists('../model/'.$myClass.'.php')){
            include('../model/'.$myClass.'.php');
        }
        elseif(file_exists('../controller/'.$myClass.'.php')){
            include('../controller/'.$myClass.'.php');
        }
    }
    spl_autoload_register("classLoad"); 
    include('../config.php');  
    //classes loading end
    session_start();    
    //post input processing
    $idProjet = $_POST['idProjet'];
	$idContrat  = $_POST['idContrat'];
	//create classes managers
	$contratManager = new ContratManager($pdo);
	$locauxManager = new LocauxManager($pdo);
	$appartementManager = new AppartementManager($pdo);
	//create classes
	$contrat = $contratManager->getContratById($idContrat);
	$redirectLink = 'Location:../contrats-list.php?idProjet='.$idProjet;
	if( isset($_GET['p']) and $_GET['p']==99 ){
		$redirectLink = 'Location:../clients-search.php';
	}
	if( $contrat->typeBien()=="appartement" ){
		if( $appartementManager->getAppartementById($contrat->idBien())->status()=="Disponible" ){
			$appartementManager->updateStatus("Vendu", $contrat->idBien());
			$contratManager->activerContrat($idContrat);
			$_SESSION['contrat-activation-success'] = "<strong>Opération valide : </strong>Le contrat est activé avec succès.";
			header($redirectLink);
			exit;	
		}
		else{
			$_SESSION['contrat-activation-error'] = "<strong>Erreur Activation Contrat : </strong>Le bien est déjà réservé par un autre client.";
			header($redirectLink);
			exit;		
		}
	}
	else if( $contrat->typeBien()=="localCommercial" ){
		if( $locauxManager->getLocauxById($contrat->idBien())->status()=="Diponible" ){
			$locauxManager->updateStatus("Vendu", $contrat->idBien());
			$contratManager->activerContrat($idContrat);
			$_SESSION['contrat-activation-success'] = "<strong>Opération valide : </strong>Le contrat est activé avec succès.";
			header($redirectLink);
			exit;	
		}
		else{
			$_SESSION['contrat-activation-error'] = "<strong>Erreur Activation Contrat : </strong>Le bien est déjà réservé par un autre client.";
			header($redirectLink);
			exit;		
		}
	}
	else if( $contrat->typeBien()=="maison" ){
		if( $maisonManager->getMaisonById($contrat->idBien())->status()=="Diponible" ){
			$maisonManager->updateStatus("Vendu", $contrat->idBien());
			$contratManager->activerContrat($idContrat);
			$_SESSION['contrat-activation-success'] = "<strong>Opération valide : </strong>Le contrat est activé avec succès.";
			header($redirectLink);
			exit;	
		}
		else{
			$_SESSION['contrat-activation-error'] = "<strong>Erreur Activation Contrat : </strong>Le bien est déjà réservé par un autre client.";
			header($redirectLink);
			exit;		
		}
	}
	else if( $contrat->typeBien()=="terrain" ){
		if( $terrainManager->getTerrainById($contrat->idBien())->status()=="Diponible" ){
			$terrainManager->updateStatus("Vendu", $contrat->idBien());
			$contratManager->activerContrat($idContrat);
			$_SESSION['contrat-activation-success'] = "<strong>Opération valide : </strong>Le contrat est activé avec succès.";
			header($redirectLink);
			exit;	
		}
		else{
			$_SESSION['contrat-activation-error'] = "<strong>Erreur Activation Contrat : </strong>Le bien est déjà réservé par un autre client.";
			header($redirectLink);
			exit;		
		}
	}
	
