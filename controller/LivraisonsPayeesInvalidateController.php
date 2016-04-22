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
    $idFournisseur = htmlentities($_POST['idFournisseur']);
    $status = "Non Pay&eacute;";
    $livraisonManager = new LivraisonManager($pdo);
        foreach($_POST['id_livraison'] as $idLivraison) {
            $livraisonManager->invalidateLivraisonsPayees($idLivraison, $idFournisseur, $idProjet, $status);        
        }
    header("Location:../livraisons-invalidate.php?idProjet=".$idProjet."&idSociete=".$idSociete."&idFournisseur=".$idFournisseur);
