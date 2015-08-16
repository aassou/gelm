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
    $idCheque = htmlentities($_POST['idCheque']);
	$idSociete = htmlentities($_POST['idSociete']);
	$statut = htmlentities($_POST['statut']);
    $chequeManager = new ChequeManager($pdo);
    $chequeManager->updateStatut($idCheque, $statut);
    $_SESSION['cheque-statut-update-success']="<strong>Opération valide : </strong>Le statut du chèque est modifié avec succès.";
	header('Location:../company-cheques.php?idSociete='.$idSociete);
    