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
	//classModel
	$employe = "";
	//classManager
	$employeManager = new EmployeManager($pdo);
	$paiementManager = new PaiementEmployeManager($pdo);
	
	if( !empty($_POST['montant'])){
			$montant = htmlentities($_POST['montant']);
			$dateOperation = htmlentities($_POST['dateOperation']);
			$idEmploye = htmlentities($_POST['idEmploye']);
			$idProjet = htmlentities($_POST['idProjet']);
			$numeroCheque = htmlentities($_POST['numeroCheque']);
			$created = date('Y-m-d');
			$createdBy = $_SESSION['userMerlaTrav']->login();
			$paiement = new PaiementEmploye(array('dateOperation' => $dateOperation, 'montant' => $montant, 'numeroCheque' => $numeroCheque,
			'idEmploye' => $idEmploye, 'idProjet' => $idProjet, 'createdBy' => $createdBy, 'created' => $created));
			$_SESSION['paiement-add-success'] = "<strong>Opération Valide : </strong>Paiement ajouté avec succès.";
			$paiementManager->add($paiement);	
	}
	else{
		$_SESSION['paiement-add-error'] = "<strong>Erreur Création Paiement : </strong>Vous devez remplir au moins le champ 'Montant'.";
		header('Location:../projet-employes.php?idProjet='.$idProjet);
		exit;
	}	
	header('Location:../projet-employes.php?idProjet='.$idProjet);
	