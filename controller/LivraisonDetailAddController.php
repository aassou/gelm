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
    $codeLivraison = htmlentities($_POST['codeLivraison']);
    $idProjet = htmlentities($_POST['idProjet']);
    $idSociete = htmlentities($_POST['idSociete']);
	if( !empty($_POST['prixUnitaire']) && !empty($_POST['quantite']) ){
        $libelle = htmlentities($_POST['libelle']);    
        $designation = htmlentities($_POST['designation']);
        $quantite = htmlentities($_POST['quantite']);
        $prixUnitaire = htmlentities($_POST['prixUnitaire']);
		$idLivraison = htmlentities($_POST['idLivraison']);
        //CREATE NEW Livraison object
        $livraisonDetail = new LivraisonDetail(array('libelle' => $libelle, 'designation' => $designation, 
        'prixUnitaire' => $prixUnitaire, 'quantite' => $quantite, 'idLivraison' => $idLivraison));
        $livraisonDetailManager = new LivraisonDetailManager($pdo);
        $livraisonDetailManager->add($livraisonDetail);
        $_SESSION['livraison-detail-add-success']='<strong>Opération valide</strong> : La livraison est ajouté avec succès !';
		$redirectLink = 'Location:../livraisons-details.php?codeLivraison='.$codeLivraison.'&idProjet='.$idProjet.'&idSociete='.$idSociete;
        header($redirectLink);
        echo $codeLivraison;
	}
    else{
    	$_SESSION['livraison-detail-add-error'] = "<strong>Erreur Ajout Livraison</strong> : Vous devez remplir au moins les champs 'Libelle', 'Prix unitaire' et 'Quantité'.";
		$redirectLink = 'Location:../livraisons-details.php?codeLivraison='.$codeLivraison.'&idProjet='.$idProjet.'&idSociete='.$idSociete;
        header($redirectLink);
		exit;
	}	