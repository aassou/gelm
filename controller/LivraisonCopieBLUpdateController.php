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
	$url = "";
	$idLivraison = htmlentities($_POST['idLivraison']);
    if(file_exists($_FILES['urlBL']['tmp_name']) || is_uploaded_file($_FILES['urlBL']['tmp_name'])) {
		$url = imageProcessing($_FILES['urlBL'], '/pieces/pieces_livraisons/');
        $livraisonManager = new LivraisonManager($pdo);
        $livraisonManager->updateCopieBL($url, $idLivraison);
        $_SESSION['livraison-copie-update-success']="<strong>Opération valide : </strong>La copie du BL est modifiée avec succès.";
	}
    else{
        $_SESSION['livraison-copie-update-error'] = "<strong>Erreur Modification Copie BL : </strong>Vous devez séléctionner un fichier.";
    }
	header('Location:../projet-livraisons.php?idProjet='.$idProjet);
    