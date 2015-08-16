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
	$idSociete = htmlentities($_POST['idSociete']);
	$idPiece = htmlentities($_POST['idPiece']);
    $piecesManager = new PiecesSocieteManager($pdo);
	$piecesManager->delete($idPiece);
	$_SESSION['pieces-delete-success'] = "<strong>Opération valide : </strong>Le document est supprimé avec succès.";
	header('Location:../company-pieces.php?idSociete='.$idSociete);
    
    