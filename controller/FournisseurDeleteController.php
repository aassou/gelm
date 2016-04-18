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
	$idFournisseur = $_POST['idFournisseur'];   
    $fournisseurManager = new FournisseurManager($pdo);
    $fournisseur = $fournisseurManager->getFournisseurById($idFournisseur);
	$fournisseurManager->delete($idFournisseur);
    //add history data to db
    $historyManager = new HistoryManager($pdo);
    $createdBy = $_SESSION['userMerlaTrav']->login();
    $created = date('Y-m-d h:i:s');
    $history = new History(array(
        'action' => "Suppression",
        'target' => "Table des fournisseurs",
        'description' => "Suppression Fournisseur : ".$fournisseur->nom()." - Societe : ".$fournisseur->societe(),
        'created' => $created,
        'createdBy' => $createdBy
    ));
    //add it to db
    $historyManager->add($history);
	$_SESSION['fournisseur-delete-success'] = "<strong>Opération valide : </strong>Fournisseur supprimé avec succès.";
	header('Location:../fournisseurs.php');
    
    