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
    $idLivraison = $_POST['idLivraison'];
	$idProjet = $_POST['idProjet'];
    $idSociete = $_POST['idSociete'];
	$codeLivraison = $_POST['codeLivraison'];
    if( !empty($_POST['dateLivraison'])){
        $libelle = htmlentities($_POST['libelle']);    
        $dateLivraison = htmlentities($_POST['dateLivraison']);
        //CREATE NEW Livraison object
        $livraison = new Livraison(array('id' => $idLivraison, 
        'libelle' => $libelle, 'dateLivraison' => $dateLivraison));
        $livraisonManager = new LivraisonManager($pdo);
        $livraisonManager->update($livraison);
        //add history data to db
        $fournisseurManager = new FournisseurManager($pdo);
        $livraison = $livraisonManager->getLivraisonById($idLivraison);
        $fournisseur = $fournisseurManager->getFournisseurById($livraison->idFournisseur());
        $projetManager = new ProjetManager($pdo);
        $projet = $projetManager->getProjetById($idProjet);
        $historyManager = new HistoryManager($pdo);
        $createdBy = $_SESSION['userMerlaTrav']->login();
        $created = date('Y-m-d h:i:s');
        $history = new History(array(
            'action' => "Modification",
            'target' => "Table des livraisons",
            'description' => "Modification Livraison : ID Livraison ".$livraison->id()." - Libelle : ".$livraison->libelle()." - Fournisseur : ".$fournisseur->nom()."/".$fournisseur->societe()." - Projet : ".$projet->nom(),
            'created' => $created,
            'createdBy' => $createdBy
        ));
        //add it to db
        $historyManager->add($history);
        $_SESSION['livraison--detail-update-success']='<strong>Opération valide</strong> : Les informations de la livraison sont modifiées avec succès.';
		$redirectLink = 'Location:../projet-livraisons.php?idProjet='.$idProjet.'&idSociete='.$idSociete;
        header($redirectLink);
    }
    else{
        $_SESSION['livraison-detail-update-error'] = "<strong>Erreur Modification Livraison</strong> : Vous devez remplir au moins les champs 'Libelle', 'Prix unitaire' et 'Quantité'.";
		$redirectLink = "Location:../projet-livraisons.php?idProjet=".$idProjet.'&idSociete='.$idSociete;
        header($redirectLink);
    }
    