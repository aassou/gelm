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
    $idSociete = $_POST['idSociete'];
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
    $contratManager->hide($contrat->id());
    //add history data to db
    $projetManager = new ProjetManager($pdo);
    $historyManager = new HistoryManager($pdo);
    $projet = $projetManager->getProjetById($idProjet);
    $contrat = $contratManager->getContratById($idContrat);
    $createdBy = $_SESSION['userMerlaTrav']->login();
    $created = date('Y-m-d h:i:s');
    $history = new History(array(
        'action' => "Cacher",
        'target' => "Table des contrats clients",
        'description' => "Cacher contrat - Client :  ".$contrat->nomClient()." - CIN : ".$contrat->cin()." - ID Contrat : ".$contrat->id()." - Type bien : ".$contrat->typeBien()." - ID Bien : ".$contrat->idBien()." - Projet : ".$projet->nom(),
        'created' => $created,
        'createdBy' => $createdBy
    ));
    //add it to db
    $historyManager->add($history);
	$_SESSION['contrat-delete-success'] = "<strong>Opération valide : </strong>Contrat supprimé avec succès.";
	$redirectLink = 'Location:../contrats-list.php?idProjet='.$idProjet.'&idSociete='.$idSociete;
	header($redirectLink);
    
    