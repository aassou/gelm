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
	$idContrat = $_POST['idContrat'];   
	$contratManager = new ContratManager($pdo);
	$contrat = $contratManager->getContratById($idContrat);
	if($contrat->typeBien()=="appartement"){
		$appartementManager = new AppartementManager($pdo);
		$appartementManager->updateStatus("Disponible", $contrat->idBien());
	}
	else if($contrat->typeBien()=="localCommercial"){
		$locauxManager = new LocauxManager($pdo);
		$locauxManager->updateStatus("Disponible", $contrat->idBien());
	}
	else if($contrat->typeBien()=="terrain"){
		$terrainManager = new TerrainManager($pdo);
		$terrainManager->updateStatus("Disponible", $contrat->idBien());
	}
	else if($contrat->typeBien()=="maison"){
		$maisonManager = new MaisonManager($pdo);
		$maisonManager->updateStatus("Disponible", $contrat->idBien());
	}
	$contratManager->delete($contrat->id());
	$_SESSION['contrat-delete-success'] = "<strong>Opération valide : </strong>Contrat supprimé avec succès.";
	$redirectLink = 'Location:../contrats-list.php?idProjet='.$idProjet;
	header($redirectLink);
    
    