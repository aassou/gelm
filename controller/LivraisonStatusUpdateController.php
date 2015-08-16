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
	$idLivraison = htmlentities($_POST['idLivraison']);
	$status = htmlentities($_POST['status']);
    $livraisonManager = new LivraisonManager($pdo);
    $livraisonManager->updateStatus($idLivraison, $status);
    $_SESSION['livraison-status-update-success']="<strong>Opération valide : </strong>Le status de la livraison est modifié avec succès.";
	header('Location:../projet-livraisons.php?idProjet='.$idProjet);
    