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
        $idCheque = htmlentities($_POST['idCheque']);
        $montant = htmlentities($_POST['montant']);
		$numeroCheque = htmlentities($_POST['numeroCheque']);    
        $designationSociete = htmlentities($_POST['designationSociete']);
		$designationPersonne = htmlentities($_POST['designationPersonne']);
		$dateCheque = htmlentities($_POST['dateCheque']);
		$idProjet = htmlentities($_POST['idProjet']);
		$createdBy = $_SESSION['userMerlaTrav']->login();
		$created = date('d/m/Y h:m');
		$statut = htmlentities($_POST['statut']);
		/*$url = "";
        if(file_exists($_FILES['urlCheque']['tmp_name']) || is_uploaded_file($_FILES['url']['tmp_name'])) {
			$url = imageProcessing($_FILES['urlCheque'], '/pieces/pieces_cheque/');
		}*/
        $cheque = new Cheque(array('id' => $idCheque, 'numero' => $numeroCheque , 'montant' => $montant, 
        'designationSociete' => $designationSociete, 'designationPersonne' => $designationPersonne, 
        'dateCheque' => $dateCheque, 'idProjet' =>$idProjet, 'createdBy' => $createdBy, 'created' => $created,
		'statut' => $statut, 'url' => $url));
        $chequeManager = new ChequeManager($pdo);
        $chequeManager->update($cheque);
        $_SESSION['cheque-update-success']="<strong>Opération valide : </strong>Le chèque est modifié avec succès.";
    }
    else{
        $_SESSION['cheque-update-error'] = "<strong>Erreur Modification Chèque : </strong>Vous devez remplir au moins les champs 'Montant', 'Numéro chèque' et 'Désignation Société'.";
    }
	header('Location:../company-cheques.php?idSociete='.$idSociete);
    