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
    $idProjet = htmlentities($_POST['idProjet']);
	$idCharge = htmlentities($_POST['idCharge']);	
	$idSociete = htmlentities($_POST['idSociete']);
    $type = htmlentities($_POST['type']);
	$charge = "";
	$chargeManager = "";
	
	if(htmlentities($_POST['typeCharge'])=="terrain"){
		$charge = new ChargesTerrain($chargeArray);
		$chargeManager = new ChargesTerrainManager($pdo);
	}
	else if(htmlentities($_POST['typeCharge'])=="construction"){
		$charge = new ChargesConstruction($chargeArray);
		$chargeManager = new ChargesConstructionManager($pdo);
	}
	else if(htmlentities($_POST['typeCharge'])=="finition"){
		$charge = new ChargesFinition($chargeArray);
		$chargeManager = new ChargesFinitionManager($pdo);
	}
    $chargeManager->delete($idCharge);
    //add history data to db
    $projetManager = new ProjetManager($pdo);
    $historyManager = new HistoryManager($pdo);
    $createdBy = $_SESSION['userMerlaTrav']->login();
    $created = date('Y-m-d h:i:s');
    $history = new History(array(
        'action' => "Suppression",
        'target' => "Table des ".htmlentities($_POST['typeCharge']),
        'description' => "Suppression des charges ".htmlentities($_POST['typeCharge'])." - ID : ".$idCharge." - Projet : ".$projetManager->getProjetById($idProjet)->nom(),
        'created' => $created,
        'createdBy' => $createdBy
    ));
    //add it to db
    $historyManager->add($history);
    $_SESSION['charge-delete-success']='<strong>Opération valide</strong> : La charge est supprimée avec succès !';
    $redirectLink = 'Location:../projet-charges.php?idProjet='.$idProjet.'&idSociete='.$idSociete.'&type='.$type;
    header($redirectLink);
	
    
    