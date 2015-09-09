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
    
    //post input processing
    $idSociete = htmlentities($_POST['idSociete']);
	$action = htmlentities($_POST['action']);
	//This var contains result message of CRUD action
	$actionMessage = "";
	$compteBancaireManager = new CompteBancaireManager($pdo);
	
	if($action == "add"){
		if( !empty($_POST['numeroCompte']) ){
			$numeroCompte = htmlentities($_POST['numeroCompte']);
			$dateCreation = htmlentities($_POST['dateCreation']);
			$createdBy = $_SESSION['userMerlaTrav']->login();
			$created = date('Y-m-d h:i:s');
			//create object
	        $compteBancaire = 
	        new CompteBancaire(array('numero' => $numeroCompte,
	        'dateCreation' => $dateCreation, 'createdBy' => $createdBy,
			'created' => $created, 'idSociete' => $idSociete));
			//add it to db
			$compteBancaireManager->add($compteBancaire);
	        $actionMessage = "Opération Valide : Compte Bancaire Ajouté avec succès.";	
		}
	    else{
	        $actionMessage = "Erreur Modification Compte Bancaire : Vous devez remplir le champ 'Numero compte'.";
	    }
	}
	else if($action == "update"){
		$idCompte = htmlentities($_POST['idCompte']);
		if(!empty($_POST['numeroCompte'])){
			$numeroCompte = htmlentities($_POST['numeroCompte']);
			$dateCreation = htmlentities($_POST['dateCreation']);
			$compteBancaire = 
			new CompteBancaire(array('id' => $idCompte, 'numero' => $numeroCompte, 'dateCreation' => $dateCreation));
			$compteBancaireManager->update($compteBancaire);
			$actionMessage = "Opération Valide : Compte Bancaire Modifié avec succès.";
		}
		else{
			$actionMessage = "Erreur Modification Compte Bancaire : Vous devez remplir le champ 'Numero compte'.";
		}
	}
	else if($action == "delete"){
		$idCompte = htmlentities($_POST['idCompte']);
		$compteBancaireManager->delete($idCompte);
		$actionMessage = "Opération Valide : Compte Bancaire supprimé avec succès.";
	}
	
	$_SESSION['bien-action-message'] = $actionMessage;
	header('Location:../company-accounts.php?idSociete='.$idSociete);
    