<<<<<<< HEAD
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
	
	if( !empty($_POST['montant']) ){
			$id = htmlentities($_POST['idPaiement']);
			$montant = htmlentities($_POST['montant']);
			$dateOperation = htmlentities($_POST['dateOperation']);
			$idEmploye = htmlentities($_POST['idEmploye']);
			$numeroCheque = htmlentities($_POST['numeroCheque']);
			$paiement = new PaiementEmploye(array('dateOperation' => $dateOperation, 'montant' => $montant, 'numeroCheque' => $numeroCheque,
			'idEmploye' => $idEmploye, 'id' => $id));
			$_SESSION['paiement-update-success'] = "<strong>Opération Valide : </strong>Paiement modifié avec succès.";
			$paiementManager->update($paiement);	
	}
	else{
		$_SESSION['paiement-update-error'] = "<strong>Erreur Modification Paiement : </strong>Vous devez remplir au moins le champ 'Montant'.";
		header('Location:../projet-employes.php?idProjet='.$idProjet);
		exit;
	}	
	header('Location:../projet-employes.php?idProjet='.$idProjet);
=======
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
	
	if( !empty($_POST['montant']) ){
			$id = htmlentities($_POST['idPaiement']);
			$montant = htmlentities($_POST['montant']);
			$dateOperation = htmlentities($_POST['dateOperation']);
			$idEmploye = htmlentities($_POST['idEmploye']);
			$numeroCheque = htmlentities($_POST['numeroCheque']);
			$paiement = new PaiementEmploye(array('dateOperation' => $dateOperation, 'montant' => $montant, 'numeroCheque' => $numeroCheque,
			'idEmploye' => $idEmploye, 'id' => $id));
			$_SESSION['paiement-update-success'] = "<strong>Opération Valide : </strong>Paiement modifié avec succès.";
			$paiementManager->update($paiement);	
	}
	else{
		$_SESSION['paiement-update-error'] = "<strong>Erreur Modification Paiement : </strong>Vous devez remplir au moins le champ 'Montant'.";
		header('Location:../projet-employes.php?idProjet='.$idProjet);
		exit;
	}	
	header('Location:../projet-employes.php?idProjet='.$idProjet);
>>>>>>> 32d8c2d0dbce6a6ed5c3ce01d84e1dca4c37cc04
	