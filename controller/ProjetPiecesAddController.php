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
	
	$idProjet = htmlentities($_POST['idProjet']);
	if(file_exists($_FILES['urlPieceProjet']['tmp_name']) || is_uploaded_file($_FILES['urlPieceProjet']['tmp_name'])) {
		$url = imageProcessing($_FILES['urlPieceProjet'], '/pieces/pieces_projet/');
		echo $url;
		$description = htmlentities($_POST['descriptionProjet']);
		$pieceProjet = 
		new PiecesProjet(array('url' => $url, 'description' => $description, 
		'idProjet' => $idProjet, 'createdBy' => $_SESSION['userMerlaTrav']->login(), 'created' => date('Y-m-d')));
		$piecesProjetManager = new PiecesProjetManager($pdo);
		$piecesProjetManager->add($pieceProjet);
		$_SESSION['pieces-add-success'] = "<strong>Opération valide : </strong>Le document a été ajouté avec succès.";
	}
	else{
		$_SESSION['pieces-add-error'] = "<strong>Erreur Ajout Documents : </strong>Vous devez ajouté un document.";
	}
	$redirect = "Location:../projets.php";
	if(isset($_GET['source']) and $_GET['source']==2){
		$redirect = "Location:../projet-details.php?idProjet=".$idProjet;
	}
	header($redirect);
