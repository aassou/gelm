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
	$idFournisseur = htmlentities($_POST['idFournisseur']);
	if( !empty($_POST['idProjet']) ){
		if( !empty($_POST['dateLivraison']) ){
	        $dateLivraison = htmlentities($_POST['dateLivraison']);
			$modePaiement = htmlentities($_POST['modePaiement']);
			$libelle = htmlentities($_POST['libelle']);
			$codeLivraison = uniqid().date('YmdHis');
			$status = htmlentities($_POST['status']);
			$url = "";
	        if(file_exists($_FILES['urlBL']['tmp_name']) || is_uploaded_file($_FILES['urlBL']['tmp_name'])) {
				$url = imageProcessing($_FILES['urlBL'], '/pieces/pieces_livraisons/');
			}
	        //CREATE NEW Livraison object
	        $livraison = new Livraison(array('dateLivraison' => $dateLivraison, 'libelle' => $libelle, 
	        'quantite' => $quantite, 'idFournisseur' => $idFournisseur, 'idProjet' => $idProjet, 
	        'code' => $codeLivraison, 'status' => $status, 'url' => $url, 'modePaiement' => $modePaiement));
	        $livraisonManager = new LivraisonManager($pdo);
	        $livraisonManager->add($livraison);
	        $_SESSION['livraison-add-success']='<strong>Opération valide</strong> : La livraison est ajouté avec succès !';
			$_SESSION['livraison-detail-fill']='<strong>Détails livraisons</strong> : Ajoutez la liste des articles à votre livraison !';
	        $redirectLink = 'Location:../livraisons-details.php?codeLivraison='.$codeLivraison;
	        header($redirectLink);
    	}
	    else{
	    	$_SESSION['livraison-add-error'] = "<strong>Erreur Ajout Livraison</strong> : Vous devez remplir au moins les champs 'Libelle', 'Prix unitaire' et 'Quantité'.";
	        $redirectLink = 'Location:../projet-livraisons.php?idProjet='.$idProjet;
	        header($redirectLink);
			exit;
    	}	
	}
	else{
		header('Location:../projet-livraisons.php?idProjet='.$idProjet);
	}
    
    