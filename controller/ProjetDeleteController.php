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
    $projet = $projetManager->getProjetById($idProjet);
	$projetManager->delete($idProjet);
    //add history data to db
    $societeManager = new SocieteManager($pdo);
    $societe = $societeManager->getSocieteById($idSociete);
    $historyManager = new HistoryManager($pdo);
    $createdBy = $_SESSION['userMerlaTrav']->login();
    $created = date('Y-m-d h:i:s');
    $history = new History(array(
        'action' => "Supppression",
        'target' => "Table des projets",
        'description' => "Suppression Projet : Nom ".$projet->nom()." - Titre : ".$projet->numeroTitre()." - Societe : ".$societe->raisonSociale(),
        'created' => $created,
        'createdBy' => $createdBy
    ));
    //add it to db
    $historyManager->add($history);
	$_SESSION['projet-delete-success'] = "<strong>Opération valide : </strong>Le projet est supprimé avec succès.";
	header('Location:../projets.php');
    
    