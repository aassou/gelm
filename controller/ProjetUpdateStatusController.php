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
    $idSociete = htmlentities($_POST['idSociete']);
	$status = htmlentities($_POST['status']);
    $projetManager = new ProjetManager($pdo);
    $projetManager->updateStatus($idProjet, $status);
    $_SESSION['projet-status-update-success']="<strong>Opération valide : </strong>Le status du projet est modifié avec succès.";
	header('Location:../projects-by-company.php?idSociete='.$idSociete);
    