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
	$redirectLink = 'Location:../contrats-list.php?idProjet='.$idProjet."&idSociete=".$idSociete;
	if( isset($_POST['paye']) ){
		$paye = htmlentities($_POST['paye']);
		$contratManager->updatePaiement($paye, $idContrat);
        $contrat = $contratManager->getContratById($idContrat);
        //add history data to db
        $projetManager = new ProjetManager($pdo);
        $historyManager = new HistoryManager($pdo);
        $projet = $projetManager->getProjetById($idProjet);
        $createdBy = $_SESSION['userMerlaTrav']->login();
        $created = date('Y-m-d h:i:s');
        $history = new History(array(
            'action' => "Ajout Paiement Contrat Client",
            'target' => "Table des contrats clients",
            'description' => "Ajout Paiement Contrat Client - Client :  ".$contrat->nomClient()." - CIN : ".$contrat->cin()." - ID Contrat : ".$idContrat." - Montant : ".$paye." - Projet : ".$projet->nom(),
            'created' => $created,
            'createdBy' => $createdBy
        ));
        //add it to db
        $historyManager->add($history);
		$_SESSION['contrat-paiement-success'] = "<strong>Opération valide : </strong>Le montant payé est modifié avec succès.";
		header($redirectLink);
		exit;	
	}
	else{
		$_SESSION['contrat-paiement-error'] = "<strong>Erreur Modification Paiement Contrat : </strong>Vous devez remplir le champ 'Montant Payé'.";
		header($redirectLink);
		exit;		
	}
	
