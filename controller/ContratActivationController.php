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
    $idSociete = $_POST['idSociete'];
	$idContrat  = $_POST['idContrat'];
    $status = $_POST['status'];
	//create classes managers
	$contratManager = new ContratManager($pdo);
	$locauxManager = new LocauxManager($pdo);
	$appartementManager = new AppartementManager($pdo);
    $maisonManager = new MaisonManager($pdo);
    $terrainManager = new TerrainManager($pdo);
	//create classes
	$contrat = $contratManager->getContratById($idContrat);
	$redirectLink = 'Location:../contrats-list.php?idProjet='.$idProjet.'&idSociete='.$idSociete;
	if( isset($_GET['p']) and $_GET['p']==99 ){
		$redirectLink = 'Location:../clients-search.php';
	}
	if( $contrat->typeBien()=="appartement" ){
		if( $appartementManager->getAppartementById($contrat->idBien())->status()=="Disponible" ){
			$appartementManager->updateStatus($status, $contrat->idBien());
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
		if( $locauxManager->getLocauxById($contrat->idBien())->status() == "Disponible" ){
			$locauxManager->updateStatus($status, $contrat->idBien());
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
		if( $maisonManager->getMaisonById($contrat->idBien())->status()=="Disponible" ){
			$maisonManager->updateStatus($status, $contrat->idBien());
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
		if( $terrainManager->getTerrainById($contrat->idBien())->status()=="Disponible" ){
			$terrainManager->updateStatus($status, $contrat->idBien());
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
	
