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
    $societe = $societeManager->getSocieteById($idSociete);
	$societeManager->delete($idSociete);
    //add history data to db
    $historyManager = new HistoryManager($pdo);
    $createdBy = $_SESSION['userMerlaTrav']->login();
    $created = date('Y-m-d h:i:s');
    $history = new History(array(
        'action' => "Suppression",
        'target' => "Table des sociétés",
        'description' => "Suppression Société : Raison Sociale ".$societe->raisonSociale(),
        'created' => $created,
        'createdBy' => $createdBy
    ));
    //add it to db
    $historyManager->add($history);
	$_SESSION['company-delete-success'] = "<strong>Opération valide : </strong>La société est supprimée avec succès.";
	header('Location:../companies.php');
    
    