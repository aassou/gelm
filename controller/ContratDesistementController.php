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
	//create classes managers
	$contratManager = new ContratManager($pdo);
	$locauxManager = new LocauxManager($pdo);
	$appartementManager = new AppartementManager($pdo);
	$terrainManager = new TerrainManager($pdo);
	$maisonManager = new MaisonManager($pdo);
	//create classes
	$contrat = $contratManager->getContratById($idContrat);
	//change status of the old contrat Bien from reservé to non reservé
	if( $contrat->typeBien()=="appartement" ){
		$appartementManager->updateStatus("Disponible", $contrat->idBien());
	}
	else if( $contrat->typeBien()=="localCommercial" ){
		$locauxManager->updateStatus("Disponible", $contrat->idBien());
	}
	else if( $contrat->typeBien()=="maison" ){
		$maisonManager->updateStatus("Disponible", $contrat->idBien());
	}
	else if( $contrat->typeBien()=="terrain" ){
		$terrainManager->updateStatus("Disponible", $contrat->idBien());
	}
	
	$contratManager->desisterContrat($contrat->id());
    //add history data to db
    $projetManager = new ProjetManager($pdo);
    $historyManager = new HistoryManager($pdo);
    $projet = $projetManager->getProjetById($idProjet);
    $createdBy = $_SESSION['userMerlaTrav']->login();
    $created = date('Y-m-d h:i:s');
    $history = new History(array(
        'action' => "Désistement",
        'target' => "Table des contrats clients",
        'description' => "Désistement contrat - Client :  ".$contrat->nomClient()." - CIN : ".$contrat->cin()." - ID Contrat : ".$contrat->id()." - Type bien : ".$contrat->typeBien()." - ID Bien : ".$contrat->idBien()." - Projet : ".$projet->nom(),
        'created' => $created,
        'createdBy' => $createdBy
    ));
    //add it to db
    $historyManager->add($history);
	$_SESSION['contrat-desister-success'] = "<strong>Opération valide : </strong>Le contrat est désisté avec succès.";
	$redirectLink = 'Location:../contrats-list.php?idProjet='.$idProjet.'&idSociete='.$idSociete;
	header($redirectLink);
	
