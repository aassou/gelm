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
	$idContrat  = $_POST['idContrat'];
	//create classes managers
	$contratManager = new ContratManager($pdo);
	$redirectLink = 'Location:../contrats-list.php?idProjet='.$idProjet;
	if( isset($_POST['paye']) ){
		$paye = htmlentities($_POST['paye']);
		$contratManager->updatePaiement($paye, $idContrat);
		$_SESSION['contrat-paiement-success'] = "<strong>Opération valide : </strong>Le montant payé est modifié avec succès.";
		header($redirectLink);
		exit;	
	}
	else{
		$_SESSION['contrat-paiement-error'] = "<strong>Erreur Modification Paiement Contrat : </strong>Vous devez remplir le champ 'Montant Payé'.";
		header($redirectLink);
		exit;		
	}
	
