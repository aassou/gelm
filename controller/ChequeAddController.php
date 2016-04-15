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
    if(!empty($_POST['numeroCheque']) and !empty($_POST['montant']) and !empty($_POST['designationSociete'])){
        $montant = htmlentities($_POST['montant']);
		$numeroCheque = htmlentities($_POST['numeroCheque']);    
        $designationSociete = htmlentities($_POST['designationSociete']);
		$designationPersonne = htmlentities($_POST['designationPersonne']);
		$dateCheque = htmlentities($_POST['dateCheque']);
		$idProjet = htmlentities($_POST['idProjet']);
		$createdBy = $_SESSION['userMerlaTrav']->login();
		$created = date('d/m/Y h:m');
		$statut = htmlentities($_POST['statut']);
		$compteBancaire = htmlentities($_POST['compteBancaire']);
		$url = "";
        if(file_exists($_FILES['urlCheque']['tmp_name']) || is_uploaded_file($_FILES['urlCheque']['tmp_name'])) {
			$url = imageProcessing($_FILES['urlCheque'], '/pieces/pieces_cheque/');
		}
        $cheque = new Cheque(array('numero' => $numeroCheque , 'montant' => $montant, 
        'designationSociete' => $designationSociete, 'designationPersonne' => $designationPersonne, 
        'dateCheque' => $dateCheque, 'idProjet' =>$idProjet, 'idSociete' => $idSociete, 'compteBancaire' => $compteBancaire, 'createdBy' => $createdBy, 'created' => $created,
		'statut' => $statut, 'url' => $url));
        $chequeManager = new ChequeManager($pdo);
        $chequeManager->add($cheque);
        $_SESSION['cheque-add-success']="<strong>Opération valide : </strong>Le chèque est ajouté au système avec succès.";
        //add history data to db
        $historyManager = new HistoryManager($pdo);
        $projetManager = new ProjetManager($pdo);
        $societeManager = new SocieteManager($pdo);
        $projet = $projetManager->getProjetById($idProjet);
        $societe = $societeManager->getSocieteById($idSociete);
        $createdBy = $_SESSION['userMerlaTrav']->login();
        $created = date('Y-m-d h:i:s');
        $history = new History(array(
            'action' => "Ajout",
            'target' => "Table des chèques",
            'description' => "Ajout de chèque- N° : ".$numeroCheque." - Montant : ".$montant." - Compte : ".$compteBancaire." - Designation : ".$designationSociete."/".$designationPersonne." - Projet : ".$projet->nom(),
            'created' => $created,
            'createdBy' => $createdBy
        ));
        //add it to db
        $historyManager->add($history);
    }
    else{
        $_SESSION['cheque-add-error'] = "<strong>Erreur Ajout Chèque : </strong>Vous devez remplir au moins les champs 'Montant', 'Numéro chèque' et 'Désignation Société'.";
    }
	header('Location:../company-cheques.php?idSociete='.$idSociete);
    