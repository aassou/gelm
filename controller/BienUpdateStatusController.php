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
	include('../lib/image-processing.php');  
    //classes loading end
    session_start();
    
    $projetManager = new ProjetManager($pdo);
    //post input processing
    $idProjet = htmlentities($_POST['idProjet']);
    $idSociete = htmlentities($_POST['idSociete']);
    $type = htmlentities($_POST['type']);
	if( !empty($_POST['idProjet']) ){
		$id = htmlentities($_POST['id']);
		$status = htmlentities($_POST['status']);
        
		if(htmlentities($_POST['typeImmobiliere'])=="appartement"){
			$appartementManager = new AppartementManager($pdo);
			$appartementManager->updateStatus($status, $id);
		}
		else if(htmlentities($_POST['typeImmobiliere'])=="local"){
			$locauxManager = new LocauxManager($pdo);
			$locauxManager->updateStatus($status, $id);
		}
		else if(htmlentities($_POST['typeImmobiliere'])=="maison"){
			$maisonManager = new MaisonManager($pdo);
			$maisonManager->updateStatus($status, $id);
		}
		else if(htmlentities($_POST['typeImmobiliere'])=="terrain"){
			$terrainManager = new TerrainManager($pdo);
			$terrainManager->updateStatus($status, $id);
		}
        
        //add history data to db
        $historyManager = new HistoryManager($pdo);
        $createdBy = $_SESSION['userMerlaTrav']->login();
        $created = date('Y-m-d h:i:s');
        $history = new History(array(
            'action' => "Modification de Status",
            'target' => "Table des ".htmlentities($_POST['typeImmobiliere']),
            'description' => "Modification de ".htmlentities($_POST['typeImmobiliere'])." - ID : ".$id." - Projet : ".$projetManager->getProjetById($idProjet)->nom(),
            'created' => $created,
            'createdBy' => $createdBy
        ));
        //add it to db
        $historyManager->add($history);
        $_SESSION['bien-update-success']='<strong>Opération valide</strong> : Le Bien Immobilière est modifié avec succès !';
        $redirectLink = 'Location:../projet-biens.php?idProjet='.$idProjet.'&type='.$type.'&idSociete='.$idSociete;
        header($redirectLink);
	}
	else{
		header('Location:../projet-biens.php?idProjet='.$idProjet.'&type='.$type.'&idSociete='.$idSociete);
	}
    
    