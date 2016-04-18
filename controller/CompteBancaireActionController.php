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
            //add history data to db
            $historyManager = new HistoryManager($pdo);
            $societeManager = new SocieteManager($pdo);
            $societe = $societeManager->getSocieteById($idSociete);
            $createdBy = $_SESSION['userMerlaTrav']->login();
            $created = date('Y-m-d h:i:s');
            $history = new History(array(
                'action' => "Ajout",
                'target' => "Table des comptes bancaires",
                'description' => "Ajout de compte bancaire - Numéro : ".$numeroCompte." - Société : ".$societe->raisonSociale(),
                'created' => $created,
                'createdBy' => $createdBy
            ));
            //add it to db
            $historyManager->add($history);
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
            //add history data to db
            $historyManager = new HistoryManager($pdo);
            $societeManager = new SocieteManager($pdo);
            $societe = $societeManager->getSocieteById($idSociete);
            $createdBy = $_SESSION['userMerlaTrav']->login();
            $created = date('Y-m-d h:i:s');
            $history = new History(array(
                'action' => "Modification",
                'target' => "Table des comptes bancaires",
                'description' => "Modification du compte bancaire - ID : ".$idCompte." - Numéro : ".$numeroCompte." - Société : ".$societe->raisonSociale(),
                'created' => $created,
                'createdBy' => $createdBy
            ));
            //add it to db
            $historyManager->add($history);
		}
		else{
			$actionMessage = "Erreur Modification Compte Bancaire : Vous devez remplir le champ 'Numero compte'.";
		}
	}
	else if($action == "delete"){
		$idCompte = htmlentities($_POST['idCompte']);
		$compte = $compteBancaireManager->getCompteBancaireById($idCompte);
		$compteBancaireManager->delete($idCompte);
		$actionMessage = "Opération Valide : Compte Bancaire supprimé avec succès.";
        //add history data to db
        $historyManager = new HistoryManager($pdo);
        $societeManager = new SocieteManager($pdo);
        $societe = $societeManager->getSocieteById($idSociete);
        $createdBy = $_SESSION['userMerlaTrav']->login();
        $created = date('Y-m-d h:i:s');
        $history = new History(array(
            'action' => "Suppression",
            'target' => "Table des comptes bancaires",
            'description' => "Suppression du compte bancaire - ID : ".$idCompte." - Numéro : ".$compte->numero()." - Société : ".$societe->raisonSociale(),
            'created' => $created,
            'createdBy' => $createdBy
        ));
        //add it to db
        $historyManager->add($history);
	}
	
	$_SESSION['bien-action-message'] = $actionMessage;
    $redirectLink = 'Location:../company-accounts.php?idSociete='.$idSociete;
    if ( isset($_POST['source']) and $_POST['source'] == "company" ) {
        $redirectLink = 'Location:../company.php?idSociete='.$idSociete;    
    }
	header($redirectLink);
    