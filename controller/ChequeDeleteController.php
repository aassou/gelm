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
	$idCheque = $_POST['idCheque'];  
	$idSociete = htmlentities($_POST['idSociete']); 
    $chequeManager = new ChequeManager($pdo);
	$chequeManager->delete($idCheque);
	$_SESSION['cheque-delete-success'] = "<strong>Opération valide : </strong>Chèque supprimé avec succès.";
	//do not forget p parameter and to send it in url
	header('Location:../company-cheques.php?idSociete='.$idSociete);
    
    