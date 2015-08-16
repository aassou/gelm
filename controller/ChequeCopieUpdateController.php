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
	$url = "";
	$idCheque = htmlentities($_POST['idCheque']);
    if(file_exists($_FILES['urlCopieCheque']['tmp_name']) || is_uploaded_file($_FILES['urlCopieCheque']['tmp_name'])) {
		$url = imageProcessing($_FILES['urlCopieCheque'], '/pieces/pieces_cheque/');
        $chequeManager = new ChequeManager($pdo);
        $chequeManager->updateCopieCheque($url, $idCheque);
        $_SESSION['cheque-copie-update-success']="<strong>Opération valide : </strong>La copie chèque est modifiée avec succès.";
	}
    else{
        $_SESSION['cheque-copie-update-error'] = "<strong>Erreur Modification Copie Chèque : </strong>Vous devez séléctionner un fichier.";
    }
	header('Location:../company-cheques.php?idSociete='.$idSociete);
    