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
	
	$idSociete = htmlentities($_POST['idSociete']);
	if(file_exists($_FILES['urlPieceSociete']['tmp_name']) || is_uploaded_file($_FILES['urlPieceSociete']['tmp_name'])) {
		$url = imageProcessing($_FILES['urlPieceSociete'], '/pieces/pieces_societe/');
		$description = htmlentities($_POST['descriptionSociete']);
		$pieceSociete = 
		new PiecesSociete(array('url' => $url, 'description' => $description, 
		'idSociete' => $idSociete, 'createdBy' => $_SESSION['userMerlaTrav']->login(), 'created' => date('Y-m-d')));
		$piecesSocieteManager = new PiecesSocieteManager($pdo);
		$piecesSocieteManager->add($pieceSociete);
		$_SESSION['pieces-add-success'] = "<strong>Opération valide : </strong>Le document a été ajouté avec succès.";
	}
	else{
		$_SESSION['pieces-add-error'] = "<strong>Erreur Ajout Documents : </strong>Vous devez ajouté un document.";
	}
	$redirect = "Location:../companies.php";
	if(isset($_GET['source']) and $_GET['source']==2){
		$redirect = "Location:../company-pieces.php?idSociete=".$idSociete;
	}
	header($redirect);
