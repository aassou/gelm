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
	$codeLivraison = $_POST['codeLivraison'];
    $idProjet = htmlentities($_POST['idProjet']);
    $idSociete = htmlentities($_POST['idSociete']);
    if( !empty($_POST['prixUnitaire']) && !empty($_POST['quantite'])){
        $designation = htmlentities($_POST['designation']);
        $quantite = htmlentities($_POST['quantite']);
        $prixUnitaire = htmlentities($_POST['prixUnitaire']);
		$idLivraison = htmlentities($_POST['idLivraisonDetail']);
        //CREATE NEW Livraison object
        $livraison = new LivraisonDetail(array('id' => $idLivraison, 'designation' => $designation, 
        'prixUnitaire' => $prixUnitaire, 'quantite' => $quantite));
        $livraisonDetailManager = new LivraisonDetailManager($pdo);
        $livraisonDetailManager->update($livraison);
        $_SESSION['livraison-detail-update-success']='<strong>Opération valide</strong> : Les informations de la livraison sont modifiées avec succès.';
		$redirectLink = 'Location:../livraisons-details.php?codeLivraison='.$codeLivraison.'&idProjet='.$idProjet.'&idSociete='.$idSociete;
        header($redirectLink);
    }
    else{
        $_SESSION['livraison-detail-update-error'] = "<strong>Erreur Modification Livraison</strong> : Vous devez remplir au moins les champs 'Libelle', 'Prix unitaire' et 'Quantité'.";
		$redirectLink = 'Location:../livraisons-details.php?codeLivraison='.$codeLivraison.'&idProjet='.$idProjet.'&idSociete='.$idSociete;
        header($redirectLink);
    }
    