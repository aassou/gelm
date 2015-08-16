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
	$idSociete = $_POST['idSociete'];
    if( !empty($_POST['raisonSociale'])){
        $raisonSociale = htmlentities($_POST['raisonSociale']);    
        $dateCreation = htmlentities($_POST['dateCreation']);
        
        $societe = new Societe(array('id' => $idSociete, 'raisonSociale' => $raisonSociale, 'dateCreation' => $dateCreation));
        $societeManager = new SocieteManager($pdo);
        $societeManager->update($societe);
        $_SESSION['company-update-success']="<strong>Opération valide : </strong>La société est modifiée avec succès.";
    }
    else{
        $_SESSION['company-update-error'] = "<strong>Erreur Modification Sorties : </strong>Vous devez remplir au moins le champ 'Raison Sociale'.";
    }
	header('Location:../companies.php');
    