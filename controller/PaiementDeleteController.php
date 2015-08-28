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
	$idPaiement = htmlentities($_POST['idPaiement']);
	$idProjet = htmlentities($_POST['idProjet']);
    $paiementManager = new PaiementEmployeManager($pdo);
	$paiementManager->delete($idPaiement);
	$_SESSION['paiement-delete-success'] = "<strong>Opération valide : </strong>Le paiement est supprimé avec succès.";
	header('Location:../projet-employes.php?idProjet='.$idProjet);
    
    