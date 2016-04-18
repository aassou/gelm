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
	$idProjet = $_POST['idProjet'];
	$idLivraison = $_POST['idLivraison'];   
    $livraisonManager = new LivraisonManager($pdo);
    $fournisseurManager = new FournisseurManager($pdo);
    $livraison = $livraisonManager->getLivraisonById($idLivraison);
    $fournisseur = $fournisseurManager->getFournisseurById($livraison->idFournisseur());
	$livraisonManager->delete($idLivraison);
    //add history data to db
    $projetManager = new ProjetManager($pdo);
    $projet = $projetManager->getProjetById($idProjet);
    $historyManager = new HistoryManager($pdo);
    $createdBy = $_SESSION['userMerlaTrav']->login();
    $created = date('Y-m-d h:i:s');
    $history = new History(array(
        'action' => "Suppression",
        'target' => "Table des livraisons",
        'description' => "Suppression Livraison : ID Livraison ".$livraison->id()." - Libelle : ".$livraison->libelle()." - Fournisseur : ".$fournisseur->nom()."/".$fournisseur->societe()." - Projet : ".$projet->nom(),
        'created' => $created,
        'createdBy' => $createdBy
    ));
    //add it to db
    $historyManager->add($history);
	$_SESSION['livraison-delete-success'] = "<strong>Opération valide : </strong>Livraison supprimée avec succès.";
	$redirectLink = 'Location:../projet-livraisons.php?idProjet='.$idProjet.'&idSociete='.$idSociete;
	header($redirectLink);
    
    