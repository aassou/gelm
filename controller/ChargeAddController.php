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
    $idProjet = htmlentities($_POST['idProjet']);
    $idSociete = htmlentities($_POST['idSociete']);
    $type = htmlentities($_POST['type']);
	if( !empty($_POST['idProjet']) ){
		if( !empty($_POST['dateOperation']) ){
	        $dateOperation = htmlentities($_POST['dateOperation']);
			$designation = htmlentities($_POST['designation']);
			$beneficiaire = htmlentities($_POST['beneficiaire']);
			$numeroCheque = htmlentities($_POST['numeroCheque']);
			$montant = htmlentities($_POST['montant']);
			$createdBy = $_SESSION['userMerlaTrav']->login();
			$created = date('d/m/Y h:m');
	        //CREATE NEW Charge object
	        $chargeArray = array('dateOperation' => $dateOperation, 'designation' => $designation,
			'beneficiaire' => $beneficiaire, 'numeroCheque' => $numeroCheque, 'montant' => $montant,
			'idProjet' => $idProjet, 'created' => $created, 'createdBy' => $createdBy);
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
	        $chargeManager->add($charge);
            //add history data to db
            $projetManager = new ProjetManager($pdo);
            $historyManager = new HistoryManager($pdo);
            $createdBy = $_SESSION['userMerlaTrav']->login();
            $created = date('Y-m-d h:i:s');
            $history = new History(array(
                'action' => "Ajout",
                'target' => "Table des ".htmlentities($_POST['typeCharge']),
                'description' => "Ajout des charges ".htmlentities($_POST['typeCharge'])." - Montant : ".$montant." - Designation : ".$designation." - Projet : ".$projetManager->getProjetById($idProjet)->nom(),
                'created' => $created,
                'createdBy' => $createdBy
            ));
            //add it to db
            $historyManager->add($history);
	        $_SESSION['charge-add-success']='<strong>Opération valide</strong> : La charge est ajoutée avec succès !';
	        $redirectLink = 'Location:../projet-charges.php?idProjet='.$idProjet.'&idSociete='.$idSociete.'&type='.$type;
	        header($redirectLink);
    	}
	    else{
	    	$_SESSION['charge-add-error'] = "<strong>Erreur Ajout Charge</strong> : Vous devez remplir au moins les champs 'Date opération'.";
	        $redirectLink = 'Location:../projet-charges.php?idProjet='.$idProjet.'&idSociete='.$idSociete.'&type='.$type;
	        header($redirectLink);
			exit;
    	}	
	}
	else{
		header('Location:../projet-charges.php?idProjet='.$idProjet.'&idSociete='.$idSociete.'&type='.$type);
	}
    
    