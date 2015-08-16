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
    $societeManager = new SocieteManager($pdo);
	$societeManager->delete($idSociete);
	$_SESSION['company-delete-success'] = "<strong>Opération valide : </strong>La société est supprimée avec succès.";
	header('Location:../companies.php');
    
    