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
	$idProjet = htmlentities($_POST['idProjet']);
    $projetManager = new ProjetManager($pdo);
	$projetManager->delete($idProjet);
	$_SESSION['projet-delete-success'] = "<strong>Opération valide : </strong>Le projet est supprimé avec succès.";
	header('Location:../projets.php');
    
    